<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Dashboard</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fc;
        }
        
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            min-height: 100vh;
            position: fixed;
            left: 0; /* Changed from right: 0 to left: 0 for LTR */
            top: 0;
            z-index: 1000;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 1rem 1.5rem;
            border-radius: 0;
        }
        
        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,.1);
        }
        
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,.2);
        }
        
        .content-wrapper {
            margin-left: 260px; /* Changed from margin-right to margin-left */
            min-height: 100vh;
        }
        
        .topbar {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 0.75rem 1.5rem;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
        
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
        
        .border-left-danger {
            border-left: 0.25rem solid #e74a3b !important;
        }
        
        .border-left-secondary {
            border-left: 0.25rem solid #858796 !important;
        }
        
        .text-primary {
            color: #4e73df !important;
        }
        
        .text-success {
            color: #1cc88a !important;
        }
        
        .text-info {
            color: #36b9cc !important;
        }
        
        .text-warning {
            color: #f6c23e !important;
        }
        
        .text-danger {
            color: #e74a3b !important;
        }
        
        .text-secondary {
            color: #858796 !important;
        }
        
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        
        .sidebar-brand {
            padding: 1.5rem;
            color: white;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.2rem;
        }
        
        .sidebar-brand:hover {
            color: white;
            text-decoration: none;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                display: none;
                position: fixed;
                width: 100%;
                height: 100%;
                z-index: 1050;
                left: 0; /* Ensures it opens from the left in mobile */
            }
            
            .sidebar.show {
                display: block;
            }
            
            .content-wrapper {
                margin-left: 0; /* Changed from margin-right to margin-left */
            }
            
            .mobile-sidebar-toggle {
                display: block !important;
            }
        }
        
        .mobile-sidebar-toggle {
            display: none;
        }
    </style>

    @yield('styles')
</head>

<body>
    <div id="wrapper">
        <nav class="sidebar" id="sidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin Panel</div>
            </a>

            <hr class="sidebar-divider my-0" style="border-color: rgba(255,255,255,.15);">

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <hr class="sidebar-divider" style="border-color: rgba(255,255,255,.15);">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        <i class="fas fa-fw fa-box"></i>
                        <span>Products</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.stories.*') ? 'active' : '' }}" href="{{ route('admin.stories.index') }}">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Stories</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.workshops.*') ? 'active' : '' }}" href="{{ route('admin.workshops.index') }}">
                        <i class="fas fa-fw fa-calendar-alt"></i>
                        <span>Workshops</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}" href="{{ route('admin.blog.index') }}">
                        <i class="fas fa-fw fa-blog"></i>
                        <span>Blog</span>
                    </a>
                </li>

               <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}" href="{{ route('admin.contact-messages.index') }}">
                        <i class="fas fa-fw fa-envelope"></i>
                        <span>Messages</span>
                    </a>
                </li>

                <hr class="sidebar-divider" style="border-color: rgba(255,255,255,.15);">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="content-wrapper">
            <nav class="topbar navbar navbar-expand navbar-light bg-white">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 mobile-sidebar-toggle">
                    <i class="fa fa-bars"></i>
                </button>

                <ul class="navbar-nav ml-auto"> <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            <img class="img-profile rounded-circle" src="{{ Auth::user()->avatar ?? '/images/default-avatar.png' }}" width="30" height="30">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                           <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="container-fluid p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Toggle the side navigation
        $("#sidebarToggleTop").on('click', function(e) {
            $("#sidebar").toggleClass("show");
        });

        // Close sidebar when clicking outside on mobile
        $(document).on('click', function(e) {
            if ($(window).width() <= 768) {
                if (!$(e.target).closest('#sidebar, #sidebarToggleTop').length) {
                    $("#sidebar").removeClass("show");
                }
            }
        });
    </script>

    @yield('scripts')
</body>
</html>