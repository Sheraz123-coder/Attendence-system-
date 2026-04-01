@extends('layouts.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'System overview')

@section('content')

<div class="row">

    <div class="col-md-4">
        <div class="card-box">
            <h6>Total Users</h6>
            <h2>{{ $usersCount ?? 0 }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box">
            <h6>Total Attendance</h6>
            <h2>{{ $attendanceCount ?? 0 }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box">
            <h6>Pending Leaves</h6>
            <h2>{{ $pendingLeaves ?? 0 }}</h2>
        </div>
    </div>

</div>

@endsection