<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Directory - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fc; }
        .sidebar { height: 100vh; background: #ffc107; color: #212529; padding-top: 20px; position: fixed; width: 250px; }
        .sidebar a { color: rgba(0,0,0,0.7); text-decoration: none; padding: 15px 25px; display: block; border-radius: 10px; margin: 5px 15px; font-weight: 500; }
        .sidebar a:hover, .sidebar a.active { background: rgba(0,0,0,0.05); color: #000; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center mb-4">AttendX HR</h4>
        <a href="{{ route('hr.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="{{ route('hr.users') }}" class="active"><i class="bi bi-people me-2"></i> User Directory</a>
        <div class="mt-auto px-4 pb-4 position-absolute bottom-0 w-100">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-dark w-100">Logout</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h2>User Directory</h2>
        </header>

        <div class="card p-4">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'hr' ? 'bg-warning' : ($user->role == 'teacher' ? 'bg-success' : 'bg-primary')) }}">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
