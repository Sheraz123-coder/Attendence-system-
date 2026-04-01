<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required|string'
        ]);

        Leave::create([
            'user_id' => Auth::id(),
            'from_date' => $data['from_date'],
            'to_date' => $data['to_date'],
            'reason' => $data['reason'],
            'status' => 'Pending'
        ]);

        return back()->with('success', 'Leave request submitted successfully.');
    }
}
