<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    // Show all tasks
    public function index(Request $request)
    {
        $tasks = Task::where('user_id', Auth::id())->get(); // sary records ko fetch kary ga jaha userid loggedin user sy match kary ge 

        if ($request->ajax()) {            // If the request is AJAX, return JSON instead of a view

            return response()->json($tasks);  
        }

        return view('tasks.index', compact('tasks'));
    }

    // Store new task
    public function store(Request $request)
    {
        $request->validate([  //ye sub inputs hai 
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'status'      => 'nullable|in:pending,completed',
        ]);

        $task = Task::create([
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'status'      => $request->status ?? 'pending',
            'user_id'     => Auth::id(),
        ]);

        return response()->json(['success' => true, 'task' => $task]); //jeson response denga sucsess ka
    }
 //aur phr hum ajx ky through crud karengy 
    // Show single task
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return response()->json($task);
    }

    // Edit method (for AJAX edit form)
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return response()->json($task);
    }

    // Update task
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'status'      => 'required|in:pending,completed',
        ]);

        $task->update($request->only('title', 'description', 'due_date', 'status'));

        return response()->json(['success' => true, 'task' => $task]);
    }

    // Delete task
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(['success' => true]);
    }

    // Update only status
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([ //ye array ky through dekhengy ky pending hai status ya complete 
            'status' => 'required|in:pending,completed',
        ]);

        $task->update(['status' => $request->status]);

        return response()->json(['success' => true, 'task' => $task]);
    }
}
