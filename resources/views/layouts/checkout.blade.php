<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('textDirection', 'ltr') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Checkout - Children\'s Treasures')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-50 {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }} flex flex-col min-h-screen">
    
    <main class="flex-1">
        <div class="container mx-auto py-4 px-4 relative">
            <a href="#" id="cancel-checkout" class="absolute btn btn-danger top-4 left-4 font-semibold py-2 px-4 border border-gray-400 rounded shadow flex items-center">
                Cancel
            </a>
            
            @yield('content')
        </div>
    </main>

    <!-- Confirmation Modal -->
    <div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h3 class="text-lg font-bold mb-4">Cancel Checkout</h3>
            <p class="mb-6">Are you sure you want to cancel the checkout process? Your order will not be processed.</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelNo" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">No, continue</button>
                <a href="{{ route('cart.index') }}" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Yes, cancel order</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cancelBtn = document.getElementById('cancel-checkout');
            const cancelModal = document.getElementById('cancelModal');
            const cancelNoBtn = document.getElementById('cancelNo');
            
            if (cancelBtn && cancelModal && cancelNoBtn) {
                cancelBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    cancelModal.classList.remove('hidden');
                });
                
                cancelNoBtn.addEventListener('click', function() {
                    cancelModal.classList.add('hidden');
                });
            }
        });
    </script>
    @stack('scripts') 
</body>
</html>
