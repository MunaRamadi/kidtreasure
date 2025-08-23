@extends('layouts.app')

@section('title', 'سلة التسوق')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6">Shopping Cart ({{ $cart->total_items }} {{ $cart->total_items == 1 ? 'Product' : 'Products' }})</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Cart Items Section -->
        <div class="lg:w-2/3 bg-white rounded-lg shadow p-6">
            @if($cart->items->count() > 0)
            @foreach($cart->items as $item)
            <div class="flex items-center border-b pb-4 mb-4" id="cart-item-{{ $item->id }}">
                    <div class="w-24 h-24 flex-shrink-0">
                        @if($item->current_product_image)
                            <img src="{{ $item->current_product_image }}" alt="{{ $item->current_product_name }}" class="w-20 h-20 rounded-lg object-cover">
                        @else
                            <div class="bg-indigo-500 w-20 h-20 rounded-lg flex items-center justify-center">
                                <span class="text-white font-semibold">{{ substr($item->current_product_name, 0, 2) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-bold">{{ $item->current_product_name }}</h3>
                        @if($item->product)
                            <p class="text-gray-600">{{ $item->product->sku ?? '' }}</p>
                        @endif
                    </div>
                    <div class="flex items-center">
                        <span class="font-bold mr-2" id="item-subtotal-{{ $item->id }}">{{ number_format($item->price, 2) }} JOD</span>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 ml-2 p-1 rounded-full">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                    <div class="flex items-center justify-end mt-4 mb-6">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                            <button type="submit" class="border rounded-lg px-3 py-1 mr-2">-</button>
                        </form>
                        <span class="mx-3 w-8 text-center">{{ $item->quantity }}</span>
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                            <button type="submit" class="border rounded-lg px-3 py-1 ml-2">+</button>
                        </form>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-8">
                    <p class="text-xl mb-4">Your cart is empty</p>
                    <a href="{{ route('products.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">Continue Shopping</a>
                </div>
            @endif
        </div>
        
        <!-- Order Summary Section -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-lg shadow p-6 mb-4">
                <h2 class="text-xl font-bold mb-4">Shopping Cart</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span>Total</span>
                        <span class="font-bold">{{ number_format($cart->total_price, 2) }} JOD</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span>Quantity</span>
                        <span>{{ $cart->total_items }}</span>
                    </div>
                    
                    @if($cart->items->count() > 0)
                    <div class="flex justify-between">
                        <span>Unit Price</span>
                        <span>{{ number_format($cart->items->first()->price, 2) }} JOD</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between border-t pt-2">
                        <span>Subtotal</span>
                        <span class="font-bold">{{ number_format($cart->total_price, 2) }} JOD</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6 mb-4">
                <div class="flex justify-between mb-4">
                    <span class="font-bold">Total</span>
                    <span class="font-bold">{{ number_format($cart->total_price, 2) }} JOD</span>
                </div>
                
                <form action="{{ route('cart.apply_coupon') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="promo_code" placeholder="cart promo" class="w-full border rounded-lg px-4 py-2">
                    </div>
                    
                    <button type="submit" class="w-full bg-gray-800 text-white rounded-lg py-2 mb-4">
                        Apply
                    </button>
                </form>
                
                @if($cart->items->count() > 0)
                <a href="{{ route('checkout.index') }}" class="block w-full bg-indigo-600 text-white rounded-lg py-3 mb-4 text-center">
                    Proceed to Checkout
                </a>
                
                <form action="{{ route('cart.clear') }}" method="POST" class="mb-4">
                    @csrf
                    <button type="submit" class="block w-full bg-red-600 text-white rounded-lg py-3 text-center">
                        Clear Cart
                    </button>
                </form>
                
                <div class="flex justify-center space-x-2">
                    <div class="bg-blue-900 text-white rounded px-3 py-1">VISA</div>
                    <div class="bg-red-600 text-white rounded px-3 py-1">MC</div>
                    <div class="bg-blue-500 text-white rounded px-3 py-1">PP</div>
                    <div class="bg-gray-800 text-white rounded px-3 py-1">PAY</div>
                    <div class="bg-blue-400 text-white rounded px-3 py-1">OP</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection