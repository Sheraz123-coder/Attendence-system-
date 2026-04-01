<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tasks - Attendance System</title>
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
        <h4 class="text-center mb-4">Admin Panel</h4>
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
            <h2>Manage Tasks</h2>
        </header>

        <div class="card p-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Submission</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->user->name }}</td>
                        <td>{{ $task->title }}</td>
                        <td>
                            <span class="badge {{ $task->status == 'Submitted' ? 'bg-warning' : ($task->status == 'Approved' ? 'bg-success' : 'bg-primary') }}">
                                {{ $task->status }}
                            </span>
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($task->user_response ?? 'No submission yet', 50) }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal{{ $task->id }}">Review</button>
                            <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            
                            <form action="{{ route('admin.tasks.delete', $task) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this task?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            
                            <div class="modal fade" id="modal{{ $task->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Review Task: {{ $task->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.tasks.approve', $task) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p><strong>Assigned To:</strong> {{ $task->user->name }}</p>
                                                <p><strong>Task Description:</strong></p>
                                                <div class="p-2 bg-light rounded text-dark mb-3 border small">{!! $task->description !!}</div>
                                                
                                                <p><strong>Student Response:</strong></p>
                                                <div class="p-3 bg-white rounded text-dark mb-4 border">{{ $task->user_response ?? 'No response yet' }}</div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Decision</label>
                                                    <select name="status" class="form-select">
                                                        <option value="Assigned" {{ $task->status == 'Assigned' ? 'selected' : '' }}>Keep Assigned (Pending)</option>
                                                        <option value="Approved" {{ $task->status == 'Approved' ? 'selected' : '' }}>Approve</option>
                                                        <option value="Rejected" {{ $task->status == 'Rejected' ? 'selected' : '' }}>Reject</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Admin Feedback</label>
                                                    <textarea name="feedback" class="form-control" rows="3" placeholder="Feedback...">{{ $task->admin_feedback }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update Status</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
