@extends('layouts.app')

@section('title', 'إتمام الطلب')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">إتمام الطلب</h1>
            <div class="flex items-center mt-4 space-x-4 space-x-reverse">
                <div class="flex items-center text-blue-600">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">1</div>
                    <span class="mr-2 font-medium">معلومات الشحن</span>
                </div>
                <div class="w-16 h-0.5 bg-gray-300"></div>
                <div class="flex items-center text-gray-400">
                    <div class="w-8 h-8 bg-gray-300 text-white rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                    <span class="mr-2">الدفع</span>
                </div>
                <div class="w-16 h-0.5 bg-gray-300"></div>
                <div class="flex items-center text-gray-400">
                    <div class="w-8 h-8 bg-gray-300 text-white rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                    <span class="mr-2">التأكيد</span>
                </div>
            </div>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Shipping Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">معلومات الشحن</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @guest
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">الاسم الأول *</label>
                                <input type="text" id="first_name" name="first_name" 
                                       value="{{ old('first_name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">الاسم الأخير *</label>
                                <input type="text" id="last_name" name="last_name" 
                                       value="{{ old('last_name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني *</label>
                                <input type="email" id="email" name="email" 
                                       value="{{ old('email') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @else
                            <!-- Hidden fields for logged-in users -->
                            <input type="hidden" name="first_name" value="{{ auth()->user()->first_name ?? auth()->user()->name }}">
                            <input type="hidden" name="last_name" value="{{ auth()->user()->last_name ?? '' }}">
                            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                            @endguest
                            
                            <div class="{{ auth()->check() ? 'md:col-span-2' : '' }}">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف *</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">العنوان *</label>
                                <input type="text" id="address" name="address" 
                                       value="{{ old('address') }}"
                                       placeholder="الشارع، رقم المبنى، إلخ"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">المدينة *</label>
                                <input type="text" id="city" name="city" 
                                       value="{{ old('city') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">الرمز البريدي</label>
                                <input type="text" id="postal_code" name="postal_code" 
                                       value="{{ old('postal_code') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('postal_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-2">البلد *</label>
                                <select id="country" name="country" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    <option value="">اختر البلد</option>
                                    <option value="Jordan" {{ old('country') == 'Jordan' ? 'selected' : '' }}>الأردن</option>
                                    <option value="Palestine" {{ old('country') == 'Palestine' ? 'selected' : '' }}>فلسطين</option>
                                    <option value="Lebanon" {{ old('country') == 'Lebanon' ? 'selected' : '' }}>لبنان</option>
                                    <option value="Syria" {{ old('country') == 'Syria' ? 'selected' : '' }}>سوريا</option>
                                    <option value="UAE" {{ old('country') == 'UAE' ? 'selected' : '' }}>الإمارات العربية المتحدة</option>
                                    <option value="Saudi Arabia" {{ old('country') == 'Saudi Arabia' ? 'selected' : '' }}>المملكة العربية السعودية</option>
                                </select>
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Method -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">طريقة الشحن</h3>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="shipping_method" value="standard" class="text-blue-600" checked>
                                <div class="mr-3 flex-1">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-900">الشحن العادي</span>
                                        <span class="text-gray-600">5.00 د.أ</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">التسليم خلال 3-5 أيام عمل</p>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="shipping_method" value="express" class="text-blue-600">
                                <div class="mr-3 flex-1">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-900">الشحن السريع</span>
                                        <span class="text-gray-600">15.00 د.أ</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">التسليم خلال 1-2 أيام عمل</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">طريقة الدفع</h3>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="cash_on_delivery" class="text-blue-600" checked>
                                <div class="mr-3 flex-1">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-900">الدفع عند الاستلام</span>
                                        <i class="fas fa-truck text-gray-400"></i>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">ادفع نقداً عند وصول الطلب</p>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="credit_card" class="text-blue-600">
                                <div class="mr-3 flex-1">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-900">بطاقة ائتمانية</span>
                                        <i class="fas fa-credit-card text-gray-400"></i>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">فيزا، ماستركارد، أو أمريكان إكسبرس</p>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="paypal" class="text-blue-600">
                                <div class="mr-3 flex-1">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-900">PayPal</span>
                                        <i class="fab fa-paypal text-blue-500"></i>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">ادفع بأمان باستخدام حساب PayPal</p>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="bank_transfer" class="text-blue-600">
                                <div class="mr-3 flex-1">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-900">تحويل بنكي</span>
                                        <i class="fas fa-university text-gray-400"></i>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">تحويل مباشر إلى الحساب البنكي</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Discount Code -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">كود الخصم</h3>
                        <div class="flex gap-3">
                            <input type="text" 
                                   name="discount_code" 
                                   value="{{ old('discount_code') }}"
                                   placeholder="أدخل كود الخصم"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="button" 
                                    id="apply-discount"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                تطبيق
                            </button>
                        </div>
                        @error('discount_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order Notes -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">ملاحظات الطلب (اختياري)</h3>
                        <textarea name="notes" rows="4" 
                                  placeholder="أضف أي ملاحظات خاصة بطلبك هنا..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">ملخص الطلب</h3>
                        
                        <!-- Cart Items -->
                        <div class="space-y-4 mb-6">
                            @foreach($cart->items as $item)
                            <div class="flex items-center space-x-4 space-x-reverse">
                                <div class="flex-shrink-0">
                                    <img src="{{ $item->product->image_url ?? asset('images/default-product.jpg') }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-16 h-16 object-cover rounded-md">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 truncate">
                                        {{ $item->product->name }}
                                    </h4>
                                    <p class="text-sm text-gray-500">
                                        الكمية: {{ $item->quantity }}
                                    </p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ number_format($item->product->price * $item->quantity, 2) }} د.أ
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Order Totals -->
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">المجموع الفرعي:</span>
                                <span class="text-sm font-medium text-gray-900">{{ number_format($cart->total_price, 2) }} د.أ</span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">الشحن:</span>
                                <span class="text-sm font-medium text-gray-900">
                                    <span id="shipping-cost">5.00</span> د.أ
                                </span>
                            </div>
                            
                            @php
                                $tax = $cart->total_price * 0.10; // 10% ضريبة
                                $total = $cart->total_price + $tax + 5.00; // إضافة تكلفة الشحن الافتراضية
                            @endphp
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">الضريبة (10%):</span>
                                <span class="text-sm font-medium text-gray-900">{{ number_format($tax, 2) }} د.أ</span>
                            </div>
                            
                            <div id="discount-section" class="hidden">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">الخصم:</span>
                                    <span class="text-sm font-medium text-green-600">
                                        -<span id="discount-amount">0.00</span> د.أ
                                    </span>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-2 mt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">المجموع الكلي:</span>
                                    <span class="text-lg font-bold text-blue-600">
                                        <span id="total-cost">{{ number_format($total, 2) }}</span> د.أ
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mt-6">
                            <label class="flex items-start">
                                <input type="checkbox" name="terms_accepted" 
                                       class="mt-1 text-blue-600 border-gray-300 rounded focus:ring-blue-500" 
                                       required>
                                <span class="mr-2 text-sm text-gray-600">
                                    أوافق على 
                                    <a href="#" class="text-blue-600 hover:underline" target="_blank">
                                        الشروط والأحكام
                                    </a>
                                    و
                                    <a href="#" class="text-blue-600 hover:underline" target="_blank">
                                        سياسة الخصوصية
                                    </a>
                                </span>
                            </label>
                            @error('terms_accepted')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full mt-6 bg-blue-600 text-white py-3 px-4 rounded-md font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                id="submit-order">
                            إتمام الطلب
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const shippingOptions = document.querySelectorAll('input[name="shipping_method"]');
    const shippingCostElement = document.getElementById('shipping-cost');
    const totalCostElement = document.getElementById('total-cost');
    const discountSection = document.getElementById('discount-section');
    const discountAmountElement = document.getElementById('discount-amount');
    const submitButton = document.getElementById('submit-order');
    const form = document.getElementById('checkout-form');
    
    const baseSubtotal = {{ $cart->total_price }};
    const baseTax = {{ $tax }};
    let currentDiscount = 0;
    
    // تحديث إجمالي السعر
    function updateTotal() {
        const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
        let shippingCost = 5.00; // افتراضي
        
        if (selectedShipping) {
            shippingCost = selectedShipping.value === 'express' ? 15.00 : 5.00;
        }
        
        shippingCostElement.textContent = shippingCost.toFixed(2);
        
        const total = baseSubtotal + baseTax + shippingCost - currentDiscount;
        totalCostElement.textContent = total.toFixed(2);
    }
    
    // معالج تغيير طريقة الشحن
    shippingOptions.forEach(option => {
        option.addEventListener('change', updateTotal);
    });
    
    // معالج كود الخصم
    document.getElementById('apply-discount').addEventListener('click', function() {
        const discountCode = document.querySelector('input[name="discount_code"]').value.trim();
        
        if (!discountCode) {
            if (typeof showToast === 'function') {
                showToast('تنبيه', 'يرجى إدخال كود الخصم', 'error');
            } else {
                console.error('Error: Please enter a discount code');
            }
            return;
        }
        
        // محاكاة التحقق من كود الخصم
        const discountCodes = {
            'WELCOME10': { type: 'percentage', value: 10 },
            'SUMMER20': { type: 'percentage', value: 20 },
            'FREESHIP': { type: 'fixed', value: 5 }
        };
        
        const discount = discountCodes[discountCode.toUpperCase()];
        
        if (discount) {
            if (discount.type === 'percentage') {
                currentDiscount = (baseSubtotal * discount.value) / 100;
            } else {
                currentDiscount = discount.value;
            }
            
            discountAmountElement.textContent = currentDiscount.toFixed(2);
            discountSection.classList.remove('hidden');
            updateTotal();
            
            // تغيير لون الزر لإظهار النجاح
            this.textContent = 'تم التطبيق';
            this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            this.classList.add('bg-green-100', 'text-green-700');
            
            if (typeof showToast === 'function') {
                showToast('نجاح', 'تم تطبيق كود الخصم بنجاح', 'success');
            } else {
                console.log('Success: Discount code applied');
            }
        } else {
            if (typeof showToast === 'function') {
                showToast('خطأ', 'كود الخصم غير صحيح', 'error');
            } else {
                console.error('Error: Invalid discount code');
            }
        }
    });
    
    // معالج إرسال النموذج
    form.addEventListener('submit', function(e) {
        submitButton.disabled = true;
        submitButton.textContent = 'جاري المعالجة...';
        
        // إعادة تفعيل الزر بعد 30 ثانية في حالة عدم الاستجابة
        setTimeout(() => {
            submitButton.disabled = false;
            submitButton.textContent = 'إتمام الطلب';
        }, 30000);
    });
    
    // تحديث السعر عند تحميل الصفحة
    updateTotal();
});
</script>
@endsection