<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{

    protected $model = Project::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(1),
            'description' => $this->faker->paragraph(1),
            'start_datetime' => $this->faker->dateTimeThisMonth(),
            'end_datetime' => $this->faker->dateTimeThisMonth(),
            'estimated_time' => $this->faker->randomNumber(2),
            'created_by' => "1",
        ];
    }
}
