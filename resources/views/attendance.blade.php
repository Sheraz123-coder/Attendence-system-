<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fc; }
        .sidebar { height: 100vh; background: linear-gradient(180deg, #4e73df 10%, #224abe 100%); color: white; padding-top: 20px; position: fixed; width: 250px; transition: 0.3s; z-index: 1050; }
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
        <h4 class="text-center mb-4 text-white">Student Attendance</h4>
        <a href="{{ route('dashboard') }}" class="active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="{{ route('tasks.index') }}"><i class="bi bi-journal-text me-2"></i> My Tasks</a>
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
        @if($errors->any())
            <div class="alert alert-danger mt-3 mx-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
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
                    <h2 class="mb-0">Hi, {{ auth()->user()->name }}</h2>
                    <span class="text-muted small">Student ID: #{{ auth()->user()->id }} | Join Date: {{ auth()->user()->created_at->format('M Y') }}</span>
                </div>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Logout</button>
                </form>
            </div>
        </header>

        <!-- Profile Modal -->
        <div class="modal fade" id="profileModal" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card p-4 text-center">
                    <div class="text-primary small fw-bold">TOTAL PRESENT</div>
                    <div class="h2 mb-0 font-weight-bold">{{ $stats['present'] }}</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card p-4 text-center">
                    <div class="text-danger small fw-bold">TOTAL ABSENT</div>
                    <div class="h2 mb-0 font-weight-bold">{{ $stats['absent'] }}</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card p-4 text-center text-warning">
                    <div class="small fw-bold">LATE ARRIVALS</div>
                    <div class="h2 mb-0 font-weight-bold">{{ $stats['late'] }}</div>
                </div>
            </div>
            
        </div>

        <div class="row">
            <div class="col-md-7 mb-4">
                <div class="card p-4">
                    <h5 class="mb-4">Today's Presence</h5>
                    
                    @if($todayAttendance)
                        <div class="alert alert-light text-center py-5 shadow-sm border-0 rounded-4">
                            <i class="bi bi-check2-circle display-1 text-success mb-3 d-block"></i>
                            Attendance Marked: <span class="h4 mt-2 d-block">Present</span>
                            <span class="text-muted small">Time: {{ $todayAttendance->created_at->format('H:i A') }}</span>
                        </div>
                    @else
                        <form action="{{ route('attendance.mark') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary d-block w-100 py-3 rounded-4 shadow mb-4">
                                <i class="bi bi-fingerprint me-2 h3"></i> Mark Attendance Now
                            </button>
                        </form>
                    @endif

                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Check-in</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $row)
                            <tr>
                                <td>{{ $row->date }}</td>
                                <td><span class="badge {{ $row->status == 'Present' ? 'bg-success' : 'bg-danger' }}">{{ $row->status }}</span></td>
                                <td>{{ $row->created_at->format('H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-5 mb-4">
                <div class="card p-4">
                    <h5 class="mb-4">Request Leave</h5>
                    <form action="{{ route('leave.request') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reason</label>
                            <textarea name="reason" rows="3" class="form-control" required placeholder="Describe your reason..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-primary w-100 py-3 rounded-4">Request Leave</button>
                    </form>

                    <h5 class="mt-5 mb-4">My Leave History</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                @foreach($leaves as $leave)
                                <tr>
                                    <td>{{ $leave->from_date }}</td>
                                    <td><span class="badge {{ $leave->status == 'Pending' ? 'bg-warning' : ($leave->status == 'Approved' ? 'bg-success' : 'bg-danger') }}">{{ $leave->status }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
