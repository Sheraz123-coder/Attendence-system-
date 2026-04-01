<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fc; }
        .sidebar { height: 100vh; background: linear-gradient(180deg, #4e73df 10%, #224abe 100%); color: white; padding-top: 20px; position: fixed; width: 250px; z-index: 1000; }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; padding: 15px 25px; display: block; border-radius: 10px; margin: 5px 15px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); color: white; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center mb-4">Student Task</h4>
        <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="{{ route('tasks.index') }}" class="active"><i class="bi bi-journal-text me-2"></i> My Tasks</a>
        <div class="mt-auto px-4 pb-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">Logout</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h2>Assigned Tasks</h2>
            <span>Your Workstation</span>
        </header>

        <div class="row">
            @forelse($tasks as $task)
            <div class="col-md-12 mb-4">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h4>{{ $task->title }}</h4>
                            <span class="text-muted small">Assigned by Admin at {{ $task->created_at->format('M d, Y') }}</span>
                        </div>
                        <span class="badge {{ $task->status == 'Assigned' ? 'bg-primary' : ($task->status == 'Submitted' ? 'bg-warning' : 'bg-success') }}">
                            {{ $task->status }}
                        </span>
                    </div>
                    <div class="mb-4">
                        {!! $task->description !!}
                    </div>

                    @if($task->status == 'Assigned')
                    <form action="{{ route('tasks.submit', $task) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Your Response / Link</label>
                            <textarea name="response" class="form-control" rows="3" placeholder="Paste link or type submission details..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4">Submit Task</button>
                    </form>
                    @elseif($task->status == 'Submitted')
                        <div class="alert alert-info">Awaiting Admin Review...</div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-light text-center py-5 shadow-sm border-0 rounded-4">
                    <i class="bi bi-clipboard-x display-1 text-muted mb-3 d-block"></i>
                    No tasks assigned yet.
                </div>
            </div>
            @endforelse
        </div>
    </div>
</body>
</html>
