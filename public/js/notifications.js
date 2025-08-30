/**
 * Notifications and Toast System
 */
document.addEventListener('DOMContentLoaded', function() {
    // Listen for toast events
    window.addEventListener('toast', function(event) {
        if (typeof window.showToast === 'function') {
            window.showToast(event.detail.type, event.detail.message);
        } else {
            console.error('Toast function not available');
        }
    });

    // Helper function to show toast from anywhere in the application
    window.showNotification = function(type, message) {
        window.dispatchEvent(new CustomEvent('toast', {
            detail: {
                type: type,
                message: message
            }
        }));
    };

    // Add click handlers for notification actions
    document.querySelectorAll('[data-notification-action="mark-read"]').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            const notificationId = this.getAttribute('data-notification-id');
            markNotificationAsRead(notificationId);
        });
    });

    document.querySelectorAll('[data-notification-action="mark-all-read"]').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            markAllNotificationsAsRead();
        });
    });

    document.querySelectorAll('[data-notification-action="delete"]').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            const notificationId = this.getAttribute('data-notification-id');
            deleteNotification(notificationId);
        });
    });
});

/**
 * Mark a notification as read
 * @param {string} id - Notification ID
 */
function markNotificationAsRead(id) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData = new FormData();
    formData.append('_token', csrfToken);

    fetch(`/notifications/${id}/mark-read`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        window.showNotification('success', 'Notification marked as read');
        
        // Update UI if needed
        const notificationElement = document.querySelector(`[data-notification-id="${id}"]`);
        if (notificationElement) {
            notificationElement.classList.remove('bg-gray-50');
            notificationElement.classList.add('bg-white');
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
        window.showNotification('error', 'Failed to mark notification as read');
    });
}

/**
 * Mark all notifications as read
 */
function markAllNotificationsAsRead() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData = new FormData();
    formData.append('_token', csrfToken);

    fetch('/notifications/mark-all-read', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        window.showNotification('success', 'All notifications marked as read');
        
        // Update UI if needed
        document.querySelectorAll('.notification-item.unread').forEach(function(element) {
            element.classList.remove('bg-gray-50', 'unread');
            element.classList.add('bg-white');
        });
    })
    .catch(error => {
        console.error('Error marking all notifications as read:', error);
        window.showNotification('error', 'Failed to mark all notifications as read');
    });
}

/**
 * Delete a notification
 * @param {string} id - Notification ID
 */
function deleteNotification(id) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData = new FormData();
    formData.append('_token', csrfToken);
    formData.append('_method', 'DELETE');

    fetch(`/notifications/${id}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        window.showNotification('success', 'Notification deleted');
        
        // Remove notification from UI
        const notificationElement = document.querySelector(`[data-notification-id="${id}"]`);
        if (notificationElement) {
            notificationElement.remove();
        }
    })
    .catch(error => {
        console.error('Error deleting notification:', error);
        window.showNotification('error', 'Failed to delete notification');
    });
}
