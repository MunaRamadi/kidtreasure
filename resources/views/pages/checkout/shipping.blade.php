@extends('layouts.checkout')

@section('title', 'Shipping Information')

@section('content')
<div class="container mx-auto py-8 px-4 max-w-6xl mt-10">
    <div class="relative">
        <a href="#" id="cancel-checkout" class="absolute top-0 left-0 btn btn-danger font-semibold py-2 px-4 border border-gray-400 rounded shadow flex items-center">
            Cancel
        </a>
    </div>
    <h1 class="text-3xl font-bold text-center mb-4">Shipping Information</h1>
    <p class="text-center text-gray-600 mb-8">Please provide your shipping details to continue</p>
    
    <!-- Checkout Progress Steps -->
    <div class="flex items-center justify-center mb-12">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white">
                <span class="font-medium">1</span>
            </div>
            <span class="ml-2 text-blue-500 font-medium">Shipping Info</span>
        </div>
        <div class="h-1 w-16 bg-gray-300 mx-4"></div>
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-white">
                <span class="font-medium">2</span>
            </div>
            <span class="ml-2 text-gray-400 font-medium">Payment</span>
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
        <!-- Shipping Form Section -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-6">Shipping Address</h2>
                
                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="{{ route('checkout.shipping.store') }}" method="POST" id="shipping-form">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $shippingInfo['first_name'] ?? '') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        
                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $shippingInfo['last_name'] ?? '') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $shippingInfo['email'] ?? '') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        
                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $shippingInfo['phone'] ?? '') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        
                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $shippingInfo['address'] ?? '') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        
                        <!-- City -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                            <input type="text" name="city" id="city" value="{{ old('city', $shippingInfo['city'] ?? '') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        
                        <!-- Postal Code -->
                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $shippingInfo['postal_code'] ?? '') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <!-- Hidden shipping method input -->
                    <input type="hidden" name="shipping_method" value="standard">
                    
                    <!-- Order Notes -->
                    <div class="mt-8">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="3" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $shippingInfo['notes'] ?? '') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Add any special instructions or information about your delivery</p>
                    </div>
                    
                    <div class="mt-8">
                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg flex items-center justify-center">
                            <span class="mr-2">Continue to Payment</span>
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
                    <div class="flex justify-between font-bold text-lg mt-4 pt-4 border-t">
                        <span>Total:</span>
                        <span class="text-blue-500">${{ number_format($cart->total_price, 2) }}</span>
                    </div>
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
        // Add click handler for shipping options
        const shippingOptions = document.querySelectorAll('.shipping-option');
        
        shippingOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Find the radio button within this option and select it
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Remove selected class from all options
                shippingOptions.forEach(opt => {
                    opt.classList.remove('border-blue-500');
                    opt.classList.add('border');
                });
                
                // Add selected class to clicked option
                this.classList.remove('border');
                this.classList.add('border-blue-500');
            });
        });
        
        // Initialize selected shipping option
        const selectedOption = document.querySelector('input[name="shipping_method"]:checked');
        if (selectedOption) {
            const parentOption = selectedOption.closest('.shipping-option');
            if (parentOption) {
                parentOption.classList.remove('border');
                parentOption.classList.add('border-blue-500');
            }
        }
        
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
