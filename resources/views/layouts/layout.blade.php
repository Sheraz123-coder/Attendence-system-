<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title')</title>

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
    overflow-x: hidden;
}

/* SIDEBAR */
.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: #111827;
    color: white;
    padding: 20px;
    display: flex;
    flex-direction: column;
    transition: 0.3s;
    z-index: 1000;
}

.sidebar h4 {
    margin-bottom: 30px;
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

/* MAIN */
.main {
    margin-left: 260px;
    padding: 30px;
    transition: 0.3s;
}

/* HEADER */
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

/* CARD */
.card-box {
    background: white;
    padding: 20px;
    border-radius: 15px;
    margin-top: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}

/* BUTTON */
.btn-primary {
    background: #4f46e5;
    border: none;
    border-radius: 10px;
}

/* MOBILE BUTTON */
.menu-btn {
    display: none;
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 1100;
    background: #4f46e5;
    color: white;
    border: none;
    font-size: 20px;
    padding: 8px 12px;
    border-radius: 8px;
}

/* OVERLAY */
.overlay {
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
    top: 0;
    left: 0;
    z-index: 999;
}

/* MOBILE */
@media(max-width:768px){

    .menu-btn {
        display: block;
    }

    .sidebar {
        left: -260px;
    }

    .sidebar.show {
        left: 0;
    }

    .overlay.show {
        display: block;
    }

    .main {
        margin-left: 0;
        padding: 20px;
    }
}
</style>

@stack('styles')
</head>

<body>

<!-- MOBILE MENU BUTTON -->
<button class="menu-btn" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
</button>

<!-- OVERLAY -->
<div class="overlay" onclick="toggleSidebar()"></div>

<!-- SIDEBAR -->
<div class="sidebar">

    <h4>⚡ Admin</h4>

    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>

    <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
        <i class="bi bi-people me-2"></i> Users
    </a>

    <a href="{{ route('admin.leaves') }}" class="{{ request()->routeIs('admin.leaves') ? 'active' : '' }}">
        <i class="bi bi-calendar-event me-2"></i> Leaves
    </a>

    <a href="{{ route('admin.tasks.manage') }}" class="{{ request()->routeIs('admin.tasks.manage') ? 'active' : '' }}">
        <i class="bi bi-check2-square me-2"></i> Tasks
    </a>

    <a href="{{ route('admin.tasks.create') }}" class="{{ request()->routeIs('admin.tasks.create') ? 'active' : '' }}">
        <i class="bi bi-plus-circle me-2"></i> Assign Task
    </a>

    <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">
        <i class="bi bi-bar-chart me-2"></i> Reports
    </a>

    <div class="mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-light w-100">Logout</button>
        </form>
    </div>
</div>

<!-- MAIN -->
<div class="main">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- HEADER -->
    <div class="header">
        <div>
            <h5 class="mb-0">@yield('page-title')</h5>
            <small class="text-muted">@yield('page-subtitle')</small>
        </div>

        <span class="fw-semibold">{{ date('d M Y') }}</span>
    </div>

    @yield('content')

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar(){
    document.querySelector('.sidebar').classList.toggle('show');
    document.querySelector('.overlay').classList.toggle('show');
}
</script>

@stack('scripts')

</body>
</html>