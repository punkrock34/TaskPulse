<?php

namespace App\Http\Controllers;

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
}
