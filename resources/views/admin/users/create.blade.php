<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fc; }
        .sidebar { height: 100vh; background: #4e73df; color: white; padding-top: 20px; position: fixed; width: 250px; }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; padding: 15px 25px; display: block; border-radius: 10px; margin: 5px 15px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); color: white; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center mb-4">AttendX Admin</h4>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}"><i class="bi bi-people me-2"></i> User Management</a>
        <a href="{{ route('admin.leaves') }}" class="{{ request()->routeIs('admin.leaves') ? 'active' : '' }}"><i class="bi bi-calendar-event me-2"></i> Leave Approval</a>
        <a href="{{ route('admin.tasks.manage') }}" class="{{ request()->routeIs('admin.tasks.manage') ? 'active' : '' }}"><i class="bi bi-journal-check me-2"></i> Manage Tasks</a>
        <a href="{{ route('admin.tasks.create') }}" class="{{ request()->routeIs('admin.tasks.create') ? 'active' : '' }}"><i class="bi bi-plus-circle me-2"></i> Assign Task</a>
        <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}"><i class="bi bi-file-earmark-bar-graph me-2"></i> Attendance Reports</a>
        <div class="mt-auto px-4 pb-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">Logout</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h2>Add New User</h2>
            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary btn-sm">Back to List</a>
        </header>

        <div class="card p-5" style="max-width: 600px;">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="user@example.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Assign Role</label>
                    <select name="role" class="form-select" required>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                        <option value="hr">HR</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="At least 8 characters" required>
                </div>
                <button type="submit" class="btn btn-primary px-5 mt-3">Create User</button>
            </form>
        </div>
    </div>
</body>
</html>
