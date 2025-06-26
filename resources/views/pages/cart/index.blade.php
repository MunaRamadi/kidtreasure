@extends('layouts.app')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .cart-container { max-width: 1000px; margin: 0 auto; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden; }
    .cart-header { background: white; padding: 20px 30px; border-bottom: 2px solid #f0f0f0; }
    .cart-header h2 { font-size: 24px; color: #333; font-weight: 600; }
    .cart-content { display: flex; min-height: 500px; }
    .cart-items { flex: 1; padding: 30px; background: #fafafa; }
    .cart-item { display: flex; align-items: center; padding: 20px; margin-bottom: 20px; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: transform 0.2s ease; }
    .cart-item:hover { transform: translateY(-2px); box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
    .item-image { width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px; text-align: center; margin-left: 20px; margin-right: 16px; }
    .item-details { flex: 1; }
    .item-name { font-size: 18px; font-weight: 600; color: #333; margin-bottom: 5px; }
    .item-specs { color: #666; font-size: 14px; margin-bottom: 15px; }
    .quantity-control { display: flex; align-items: center; gap: 10px; }
    .qty-btn { width: 35px; height: 35px; border: 2px solid #e0e0e0; background: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 18px; font-weight: bold; color: #666; transition: all 0.2s ease; }
    .qty-btn:hover { border-color: #4f46e5; color: #4f46e5; background: #f8faff; }
    .qty-input { width: 50px; height: 35px; text-align: center; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; font-weight: 600; }
    .item-price { font-size: 20px; font-weight: bold; color: #333; margin: 0 20px; }
    .remove-btn { width: 30px; height: 30px; border: none; background: #fee2e2; color: #dc2626; border-radius: 50%; cursor: pointer; font-size: 16px; transition: all 0.2s ease; }
    .remove-btn:hover { background: #fecaca; transform: scale(1.1); }
    .order-summary { width: 350px; background: white; padding: 30px; border-right: 2px solid #f0f0f0; }
    .summary-header { font-size: 20px; font-weight: 600; color: #333; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0; }
    .summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; font-size: 16px; }
    .summary-label { color: #666; }
    .summary-value { font-weight: 600; color: #333; }
    .free-shipping { color: #059669; font-weight: 600; }
    .total-row { margin-top: 20px; padding-top: 20px; border-top: 2px solid #f0f0f0; font-size: 18px; font-weight: bold; }
    .promo-section { margin: 25px 0; }
    .promo-input { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; margin-bottom: 10px; }
    .promo-input:focus { outline: none; border-color: #4f46e5; }
    .apply-btn { width: 100%; padding: 10px; background: #374151; color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s ease; }
    .apply-btn:hover { background: #1f2937; }
    .checkout-btn { width: 100%; padding: 15px; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 12px; font-size: 22px; font-weight: 700; cursor: pointer; margin: 24px auto 0 auto; transition: all 0.2s ease; display: block; text-align: center; box-shadow: 0 2px 8px rgba(79,70,229,0.10); letter-spacing: 0.5px; }
    .checkout-btn:hover { background: linear-gradient(90deg, #5a67d8 0%, #6c47a2 100%); transform: translateY(-2px); box-shadow: 0 4px 20px rgba(79, 70, 229, 0.18); }
    .payment-methods { display: flex; gap: 8px; margin-top: 15px; justify-content: center; }
    .payment-icon { width: 40px; height: 25px; background: #f3f4f6; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #666; font-weight: bold; }
    .visa { background: #1a1f71; color: white; }
    .mastercard { background: #eb001b; color: white; }
    .paypal { background: #0070ba; color: white; }
    .apple { background: #000; color: white; }
    .google { background: #4285f4; color: white; }
    @media (max-width: 768px) { .cart-content { flex-direction: column; } .order-summary { width: 100%; border-right: none; border-top: 2px solid #f0f0f0; } .cart-item { flex-direction: column; text-align: center; } .item-image { margin: 0 0 15px 0; } }
</style>
<div class="cart-container">
    <div class="cart-header">
        <h2>{{ __('cart.cart') }} ({{ isset($cart) ? $cart->items->count() : 0 }} {{ __('cart.product') }})</h2>
    </div>
    <div class="cart-content">
        <div class="cart-items">
            @if(isset($cart) && $cart->items->count() > 0)
                @foreach($cart->items as $item)
                <div class="cart-item">
                    <div class="item-image">
                        @if($item->product->image_path)
                            <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:12px;">
                        @else
                            {{ app()->getLocale() == 'ar' ? ($item->product->name ?? '') : ($item->product->name_en ?? $item->product->name) }}
                        @endif
                    </div>
                    <div class="item-details">
                        <div class="item-name">{{ app()->getLocale() == 'ar' ? ($item->product->name ?? '') : ($item->product->name_en ?? $item->product->name) }}</div>
                        <div class="item-specs">{{ $item->product->description ? Str::limit(strip_tags($item->product->description), 40) : '' }}</div>
                        <div class="quantity-control">
                            <form action="{{ route('cart.update', $item->product_id) }}" method="POST" style="display:inline-flex;align-items:center;gap:10px;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="qty-btn" @if($item->quantity <= 1) disabled style="opacity:0.5;cursor:not-allowed;" @endif>−</button>
                                <input type="number" name="quantity" class="qty-input" value="{{ $item->quantity }}" min="1" onchange="this.form.submit()">
                                <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="qty-btn">+</button>
                            </form>
                        </div>
                    </div>
                    <div class="item-price">{{ number_format($item->price, 2) }} JOD</div>
                    <form action="{{ route('cart.remove', $item->product_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="remove-btn">🗑</button>
                    </form>
                </div>
                @endforeach
            @else
                <div style="text-align:center;color:#888;font-size:18px;padding:40px 0;">{{ __('cart.empty') }}</div>
            @endif
        </div>
        <div class="order-summary">
            <div class="summary-header">{{ __('cart.cart') }}</div>
            <div class="summary-row">
                <span class="summary-label">{{ __('cart.total') }}</span>
                <span class="summary-value">{{ isset($cart) ? number_format($cart->total_price, 2) : '0.00' }} JOD</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">{{ __('cart.quantity') }}</span>
                <span class="summary-value">{{ isset($cart) ? $cart->items->sum('quantity') : 0 }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">{{ __('cart.unit_price') }}</span>
                <span class="summary-value">{{ isset($cart) && $cart->items->count() > 0 ? number_format($cart->items->sum(function($i){return $i->price;})/$cart->items->count(), 2) : '0.00' }} JOD</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">{{ __('cart.subtotal') }}</span>
                <span class="summary-value">{{ isset($cart) ? number_format($cart->total_price, 2) : '0.00' }} JOD</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">{{ __('cart.proceed') }}</span>
                @if(isset($cart) && $cart->items->count() > 0)
                    <span class="free-shipping" style="color: #28a745;">{{ __('cart.proceed') }}</span>
                @else
                    <span class="free-shipping" style="color: #888;">{{ __('cart.empty') }}</span>
                @endif
            </div>
            <div class="summary-row total-row">
                <span class="summary-label">{{ __('cart.total') }}</span>
                <span class="summary-value">{{ isset($cart) ? number_format($cart->total_price, 2) : '0.00' }} JOD</span>
            </div>
            <div class="promo-section">
                <input type="text" class="promo-input" placeholder="{{ __('cart.promo') ?? 'Promo code' }}">
                <button class="apply-btn" type="button">{{ __('cart.apply') ?? 'Apply' }}</button>
            </div>
            <a href="{{ route('checkout.index') }}" class="checkout-btn">{{ __('cart.proceed') }}</a>
            <div class="payment-methods">
                <div class="payment-icon visa">VISA</div>
                <div class="payment-icon mastercard">MC</div>
                <div class="payment-icon paypal">PP</div>
                <div class="payment-icon apple">PAY</div>
                <div class="payment-icon google">GP</div>
            </div>
        </div>
    </div>
</div>
@endsection
