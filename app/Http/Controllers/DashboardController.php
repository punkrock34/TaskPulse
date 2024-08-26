<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    public function index()
    {
        return Inertia::render('Dashboard', [
            'tasks' => $this->taskService->getUserTasks(),
        ]);
    }
}
