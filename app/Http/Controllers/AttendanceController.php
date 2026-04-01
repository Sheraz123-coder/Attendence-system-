<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Leave;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->first();

        $attendances = Attendance::where('user_id', $user->id)->orderBy('date', 'desc')->get();
        $leaves = Leave::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $tasks = Task::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();


        $stats = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'Present')->count(),
            'absent' => $attendances->where('status', 'Absent')->count(),
            'late' => $attendances->where('status', 'Late')->count(),
        ];

        return view('attendance', compact('todayAttendance', 'attendances', 'leaves', 'tasks', 'stats'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        

        $exists = Attendance::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->exists();

        if ($exists) {
            return back()->with('error', 'Attendance already marked for today.');
        }

        Attendance::create([
            'user_id' => $user->id,
            'date' => Carbon::today(),
            'status' => 'Present',
        ]);

        return back()->with('success', 'Attendance marked successfully.');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('avatars'), $imageName);
            
            $user->update([
                'profile_image' => 'avatars/' . $imageName
            ]);
        }

        return back()->with('success', 'Profile picture updated successfully.');
    }
}
