<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TasksController extends Controller
{
    public function index(Request $request) {
        $search = $request->query('search');

        // default sort by due_date
        $sortField = $request->query('sort', 'due_date');
        $sortDirection = $request->query('direction', 'asc');

        // get tasks - added search and sort
        $tasks = Task::when($search, function($query, $search) {
            $query->where('title', 'like', "%{$search}%");
        })
        ->orderBy($sortField, $sortDirection)
        ->get();

        return view('tasks.index', compact('tasks', 'search', 'sortField', 'sortDirection'));
    }

    public function create() {
        return view('tasks.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|string|in:pending,in-progress,completed',
            'due_date'    => 'required|date',
        ],
        [
            'due_date.required' => 'Due date is required for all tasks',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully');
    }

    public function edit($id) {
        $task = Task::find($id);

        if (!$task) {
            return redirect()->route('tasks.index')
                ->with('error', 'Task not found.');
        }

        return view('tasks.edit')->with('task', $task);
    }

    public function update(Request $request) {
        $task = Task::find($request->id);

        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found.');
        }
        
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|string|in:pending,in-progress,completed',
            'due_date'    => 'required|date',
        ],
        [
            'due_date.required' => 'Due date is required for all tasks',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully');
    }



    public function destroy(Request $request) {
        $task = Task::find($request->id);
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully');
    }
}
