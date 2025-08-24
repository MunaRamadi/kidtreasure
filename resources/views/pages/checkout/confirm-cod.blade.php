@extends('layouts.checkout')

@section('title', 'Confirm Order')

@section('content')
<div class="container mx-auto px-4 max-w-6xl mt-10">
    <h1 class="text-3xl font-bold text-center mb-4">Confirm Your Order</h1>
    <p class="text-center text-gray-600 mb-8">Please review your order details before confirming</p>
    
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
            <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <span class="ml-2 text-green-500 font-medium">Payment</span>
        </div>
        <div class="h-1 w-16 bg-green-500 mx-4"></div>
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white">
                <span class="font-medium">3</span>
            </div>
            <span class="ml-2 text-blue-500 font-medium">Confirmation</span>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <div class="flex items-center justify-center mb-6">
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold">Cash on Delivery</h2>
                <p class="text-gray-600">You will pay when your order arrives</p>
            </div>
        </div>
        
        <div class="border-t border-b py-6 my-6">
        <div class="mb-6">
            <h3 class="text-lg font-bold mb-4">Shipping Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p><span class="font-medium">Name:</span> {{ $order->customer_name }}</p>
                    <p><span class="font-medium">Email:</span> {{ $order->customer_email }}</p>
                    <p><span class="font-medium">Phone:</span> {{ $order->customer_phone }}</p>
                </div>
                <div>
                    <p><span class="font-medium">Address:</span> {{ $order->shipping_address['address'] }}</p>
                    <p><span class="font-medium">City:</span> {{ $order->shipping_address['city'] }}</p>
                    @if(!empty($order->shipping_address['postal_code']))
                        <p><span class="font-medium">Postal Code:</span> {{ $order->shipping_address['postal_code'] }}</p>
                    @endif
                </div>
            </div>
        </div>
            <h3 class="text-lg font-bold mb-4">Order Summary</h3>
            
            @foreach($order->items as $item)
            <div class="flex items-center mb-4">
                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden mr-4">
                    @if($item->product_image)
                        <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                    @else
                        <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                            <span class="text-gray-500">{{ substr($item->product_name, 0, 2) }}</span>
                        </div>
                    @endif
                </div>
                <div class="flex-grow">
                    <h4 class="font-medium">{{ $item->product_name }}</h4>
                    <p class="text-gray-500 text-sm">Quantity: {{ $item->quantity }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold">${{ number_format($item->unit_price_jod, 2) }}</p>
                    <p class="text-sm text-gray-500">Subtotal: ${{ number_format($item->subtotal_jod, 2) }}</p>
                </div>
            </div>
            @endforeach
            
            <div class="mt-6 pt-4 border-t">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Subtotal:</span>
                    <span>${{ number_format($order->total_amount_jod - $order->shipping_cost, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Shipping ({{ ucfirst($order->shipping_method) }}):</span>
                    <span>${{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="flex justify-between mb-2 text-green-600">
                    <span>Discount:</span>
                    <span>-${{ number_format($order->discount_amount, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between font-bold text-lg mt-4 pt-4 border-t">
                    <span>Total:</span>
                    <span class="text-blue-500">${{ number_format($order->total_amount_jod, 2) }}</span>
                </div>
            </div>
        </div>
        
    
        
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h4 class="font-bold text-yellow-800">Important Information</h4>
                    <p class="text-yellow-800">By confirming this order, you agree to pay the full amount in cash when your order is delivered. Please ensure someone is available to receive the package and make the payment.</p>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col md:flex-row gap-4 justify-center">
            <a href="{{ route('checkout.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 px-8 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                <span>Change Payment Method</span>
            </a>
            <form action="{{ route('checkout.process-cod', ['order' => $order->id]) }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-3 px-8 rounded-lg flex items-center justify-center">
                    <span class="mr-2">Confirm Order</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </form>
            
           
        </div>
    </div>
</div>
@endsection
