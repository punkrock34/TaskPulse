<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use DateTime;

enum TaskStatus: string
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}

interface RepositoryInterface
{
    public function all(): array;
}

class FakeTask
{
    public $id;
    public $title;
    public $description;
    public $status;
    public $created_at;
    public $updated_at;
    public $user_id;

    public function __construct(
        $id = null, 
        $title = null, 
        $description = null, 
        $status = null,
        $user_id = null
    )
    {
        $this->id = $id ?? rand(1, 1000);
        $this->title = $title ?? "Fake Task " . $this->id;
        $this->description = $description ?? "Description for fake task " . $this->id;
        $this->status = $status ?? TaskStatus::TODO->value;
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
        $this->user_id = $user_id ?? 1;
    }

    protected function user()
    {
        return new class
        {
            public function id()
            {
                return 1;
            }
        };
    }
}

class FakeTaskRepository implements RepositoryInterface
{
    protected $tasks;

    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }

    public function all(): array
    {
        return $this->tasks;
    }
}

class FakeTaskService
{
    protected $taskRepository;

    public function __construct($taskRepository = null)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAllTasks(): array
    {
        return $this->taskRepository->all();
    }
}

function fakeTasks($taskNumber) {
    $tasks = [];

    if ($taskNumber <= 0) {
        return $tasks;
    }

    for ($i = 0; $i < $taskNumber; $i++) {
        $tasks[] = new FakeTask();
    }
    
    return $tasks;
}

function fakeTaskService($tasksNumber = 0)
{
    $tasks = fakeTasks($tasksNumber);
    return new FakeTaskService(new FakeTaskRepository($tasks));
}

// TODO: update tests to only test for tasks linked to the user
class TasksTest extends TestCase
{
    public function test_get_all_returns_empty_when_there_are_no_tasks(): void
    {
        $taskService = fakeTaskService();
        $tasks = $taskService->getAllTasks();

        $this->assertEmpty($tasks);
        $this->assertCount(0, $tasks);
    }

    public function test_get_all_returns_single_task_when_one_tasks_exists(): void
    {
        $taskService = fakeTaskService(1);
        $tasks = $taskService->getAllTasks();

        $this->assertNotEmpty($tasks);
        $this->assertCount(1, $tasks);
    }

    public function test_get_all_returns_multiple_tasks_when_multiple_tasks_exists(): void 
    {
        $taskService = fakeTaskService(5);
        $tasks = $taskService->getAllTasks();

        $this->assertNotEmpty($tasks);
        $this->assertCount(5, $tasks);
    }
}
