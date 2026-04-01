@extends('layouts.user-layout')

@section('title', 'Dashboard')

@section('content')

{{-- ALERTS --}}


{{-- HEADER --}}
<div class="card-box mb-4 d-flex justify-content-between align-items-center flex-wrap">

<div class="d-flex align-items-center gap-3">

{{-- PROFILE IMAGE (CLICK TO UPDATE) --}}
<img
src="{{ auth()->user()->profile_image
? asset(auth()->user()->profile_image)
: 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}"
class="rounded-circle shadow"
style="width:60px;height:60px;object-fit:cover;cursor:pointer;"
data-bs-toggle="modal"
data-bs-target="#profileModal">

<div>
<h4 class="mb-0">Hi, {{ auth()->user()->name }}</h4>
<small class="text-muted">
ID #{{ auth()->user()->id }} | Joined {{ auth()->user()->created_at->format('M Y') }}
</small>
</div>

</div>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button class="btn btn-outline-danger">
Logout
</button>
</form>

</div>

{{-- PROFILE UPDATE MODAL --}}
<div class="modal fade" id="profileModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update Profile Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body text-center">

                    <img
                    src="{{ auth()->user()->profile_image
                    ? asset(auth()->user()->profile_image)
                    : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}"
                    class="rounded-circle mb-3"
                    style="width:80px;height:80px;object-fit:cover;">

                    <input type="file" name="image" class="form-control" required>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary w-100">
                        Upload Image
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- STATS --}}
<div class="row mb-4">

<div class="col-md-4">
<div class="card-box text-center">
<h6 class="text-primary">TOTAL PRESENT</h6>
<h2>{{ $stats['present'] }}</h2>
</div>
</div>

<div class="col-md-4">
<div class="card-box text-center">
<h6 class="text-danger">TOTAL ABSENT</h6>
<h2>{{ $stats['absent'] }}</h2>
</div>
</div>

<div class="col-md-4">
<div class="card-box text-center">
<h6 class="text-warning">LATE ARRIVALS</h6>
<h2>{{ $stats['late'] }}</h2>
</div>
</div>

</div>

<div class="row">

{{-- ATTENDANCE --}}
<div class="col-md-7 mb-4">

<div class="card-box">

<h5>Today's Attendance</h5>

@if($todayAttendance)

<div class="alert alert-success text-center mt-3">
<h4>Present</h4>
<p>{{ $todayAttendance->created_at->format('H:i A') }}</p>
</div>

@else

<form action="{{ route('attendance.mark') }}" method="POST">
@csrf
<button class="btn btn-primary w-100 mt-3">
Mark Attendance
</button>
</form>

@endif

<table class="table mt-4">
<thead>
<tr>
<th>Date</th>
<th>Status</th>
<th>Time</th>
</tr>
</thead>
<tbody>
@foreach($attendances as $row)
<tr>
<td>{{ $row->date }}</td>
<td>
<span class="badge {{ $row->status == 'Present' ? 'bg-success' : 'bg-danger' }}">
{{ $row->status }}
</span>
</td>
<td>{{ $row->created_at->format('H:i') }}</td>
</tr>
@endforeach
</tbody>
</table>

</div>

</div>

{{-- LEAVE --}}
<div class="col-md-5 mb-4">

<div class="card-box">

<h5>Request Leave</h5>

<form action="{{ route('leave.request') }}" method="POST">
@csrf

<input type="date" name="from_date" class="form-control mb-2" required>
<input type="date" name="to_date" class="form-control mb-2" required>

<textarea name="reason" class="form-control mb-2" rows="3"
placeholder="Reason" required></textarea>

<button class="btn btn-outline-primary w-100">
Submit Request
</button>

</form>

<hr>

<h6>Leave History</h6>

@foreach($leaves as $leave)
<div class="d-flex justify-content-between border-bottom py-2">
<span>{{ $leave->from_date }}</span>

<span class="badge
{{ $leave->status == 'Pending' ? 'bg-warning' :
($leave->status == 'Approved' ? 'bg-success' : 'bg-danger') }}">
{{ $leave->status }}
</span>

</div>
@endforeach

</div>

</div>

</div>

@endsection