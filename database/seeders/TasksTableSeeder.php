<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = ['low', 'medium', 'high'];

        Task::create([
            'title'       => 'Task 1',
            'description' => 'Test description 1',
            'status'      => 'pending',
            'priority'    => $priorities[array_rand($priorities)],
            'due_date'    => Carbon::now()->addDays(3),
        ]);

        Task::create([
            'title'       => 'Task 2',
            'description' => 'Test description 2',
            'status'      => 'in-progress',
            'priority'    => $priorities[array_rand($priorities)],
            'due_date'    => Carbon::now()->addDays(5),
        ]);

        Task::create([
            'title'       => 'Task 3',
            'description' => 'Test description 3',
            'status'      => 'completed',
            'priority'    => $priorities[array_rand($priorities)],
            'due_date'    => Carbon::now()->addDay(),
        ]);
    }
}
