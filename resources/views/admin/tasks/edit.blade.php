@extends('layouts.layout')

@section('title', 'Edit Task')
@section('page-title', 'Edit Task')
@section('page-subtitle', 'Modify task details')

@push('styles')
<style>
.ck-editor__editable {
    min-height: 200px;
}
</style>
@endpush

@section('content')

<div class="card-box">


<form action="{{ route('admin.tasks.update', $task) }}" method="POST">
@csrf

<div class="mb-3">
<label class="form-label">Select Student</label>
<select name="user_id" class="form-select" required>
@foreach($users as $user)
<option value="{{ $user->id }}"
{{ $task->user_id == $user->id ? 'selected' : '' }}>
{{ $user->name }} ({{ $user->email }})
</option>
@endforeach
</select>
</div>

<div class="mb-3">
<label class="form-label">Task Title</label>
<input type="text" name="title" class="form-control"
value="{{ $task->title }}" required>
</div>

<div class="mb-3">
<label class="form-label">Task Description</label>
<textarea name="description" id="editor" class="form-control">
{!! $task->description !!}
</textarea>
</div>

<button type="submit" class="btn btn-success px-4">
Update Task
</button>

<a href="{{ route('admin.tasks.manage') }}" class="btn btn-secondary px-4">
Cancel
</a>

</form>

</div>

@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

<script>
ClassicEditor
.create(document.querySelector('#editor'))
.catch(error => {
    console.error(error);
});
</script>
@endpush