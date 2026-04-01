@extends('layouts.user-layout')

@section('title', 'My Tasks')
@section('page-title', 'My Tasks')
@section('page-subtitle', 'View and submit your assigned tasks')

@section('content')

<div class="row">

    @forelse($tasks as $task)

    <div class="col-12 mb-4">

        <div class="card-box">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>
                    <h5 class="mb-1">{{ $task->title }}</h5>
                    <small class="text-muted">
                        Assigned on {{ $task->created_at->format('M d, Y') }}
                    </small>
                </div>

                <span class="badge
                    @if($task->status == 'Assigned') bg-primary
                    @elseif($task->status == 'Submitted') bg-warning
                    @else bg-success
                    @endif
                    ">
                    {{ $task->status }}
                </span>

            </div>

            <!-- DESCRIPTION -->
            <div class="mb-4">
                {!! $task->description !!}
            </div>

            <!-- FORM / STATUS -->
            @if($task->status == 'Assigned')

                <form action="{{ route('tasks.submit', $task) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Your Submission</label>
                        <textarea name="response" class="form-control" rows="3"
                            placeholder="Paste link or write your answer..." required></textarea>
                    </div>

                    <button class="btn btn-primary px-4">
                        Submit Task
                    </button>
                </form>

            @elseif($task->status == 'Submitted')

                <div class="alert alert-info mb-0">
                    ⏳ Waiting for admin review...
                </div>

            @else

                <div class="alert alert-success mb-0">
                    ✅ Task completed
                </div>

            @endif

        </div>

    </div>

    @empty

    <div class="col-12">
        <div class="card-box text-center py-5">

            <i class="bi bi-clipboard-x display-1 text-muted"></i>

            <h5 class="mt-3">No Tasks Found</h5>
            <p class="text-muted">You don't have any assigned tasks yet.</p>

        </div>
    </div>

    @endforelse

</div>

@endsection