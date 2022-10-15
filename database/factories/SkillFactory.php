<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $skills = [
            "Laravel",
            "Mysql",
            "PostgreSQL",
            "Codeigniter",
            "Java"
        ];

        return [
            'name' => $skills[rand(0, 4)],
        ];
    }
}
