<?php

namespace Database\Factories;

use App\Models\Statistics;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Statistics>
 */
class StatisticsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_count' => function(){
                return fake()->numberBetween(1,2000);
            },
            'user_id' => function(){
                return  User::factory()->create()->id;
            }
        ];
    }
}
