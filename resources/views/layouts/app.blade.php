<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('textDirection', 'ltr') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Children\'s Treasures')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Snackbar styles */
        .snackbar {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #4e73df;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 16px;
            position: fixed;
            z-index: 1100;
            left: 50%;
            bottom: 30px;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .snackbar.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
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
    @stack('styles')
</head>
<body class="bg-gray-50 {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }} flex flex-col min-h-screen">
    
    @include('partials.header')
  
    <main class="flex-1">
        @yield('content')
    </main>
    
    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Testimonial slider functionality
        document.addEventListener('DOMContentLoaded', function() {
            const track = document.querySelector('.testimonial-track');
            if (track) {
                let current = 0;
                
                setInterval(() => {
                    current = (current + 1) % 2;
                    track.style.transform = `translateX(-${current * 100}%)`;
                }, 5000);
            }
        });
    </script>
    
    @stack('scripts') 
    
    <!-- Snackbar for welcome message -->
    @if(session('welcome'))
    <div id="welcomeSnackbar" class="snackbar">
        <i class="fas fa-user-check me-2"></i> مرحباً {{ session('welcome') }}! تم تسجيل الدخول بنجاح.
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var snackbar = document.getElementById("welcomeSnackbar");
            snackbar.className = "snackbar show";
            setTimeout(function(){ 
                snackbar.className = snackbar.className.replace("show", ""); 
            }, 3000);
        });
    </script>
    @endif

    <!-- Snackbar for success message -->
    @if(session('success'))
    <div id="successSnackbar" class="snackbar">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var snackbar = document.getElementById("successSnackbar");
            snackbar.className = "snackbar show";
            setTimeout(function(){ 
                snackbar.className = snackbar.className.replace("show", ""); 
            }, 3000);
        });
    </script>
    @endif
</body>
</html>