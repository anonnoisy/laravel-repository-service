<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            'CEO',
            'CTO',
            'CMO',
            'Senior HRD',
            'HRD',
            'Frontend Developer',
            'Backend Developer',
            'Mobile Developer',
            'UI/UX Designer',
        ];

        foreach ($positions as $position) {
            $exists = DB::table('positions')
                ->where('name', $position)
                ->first();

            if (empty($exists)) {
                DB::table('positions')->insert([
                    'name' => $position,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
