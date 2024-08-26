<?php

namespace App\Services;

use App\Exceptions\TaskNotFoundException;
use App\Exceptions\UnexpectedErrorException;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskService
{
    public function getTask(int $id): Task
    {
        try {
            return Task::with('attachments')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Log::error("Task not found: {$e->getMessage()}");
            throw new TaskNotFoundException;
        } catch (\Exception $e) {
            Log::error("Error fetching task: {$e->getMessage()}");
            throw new UnexpectedErrorException;
        }
    }

    public function getUserTasks(): array
    {
        try {
            return Auth::user()->tasks->toArray();
        } catch (\Exception $e) {
            Log::error("Error fetching user tasks: {$e->getMessage()}");
            throw new UnexpectedErrorException;
        }
    }

    public function createTask(array $data): Task
    {
        try {
            return Task::create($data);
        } catch (\Exception $e) {
            Log::error("Error creating task: {$e->getMessage()}");
            throw new UnexpectedErrorException;
        }
    }

    public function updateTask(Task $task, array $data): Task
    {
        try {
            $task->update($data);

            return $task;
        } catch (\Exception $e) {
            Log::error("Error updating task: {$e->getMessage()}");
            throw new UnexpectedErrorException;
        }
    }

    public function deleteTask(Task $task): void
    {
        try {
            $task->delete();
        } catch (\Exception $e) {
            Log::error("Error deleting task: {$e->getMessage()}");
            throw new UnexpectedErrorException;
        }
    }
}
