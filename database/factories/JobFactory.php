<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'category_id' => rand(1, 4),
            'job_type_id' => rand(1, 4),
            'user_id' => 1,
            'vacancy' => $this->faker->numberBetween(1, 10),
            'salary' => $this->faker->numberBetween(1000, 10000),
            'location' => $this->faker->city,
            'description' => $this->faker->paragraph,
            'benefits' => $this->faker->paragraph,
            'responsibility' => $this->faker->paragraph,
            'qualifications' => $this->faker->paragraph,
            'keywords' => $this->faker->sentence,
            'experience' => $this->faker->numberBetween(1, 10),
            'company_name' => $this->faker->company,
            'company_location' => $this->faker->city,
            'company_website' => $this->faker->url,
        ];
    }
}
