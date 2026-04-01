<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fc; }
        .sidebar { height: 100vh; background: #198754; color: white; padding-top: 20px; position: fixed; width: 250px; transition: 0.3s; z-index: 1050; }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; padding: 15px 25px; display: block; border-radius: 10px; margin: 5px 15px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); color: white; }
        .main-content { margin-left: 250px; padding: 30px; transition: 0.3s; }
        .card { border: none; border-radius: 15px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
        .mobile-toggle { display: none; }

        @media (max-width: 991.98px) {
            .sidebar { left: -250px; }
            .sidebar.show { left: 0; }
            .main-content { margin-left: 0; padding: 15px; }
            .mobile-toggle { display: block; position: fixed; top: 15px; left: 15px; z-index: 1100; background: #198754; color: #fff; border: none; font-size: 1.5rem; border-radius: 5px; }
            header { margin-top: 50px; }
        }
    </style>
</head>
<body>
    <button class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('show')">
        <i class="bi bi-list"></i>
    </button>
    <div class="sidebar">
        <h4 class="text-center mb-4">AttendX Teacher</h4>
        <a href="{{ route('teacher.dashboard') }}" class="active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="{{ route('teacher.attendance') }}"><i class="bi bi-people me-2"></i> My Students</a>
        <div class="mt-auto px-4 pb-4 position-absolute bottom-0 w-100">
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
                    <h2 class="mb-0">Teacher Workspace</h2>
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
                            <button type="submit" class="btn btn-success w-100">Upload Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card p-4 border-start border-success border-5">
                    <div class="text-success text-uppercase small font-weight-bold">Total Students</div>
                    <div class="h2 mb-0 font-weight-bold">{{ $studentCount }}</div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card p-4 border-start border-primary border-5">
                    <div class="text-primary text-uppercase small font-weight-bold">Present Today</div>
                    <div class="h2 mb-0 font-weight-bold">{{ $presentToday }}</div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
