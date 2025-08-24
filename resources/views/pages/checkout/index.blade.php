@extends('layouts.checkout')

@section('title', 'الدفع')

@section('content')
<div class="container mx-auto px-4 max-w-6xl mt-10">
    <div class="relative">
        <a href="#" id="cancel-checkout" class="absolute top-0 left-0 btn btn-danger font-semibold py-2 px-4 border border-gray-400 rounded shadow flex items-center">
            Cancel
        </a>
    </div>
    <h1 class="text-3xl font-bold text-center mb-4">Choose Payment Method</h1>
    <p class="text-center text-gray-600 mb-8">Select the most convenient way to complete your purchase</p>
    
    <!-- Checkout Progress Steps -->
    <div class="flex items-center justify-center mb-12">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <span class="ml-2 text-green-500 font-medium">Shipping Info</span>
        </div>
        <div class="h-1 w-16 bg-green-500 mx-4"></div>
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white">
                <span class="font-medium">2</span>
            </div>
            <span class="ml-2 text-blue-500 font-medium">Payment</span>
        </div>
        <div class="h-1 w-16 bg-gray-300 mx-4"></div>
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-white">
                <span class="font-medium">3</span>
            </div>
            <span class="ml-2 text-gray-400 font-medium">Confirmation</span>
        </div>
    </div>
    
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Payment Methods Section -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-6">Available Payment Methods</h2>
                
                <form action="{{ route('checkout.process') }}" method="POST" id="payment-form">
                    @csrf
                    
                    <!-- Cash on Delivery Option -->
                    <div class="border rounded-lg p-4 mb-4 hover:border-blue-500 cursor-pointer payment-option">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h3 class="font-bold">Cash on Delivery</h3>
                                <p class="text-sm text-gray-600">Pay cash when your order arrives</p>
                            </div>
                            <div>
                                <input type="radio" name="payment_method" value="cash_on_delivery" class="h-5 w-5 text-blue-500">
                            </div>
                        </div>
                        <div class="mt-2 ml-16">
                            <span class="text-xs text-green-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Safe & Secure
                            </span>
                        </div>
                    </div>
                    
                    <!-- Credit Card Option -->
                    <div class="border rounded-lg p-4 mb-4 hover:border-blue-500 cursor-pointer payment-option">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h3 class="font-bold">Visa / Mastercard</h3>
                                <p class="text-sm text-gray-600">Pay securely using your credit card</p>
                            </div>
                            <div>
                                <input type="radio" name="payment_method" value="credit_card" class="h-5 w-5 text-blue-500">
                            </div>
                        </div>
                        <div class="mt-2 ml-16 flex">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="h-6 mr-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-6">
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg flex items-center justify-center">
                            <span class="mr-2">Continue Payment</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Order Summary Section -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-6">Order Summary</h2>
                
                @foreach($cart->items as $item)
                <div class="flex items-center mb-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden mr-4">
                        @if($item->current_product_image)
                            <img src="{{ $item->current_product_image }}" alt="{{ $item->current_product_name }}" class="w-full h-full object-cover">
                        @else
                            <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                <span class="text-gray-500">{{ substr($item->current_product_name, 0, 2) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-medium text-sm">{{ $item->current_product_name }}</h3>
                        <p class="text-gray-500 text-xs">Quantity: {{ $item->quantity }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold">${{ number_format($item->price, 2) }}</p>
                    </div>
                </div>
                @endforeach
                
                <div class="border-t pt-4 mt-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal:</span>
                        <span>${{ number_format($cart->total_price, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Shipping:</span>
                        <span>${{ number_format(2.00, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg mt-4 pt-4 border-t">
                        <span>Total:</span>
                        <span class="text-blue-500">${{ number_format($cart->total_price + 2.00, 2) }}</span>
                    </div>
                </div>
                
                <!-- Shipping Information Summary -->
                <div class="mt-6 pt-6 border-t">
                    <h3 class="font-bold flex items-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Shipping Information
                    </h3>
                    <div class="text-sm space-y-2">
                        <p><span class="font-medium">Name:</span> {{ $shippingInfo['first_name'] }} {{ $shippingInfo['last_name'] }}</p>
                        <p><span class="font-medium">Email:</span> {{ $shippingInfo['email'] }}</p>
                        <p><span class="font-medium">Phone:</span> {{ $shippingInfo['phone'] }}</p>
                        <p><span class="font-medium">Address:</span> {{ $shippingInfo['address'] }}</p>
                        <p><span class="font-medium">City:</span> {{ $shippingInfo['city'] }}</p>
                        @if(!empty($shippingInfo['postal_code']))
                            <p><span class="font-medium">Postal Code:</span> {{ $shippingInfo['postal_code'] }}</p>
                        @endif
                        <div class="mt-2">
                            <a href="{{ route('checkout.shipping') }}" class="text-blue-500 hover:text-blue-700 text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Edit Shipping Information
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Security Features -->
                <div class="mt-6 pt-6 border-t">
                    <h3 class="font-bold flex items-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Security & Protection
                    </h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            256-bit SSL Encryption
                        </li>
                        <li class="flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Fraud Extra Protection
                        </li>
                        <li class="flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Money Back Guarantee
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add click handler for payment options
        const paymentOptions = document.querySelectorAll('.payment-option');
        
        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Find the radio button within this option and select it
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Remove selected class from all options
                paymentOptions.forEach(opt => {
                    opt.classList.remove('border-blue-500');
                    opt.classList.add('border');
                });
                
                // Add selected class to clicked option
                this.classList.remove('border');
                this.classList.add('border-blue-500');
            });
        });
        
        // Cancel checkout functionality
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
@endpush
@endsection
