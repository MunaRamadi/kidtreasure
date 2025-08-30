<div class="relative mx-2" 
    x-data="{
        openNotifications: false,
        notifications: [],
        unreadCount: 0,
        loading: false,
        
        init() {
            this.fetchNotifications();
            
            // Refresh notifications every 30 seconds
            setInterval(() => {
                this.fetchNotifications();
            }, 30000);
        },
        
        fetchNotifications() {
            this.loading = true;
            fetch('{{ route('notifications.unread') }}')
                .then(response => response.json())
                .then(data => {
                    this.notifications = data.notifications;
                    this.unreadCount = data.count;
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Error fetching notifications:', error);
                    this.loading = false;
                });
        },
        
        markAsRead(id) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            
            fetch(`/notifications/${id}/mark-read`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                this.fetchNotifications();
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: {
                        type: 'success',
                        message: 'Notification marked as read'
                    }
                }));
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
            });
        },
        
        markAllAsRead() {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            
            fetch('{{ route('notifications.mark-all-read') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.fetchNotifications();
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: {
                        type: 'success',
                        message: 'All notifications marked as read'
                    }
                }));
            })
            .catch(error => {
                console.error('Error marking all notifications as read:', error);
            });
        }
    }"
>
    <button 
        @click="openNotifications = !openNotifications" 
        @click.away="openNotifications = false" 
        class="flex items-center justify-center text-purple-600 px-3 py-2 rounded-lg font-medium hover:text-purple-700 transition-colors duration-300 text-sm relative"
    >
        <i class="fa-solid fa-bell"></i>
        <span 
            x-show="unreadCount > 0"
            x-text="unreadCount > 99 ? '99+' : unreadCount"
            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
        ></span>
    </button>
    
    <div 
        x-show="openNotifications" 
        x-transition:enter="transition ease-out duration-200" 
        x-transition:enter-start="opacity-0 scale-95" 
        x-transition:enter-end="opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-150" 
        x-transition:leave-start="opacity-100 scale-100" 
        x-transition:leave-end="opacity-0 scale-95" 
        class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-1 z-50"
        style="display: none;"
    >
        <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-medium text-gray-800" data-translate="notifications_title">Notifications</h3>
            <button 
                x-show="unreadCount > 0"
                @click="markAllAsRead()"
                class="text-xs text-indigo-600 hover:text-indigo-800"
            >
                Mark all as read
            </button>
        </div>
        
        <div class="max-h-64 overflow-y-auto">
            <template x-if="loading">
                <div class="flex justify-center items-center py-4">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-500"></div>
                </div>
            </template>
            
            <template x-if="!loading && notifications.length === 0">
                <div class="px-4 py-6 text-center text-gray-500">
                    <i class="fa-regular fa-bell-slash text-2xl mb-2"></i>
                    <p>No new notifications</p>
                </div>
            </template>
            
            <template x-for="notification in notifications" :key="notification.id">
                <a 
                    :href="notification.data.url || '{{ route('notifications.index') }}'"
                    @click.prevent="markAsRead(notification.id); window.location.href = notification.data.url || '{{ route('notifications.index') }}'"
                    class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100"
                >
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-full p-1">
                            <template x-if="notification.data.status === 'shipped'">
                                <i class="fa-solid fa-truck text-indigo-500 text-sm"></i>
                            </template>
                            <template x-if="notification.data.status === 'delivered'">
                                <i class="fa-solid fa-check text-green-500 text-sm"></i>
                            </template>
                            <template x-if="notification.data.status === 'processing'">
                                <i class="fa-solid fa-spinner text-orange-500 text-sm"></i>
                            </template>
                            <template x-if="!notification.data.status">
                                <i class="fa-solid fa-bell text-indigo-500 text-sm"></i>
                            </template>
                        </div>
                        <div class="ml-3 w-0 flex-1">
                            <p class="text-sm font-medium text-gray-800" x-text="notification.data.order_number ? 'Order ' + notification.data.order_number : 'Notification'"></p>
                            <p class="text-xs text-gray-500" x-text="notification.data.message"></p>
                            <p class="text-xs text-gray-400 mt-1" x-text="new Date(notification.created_at).toLocaleString()"></p>
                        </div>
                    </div>
                </a>
            </template>
        </div>
        
        <div class="px-4 py-2 border-t border-gray-100 text-center">
            <a href="{{ route('notifications.index') }}" class="text-sm mx-2 text-indigo-600 hover:text-indigo-800 font-medium" data-translate="view_all_notifications">
                View all notifications
            </a>
        </div>
    </div>
</div>
