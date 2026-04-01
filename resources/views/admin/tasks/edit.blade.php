<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fc; }
        .sidebar { height: 100vh; background: #4e73df; color: white; padding-top: 20px; position: fixed; width: 250px; }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; padding: 15px 25px; display: block; border-radius: 10px; margin: 5px 15px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); color: white; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
        .ck-editor__editable { min-height: 200px; }
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
            <h2>Edit Task</h2>
            <span>Modify details</span>
        </header>

        <div class="card p-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.tasks.update', $task) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Select Student</label>
                    <select name="user_id" class="form-select" required>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $task->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Task Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Task Description</label>
                    <textarea name="description" id="editor" class="form-control" rows="5">{!! $task->description !!}</textarea>
                </div>
                <button type="submit" class="btn btn-success px-5 py-2">Update Task</button>
                <a href="{{ route('admin.tasks.manage') }}" class="btn btn-secondary px-5 py-2">Cancel</a>
            </form>
        </div>
    </div>

    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
</body>
</html>
