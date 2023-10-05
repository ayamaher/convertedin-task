<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Admin;
use App\Models\Statistics;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class StatisticsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @return void
     */
    public function test_statistics_returns_top_10_tasks_users_with_a_successful_response()
    {

        $admin = Admin::factory()->create();
        $topUsersCount = 10;
        $otherUsersCount = 30;
        $top10TasksUsers = User::factory()->count($topUsersCount)->create();
        $otherUsers = User::factory()->count($otherUsersCount)->create();
        $topUsersTasksCount = 20;
        $otherUsersTasksCount = 2;

        foreach ($top10TasksUsers as $top10TasksUser){
            Task::factory()->count($topUsersTasksCount)->create(['assigned_by_id' => $admin->id, 'assigned_to_id' => $top10TasksUser->id]);
            Statistics::factory()->create(['user_id' => $top10TasksUser, 'task_count' => $topUsersTasksCount]);
        }

        foreach ($otherUsers as $otherUser){
            Task::factory()->count($otherUsersTasksCount)->create(['assigned_by_id' => $admin->id, 'assigned_to_id' => $otherUser->id]);
            Statistics::factory()->create(['user_id' => $otherUser, 'task_count' => $otherUsersTasksCount]);
        }

        $response = $this->get('/statistics');

        $response->assertStatus(200);
        $this->assertCount(10, $response['topUsers']);

        foreach ($response['topUsers'] as $topUser) {
            $this->assertEquals($topUsersTasksCount, $topUser->tasks_count);
            $this->assertInstanceOf(User::class, $topUser);
        }

        $this->assertDatabaseCount('statistics', $topUsersCount  + $otherUsersCount );
        $this->assertDatabaseCount('tasks', ($topUsersCount * $topUsersTasksCount) + ($otherUsersCount * $otherUsersTasksCount));
    }
}
