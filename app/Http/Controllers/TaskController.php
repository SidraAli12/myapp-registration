<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * Show all tasks for logged-in user
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();  // Sirf current logged-in user ke tasks fetch karo
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show create task form
     */
    public function create()
    {
        return view('tasks.create');  // Sirf form dikhata hai jahan se user task add karega
    }

    /**
     * Store new task
     */
    public function store(Request $request)
    {
        $request->validate([  // Validation: title required hai, baqi optional
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'status' => 'required|in:pending,completed',
        ]);

        Task::create([   // ye array Task create karna aur user_id automatically assign karna
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'status'      => 'pending',   // default
            'user_id'     => Auth::id(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created!');
    }

    /**
     * Show edit task form
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update task details
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
        ]);

        $task->update($request->only('title', 'description', 'due_date','status'));

        return redirect()->route('tasks.index')->with('success', 'Task updated!');
    }

    /**
     * Delete task
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task); // Policy check: sirf owner apna task delete kare

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted!');
    }

    /**
     * Update only status of task
     */
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'status' => 'required|in:pending,completed',
        ]);

        $task->update(['status' => $request->status]);  // Status validation: sirf pending ya completed allow hai

        return redirect()->route('tasks.index')->with('success', 'Task status updated!');
    }
}
