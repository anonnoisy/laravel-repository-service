<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            "Laravel",
            "Mysql",
            "PostgreSQL",
            "Codeigniter",
            "Java",
            "Visual Design",
            "Design Software",
            "User Research",
            "Usability Testing",
            "Agile"
        ];

        foreach ($skills as $skill) {
            $exists = DB::table('skills')
                ->where('name', $skill)
                ->first();

            if (empty($exists)) {
                DB::table('skills')->insert([
                    'name' => $skill,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
