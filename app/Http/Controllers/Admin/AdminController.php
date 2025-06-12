<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        // إحصائيات عامة
        $stats = [
            'products' => \App\Models\Product::count(),
            'orders' => \App\Models\Order::count(),
            'users' => \App\Models\User::count(),
            'messages' => \App\Models\ContactMessage::count(),
            'stories' => \App\Models\Story::count(),
            'workshops' => \App\Models\WorkshopEvent::count(),
            'blog_posts' => \App\Models\BlogPost::count(),
            'pending_stories' => \App\Models\Story::where('status', 'pending')->count(),
            'pending_orders' => \App\Models\Order::where('status', 'pending')->count(),
            'unread_messages' => \App\Models\ContactMessage::where('is_read', false)->count(),
        ];

        // بيانات المبيعات الأخيرة
        $recentOrders = \App\Models\Order::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // بيانات المنتجات الأكثر مبيعاً
        $topProducts = \App\Models\Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
}
