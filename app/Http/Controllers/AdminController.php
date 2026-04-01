<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Leave;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $pendingLeaves = Leave::where('status', 'Pending')->count();
        $presentToday = Attendance::where('date', Carbon::today())->where('status', 'Present')->count();
        
        return view('admin.dashboard', compact('usersCount', 'pendingLeaves', 'presentToday'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:student,teacher,hr,admin',
            'password' => 'required|min:8'
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.users')->with('success', 'User added successfully.');
    }

    public function allTasks()
    {
        $tasks = Task::with('user', 'admin')->orderBy('created_at', 'desc')->get();
        return view('admin.tasks.manage', compact('tasks'));
    }

    public function approveTask(Request $request, Task $task)
    {
        $task->update([
            'status' => $request->status,
            'admin_feedback' => $request->feedback
        ]);

        return back()->with('success', 'Task status updated.');
    }

    public function users()
    {
        $users = User::all();
        foreach ($users as $user) {
            if ($user->role === 'student') {
                $user->attendance_count = $user->attendances()->whereMonth('date', Carbon::now()->month)->count();
                $user->grade = $this->calculateGrade($user->attendance_count);
            } else {
                $user->attendance_count = '-';
                $user->grade = '-';
            }
        }
        return view('admin.users', compact('users'));
    }

    public function leaves()
    {
        $leaves = Leave::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.leaves', compact('leaves'));
    }

    public function approveLeave(Request $request, Leave $leave)
    {
        $leave->update([
            'status' => $request->status,
            'admin_comment' => $request->comment
        ]);

        return back()->with('success', 'Leave request updated.');
    }

    public function reports(Request $request)
    {
        try {
            $query = Attendance::with('user');

            if ($request->from_date && $request->to_date) {
                $query->whereBetween('date', [$request->from_date, $request->to_date]);
            }

            if ($request->user_id) {
                $query->where('user_id', $request->user_id);
            }

            $reports = $query->get();
            $users = User::all();

            return view('admin.reports', compact('reports', 'users'));
        } catch (\Exception $e) {
            return back()->with('error', 'Report Error: ' . $e->getMessage());
        }
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function deleteLeave(Leave $leave)
    {
        $leave->delete();
        return back()->with('success', 'Leave request deleted successfully.');
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
        return back()->with('success', 'Task deleted successfully.');
    }

    public function editTask(Task $task)
    {
        $users = User::where('role', 'student')->get();
        return view('admin.tasks.edit', compact('task', 'users'));
    }

    public function updateTask(Request $request, Task $task)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $task->update($data);

        return redirect()->route('admin.tasks.manage')->with('success', 'Task updated successfully.');
    }

    private function calculateGrade($days)
    {
        if ($days >= 26) return 'A';
        if ($days >= 20) return 'B';
        if ($days >= 15) return 'C';
        if ($days >= 10) return 'D';
        return 'F';
    }
}
