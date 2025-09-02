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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
            left: 0;
            /* Changed from right: 0 to left: 0 for LTR */
            top: 0;
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, .8);
            padding: 1rem 1.5rem;
            border-radius: 0;
        }

        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, .1);
        }

        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, .2);
        }

        .content-wrapper {
            margin-left: 260px;
            /* Changed from margin-right to margin-left */
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
                left: 0;
                /* Ensures it opens from the left in mobile */
            }

            .sidebar.show {
                display: block;
            }

            .content-wrapper {
                margin-left: 0;
                /* Changed from margin-right to margin-left */
            }

            .mobile-sidebar-toggle {
                display: block !important;
            }
        }

        .mobile-sidebar-toggle {
            display: none;
        }
        
        /* Snackbar styles */
        .snackbar {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 16px;
            position: fixed;
            z-index: 9999;
            left: 50%;
            bottom: 30px;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .snackbar.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }
        
        .snackbar.success {
            background-color: #28a745;
        }
        
        .snackbar.error {
            background-color: #dc3545;
        }
        
        .snackbar.info {
            background-color: #17a2b8;
        }
        
        .snackbar-content {
            display: flex;
            align-items: center;
            width: 100%;
        }
        
        .snackbar-message {
            flex-grow: 1;
            text-align: left;
        }
        
        .snackbar-close {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 0 0 0 16px;
        }

        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }
    </style>

    @yield('styles')
</head>

<body>
    <div id="wrapper">
        <!-- Snackbar element -->
        <div id="snackbar" class="snackbar">
            <div class="snackbar-content">
                <div class="snackbar-message">
                    <strong id="snackbar-title">Message</strong>
                    <div id="snackbar-text"></div>
                </div>
                <button class="snackbar-close" onclick="hideSnackbar()">&times;</button>
            </div>
        </div>
        <nav class="sidebar" id="sidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-text mx-3">Admin Panel</div>
            </a>

            <hr class="sidebar-divider my-0" style="border-color: rgba(255,255,255,.15);">

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <hr class="sidebar-divider" style="border-color: rgba(255,255,255,.15);">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                        href="{{ route('admin.products.index') }}">
                        <i class="fas fa-fw fa-box"></i>
                        <span>Products</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                        href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                        href="{{ route('admin.users.index') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.stories.*') ? 'active' : '' }}"
                        href="{{ route('admin.stories.index') }}">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Stories</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.workshops.*') ? 'active' : '' }}"
                        href="{{ route('admin.workshops.index') }}">
                        <i class="fas fa-fw fa-calendar-alt"></i>
                        <span>Workshops</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"
                        href="{{ route('admin.workshop-events.index') }}">
                        <i class="fas fa-fw fa-calendar"></i>
                        <span>Events</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}"
                        href="{{ route('admin.blog.index') }}">
                        <i class="fas fa-fw fa-blog"></i>
                        <span>Blog</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}"
                        href="{{ route('admin.contact-messages.index') }}">
                        <i class="fas fa-fw fa-envelope"></i>
                        <span>Messages</span>
                    </a>
                </li>

                <hr class="sidebar-divider" style="border-color: rgba(255,255,255,.15);">

            </ul>
        </nav>
        <div class="content-wrapper">
            <nav class="topbar navbar navbar-expand navbar-light bg-white">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 mobile-sidebar-toggle">
                    <i class="fa fa-bars"></i>
                </button>
                <ul class="navbar-nav ">
                    <li>
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="fas fa-home"></i>
                            Go to Website
                        </a>
                    </li>

                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown mx-3 mt-1">
                        @include('admin.components.notification-dropdown')
                    </li>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="me-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            <i class="fas fa-user-circle fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
                @if(session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showSnackbar('Error', '{{ session('error') }}', 'error');
                    });
                </script>
                @endif

                @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showSnackbar('Success', '{{ session('success') }}', 'success');
                    });
                </script>
                @endif

                @if(session('info'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showSnackbar('Information', '{{ session('info') }}', 'info');
                    });
                </script>
                @endif

                @if(session('snackbar'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showSnackbar('Success', '{{ session('snackbar') }}', 'success');
                    });
                </script>
                @endif

                @if(session('welcome'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showSnackbar('Welcome', 'مرحباً {{ session('welcome') }}! تم تسجيل الدخول بنجاح.', 'success');
                    });
                </script>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/admin-notifications.js') }}"></script>

    <script>
        // Toggle the side navigation
        $("#sidebarToggleTop").on('click', function (e) {
            $("#sidebar").toggleClass("show");
        });

        // Close sidebar when clicking outside on mobile
        $(document).on('click', function (e) {
            if ($(window).width() <= 768) {
                if (!$(e.target).closest('#sidebar, #sidebarToggleTop').length) {
                    $("#sidebar").removeClass("show");
                }
            }
        });

        function showSnackbar(title, message, type) {
            var snackbar = document.getElementById("snackbar");
            snackbar.className = "snackbar " + type;
            document.getElementById("snackbar-title").innerHTML = title;
            document.getElementById("snackbar-text").innerHTML = message;
            snackbar.className = "snackbar " + type + " show";
            setTimeout(function(){ 
                snackbar.className = snackbar.className.replace("show", ""); 
            }, 3000);
        }

        function hideSnackbar() {
            var snackbar = document.getElementById("snackbar");
            snackbar.className = snackbar.className.replace("show", "");
        }
    </script>

    @yield('scripts')
</body>

</html>