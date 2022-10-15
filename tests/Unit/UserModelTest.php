<?php

namespace Tests\Unit;

use App\Models\Candidate;
use App\Models\Education;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_a_position()
    {
        $position = Position::factory()->create();
        $user = User::factory()->create([
            'position_id' => $position->id,
        ]);

        // Method 1:
        $this->assertInstanceOf(Position::class, $user->position);

        // Method 2:
        $this->assertEquals(1, $user->position->count());
    }

    /** @test */
    public function a_user_email_or_phone_number_must_be_unique()
    {
        $position = Position::factory()->create();
        $username = fake()->unique()->userName();
        $email = fake()->unique()->safeEmail();

        User::factory()->create([
            'username' => $username,
            'email' => $email,
            'position_id' => $position->id,
        ]);

        $this->assertDatabaseCount('users', 1);
        $this->expectException(QueryException::class);

        User::factory()->create([
            'username' => $username,
            'email' => $email,
            'position_id' => $position->id,
        ]);

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function a_user_password_must_be_encrypted()
    {
        $position = Position::factory()->create();
        $password = "MyPassword";
        $user = User::factory()->create([
            'position_id' => $position->id,
            'password' => Hash::make($password)
        ]);

        $this->assertNotEquals($password, $user->password);
        $this->assertTrue(Hash::check($password, $user->password));
    }

    /** @test */
    public function a_user_password_must_be_private()
    {
        $position = Position::factory()->create();
        $user = User::factory()->create([
            'position_id' => $position->id,
            'password' => Hash::make("MyPassword")
        ]);

        $userResponse = $user->toArray();
        $this->assertArrayNotHasKey('password', $userResponse);
    }
}
