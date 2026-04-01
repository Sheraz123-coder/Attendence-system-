<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Attendance System</title>
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
        .stat-card { border-left: 5px solid #4e73df; }
        .stat-card.orange { border-left-color: #f6c23e; }
        .stat-card.green { border-left-color: #1cc88a; }
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
        <h4 class="text-center mb-4"> Admin Panel</h4>
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
        @if(session('success'))
            <div class="alert alert-success mt-3 mx-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mt-3 mx-3">{{ session('error') }}</div>
        @endif

        <header class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <div class="position-relative me-3">
                    <img src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" 
                         class="rounded-circle shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                    <button class="btn btn-sm btn-dark position-absolute bottom-0 end-0 rounded-circle p-1" style="line-height:1;" data-bs-toggle="modal" data-bs-target="#profileModal">
                        <i class="bi bi-camera small"></i>
                    </button>
                </div>
                <div>
                    <h2 class="mb-0">Admin Panel</h2>
                    <span class="text-muted">Welcome, {{ auth()->user()->name }}</span>
                </div>
            </div>
            <span>{{ date('l, d M Y') }}</span>
        </header>

        <!-- Profile Modal -->
        <div class="modal fade" id="profileModal" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Profile Pic</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="file" name="image" class="form-control" required>
                            <small class="text-muted text-dark">Max: 2MB</small>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">Upload Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card stat-card p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-primary text-uppercase small font-weight-bold">Total Students</div>
                            <div class="h3 mb-0 font-weight-bold">{{ $usersCount }}</div>
                        </div>
                        <i class="bi bi-people h1 text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card stat-card orange p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-warning text-uppercase small font-weight-bold">Pending Leaves</div>
                            <div class="h3 mb-0 font-weight-bold">{{ $pendingLeaves }}</div>
                        </div>
                        <i class="bi bi-hourglass-split h1 text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card stat-card green p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-success text-uppercase small font-weight-bold">Today's Attendance</div>
                            <div class="h3 mb-0 font-weight-bold">{{ $presentToday }}</div>
                        </div>
                        <i class="bi bi-calendar-check h1 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
