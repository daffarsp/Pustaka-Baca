<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Perpustakaan') }} - @yield('title')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #0d9488;
            --primary-dark: #0f766e;
            --primary-light: #ccfbf1;
            --secondary-color: #475569;
            --success-color: #10b981;
            --info-color: #0284c7;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --bg-body: #f8fafc;
            --sidebar-gradient: linear-gradient(180deg, #0f172a 0%, #0f766e 60%, #1e3a8a 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: #334155;
        }

        .sidebar {
            min-height: 100vh;
            background: var(--sidebar-gradient);
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 0.85rem 1.25rem;
            font-weight: 600;
            border-radius: 8px;
            margin: 2px 12px;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.12);
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            color: #ffffff;
            background: linear-gradient(90deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.05) 100%);
            border-left: 4px solid #5eead4;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .sidebar .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
            vertical-align: middle;
        }

        .card {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 700;
            color: var(--primary-dark);
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
            padding: 1rem 1.25rem;
        }

        .stat-card {
            border-left: 4px solid;
            border-radius: 12px;
        }

        .stat-card.primary { border-left-color: var(--primary-color); }
        .stat-card.success { border-left-color: var(--success-color); }
        .stat-card.info { border-left-color: var(--info-color); }
        .stat-card.warning { border-left-color: var(--warning-color); }

        .btn-primary {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
            border-color: #0f766e;
            box-shadow: 0 2px 8px rgba(13, 148, 136, 0.25);
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
            border-color: #115e59;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.35);
        }

        .table thead th {
            background-color: #f1f5f9;
            font-weight: 700;
            font-size: 0.82rem;
            color: var(--primary-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }

        .badge {
            font-weight: 600;
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            color: #0f172a;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .navbar {
            border-bottom: 1px solid #e2e8f0;
        }

        /* Print Media Styles */
        @media print {
            .sidebar, .navbar, .btn, .no-print {
                display: none !important;
            }
            .flex-grow-1 {
                margin: 0 !important;
                padding: 0 !important;
            }
            body {
                background-color: #fff !important;
            }
            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div id="app">
        @auth
            <div class="d-flex">
                <!-- Sidebar -->
                <div class="sidebar text-white" style="width: 260px;">
                    <div class="p-4">
                        <h4 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="bi bi-book-half me-2 text-teal" style="color: #5eead4;"></i> Perpustakaan
                        </h4>
                        <small class="text-teal-200" style="color: #99f6e4;">{{ Auth::user()->role === 'admin' ? 'Admin Control Center' : 'Portal Mahasiswa' }}</small>
                    </div>
                    
                    <hr class="sidebar-divider my-0" style="border-color: rgba(255,255,255,0.15);">
                    
                    <ul class="nav flex-column mt-3">
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                    <i class="bi bi-people"></i> Kelola User
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}" href="{{ route('admin.buku.index') }}">
                                    <i class="bi bi-book"></i> Kelola Buku
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}" href="{{ route('admin.peminjaman.index') }}">
                                    <i class="bi bi-arrow-left-right"></i> Peminjaman
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.kunjungan.*') ? 'active' : '' }}" href="{{ route('admin.kunjungan.index') }}">
                                    <i class="bi bi-door-open"></i> Kunjungan
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}" href="{{ route('mahasiswa.dashboard') }}">
                                    <i class="bi bi-house-door"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('mahasiswa.buku.*') ? 'active' : '' }}" href="{{ route('mahasiswa.buku.index') }}">
                                    <i class="bi bi-journal-bookmark-fill"></i> Katalog Buku
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('mahasiswa.kunjungan.*') ? 'active' : '' }}" href="{{ route('mahasiswa.kunjungan.create') }}">
                                    <i class="bi bi-camera"></i> Check-in Presensi
                                </a>
                            </li>
                        @endif
                    </ul>
                    
                    <hr class="sidebar-divider" style="border-color: rgba(255,255,255,0.2);">
                    
                    <div class="px-3 py-2">
                        <div class="text-white-50 small">Login sebagai:</div>
                        <div class="text-white font-weight-bold">{{ Auth::user()->name }}</div>
                        <div class="text-white-50 small">{{ Auth::user()->nim_nip }}</div>
                    </div>
                    
                    <div class="px-3 mt-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm w-100">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-grow-1">
                    <!-- Top Navbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white shadow-sm mb-4">
                        <div class="container-fluid">
                            <div class="ms-auto d-flex align-items-center">
                                <span class="me-3">
                                    <i class="bi bi-calendar3"></i>
                                    {{ now()->isoFormat('dddd, D MMMM Y') }}
                                </span>
                                <div class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-person"></i> Profile
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-box-arrow-right"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>

                    <!-- Main Content -->
                    <div class="container-fluid px-4 pb-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('info'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        @else
            <!-- Guest Content -->
            <main class="py-4">
                @yield('content')
            </main>
        @endauth
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('scripts')
</body>
</html>