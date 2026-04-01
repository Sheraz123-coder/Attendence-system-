@extends('layouts.layout')

@section('title', 'Reports')
@section('page-title', 'Attendance Reports')
@section('page-subtitle', 'Filter & analyze attendance')

@section('content')

<div class="card-box">

<form method="GET" action="{{ route('admin.reports') }}" class="row g-3">

<div class="col-md-4">
<select name="user_id" class="form-select">
<option value="">All Students</option>
@foreach($users as $user)
<option value="{{ $user->id }}"
{{ request('user_id') == $user->id ? 'selected' : '' }}>
{{ $user->name }}
</option>
@endforeach
</select>
</div>

<div class="col-md-3">
<input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
</div>

<div class="col-md-3">
<input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100">Filter</button>
</div>

</form>

</div>

<div class="card-box">

<table class="table table-hover">

<thead>
<tr>
<th>Date</th>
<th>Student</th>
<th>Status</th>
<th>Notes</th>
</tr>
</thead>

<tbody>

@forelse($reports as $report)
<tr>

<td>{{ $report->date }}</td>
<td>{{ $report->user->name ?? 'N/A' }}</td>

<td>
<span class="badge {{ $report->status == 'Present' ? 'bg-success' : 'bg-danger' }}">
{{ $report->status }}
</span>
</td>

<td>{{ $report->notes }}</td>

</tr>
@empty
<tr>
<td colspan="4" class="text-center text-muted">No data found</td>
</tr>
@endforelse

</tbody>

</table>

</div>

@endsection