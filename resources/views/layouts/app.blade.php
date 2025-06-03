<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Children\'s Treasures')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
  
    @yield('styles')
</head>
<body class="bg-gray-50 ltr">
    
    @include('partials.header')
  
    <main>
        @yield('content')
    </main>
    
    @include('partials.footer')

    <!-- Scripts -->
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
    
    @yield('scripts')
</body>
</html>





   