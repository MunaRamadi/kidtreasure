<div x-data="adminNotifications()" x-init="init()" class="relative">
    <a class="nav-link" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown">
        <i class="fas fa-bell fa-fw"></i>
        <span 
            x-show="unreadCount > 0"
            x-text="unreadCount"
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        </span>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-end shadow animated--grow-in" style="width: 320px;">
        <h6 class="dropdown-header bg-primary text-white">
            Notifications
        </h6>
        
        <div x-show="loading" class="text-center py-3">
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span class="ms-2">Loading notifications...</span>
        </div>
        
        <template x-if="!loading && notifications.length === 0">
            <div class="text-center py-5 text-gray-500">
                <i class="fas fa-bell-slash fa-lg mb-2"></i>
                <p>No new notifications</p>
            </div>
        </template>
        
        <template x-if="!loading && notifications.length > 0">
            <div>
                <template x-for="notification in notifications" :key="notification.id">
                    <a class="dropdown-item d-flex align-items-center" 
                       href="#" 
                       @click.prevent="markAsRead(notification.id, notification.data.url)">
                        <div class="me-3">
                            <div class="icon-circle" :class="{
                                'bg-primary': notification.data && notification.data.type === 'order',
                                'bg-info': notification.data && notification.data.type === 'contact_message',
                                'bg-success': notification.data && notification.data.type === 'story_request',
                                'bg-secondary': !notification.data || !notification.data.type
                            }">
                                <i class="fas" :class="{
                                    'fa-shopping-cart': notification.data && notification.data.type === 'order',
                                    'fa-envelope': notification.data && notification.data.type === 'contact_message',
                                    'fa-book': notification.data && notification.data.type === 'story_request',
                                    'fa-bell': !notification.data || !notification.data.type
                                }"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500" x-text="formatDate(notification.created_at)"></div>
                            <span x-text="notification.data && notification.data.message ? notification.data.message : 'New notification'"></span>
                        </div>
                    </a>
                </template>
                
                <div class="dropdown-item text-center">
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-sm btn-primary w-100">
                        View All Notifications
                    </a>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
    function adminNotifications() {
        return {
            notifications: [],
            unreadCount: 0,
            loading: true,
            
            init() {
                this.fetchNotifications();
                
                // Set up polling every 30 seconds
                setInterval(() => {
                    this.fetchNotifications();
                }, 30000);
            },
            
            fetchNotifications() {
                this.loading = true;
                
                fetch('{{ route('admin.notifications.unread') }}')
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
            
            markAllAsRead() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const formData = new FormData();
                formData.append('_token', csrfToken);
                
                fetch('{{ route('admin.notifications.mark-all-read') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    this.notifications = [];
                    this.unreadCount = 0;
                })
                .catch(error => {
                    console.error('Error marking notifications as read:', error);
                });
            },
            
            markAsRead(notificationId, url) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const formData = new FormData();
                formData.append('_token', csrfToken);
                
                fetch(`{{ route('admin.notifications.mark-read', '') }}/${notificationId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update the notifications list immediately
                    this.notifications = this.notifications.filter(notification => notification.id !== notificationId);
                    this.unreadCount = Math.max(0, this.unreadCount - 1);
                    
                    // Navigate to the notification URL after marking as read
                    if (url) {
                        window.location.href = url;
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                    // Still try to navigate even if marking as read fails
                    if (url) {
                        window.location.href = url;
                    }
                });
            },
            
            getNotificationTitle(notification) {
                if (!notification.data || !notification.data.type) {
                    return 'New Notification';
                }
                
                switch (notification.data.type) {
                    case 'order':
                        return 'New Order';
                    case 'contact_message':
                        return 'New Message';
                    case 'story_request':
                        return 'New Story Request';
                    default:
                        return 'New Notification';
                }
            },
            
            formatDate(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diffMs = now - date;
                const diffMins = Math.round(diffMs / 60000);
                const diffHours = Math.round(diffMs / 3600000);
                const diffDays = Math.round(diffMs / 86400000);
                
                if (diffMins < 60) {
                    return diffMins + ' min' + (diffMins !== 1 ? 's' : '') + ' ago';
                } else if (diffHours < 24) {
                    return diffHours + ' hour' + (diffHours !== 1 ? 's' : '') + ' ago';
                } else {
                    return diffDays + ' day' + (diffDays !== 1 ? 's' : '') + ' ago';
                }
            }
        };
    }
</script>

<style>
    .icon-circle {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .dropdown-item {
        white-space: normal;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e3e6f0;
    }
</style>
