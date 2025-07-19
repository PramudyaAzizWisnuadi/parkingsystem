<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', config('app.name'))</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

        <!-- Theme and app metadata -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#667eea">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="description" content="Sistem Manajemen Parkir - {{ config('app.name') }}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link href="{{ asset('css/favicon-enhancements.css') }}" rel="stylesheet">

        <!-- SweetAlert2 -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

        <!-- PWA -->
        <meta name="theme-color" content="#6777ef">
        <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
        <style>
            .navbar-brand {
                font-weight: bold;
            }

            .sidebar {
                min-height: 100vh;
                background-color: #f8f9fa;
            }

            .sidebar .nav-link {
                color: #333;
                padding: 10px 20px;
                border-radius: 0;
            }

            .sidebar .nav-link:hover {
                background-color: #e9ecef;
            }

            .sidebar .nav-link.active {
                background-color: #007bff;
                color: white;
            }

            .main-content {
                min-height: 100vh;
            }

            .card {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }

            .btn-print {
                background-color: #28a745;
                border-color: #28a745;
            }

            .btn-print:hover {
                background-color: #218838;
                border-color: #1e7e34;
            }

            @media (max-width: 768px) {
                .sidebar {
                    min-height: auto;
                }

                .sidebar .nav {
                    flex-direction: row;
                    overflow-x: auto;
                    white-space: nowrap;
                }

                .sidebar .nav-item {
                    flex: 0 0 auto;
                }

                .sidebar .nav-link {
                    padding: 8px 16px;
                    font-size: 0.9rem;
                }

                .main-content {
                    padding-left: 15px !important;
                    padding-right: 15px !important;
                    padding-top: 10px !important;
                    padding-bottom: 10px !important;
                }

                .container-fluid {
                    padding-left: 15px;
                    padding-right: 15px;
                }

                .card {
                    margin-bottom: 15px;
                }

                .card-body {
                    padding: 15px;
                }

                .table-responsive {
                    font-size: 0.875rem;
                    margin-left: -5px;
                    margin-right: -5px;
                    padding-left: 5px;
                    padding-right: 5px;
                }

                /* Additional padding for form elements */
                .form-control,
                .form-select {
                    margin-bottom: 10px;
                }

                /* Better spacing for buttons */
                .btn {
                    margin-bottom: 5px;
                }

                /* Header padding */
                .border-bottom {
                    padding-left: 5px;
                    padding-right: 5px;
                }

                /* Better spacing for statistics cards */
                .row>[class*="col-"] {
                    padding-left: 8px;
                    padding-right: 8px;
                    margin-bottom: 10px;
                }
            }

            @media print {
                .no-print {
                    display: none !important;
                }
            }

            /* Additional mobile optimizations */
            @media (max-width: 576px) {
                .main-content {
                    padding-left: 10px !important;
                    padding-right: 10px !important;
                }

                .container-fluid {
                    padding-left: 10px;
                    padding-right: 10px;
                }

                .card-body {
                    padding: 10px;
                }

                .btn-toolbar {
                    margin-bottom: 10px;
                }

                .d-flex.justify-content-between {
                    flex-direction: column;
                    gap: 10px;
                }

                .h2 {
                    font-size: 1.5rem;
                    margin-bottom: 10px;
                }

                /* Better spacing for small screens */
                .row>[class*="col-"] {
                    padding-left: 5px;
                    padding-right: 5px;
                }
            }

            /* Chart Styles */
            .chart-container {
                position: relative;
                height: 300px;
                margin-bottom: 20px;
            }

            .chart-card {
                transition: transform 0.2s ease-in-out;
                border: none;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .chart-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
            }

            .chart-card .card-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border-bottom: none;
                padding: 1rem 1.5rem;
            }

            .chart-card .card-header h5 {
                margin: 0;
                font-size: 1.1rem;
                font-weight: 600;
            }

            .chart-card .card-body {
                padding: 1.5rem;
                background: #f8f9fa;
            }

            .stats-card {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                color: white;
                transition: all 0.3s ease;
            }

            .stats-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }

            .stats-card .card-header {
                background: rgba(255, 255, 255, 0.1);
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                font-size: 0.9rem;
                font-weight: 500;
            }

            .stats-card .card-body {
                padding: 1.5rem;
            }

            .stats-card .card-title {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .stats-card .card-text {
                font-size: 0.9rem;
                opacity: 0.9;
                margin-bottom: 0;
            }

            /* Responsive chart adjustments */
            @media (max-width: 768px) {
                .chart-container {
                    height: 250px;
                }

                .chart-card .card-header h5 {
                    font-size: 1rem;
                }

                .stats-card .card-title {
                    font-size: 1.5rem;
                }
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="fas fa-car"></i> {{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                                    <span class="badge bg-secondary">{{ ucfirst(Auth::user()->role) }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user-cog"></i> Profile
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endauth
                        <li class="nav-item">
                            <span class="navbar-text">
                                <i class="fas fa-calendar"></i> {{ date('d/m/Y H:i') }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                @auth
                    <nav class="col-md-2 d-md-block sidebar collapse">
                        <div class="position-sticky pt-3">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                        href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> <span
                                            class="d-none d-md-inline">Dashboard</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('parking.*') ? 'active' : '' }}"
                                        href="{{ route('parking.index') }}">
                                        <i class="fas fa-car"></i> <span class="d-none d-md-inline">Transaksi</span>
                                    </a>
                                </li>
                                @if (Auth::user()->isAdmin())
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('vehicle-types.*') ? 'active' : '' }}"
                                            href="{{ route('vehicle-types.index') }}">
                                            <i class="fas fa-list"></i> <span class="d-none d-md-inline">Master</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                                            href="{{ route('reports.index') }}">
                                            <i class="fas fa-chart-bar"></i> <span
                                                class="d-none d-md-inline">Laporan</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('ticket-config.*') ? 'active' : '' }}"
                                            href="{{ route('ticket-config.index') }}">
                                            <i class="fas fa-cog"></i> <span class="d-none d-md-inline">Konfigurasi</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </nav>
                @endauth

                <main class="col-md-{{ auth()->check() ? '10' : '12' }} ms-sm-auto px-md-4 main-content">
                    <div class="pt-3">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('/sw.js') }}"></script>
        <script>
            if (!navigator.serviceWorker.controller) {
                navigator.serviceWorker.register("/sw.js").then(function(reg) {
                    console.log("Service worker registered: " + reg.scope);
                });
            }
        </script>
        @stack('scripts')
    </body>

</html>
