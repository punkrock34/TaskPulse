<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //create task with title, description, status, random uid string, 10 times
        for ($i = 1; $i <= 10; $i++) {
            $status = ['todo', 'in_progress', 'completed'];
            $randStatus = array_rand($status);
            Task::create([
                'title' => 'Task ' . $i,
                'description' => 'Description for task ' . $i,
                'status' => $status[$randStatus],
                'owner_id' => '03lHqYxmKPanHvZwUNVtCwtQ7jk2'
            ]);
        }
    }
}
