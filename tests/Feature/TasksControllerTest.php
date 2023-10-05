<?php

namespace Tests\Feature;

use App\Jobs\UpdateStatisticsJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Admin;
use App\Models\Task;
use App\Models\User;
use \Illuminate\Pagination\LengthAwarePaginator;
use \Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class TasksControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @return void
     */
    public function test_should_create_task_with_a_successful_response()
    {
        $user = User::factory()->create();
        $admin = Admin::factory()->create();

        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test task description',
            'assigned_to_id' => $user->id,
            'assigned_by_id' => $admin->id,
        ];

        // Mock the UpdateStatisticsJob
        Queue::fake();

        // Make a POST request to the store route with valid data
        $response = $this->post(route('task.store'), $taskData);

        // Assert that the task was created in the database
        $this->assertDatabaseHas('tasks', $taskData);


        // Assert that the UpdateStatisticsJob is dispatched
        Queue::assertPushed(UpdateStatisticsJob::class, function ($job) use ($taskData) {
            return $job->getAssignedToUserId() === $taskData['assigned_to_id'];
        });

        // Assert that a success flash message is set
        $response->assertSessionHas('response', [
            'type' => 'success',
            'message' => $taskData['title'] . ' Created Successfully',
        ]);

        // Assert that the user is redirected to the task list route
        $response->assertRedirect(route('task.list'));
    }


    /**
     *
     * @return void
     */
    public function test_task_not_stored_and_job_not_dispatched_due_to_missing_required_parameter()
    {
        $admin = Admin::factory()->create();

        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test task description',
            'assigned_by_id' => $admin->id,
        ];

        // Mock the UpdateStatisticsJob
        Queue::fake();

        // Make a POST request to the store route with invalid data (e.g., missing required field assigned_to_id)
        $response = $this->post(route('task.store'), $taskData);


        $this->assertDatabaseEmpty('tasks');
        $this->assertDatabaseMissing('tasks', $taskData);


        // Assert that an error flash message is set
        $response->assertSessionHas('response', [
            'type' => 'error',
            'message' => 'The assigned to id field is required.',
        ]);

        Queue::assertNothingPushed();
        // Assert that the user is redirected back to the task creation form
        $response->assertRedirect(route('task.list'));
    }


    public function testIndexListsTasksPaginated()
    {
        // Create 35 tasks in the database for testing pagination
        Task::factory()->count(35)->create();

        // Make a GET request to the index route
        $response = $this->get(route('task.list'));

        // Assert that the response has a successful status code (200)
        $response->assertStatus(200);

        // Assert that the view contains the tasks pagination links
        $response->assertSee('Previous');
        $response->assertSee('1');
        $response->assertSee('Next');

        // Assert that the view contains 10 tasks (due to pagination)
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks instanceof LengthAwarePaginator && $tasks->count() === 10;
        });
    }
}
