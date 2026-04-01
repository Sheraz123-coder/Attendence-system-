<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Approval - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fc; }
        .sidebar { height: 100vh; background: #4e73df; color: white; padding-top: 20px; position: fixed; width: 250px; transition: 0.3s; z-index: 1050; }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; padding: 15px 25px; display: block; border-radius: 10px; margin: 5px 15px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); color: white; }
        .main-content { margin-left: 250px; padding: 30px; transition: 0.3s; }
        .card { border: none; border-radius: 15px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
        .mobile-toggle { display: none; }

        @media (max-width: 991.98px) {
            .sidebar { left: -250px; }
            .sidebar.show { left: 0; }
            .main-content { margin-left: 0; padding: 15px; }
            .mobile-toggle { display: block; position: fixed; top: 15px; left: 15px; z-index: 1100; background: #4e73df; color: #fff; border: none; font-size: 1.5rem; border-radius: 5px; }
            header { margin-top: 50px; }
        }
    </style>
</head>
<body>
    <button class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('show')">
        <i class="bi bi-list"></i>
    </button>
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
            <h2>Leave Approvals</h2>
            <span>Pending Requests</span>
        </header>

        <div class="card p-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-hover">
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
                            <span class="badge {{ $leave->status == 'Pending' ? 'bg-warning' : ($leave->status == 'Approved' ? 'bg-success' : 'bg-danger') }}">
                                {{ $leave->status }}
                            </span>
                        </td>
                        <td>
                            @if($leave->status == 'Pending')
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal{{ $leave->id }}">Manage</button>
                                
                                <div class="modal fade" id="modal{{ $leave->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Handle Leave Request</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.leaves.approve', $leave) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Decision</label>
                                                        <select name="status" class="form-select">
                                                            <option value="Approved">Approve</option>
                                                            <option value="Rejected">Reject</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Comment</label>
                                                        <textarea name="comment" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted d-block small mb-1">{{ $leave->admin_comment }}</span>
                            @endif
                            <form action="{{ route('admin.leaves.delete', $leave) }}" method="POST" onsubmit="return confirm('Delete this leave request?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0 mt-1" style="text-decoration: none; font-size: 0.8rem;">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
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
