@extends('layouts.app')

@section('title', 'سلة التسوق')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">سلة التسوق</h1>
            <p class="text-gray-600 mt-2">راجع منتجاتك المختارة قبل إتمام الطلب</p>
        </div>

        @if($cart->total_items > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">المنتجات ({{ $cart->total_items }} منتج)</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($cart->items as $item)
                                <div class="p-6 cart-item" data-item-id="{{ $item->id }}">
                                    <div class="flex items-center space-x-4 space-x-reverse">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            @if($item->product_image)
                                                <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}" 
                                                     class="w-20 h-20 object-cover rounded-lg">
                                            @else
                                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-medium text-gray-900">{{ $item->product_name }}</h3>
                                            <p class="text-sm text-gray-500 mt-1">السعر: {{ number_format($item->price, 2) }} د.أ</p>
                                            
                                            <!-- Quantity Controls -->
                                            <div class="flex items-center mt-3 space-x-3 space-x-reverse">
                                                <label class="text-sm font-medium text-gray-700">الكمية:</label>
                                                <div class="flex items-center border border-gray-300 rounded-md">
                                                    <button type="button" class="quantity-btn decrease-btn px-3 py-1 text-gray-600 hover:text-gray-800 hover:bg-gray-100" 
                                                            data-item-id="{{ $item->id }}" data-action="decrease">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="number" 
                                                           class="quantity-input w-16 px-2 py-1 text-center border-0 focus:ring-0" 
                                                           value="{{ $item->quantity }}" 
                                                           min="1" 
                                                           data-item-id="{{ $item->id }}">
                                                    <button type="button" class="quantity-btn increase-btn px-3 py-1 text-gray-600 hover:text-gray-800 hover:bg-gray-100" 
                                                            data-item-id="{{ $item->id }}" data-action="increase">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Price and Remove -->
                                        <div class="flex flex-col items-end space-y-2">
                                            <div class="text-lg font-semibold text-gray-900 item-subtotal">
                                                {{ number_format($item->total, 2) }} د.أ
                                            </div>
                                            <button type="button" class="remove-item-btn text-red-600 hover:text-red-800 text-sm" 
                                                    data-item-id="{{ $item->id }}">
                                                <svg class="w-5 h-5 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                حذف
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Clear Cart Button -->
                        <div class="p-6 bg-gray-50 border-t border-gray-200">
                            <button type="button" id="clear-cart-btn" 
                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                <svg class="w-5 h-5 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                تفريغ السلة بالكامل
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">ملخص الطلب</h3>
                        
                        <div class="space-y-3 border-b border-gray-200 pb-4 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">عدد المنتجات:</span>
                                <span class="font-medium cart-total-items">{{ $cart->total_items }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">المجموع الفرعي:</span>
                                <span class="font-medium cart-subtotal">{{ number_format($cart->total_price, 2) }} د.أ</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">الشحن:</span>
                                <span class="font-medium">سيتم حسابه في الدفع</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between text-lg font-semibold text-gray-900 mb-6">
                            <span>المجموع:</span>
                            <span class="cart-total-price">{{ number_format($cart->total_price, 2) }} د.أ</span>
                        </div>
                        
                        <div class="space-y-3">
                            <a href="{{ route('checkout.index') }}" 
                               class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200 text-center block">
                                متابعة إلى الدفع
                            </a>
                            
                            <a href="{{ route('products.index') }}" 
                               class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200 text-center block">
                                متابعة التسوق
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">سلة التسوق فارغة</h2>
                <p class="text-gray-600 mb-8">لم تقم بإضافة أي منتجات إلى سلة التسوق بعد</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    تصفح المنتجات
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const action = this.dataset.action;
            const input = document.querySelector(`input[data-item-id="${itemId}"]`);
            let currentValue = parseInt(input.value);
            
            if (action === 'increase') {
                input.value = currentValue + 1;
            } else if (action === 'decrease' && currentValue > 1) {
                input.value = currentValue - 1;
            }
            
            updateCartItem(itemId, input.value);
        });
    });
    
    // Direct quantity input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const quantity = Math.max(1, parseInt(this.value) || 1);
            this.value = quantity;
            updateCartItem(itemId, quantity);
        });
    });
    
    // Remove item buttons
    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            removeCartItem(itemId);
        });
    });
    
    // Clear cart button
    document.getElementById('clear-cart-btn')?.addEventListener('click', function() {
        if (confirm('هل أنت متأكد من تفريغ سلة التسوق بالكامل؟')) {
            clearCart();
        }
    });
    
    function updateCartItem(itemId, quantity) {
        fetch(`/cart/update-item/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update item subtotal
                const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
                const subtotalElement = itemElement.querySelector('.item-subtotal');
                subtotalElement.textContent = parseFloat(data.item.subtotal).toFixed(2) + ' د.أ';
                
                // Update cart totals
                updateCartTotals(data.cart);
                
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('حدث خطأ أثناء تحديث السلة', 'error');
        });
    }
    
    function removeCartItem(itemId) {
        fetch(`/cart/remove-item/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove item from DOM
                document.querySelector(`[data-item-id="${itemId}"]`).remove();
                
                // Update cart totals
                updateCartTotals(data.cart);
                
                // Check if cart is empty
                if (data.cart.total_items === 0) {
                    location.reload();
                }
                
                showNotification(data.message, 'success');
            } else {
                showNotification('حدث خطأ أثناء حذف المنتج', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('حدث خطأ أثناء حذف المنتج', 'error');
        });
    }
    
    function clearCart() {
        fetch('/cart/clear', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showNotification('حدث خطأ أثناء تفريغ السلة', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('حدث خطأ أثناء تفريغ السلة', 'error');
        });
    }
    
    function updateCartTotals(cart) {
        document.querySelector('.cart-total-items').textContent = cart.total_items;
        document.querySelector('.cart-subtotal').textContent = parseFloat(cart.total_price).toFixed(2) + ' د.أ';
        document.querySelector('.cart-total-price').textContent = parseFloat(cart.total_price).toFixed(2) + ' د.أ';
    }
    
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
</script>
@endpush
@endsection