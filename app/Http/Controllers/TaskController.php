<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateStatisticsJob;
use App\Models\Admin;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{


    /**
     * @return View
     */
    public function index(): View
    {
        $tasks = Task::paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $admins = Admin::all();
        $users = User::all();

        return view('tasks.create', compact('admins', 'users'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'assigned_to' => 'required|exists:users,id',
                'assigned_by' => 'required|exists:admins,id',
            ]);
            $assignedToUserId = $request->input('assigned_to');

            $task = Task::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'assigned_to_id' => $validatedData['assigned_to'],
                'assigned_by_id' => $validatedData['assigned_by'],
            ]);

            UpdateStatisticsJob::dispatchAfterResponse($assignedToUserId);
            $response['type'] = 'success';
            $response['message'] = $task->title . " Created Successfully";

        }catch (\Exception $e){
            $response['type'] = 'error';
            $response['message'] = $e->getMessage();
        }

        session()->flash('response', $response);

        return redirect()->route('task.list');
    }
}
