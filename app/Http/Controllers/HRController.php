<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Leave;

class HRController extends Controller
{
    public function index()
    {
        $allUsers = User::count();
        $pendingLeaves = Leave::where('status', 'Pending')->count();
        return view('hr.dashboard', compact('allUsers', 'pendingLeaves'));
    }

    public function users()
    {
        $users = User::all();
        return view('hr.users', compact('users'));
    }
}
