/**
 * Admin Notifications JavaScript
 * Handles real-time notification updates for admin users
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check if Alpine.js is available
    if (typeof Alpine === 'undefined') {
        console.error('Alpine.js is required for admin notifications');
        return;
    }
    
    // Register the adminNotifications component if not already defined
    if (!window.adminNotifications) {
        window.adminNotifications = function() {
            return {
                notifications: [],
                unreadCount: 0,
                loading: true,
                openNotifications: false,
                
                init() {
                    this.fetchNotifications();
                    
                    // Set up polling every 30 seconds
                    setInterval(() => {
                        this.fetchNotifications();
                    }, 30000);
                },
                
                fetchNotifications() {
                    this.loading = true;
                    
                    fetch('/admin/notifications/unread')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
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
                    
                    fetch('/admin/notifications/mark-all-read', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        this.notifications = [];
                        this.unreadCount = 0;
                        this.openNotifications = false;
                    })
                    .catch(error => {
                        console.error('Error marking notifications as read:', error);
                    });
                },
                
                markAsRead(notificationId) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const formData = new FormData();
                    formData.append('_token', csrfToken);
                    
                    fetch(`/admin/notifications/${notificationId}/mark-read`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Remove the notification from the list
                        this.notifications = this.notifications.filter(notification => notification.id !== notificationId);
                        this.unreadCount = Math.max(0, this.unreadCount - 1);
                    })
                    .catch(error => {
                        console.error('Error marking notification as read:', error);
                    });
                },
                
                getNotificationTitle(notification) {
                    // Check if notification.data exists and has a type property
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
        };
    }
});
