<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskCreatorController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    public function index()
    {
        return Inertia::render('CreateTask');
    }

    public function store(TaskCreateRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        try {
            $task = $this->taskService->createTask($data);

            return redirect()->route('task.index', $task->id);
        } catch (\Exception $e) {
            return Inertia::render('CreateTask', ['errors' => [$e->getCode() => $e->getMessage()]]);
        }
    }
}
