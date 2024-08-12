<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        return $this->taskService->getAllTasks();
    }
}