<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Event Ticketing')</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: white;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, .75);
            padding: 1rem;
        }

        .sidebar .nav-link:hover {
            color: rgba(255, 255, 255, 1);
            background: rgba(255, 255, 255, .1);
        }

        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, .1);
        }

        .main-content {
            min-height: 100vh;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
        }

        .header-login {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3">
                    <h4 class="text-center mb-4">STARTIX</h4>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            @auth
                                    @if(auth()->user()->role === 'admin')
                                            <!-- Dashboard untuk Admin EO -->
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                                href="{{ route('admin.dashboard') }}">
                                                <i class="fas fa-home me-2"></i> Dashboard
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}"
                                                href="{{ route('admin.tickets.index') }}">
                                                <i class="fas fa-ticket-alt me-2"></i> Tiket
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.checkins.*') ? 'active' : '' }}"
                                                href="{{ route('admin.checkins') }}">
                                                <i class="fas fa-user-plus"></i> Checkins
                                            </a>
                                        </li>
                                    @elseif(auth()->user()->role === 'superadmin')
                                    <!-- Dashboard untuk Superadmin -->
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.super.dashboard') ? 'active' : '' }}"
                                            href="{{ route('admin.super.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                        </a>
                                    </li>
                                @endif
                            @endauth

                        </li>
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin.acara*') ? 'active' : '' }}"
                                href="#submenuTiket" data-bs-toggle="collapse" role="button"
                                aria-expanded="{{ request()->is('admin.acara*') ? 'true' : 'false' }}"
                                aria-controls="submenuTiket">
                                <i class="fas fa-calendar-alt me-2"></i> Events
                            </a>
                            <div class="collapse {{ request()->is('admin.acara.aktif_event*') ? 'show' : '' }}"
                                id="submenuTiket">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.acara.aktif_event') ? 'active' : '' }}"
                                            href="{{ route('admin.acara.aktif_event') }}">
                                            <i class="fas fa-play-circle me-2"></i> Ongoing Event
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.acara.done_event') ? 'active' : '' }}"
                                            href="{{ route('admin.acara.done_event') }}">
                                            <i class="fas fa-check-circle me-2"></i> Completed Event
                                        </a>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.acara') ? 'active' : '' }}"
                                            href="{{ route('admin.acara') }}">
                                            <i class="fas fa-plus"></i> Create Events
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        {{-- <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.acara') ? 'active' : '' }}"
                                href="{{ route('admin.acara') }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Event</span>
                            </a>
                        </li> --}}
                        @auth

                            @if(auth()->user()->role === 'superadmin')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}"
                                        href="{{ route('admin.admins.index') }}">
                                        <i class="fas fa-users-cog me-2"></i> Daftar Admin
                                    </a>
                                </li>

                            @endif
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @endauth
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>

</html>