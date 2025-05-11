<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;

class TaskApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test retrieving all tasks.
     *
     * @return void
     */
    public function test_can_get_all_tasks()
    {
        // Create some tasks
        Task::factory()->count(3)->create();

        // Make request to get all tasks
        $response = $this->getJson('/api/tasks');

        // Assert response status and structure
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'description',
                             'status',
                             'created_at',
                             'updated_at'
                         ]
                     ]
                 ]);
        
        // Assert we have 3 tasks
        $this->assertCount(3, $response->json('data'));
    }

    /**
     * Test retrieving a single task.
     *
     * @return void
     */
    public function test_can_get_single_task()
    {
        // Create a task
        $task = Task::factory()->create();

        // Make request to get the task
        $response = $this->getJson("/api/tasks/{$task->id}");

        // Assert response status and data
        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $task->id,
                         'name' => $task->name,
                         'description' => $task->description,
                         'status' => $task->status
                     ]
                 ]);
    }

    /**
     * Test retrieving a non-existent task.
     *
     * @return void
     */
    public function test_cannot_get_nonexistent_task()
    {
        // Make request to get a non-existent task
        $response = $this->getJson('/api/tasks/999');

        // Assert response status and error message
        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Task not found'
                 ]);
    }

    /**
     * Test creating a new task.
     *
     * @return void
     */
    public function test_can_create_task()
    {
        // Task data
        $taskData = [
            'name' => 'Test Task',
            'description' => 'This is a test task',
            'status' => 'Pending'
        ];

        // Make request to create a task
        $response = $this->postJson('/api/tasks', $taskData);

        // Assert response status and data
        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'name' => 'Test Task',
                         'description' => 'This is a test task',
                         'status' => 'Pending'
                     ],
                     'message' => 'Task created successfully'
                 ]);
        
        // Assert task exists in database
        $this->assertDatabaseHas('tasks', [
            'name' => 'Test Task',
            'description' => 'This is a test task',
            'status' => 'Pending'
        ]);
    }

    /**
     * Test validation when creating a task.
     *
     * @return void
     */
    public function test_validation_when_creating_task()
    {
        // Invalid task data (missing required name)
        $taskData = [
            'description' => 'This is a test task',
            'status' => 'Invalid Status'
        ];

        // Make request to create a task
        $response = $this->postJson('/api/tasks', $taskData);

        // Assert response status and validation errors
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'status']);
    }

    /**
     * Test updating a task.
     *
     * @return void
     */
    public function test_can_update_task()
    {
        // Create a task
        $task = Task::factory()->create();

        // Updated task data
        $updatedData = [
            'name' => 'Updated Task Name',
            'description' => 'Updated task description',
            'status' => 'Completed'
        ];

        // Make request to update the task
        $response = $this->putJson("/api/tasks/{$task->id}", $updatedData);

        // Assert response status and data
        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $task->id,
                         'name' => 'Updated Task Name',
                         'description' => 'Updated task description',
                         'status' => 'Completed'
                     ],
                     'message' => 'Task updated successfully'
                 ]);
        
        // Assert task was updated in database
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Updated Task Name',
            'description' => 'Updated task description',
            'status' => 'Completed'
        ]);
    }

    /**
     * Test validation when updating a task.
     *
     * @return void
     */
    public function test_validation_when_updating_task()
    {
        // Create a task
        $task = Task::factory()->create();

        // Invalid task data
        $updatedData = [
            'name' => '',
            'status' => 'Invalid Status'
        ];

        // Make request to update the task
        $response = $this->putJson("/api/tasks/{$task->id}", $updatedData);

        // Assert response status and validation errors
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'status']);
    }

    /**
     * Test deleting a task.
     *
     * @return void
     */
    public function test_can_delete_task()
    {
        // Create a task
        $task = Task::factory()->create();

        // Make request to delete the task
        $response = $this->deleteJson("/api/tasks/{$task->id}");

        // Assert response status and message
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Task deleted successfully'
                 ]);
        
        // Assert task was deleted from database
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }

    /**
     * Test deleting a non-existent task.
     *
     * @return void
     */
    public function test_cannot_delete_nonexistent_task()
    {
        // Make request to delete a non-existent task
        $response = $this->deleteJson('/api/tasks/999');

        // Assert response status and error message
        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Task not found'
                 ]);
    }
}
