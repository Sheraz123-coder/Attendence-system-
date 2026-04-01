@extends('layouts.layout')

@section('title', 'Add User')
@section('page-title', 'Add New User')
@section('page-subtitle', 'Create and manage system users')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            {{-- CARD --}}
            <div class="card shadow-lg border-0 rounded-4">

                {{-- HEADER --}}
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>
                        Create New User
                    </h5>
                </div>

                {{-- BODY --}}
                <div class="card-body p-4">

                    {{-- SUCCESS --}}
                    @if(session('success'))
                        <div class="alert alert-success rounded-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- ERRORS --}}
                    @if($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM --}}
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        {{-- NAME --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="name"
                                       class="form-control"
                                       placeholder="Enter full name"
                                       required>
                            </div>
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email"
                                       class="form-control"
                                       placeholder="user@example.com"
                                       required>
                            </div>
                        </div>

                        {{-- ROLE --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Assign Role</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-shield-lock"></i>
                                </span>
                                <select name="role" class="form-select" required>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="hr">HR</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-key"></i>
                                </span>
                                <input type="password" name="password"
                                       class="form-control"
                                       placeholder="Minimum 8 characters"
                                       required>
                            </div>
                        </div>

                        {{-- BUTTON --}}
                        <button type="submit" class="btn btn-primary w-100 mt-3 py-2">
                            <i class="bi bi-person-plus-fill me-1"></i>
                            Create User
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection