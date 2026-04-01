<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class TeacherController extends Controller
{
    public function index()
    {
        $studentCount = User::where('role', 'student')->count();
        $presentToday = Attendance::where('date', Carbon::today())->where('status', 'Present')->count();
        return view('teacher.dashboard', compact('studentCount', 'presentToday'));
    }

    public function attendance()
    {
        $students = User::where('role', 'student')->get();
        return view('teacher.attendance', compact('students'));
    }
}
