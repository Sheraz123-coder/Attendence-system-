@extends('layouts.layout')

@section('title', 'Manage Tasks')
@section('page-title', 'Manage Tasks')
@section('page-subtitle', 'View, review and control all assigned tasks')

@section('content')

<div class="card-box">



<div class="table-responsive">
<table class="table table-hover align-middle">

<thead>
<tr>
<th>Student</th>
<th>Title</th>
<th>Status</th>
<th>Submission</th>
<th style="width: 220px;">Action</th>
</tr>
</thead>

<tbody>

@foreach($tasks as $task)
<tr>

<td>{{ $task->user->name }}</td>

<td>{{ $task->title }}</td>

<td>
<span class="badge 
{{ $task->status == 'Submitted' ? 'bg-warning' : 
   ($task->status == 'Approved' ? 'bg-success' : 'bg-primary') }}">
{{ $task->status }}
</span>
</td>

<td>
{{ \Illuminate\Support\Str::limit($task->user_response ?? 'No submission yet', 50) }}
</td>

<td class="d-flex gap-1 flex-wrap">

<!-- Review Button -->
<button class="btn btn-sm btn-outline-primary"
data-bs-toggle="modal"
data-bs-target="#modal{{ $task->id }}">
Review
</button>

<!-- Edit -->
<a href="{{ route('admin.tasks.edit', $task) }}"
class="btn btn-sm btn-outline-secondary">
<i class="bi bi-pencil"></i>
</a>

<!-- Delete -->
<form action="{{ route('admin.tasks.delete', $task) }}"
method="POST"
onsubmit="return confirm('Delete this task?')">
@csrf
@method('DELETE')

<button type="submit" class="btn btn-sm btn-outline-danger">
<i class="bi bi-trash"></i>
</button>
</form>

</td>
</tr>

<!-- MODAL -->
<div class="modal fade" id="modal{{ $task->id }}" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">
Review Task: {{ $task->title }}
</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form action="{{ route('admin.tasks.approve', $task) }}" method="POST">
@csrf

<div class="modal-body">

<p><strong>Assigned To:</strong> {{ $task->user->name }}</p>

<p><strong>Task Description:</strong></p>
<div class="p-3 bg-light rounded border small mb-3">
{!! $task->description !!}
</div>

<p><strong>Student Response:</strong></p>
<div class="p-3 bg-white border rounded mb-3">
{{ $task->user_response ?? 'No response yet' }}
</div>

<div class="mb-3">
<label class="form-label">Decision</label>
<select name="status" class="form-select">

<option value="Assigned"
{{ $task->status == 'Assigned' ? 'selected' : '' }}>
Keep Assigned
</option>

<option value="Approved"
{{ $task->status == 'Approved' ? 'selected' : '' }}>
Approve
</option>

<option value="Rejected"
{{ $task->status == 'Rejected' ? 'selected' : '' }}>
Reject
</option>

</select>
</div>

<div class="mb-3">
<label class="form-label">Admin Feedback</label>
<textarea name="feedback"
class="form-control"
rows="3">{{ $task->admin_feedback }}</textarea>
</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
Close
</button>
<button type="submit" class="btn btn-primary">
Update Status
</button>
</div>

</form>

</div>
</div>
</div>
<!-- END MODAL -->

@endforeach

</tbody>
</table>
</div>

</div>

@endsection