<?php

namespace Tests\Unit;

use App\Models\Candidate;
use App\Models\Education;
use App\Models\Position;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidateModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_candidate_has_a_education()
    {
        $education = Education::factory()->create();
        $last_position = Position::factory()->create();
        $applied_position = Position::factory()->create();
        $candidate = Candidate::factory()->create([
            'education_id' => $education->id,
            'last_position_id' => $last_position->id,
            'applied_position_id' => $applied_position->id,
        ]);

        // Method 1:
        $this->assertInstanceOf(Education::class, $candidate->education);

        // Method 2:
        $this->assertEquals(1, $candidate->education->count());
    }

    /** @test */
    public function a_candidate_related_with_position()
    {
        $education = Education::factory()->create();
        $last_position = Position::factory()->create();
        $applied_position = Position::factory()->create();
        $candidate = Candidate::factory()->create([
            'education_id' => $education->id,
            'last_position_id' => $last_position->id,
            'applied_position_id' => $applied_position->id,
        ]);

        // Method 1:
        $this->assertInstanceOf(Position::class, $candidate->last_position);
        $this->assertInstanceOf(Position::class, $candidate->applied_position);

        // Method 2:
        $this->assertEquals(2, $candidate->last_position->count());
        $this->assertEquals(2, $candidate->applied_position->count());
    }

    /** @test */
    public function a_candidate_email_or_phone_number_must_be_unique()
    {
        $education = Education::factory()->create();
        $last_position = Position::factory()->create();
        $applied_position = Position::factory()->create();

        $phoneNumber = fake()->unique()->phoneNumber();
        Candidate::factory()->create([
            'email' => 'duplicate@email.com',
            'phone_number' => $phoneNumber,
            'education_id' => $education->id,
            'last_position_id' => $last_position->id,
            'applied_position_id' => $applied_position->id,
        ]);

        $this->assertDatabaseCount('candidates', 1);
        $this->expectException(QueryException::class);

        Candidate::factory()->create([
            'email' => 'duplicate@email.com',
            'phone_number' => $phoneNumber,
            'education_id' => $education->id,
            'last_position_id' => $last_position->id,
            'applied_position_id' => $applied_position->id,
        ]);

        $this->assertDatabaseCount('candidates', 1);
    }
}
