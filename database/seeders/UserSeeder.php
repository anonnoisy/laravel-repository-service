<?php

namespace Database\Seeders;

use App\Models\User;
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

        $seniorHRDUserData = [
            'first_name' => 'John Doe',
            'last_name' => NULL,
            'position_id' => $position->id,
            'username' => 'johndoe',
            'email' => 'john@dev.com',
            'email_verified_at' => NULL,
            'password' => Hash::make('password'),
        ];

        $seniorHRD = User::where('email', 'john@dev.com')->first();
        if (empty($seniorHRD)) {
            $seniorHRD = User::create($seniorHRDUserData);
        }

        $position = DB::table('positions')
            ->where('name', 'HRD')
            ->first();

        $hrdUserData = [
            'first_name' => 'Kyle Alam',
            'last_name' => 'Bustamante',
            'position_id' => $position->id,
            'username' => 'kylealam',
            'email' => 'kyle@dev.com',
            'email_verified_at' => NULL,
            'password' => Hash::make('password'),
        ];

        $hrd = User::where('email', 'kyle@dev.com')->first();
        if (empty($hrd)) {
            $hrd = User::create($hrdUserData);
        }
    }
}
