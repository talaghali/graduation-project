<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Voices Of Gaza</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 70px;
            --primary-color: #b70003;
            --secondary-color: #8b0002;
            --dark-bg: #1a1a1a;
            --sidebar-bg: #2d2d2d;
            --hover-bg: #3d3d3d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--dark-bg) 0%, var(--sidebar-bg) 100%);
            padding: 1.5rem 0;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar-brand {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1.5rem;
        }

        .sidebar-brand h4 {
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 0.25rem;
        }

        .sidebar-brand small {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
        }

        .sidebar-nav {
            padding: 0 0.75rem;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.85rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .nav-link i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 0.75rem;
        }

        .nav-link:hover {
            background: var(--hover-bg);
            color: white;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(183, 0, 3, 0.4);
        }

        .nav-section-title {
            padding: 1.5rem 1rem 0.5rem;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            background: white;
            height: var(--topbar-height);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-title h5 {
            margin: 0;
            font-weight: 600;
            color: #2c3e50;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: #f8f9fa;
            border-radius: 50px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: #2c3e50;
        }

        .user-role {
            font-size: 0.75rem;
            color: #7f8c8d;
        }

        /* Page Content */
        .page-content {
            padding: 2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block !important;
            }
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4><i class="bi bi-speedometer2"></i> Dashboard</h4>
            <small>Voices Of Gaza</small>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Overview</span>
                    </a>
                </li>

                <div class="nav-section-title">Content Management</div>

                <li class="nav-item">
                    <a href="{{ route('dashboard.stories.index') }}" class="nav-link {{ request()->routeIs('dashboard.stories.*') ? 'active' : '' }}">
                        <i class="bi bi-book-fill"></i>
                        <span>Stories</span>
                        @if($pending_count = \App\Models\Story::pending()->count())
                            <span class="badge bg-warning ms-auto">{{ $pending_count }}</span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard.highlights.index') }}" class="nav-link {{ request()->routeIs('dashboard.highlights.*') ? 'active' : '' }}">
                        <i class="bi bi-play-btn-fill"></i>
                        <span>Highlight Videos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard.delete-requests.index') }}" class="nav-link {{ request()->routeIs('dashboard.delete-requests.*') ? 'active' : '' }}">
                        <i class="bi bi-trash-fill"></i>
                        <span>Delete Requests</span>
                        @if($delete_requests_count = \App\Models\StoryDeleteRequest::pending()->count())
                            <span class="badge bg-danger ms-auto">{{ $delete_requests_count }}</span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard.donations.index') }}" class="nav-link {{ request()->routeIs('dashboard.donations.*') ? 'active' : '' }}">
                        <i class="bi bi-heart-fill"></i>
                        <span>Donations</span>
                        @if($pending_donations_count = \App\Models\Donation::where('status', 'pending')->count())
                            <span class="badge bg-info ms-auto">{{ $pending_donations_count }}</span>
                        @endif
                    </a>
                </li>

                <div class="nav-section-title">System</div>

                <li class="nav-item">
                    <a href="{{ route('dashboard.profile.index') }}" class="nav-link {{ request()->routeIs('dashboard.profile.*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i>
                        <span>My Profile</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard.admins.index') }}" class="nav-link {{ request()->routeIs('dashboard.admins.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>Admin Management</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard.users.index') }}" class="nav-link {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>User Management</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('index') }}" class="nav-link" target="_blank">
                        <i class="bi bi-globe"></i>
                        <span>View Website</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('dashboard.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-title">
                <button class="mobile-menu-btn" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list"></i>
                </button>
                <h5>@yield('page-title', 'Dashboard')</h5>
            </div>

            <div class="topbar-actions">
                <div class="topbar-user">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                        <span class="user-role">Administrator</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="page-content">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Setup axios defaults
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
        axios.defaults.headers.common['Accept'] = 'application/json';

        // Setup SweetAlert2 Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    </script>

    <!-- CRUD Functions -->
    <script src="{{ asset('dashboard-assets/js/crud.js') }}"></script>

    @stack('scripts')
</body>
</html>
