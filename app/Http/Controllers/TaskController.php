<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = User::where('role', 'student')->get();
        return view('admin.tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        Task::create([
            'user_id' => $data['user_id'],
            'admin_id' => Auth::id(),
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => 'Assigned'
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Task assigned successfully.');
    }

    public function submit(Request $request, Task $task)
    {
        $request->validate(['response' => 'required|string']);

        $task->update([
            'user_response' => $request->response,
            'status' => 'Submitted'
        ]);

        return back()->with('success', 'Task submitted successfully.');
    }
}
