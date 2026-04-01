<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'User Dashboard')</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f1f5f9;
}

/* Sidebar */
.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    background: #111827;
    color: white;
    padding: 20px;
    display: flex;
    flex-direction: column;
}

.sidebar h4 {
    margin-bottom: 30px;
    font-weight: 600;
}

.sidebar a {
    color: #cbd5e1;
    padding: 12px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    text-decoration: none;
    transition: 0.3s;
}

.sidebar a:hover,
.sidebar a.active {
    background: #4f46e5;
    color: white;
}

/* Main */
.main {
    margin-left: 260px;
    padding: 30px;
}

/* Header */
.header {
    background: white;
    padding: 20px;
    border-radius: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

/* Card */
.card-box {
    background: white;
    padding: 20px;
    border-radius: 15px;
    margin-top: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}

/* Buttons */
.btn-primary {
    background: #4f46e5;
    border: none;
    border-radius: 10px;
}

/* Mobile */
@media(max-width:768px){
    .sidebar { display:none; }
    .main { margin-left:0; }
}
</style>

@stack('styles')
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">

    <h4>⚡ Student Panel</h4>

    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>

    <a href="{{ route('tasks.index') }}" class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}">
        <i class="bi bi-journal-text me-2"></i> My Tasks
    </a>


    <div class="mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>

</div>

<!-- Main -->
<div class="main">

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Header -->
    <div class="header">

        <div>
            <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
            <small class="text-muted">@yield('page-subtitle', 'Welcome back')</small>
        </div>

        <div class="text-end">
            <div class="fw-semibold">{{ auth()->user()->name }}</div>
            <small class="text-muted">{{ date('d M Y') }}</small>
        </div>

    </div>

    <!-- Content -->
    @yield('content')

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>