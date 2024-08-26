<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Inertia\Inertia;

class TaskDetailsController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    public function index()
    {
        $task = $this->taskService->getTask(request()->route('id'));

        return Inertia::render('TaskDetails', [
            'task' => $task->toArray(),
        ]);
    }

    public function update(UpdateTaskRequest $request)
    {
        $task = $this->taskService->getTask($request->route('id'));
        $data = $request->validated();

        try {
            $this->taskService->updateTask($task, $data);

            return Inertia::render('TaskDetails', [
                'task' => $task->toArray(),
                'success' => 'Task updated successfully',
            ]);
        } catch (\Exception $e) {
            return Inertia::render('TaskDetails', [
                'task' => $task->toArray(),
                'errors' => [$e->getCode() => $e->getMessage()],
            ]);
        }
    }
}
