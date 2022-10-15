<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $institution_names = [
            "Faker Universitas Indonesia",
            "Faker Universitas Gadjah Mada",
            "Faker Universitas Brawijaya",
            "Faker Institut Teknologi Bandung",
        ];

        return [
            'name' => $institution_names[rand(0, 3)],
        ];
    }
}
