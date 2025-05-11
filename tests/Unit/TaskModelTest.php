<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test task model creation.
     *
     * @return void
     */
    public function test_can_create_task()
    {
        $taskData = [
            'name' => 'Test Task',
            'description' => 'This is a test task',
            'status' => 'Pending'
        ];

        $task = Task::create($taskData);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals('Test Task', $task->name);
        $this->assertEquals('This is a test task', $task->description);
        $this->assertEquals('Pending', $task->status);
    }

    /**
     * Test task model attributes.
     *
     * @return void
     */
    public function test_task_has_correct_attributes()
    {
        $task = Task::factory()->create([
            'name' => 'Attribute Test',
            'description' => 'Testing attributes',
            'status' => 'Completed'
        ]);

        $this->assertEquals('Attribute Test', $task->name);
        $this->assertEquals('Testing attributes', $task->description);
        $this->assertEquals('Completed', $task->status);
    }

    /**
     * Test task model fillable attributes.
     *
     * @return void
     */
    public function test_task_has_correct_fillable_attributes()
    {
        $task = new Task();
        
        $this->assertEquals([
            'name',
            'description',
            'status',
        ], $task->getFillable());
    }
}
