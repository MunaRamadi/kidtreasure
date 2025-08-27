@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-[#9232E9] text-center">{{ __('My Orders') }}</h1>
    
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar Filters -->
        <div class="w-full md:w-1/4">
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('Filter Orders') }}</h3>
                <form action="{{ route('profile.orders') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Status') }}</label>
                            <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">{{ __('All Statuses') }}</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>{{ __('Canceled') }}</option>
                                <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>{{ __('Refunded') }}</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">{{ __('From Date') }}</label>
                            <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="mt-1 block w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">{{ __('To Date') }}</label>
                            <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="mt-1 block w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                    </div>
                    
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#9232E9] hover:bg-[#7E22CE] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#9232E9]">
                            {{ __('Filter') }}
                        </button>
                        <a href="{{ route('profile.orders') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#9232E9]">
                            {{ __('Reset') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Content -->
        <div class="w-full md:w-3/4">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <!-- Orders List -->
                @if($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Order ID') }}
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Date') }}
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Total') }}
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Status') }}
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Payment') }}
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            #{{ $order->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($order->total_amount_jod, 2) }} 
                                            @if(app()->getLocale() == 'ar')
                                                {{ __('دينار') }}
                                            @else
                                                {{ __('JOD') }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($order->order_status)
                                                @case('pending')
                                                @case('processing')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        @if(app()->getLocale() == 'ar')
                                                            {{ __('قيد الانتظار') }}
                                                        @else
                                                            {{ __('Pending') }}
                                                        @endif
                                                    </span>
                                                    @break
                                                @case('completed')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        @if(app()->getLocale() == 'ar')
                                                            {{ __('تم') }}
                                                        @else
                                                            {{ __('Completed') }}
                                                        @endif
                                                    </span>
                                                    @break
                                                @case('canceled')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        @if(app()->getLocale() == 'ar')
                                                            {{ __('ملغي') }}
                                                        @else
                                                            {{ __('Canceled') }}
                                                        @endif
                                                    </span>
                                                    @break
                                                @case('refunded')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        @if(app()->getLocale() == 'ar')
                                                            {{ __('مسترجع') }}
                                                        @else
                                                            {{ __('Refunded') }}
                                                        @endif
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ $order->order_status }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($order->payment_status)
                                                @case('pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        @if(app()->getLocale() == 'ar')
                                                            {{ __('قيد الانتظار') }}
                                                        @else
                                                            {{ __('Pending') }}
                                                        @endif
                                                    </span>
                                                    @break
                                                @case('completed')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        @if(app()->getLocale() == 'ar')
                                                            {{ __('تم') }}
                                                        @else
                                                            {{ __('Completed') }}
                                                        @endif
                                                    </span>
                                                    @break
                                                @case('canceled')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        @if(app()->getLocale() == 'ar')
                                                            {{ __('ملغي') }}
                                                        @else
                                                            {{ __('Canceled') }}
                                                        @endif
                                                    </span>
                                                    @break
                                                @case('refunded')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        @if(app()->getLocale() == 'ar')
                                                            {{ __('مسترجع') }}
                                                        @else
                                                            {{ __('Refunded') }}
                                                        @endif
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ $order->payment_status }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button type="button" class="text-[#9232E9] hover:text-[#7E22CE] view-order" data-order-id="{{ $order->id }}">
                                                {{ __('View Details') }}
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Order Details Row (Hidden by default) -->
                                    <tr class="order-details-{{ $order->id }} hidden bg-gray-50">
                                        <td colspan="6" class="px-6 py-4">
                                            <div class="border rounded-lg p-4 bg-white">
                                                <h3 class="font-semibold text-lg mb-2">{{ __('Order Items') }}</h3>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    @foreach($order->items as $item)
                                                        <div class="flex items-center p-3 border rounded-md">
                                                            <div class="flex-shrink-0 h-16 w-16">
                                                                @if($item->product && $item->product->image)
                                                                    <img class="h-16 w-16 object-cover rounded-md" src="{{ asset($item->product->image) }}" alt="{{ $item->product_name }}">
                                                                @else
                                                                    <div class="h-16 w-16 bg-gray-200 rounded-md flex items-center justify-center">
                                                                        <span class="text-gray-500">{{ __('No Image') }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $item->product_name }}
                                                                </div>
                                                                <div class="text-sm text-gray-500">
                                                                    {{ __('Quantity') }}: {{ $item->quantity }}
                                                                </div>
                                                                <div class="text-sm text-gray-500">
                                                                    {{ __('Price') }}: {{ number_format($item->unit_price_jod, 2) }} 
                                                                    @if(app()->getLocale() == 'ar')
                                                                        {{ __('دينار') }}
                                                                    @else
                                                                        {{ __('JOD') }}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                                @if($order->shipping_address)
                                                    <div class="mt-4">
                                                        <h3 class="font-semibold text-lg mb-2">{{ __('Shipping Information') }}</h3>
                                                        <div class="bg-gray-50 p-3 rounded-md">
                                                            <p class="text-sm text-gray-700">
                                                                @if(is_array($order->shipping_address))
                                                                    {{ "Name: ".($order->shipping_address['first_name'] ?? '') }} {{ $order->shipping_address['last_name'] ?? '' }}<br>
                                                                    {{ "Address: ".($order->shipping_address['address'] ?? '') }}<br>
                                                                    {{ "City: ".($order->shipping_address['city'] ?? '') }}
                                                                    @if(isset($order->shipping_address['state']))
                                                                    , {{ "State: ".$order->shipping_address['state'] }}
                                                                    @endif
                                                                    @if(isset($order->shipping_address['zip']))
                                                                    {{ "Zip: ".$order->shipping_address['zip'] }}
                                                                    @endif
                                                                    <br>
                                                                    {{ $order->shipping_address['country'] ?? '' }}
                                                                @else
                                                                    {{ $order->shipping_address }}
                                                                @endif
                                                            </p>
                                                            @if($order->shipping_carrier)
                                                                <p class="text-sm text-gray-700 mt-1">
                                                                    <span class="font-medium">{{ __('Carrier') }}:</span> {{ $order->shipping_carrier }}
                                                                </p>
                                                            @endif
                                                            @if($order->tracking_number)
                                                                <p class="text-sm text-gray-700 mt-1">
                                                                    <span class="font-medium">{{ __('Tracking') }}:</span> {{ $order->tracking_number }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="bg-gray-50 p-6 text-center rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('No orders found') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('You have not placed any orders yet.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle order details visibility
        const viewOrderButtons = document.querySelectorAll('.view-order');
        viewOrderButtons.forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                const detailsRow = document.querySelector(`.order-details-${orderId}`);
                
                if (detailsRow.classList.contains('hidden')) {
                    detailsRow.classList.remove('hidden');
                    this.textContent = '{{ __("Hide Details") }}';
                } else {
                    detailsRow.classList.add('hidden');
                    this.textContent = '{{ __("View Details") }}';
                }
            });
        });
    });
</script>
@endpush
@endsection
