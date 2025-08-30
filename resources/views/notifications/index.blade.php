@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-600 text-white flex justify-between items-center">
                <h1 class="text-xl font-semibold" data-translate="notifications_title">Notifications</h1>
                
                @if($notifications->where('read_at', null)->count() > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-white text-indigo-600 px-3 py-1 rounded-md text-sm hover:bg-indigo-50 transition-colors duration-200" data-notification-action="mark-all-read">
                        {{ __('Mark all as read') }}
                    </button>
                </form>
                @endif
            </div>
            
            <div class="divide-y divide-gray-200">
                @forelse($notifications as $notification)
                    <div class="notification-item {{ $notification->read_at ? 'bg-white' : 'bg-gray-50 unread' }} hover:bg-gray-100 transition-colors duration-200" data-notification-id="{{ $notification->id }}">
                        <div class="p-4 md:p-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mr-4">
                                    @if(isset($notification->data['status']))
                                        @if($notification->data['status'] === 'shipped')
                                            <div class="bg-indigo-100 rounded-full p-2">
                                                <i class="fa-solid fa-truck text-indigo-500"></i>
                                            </div>
                                        @elseif($notification->data['status'] === 'delivered')
                                            <div class="bg-green-100 rounded-full p-2">
                                                <i class="fa-solid fa-check text-green-500"></i>
                                            </div>
                                        @elseif($notification->data['status'] === 'processing')
                                            <div class="bg-orange-100 rounded-full p-2">
                                                <i class="fa-solid fa-spinner text-orange-500"></i>
                                            </div>
                                        @else
                                            <div class="bg-blue-100 rounded-full p-2">
                                                <i class="fa-solid fa-bell text-blue-500"></i>
                                            </div>
                                        @endif
                                    @else
                                        <div class="bg-blue-100 rounded-full p-2">
                                            <i class="fa-solid fa-bell text-blue-500"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">
                                                @if(isset($notification->data['order_number']))
                                                    Order {{ $notification->data['order_number'] }}
                                                @else
                                                    {{ __('Notification') }}
                                                @endif
                                            </h3>
                                            <p class="mt-1 text-sm text-gray-600">{{ $notification->data['message'] ?? '' }}</p>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    <div class="mt-4 flex items-center justify-between">
                                        @if(isset($notification->data['url']))
                                            <a href="{{ $notification->data['url'] }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                                                {{ __('View Details') }} <i class="fa-solid fa-arrow-right ml-1"></i>
                                            </a>
                                        @else
                                            <span></span>
                                        @endif
                                        
                                        <div class="flex space-x-2">
                                            @if(!$notification->read_at)
                                                <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-800" data-notification-action="mark-read" data-notification-id="{{ $notification->id }}">
                                                        {{ __('Mark as read') }}
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-800" data-notification-action="delete" data-notification-id="{{ $notification->id }}">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="text-gray-400 mb-4">
                            <i class="fa-regular fa-bell-slash text-5xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">{{ __('No notifications') }}</h3>
                        <p class="text-gray-500">{{ __('You don\'t have any notifications at the moment.') }}</p>
                    </div>
                @endforelse
            </div>
            
            @if($notifications->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
