<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'description' => fake()->text(),
            'assigned_to_id' => function(){
                return  User::factory()->create()->id;
            },
            'assigned_by_id' => function(){
                return  Admin::factory()->create()->id;
            }
        ];
    }
}
