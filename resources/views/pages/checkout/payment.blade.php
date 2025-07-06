@extends('layouts.app')

@section('title', 'Payment Method Selection')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Choose Payment Method</h1>
                <p class="text-gray-600 text-lg">Select the most convenient way to complete your purchase</p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-12">
                <div class="flex items-center justify-center space-x-8">
                    <div class="flex items-center text-green-600">
                        <div class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-lg">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="ml-3 font-semibold text-lg">Shipping Info</span>
                    </div>
                    <div class="w-20 h-1 bg-green-600 rounded-full"></div>
                    <div class="flex items-center text-blue-600">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-lg">2</div>
                        <span class="ml-3 font-semibold text-lg">Payment</span>
                    </div>
                    <div class="w-20 h-1 bg-gray-300 rounded-full"></div>
                    <div class="flex items-center text-gray-400">
                        <div class="w-10 h-10 bg-gray-300 text-white rounded-full flex items-center justify-center text-sm font-bold">3</div>
                        <span class="ml-3 font-medium text-lg">Confirmation</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Payment Methods Section -->
                <div class="xl:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Available Payment Methods</h2>

                        <form action="{{ route('checkout.payment.process') }}" method="POST" id="payment-form">
                            @csrf
                            <div class="space-y-6">
                                <!-- Cash on Delivery -->
                                <div class="payment-option border-3 border-gray-200 rounded-xl p-6 cursor-pointer hover:border-green-500 transition-all duration-300 transform hover:scale-105" data-payment="cash_on_delivery">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                                                    <i class="fas fa-truck text-3xl text-white"></i>
                                                </div>
                                            </div>
                                            <div class="ml-6">
                                                <h3 class="text-xl font-bold text-gray-900">Cash on Delivery</h3>
                                                <p class="text-gray-600 mt-2 text-base">Pay cash when your order arrives</p>
                                                <div class="flex items-center mt-3">
                                                    <i class="fas fa-shield-alt text-green-500 text-base mr-2"></i>
                                                    <span class="text-base text-green-600 font-medium">Safe & Secure</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" name="payment_method" value="cash_on_delivery" class="text-green-600 w-6 h-6 focus:ring-green-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Visa/Mastercard -->
                                <div class="payment-option border-3 border-gray-200 rounded-xl p-6 cursor-pointer hover:border-blue-500 transition-all duration-300 transform hover:scale-105" data-payment="credit_card">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                                                    <i class="fas fa-credit-card text-3xl text-white"></i>
                                                </div>
                                            </div>
                                            <div class="ml-6">
                                                <h3 class="text-xl font-bold text-gray-900">Visa / Mastercard</h3>
                                                <p class="text-gray-600 mt-2 text-base">Pay securely using your credit card</p>
                                                <div class="flex items-center mt-3 space-x-3">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="h-8 rounded shadow-sm">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-8 rounded shadow-sm">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" name="payment_method" value="credit_card" class="text-blue-600 w-6 h-6 focus:ring-blue-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- CliQ -->
                                <div class="payment-option border-3 border-gray-200 rounded-xl p-6 cursor-pointer hover:border-purple-500 transition-all duration-300 transform hover:scale-105" data-payment="cliq">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                                    <i class="fas fa-mobile-alt text-3xl text-white"></i>
                                                </div>
                                            </div>
                                            <div class="ml-6">
                                                <h3 class="text-xl font-bold text-gray-900">CliQ</h3>
                                                <p class="text-gray-600 mt-2 text-base">Fast and secure payment via CliQ</p>
                                                <div class="flex items-center mt-3">
                                                    <i class="fas fa-bolt text-yellow-500 text-base mr-2"></i>
                                                    <span class="text-base text-purple-600 font-medium">Instant Transfer</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" name="payment_method" value="cliq" class="text-purple-600 w-6 h-6 focus:ring-purple-500">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Continue Button -->
                            <div class="mt-10">
                                <button type="submit" id="continue-payment" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 px-8 rounded-xl text-lg font-bold hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg transform hover:scale-105" disabled>
                                    <i class="fas fa-arrow-right mr-2"></i>
                                    Continue Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary Section -->
                <div class="xl:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-8 sticky top-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Order Summary</h3>

                        <!-- Cart Items -->
                        <div class="space-y-4 mb-8">
                            @foreach($cart->items as $item)
                            <div class="flex items-center space-x-4 bg-gray-50 p-4 rounded-xl">
                                <div class="flex-shrink-0">
                                    <img src="{{ $item->product->image_url ?? asset('images/default-product.jpg') }}"
                                         alt="{{ $item->product->name }}"
                                         class="w-16 h-16 object-cover rounded-xl shadow-md">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-base font-bold text-gray-900 truncate">
                                        {{ $item->product->name }}
                                    </h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Quantity: {{ $item->quantity }}
                                    </p>
                                    <p class="text-lg font-bold text-blue-600 mt-1">
                                        ${{ number_format($item->product->price * $item->quantity, 2) }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Order Totals -->
                        <div class="border-t-2 border-gray-200 pt-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-base text-gray-600 font-medium">Subtotal:</span>
                                    <span class="text-base font-bold text-gray-900">${{ number_format($orderData['subtotal'], 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-base text-gray-600 font-medium">Shipping:</span>
                                    <span class="text-base font-bold text-gray-900">$2.00</span>
                                </div>

                                @if($orderData['discount'] > 0)
                                <div class="flex justify-between items-center">
                                    <span class="text-base text-gray-600 font-medium">Discount:</span>
                                    <span class="text-base font-bold text-green-600">-${{ number_format($orderData['discount'], 2) }}</span>
                                </div>
                                @endif

                                <div class="border-t-2 border-gray-200 pt-4 mt-6">
                                    <div class="flex justify-between items-center bg-blue-50 p-4 rounded-xl">
                                        <span class="text-xl font-bold text-gray-900">Total:</span>
                                        <span class="text-2xl font-bold text-blue-600">${{ number_format($orderData['subtotal'] + 2 - $orderData['discount'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Features -->
                        <div class="mt-8 p-6 bg-gradient-to-br from-green-50 to-blue-50 rounded-xl border border-green-200">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 text-center">
                                <i class="fas fa-shield-alt text-green-600 mr-2"></i>
                                Security & Protection
                            </h4>
                            <div class="space-y-3">
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class="fas fa-lock text-green-500 mr-3 w-5"></i>
                                    <span class="font-medium">256-bit SSL Encryption</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class="fas fa-shield-alt text-green-500 mr-3 w-5"></i>
                                    <span class="font-medium">Bank Data Protection</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class="fas fa-undo text-green-500 mr-3 w-5"></i>
                                    <span class="font-medium">Money Back Guarantee</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentOptions = document.querySelectorAll('.payment-option');
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const continueButton = document.getElementById('continue-payment');
    const form = document.getElementById('payment-form');

    // Handle payment option selection
    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            paymentOptions.forEach(opt => {
                opt.classList.remove('border-blue-500', 'bg-blue-50', 'border-green-500', 'bg-green-50', 'border-purple-500', 'bg-purple-50');
                opt.classList.add('border-gray-200');
            });

            // Add active class to selected option based on payment method
            const paymentMethod = this.getAttribute('data-payment');
            this.classList.remove('border-gray-200');

            if (paymentMethod === 'cash_on_delivery') {
                this.classList.add('border-green-500', 'bg-green-50');
            } else if (paymentMethod === 'credit_card') {
                this.classList.add('border-blue-500', 'bg-blue-50');
            } else if (paymentMethod === 'cliq') {
                this.classList.add('border-purple-500', 'bg-purple-50');
            }

            // Check the radio button
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;

            // Enable continue button
            continueButton.disabled = false;
        });
    });

    // Handle radio button change
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                continueButton.disabled = false;
            }
        });
    });

    // Handle form submission
    form.addEventListener('submit', function(e) {
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');

        if (!selectedPayment) {
            e.preventDefault();
            // Show elegant alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Please select a payment method';
            document.body.appendChild(alertDiv);

            setTimeout(() => {
                document.body.removeChild(alertDiv);
            }, 3000);
            return;
        }

        // Show loading state
        continueButton.disabled = true;
        continueButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';

        // Re-enable button after timeout (fallback)
        setTimeout(() => {
            continueButton.disabled = false;
            continueButton.innerHTML = '<i class="fas fa-arrow-right mr-2"></i>Continue Payment';
        }, 30000);
    });
});
</script>

<style>
.payment-option {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.payment-option:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.payment-option.border-green-500 {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.05), rgba(134, 239, 172, 0.05));
    border-width: 3px;
}

.payment-option.border-blue-500 {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(147, 197, 253, 0.05));
    border-width: 3px;
}

.payment-option.border-purple-500 {
    background: linear-gradient(135deg, rgba(147, 51, 234, 0.05), rgba(196, 181, 253, 0.05));
    border-width: 3px;
}

/* Custom scrollbar for the order summary */
.sticky {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 #f1f5f9;
}

.sticky::-webkit-scrollbar {
    width: 6px;
}

.sticky::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.sticky::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.sticky::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Smooth animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.payment-option {
    animation: fadeInUp 0.6s ease-out;
}

.payment-option:nth-child(1) { animation-delay: 0.1s; }
.payment-option:nth-child(2) { animation-delay: 0.2s; }
.payment-option:nth-child(3) { animation-delay: 0.3s; }
</style>
@endsection