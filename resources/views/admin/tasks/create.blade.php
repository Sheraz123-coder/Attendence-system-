@extends('layouts.layout')

@section('title', 'Assign Task')
@section('page-title', 'Assign New Task')
@section('page-subtitle', 'Notify students with tasks')

@push('styles')
<style>
.ck-editor__editable {
    min-height: 200px;
}
</style>
@endpush

@section('content')

<div class="card-box">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.tasks.store') }}" method="POST">
@csrf

<div class="mb-3">
<label class="form-label">Select Student</label>
<select name="user_id" class="form-select" required>
@foreach($users as $user)
<option value="{{ $user->id }}">
{{ $user->name }} ({{ $user->email }})
</option>
@endforeach
</select>
</div>

<div class="mb-3">
<label class="form-label">Task Title</label>
<input type="text" name="title" class="form-control"
placeholder="Project Submission" required>
</div>

<div class="mb-3">
<label class="form-label">Task Description</label>
<textarea name="description" id="editor" class="form-control"></textarea>
</div>

<button type="submit" class="btn btn-primary px-4">
Assign Task
</button>

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