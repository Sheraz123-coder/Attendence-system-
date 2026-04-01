@extends('layouts.layout')

@section('title', 'Leaves')
@section('page-title', 'Leave Approvals')
@section('page-subtitle', 'Manage leave requests')

@section('content')

<div class="card-box">



<table class="table table-hover align-middle">

<thead>
<tr>
<th>Student</th>
<th>Dates</th>
<th>Reason</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@foreach($leaves as $leave)
<tr>

<td>{{ $leave->user->name }}</td>

<td>{{ $leave->from_date }} to {{ $leave->to_date }}</td>

<td>{{ $leave->reason }}</td>

<td>
<span class="badge 
{{ $leave->status == 'Pending' ? 'bg-warning' : ($leave->status == 'Approved' ? 'bg-success' : 'bg-danger') }}">
{{ $leave->status }}
</span>
</td>

<td>

@if($leave->status == 'Pending')
<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#m{{ $leave->id }}">
Manage
</button>

<!-- Modal -->
<div class="modal fade" id="m{{ $leave->id }}">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5>Leave Action</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form action="{{ route('admin.leaves.approve', $leave) }}" method="POST">
@csrf

<div class="modal-body">

<select name="status" class="form-select mb-2">
<option value="Approved">Approve</option>
<option value="Rejected">Reject</option>
</select>

<textarea name="comment" class="form-control" placeholder="Comment"></textarea>

</div>

<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button class="btn btn-primary">Save</button>
</div>

</form>

</div>
</div>
</div>

@else
<small class="text-muted">{{ $leave->admin_comment }}</small>
@endif

</td>

</tr>
@endforeach

</tbody>

</table>

</div>

@endsection