<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderStatusChanged;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->paginate(10);
            
        return view('notifications.index', compact('notifications'));
    }
    
    /**
     * Mark a notification as read.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return back()->with('success', __('Notification marked as read'));
    }
    
    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function markAllAsRead(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', __('All notifications marked as read'));
    }
    
    /**
     * Delete a notification.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        
        return back()->with('success', __('Notification deleted'));
    }
    
    /**
     * Get unread notifications for the dropdown.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnreadNotifications()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->latest()->take(5)->get();
        $count = $user->unreadNotifications()->count();
        
        return response()->json([
            'notifications' => $notifications,
            'count' => $count
        ]);
    }
    
    /**
     * Test sending a notification (for development only).
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function testNotification()
    {
        $user = Auth::user();
        
        // Create a test order status notification
        $orderData = [
            'order_id' => 12345,
            'order_number' => 'ORD-' . rand(10000, 99999),
            'status' => 'shipped',
            'message' => 'Your order has been shipped and is on its way!',
            'url' => route('profile.orders')
        ];
        
        $user->notify(new OrderStatusChanged($orderData));
        
        return redirect()->route('notifications.index')
            ->with('success', 'Test notification sent successfully!');
    }
}
