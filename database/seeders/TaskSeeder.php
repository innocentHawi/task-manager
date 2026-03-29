<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'title'    => 'Fix critical authentication bug',
                'due_date' => now()->addDays(1)->format('Y-m-d'),
                'priority' => 'high',
                'status'   => 'pending',
            ],
            [
                'title'    => 'Deploy hotfix to production',
                'due_date' => now()->addDays(2)->format('Y-m-d'),
                'priority' => 'high',
                'status'   => 'in_progress',
            ],
            [
                'title'    => 'Update API documentation',
                'due_date' => now()->addDays(3)->format('Y-m-d'),
                'priority' => 'medium',
                'status'   => 'pending',
            ],
            [
                'title'    => 'Write unit tests for task module',
                'due_date' => now()->addDays(4)->format('Y-m-d'),
                'priority' => 'medium',
                'status'   => 'done',
            ],
            [
                'title'    => 'Clean up unused dependencies',
                'due_date' => now()->addDays(5)->format('Y-m-d'),
                'priority' => 'low',
                'status'   => 'done',
            ],
            [
                'title'    => 'Review pull requests',
                'due_date' => now()->addDays(2)->format('Y-m-d'),
                'priority' => 'high',
                'status'   => 'pending',
            ],
            [
                'title'    => 'Set up staging environment',
                'due_date' => now()->addDays(6)->format('Y-m-d'),
                'priority' => 'medium',
                'status'   => 'in_progress',
            ],
            [
                'title'    => 'Optimise database queries',
                'due_date' => now()->addDays(7)->format('Y-m-d'),
                'priority' => 'low',
                'status'   => 'pending',
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}