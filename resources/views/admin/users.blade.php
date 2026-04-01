@extends('layouts.layout')

@section('title', 'Users')
@section('page-title', 'User Management')
@section('page-subtitle', 'Manage all users')

@section('content')

<div class="card-box">

    {{-- HEADER ACTION BAR --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

        <h5 class="mb-0">All Users</h5>

        {{-- ADD NEW USER BUTTON --}}
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i> Add New User
        </a>

    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Attendance</th>
                    <th>Grade</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach($users as $user)
                <tr>

                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        <span class="badge bg-secondary">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    <td>
                        {{ $user->attendance_count }}
                        {{ is_numeric($user->attendance_count) ? 'Days' : '' }}
                    </td>

                    <td>
                        @if($user->grade !== '-')
                            <span class="badge bg-primary">
                                Grade {{ $user->grade }}
                            </span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <td>
                        <form action="{{ route('admin.users.delete', $user) }}" method="POST"
                            onsubmit="return confirm('Delete this user?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-outline-danger"
                                {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                <i class="bi bi-trash"></i>
                            </button>

                        </form>
                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>
    </div>

</div>

@endsection