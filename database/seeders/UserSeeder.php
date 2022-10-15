<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $position = DB::table('positions')
            ->where('name', 'Senior HRD')
            ->first();

        $userData = [
            'first_name' => 'John Doe',
            'last_name' => NULL,
            'position_id' => $position->id,
            'username' => 'johndoe',
            'email' => 'john@dev.com',
            'email_verified_at' => NULL,
            'password' => Hash::make('password'),
        ];

        $user = User::where('email', 'john@dev.com')->first();
        if (empty($user)) {
            $user = User::create($userData);
        }
    }
}
