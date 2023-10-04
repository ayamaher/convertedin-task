<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        // Fetch data for dropdowns (e.g., admin names and assigned users)
        $admins = Admin::all();
        $users = User::all();

        return view('tasks.create', compact('admins', 'users'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'assigned_to' => 'required|exists:users,id', // Ensure it exists in the 'users' table
            'assigned_by' => 'required|exists:admins,id', // Ensure it exists in the 'admins' table
        ]);

        // Create a new task using the validated data
        Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'assigned_to_id' => $validatedData['assigned_to'],
            'assigned_by_id' => $validatedData['assigned_by'],
        ]);

        // Redirect the user after successfully creating the task
        return redirect()->route('task.list')->with('success', 'Task created successfully');
    }
}
