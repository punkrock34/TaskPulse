<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        $task = [
            'id' => 1,
            'title' => 'Sample Task Title',
            'description' => 'Sample task description.',
            'completed' => false,
            'created_at' => now()->toDateTimeString(),
            'deadline' => now()->addDay()->toDateTimeString(),
        ];

        return Inertia::render('TaskDetails', [
            'task' => $task,
        ]);
    }
}
