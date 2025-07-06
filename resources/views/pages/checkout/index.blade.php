@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success text-center my-4" style="font-size:1.2em;">
            {{ session('success') }}
        </div>
    @endif
    <h1 class="page-title mb-4">{{ __('checkout.checkout') }}</h1>
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card p-4 mb-3">
                <h4 class="mb-3">{{ __('checkout.customer_info') }}</h4>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin-bottom:0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('checkout.confirm') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('checkout.first_name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" required value="{{ old('first_name', Auth::user()->first_name ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('checkout.last_name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control" required value="{{ old('last_name', Auth::user()->last_name ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('checkout.phone') }} <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" required value="{{ old('phone', Auth::user()->phone ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('checkout.email') }}</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('checkout.shipping_address') }} <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" required>{{ old('address', Auth::user()->address ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('checkout.city') }} <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control" required value="{{ old('city', Auth::user()->city ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('checkout.country') }} <span class="text-danger">*</span></label>
                        <input type="text" name="country" class="form-control" required value="{{ old('country', Auth::user()->country ?? 'الأردن') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('checkout.postal_code') }}</label>
                        <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', Auth::user()->postal_code ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('checkout.notes') }}</label>
                        <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">طريقة الشحن <span class="text-danger">*</span></label>
                        <select name="shipping_method" class="form-control" required>
                            <option value="">اختر طريقة الشحن</option>
                            <option value="standard">عادي</option>
                            <option value="express">سريع</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="terms_accepted" class="form-check-input" id="termsCheck" required>
                        <label class="form-check-label" for="termsCheck">
                            أوافق على <a href="#">الشروط والأحكام</a>
                        </label>
                    </div>
                    <input type="hidden" name="discount_code" value="">
                    <button type="submit" class="btn w-100" style="background-color: #764ba2; color: #fff; border: none;">{{ __('checkout.confirm_order') }}</button>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card p-4">
                <h4 class="mb-3">{{ __('checkout.cart_summary') }}</h4>
                <ul class="list-group mb-3">
                    @foreach($cart->items as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">{{ $item->product->name }}</div>
                                <small class="text-muted">{{ __('checkout.quantity') }}: {{ $item->quantity }}</small>
                                <div class="text-muted" style="font-size: 0.95em;">
                                    {{ __('checkout.price') }}: {{ number_format($item->price, 2) }} JOD
                                </div>
                            </div>
                            <span>{{ number_format($item->quantity * $item->price, 2) }} JOD</span>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ __('checkout.subtotal') }} ({{ __('checkout.amount') }}):</span>
                    <span class="fw-bold" style="color:#764ba2; font-size:1.1em;">
                        {{ number_format($cart->total_price, 2) }} <span style="font-size:0.9em;">JOD</span>
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ __('checkout.shipping') }}:</span>
                    <span id="shippingAmount">2.00 <span style="font-size:0.9em;">JOD</span></span>
                </div>

                <!-- Coupon Section -->
                <div class="coupon-section mb-3">
                    <div class="input-group">
                        <input type="text" id="couponCode" class="form-control" placeholder="{{ __('checkout.coupon_placeholder') }}">
                        <button class="btn btn-outline-primary" type="button" id="applyCoupon">{{ __('checkout.apply_coupon') }}</button>
                    </div>
                    <div id="couponMessage" class="mt-2" style="display: none;"></div>
                </div>

                <div class="d-flex justify-content-between mb-2" id="discountRow" style="display: none;">
                    <span>{{ __('checkout.discount') }}:</span>
                    <span id="discountAmount">0.00 JOD</span>
                </div>

                <div class="d-flex justify-content-between fw-bold border-top pt-2">
                    <span style="font-size:1.1em;">{{ __('checkout.total') }} ({{ __('checkout.amount') }}):</span>
                    <span id="totalAmount" style="color:#764ba2; font-size:1.2em;">
                        {{ number_format($cart->total_price + 2, 2) }} <span style="font-size:0.9em;">JOD</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-title {
    color: #0f8a42;
    font-weight: bold;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
    text-align: right;
}
.card {
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    background: #fff;
}
.btn-primary {
    background-color: #0f8a42;
    border: none;
}
.btn-primary:hover {
    background-color: #0c6b37;
}
.coupon-section {
    border-top: 1px solid #eee;
    padding-top: 15px;
}
#couponMessage {
    font-size: 0.9rem;
}
#couponMessage.success {
    color: #0f8a42;
}
#couponMessage.error {
    color: #dc3545;
}
@media (max-width: 768px) {
    .row { flex-direction: column-reverse; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const applyCouponBtn = document.getElementById('applyCoupon');
    const couponCodeInput = document.getElementById('couponCode');
    const couponMessage = document.getElementById('couponMessage');
    const discountRow = document.getElementById('discountRow');
    const discountAmount = document.getElementById('discountAmount');
    const totalAmount = document.getElementById('totalAmount');
    const shippingAmount = 2.00;
    let originalTotal = {{ $cart->total_price }};

    // رسائل الترجمة من PHP
    const messages = {
        success: "{{ __('checkout.success_coupon') }}",
        invalid: "{{ __('checkout.invalid_coupon') }}",
        error: "{{ __('checkout.error_coupon') }}",
        enter: "{{ __('checkout.enter_coupon') }}"
    };

    applyCouponBtn.addEventListener('click', function() {
        const code = couponCodeInput.value.trim();
        if (!code) {
            showMessage(messages.enter, 'error');
            return;
        }

        // Show loading state
        applyCouponBtn.disabled = true;
        applyCouponBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + messages.apply;

        // Send coupon validation request
        fetch(`/checkout/apply-coupon?code=${encodeURIComponent(code)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const discount = data.discount;
                    const newTotal = originalTotal - discount + shippingAmount;

                    // Update display
                    discountRow.style.display = 'flex';
                    discountAmount.textContent = `${discount.toFixed(2)} JOD`;
                    totalAmount.textContent = `${newTotal.toFixed(2)} JOD`;

                    showMessage(messages.success, 'success');
                } else {
                    showMessage(data.message || messages.invalid, 'error');
                }
            })
            .catch(error => {
                showMessage(messages.error, 'error');
            })
            .finally(() => {
                // Re-enable button
                applyCouponBtn.disabled = false;
                applyCouponBtn.textContent = messages.apply || '{{ __('checkout.apply_coupon') }}';
            });
    });

    function showMessage(message, type) {
        couponMessage.textContent = message;
        couponMessage.className = type;
        couponMessage.style.display = 'block';

        // Hide message after 3 seconds
        setTimeout(() => {
            couponMessage.style.display = 'none';
        }, 3000);
    }
});
</script>
@endsection
