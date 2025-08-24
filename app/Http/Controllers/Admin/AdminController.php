<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\ContactMessage;
use App\Models\Story;
use App\Models\WorkshopEvent;
use App\Models\BlogPost;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        // إحصائيات عامة
        $stats = [
            'products' => Product::count(),
            'orders' => Order::count(),
            'users' => User::count(),
            'messages' => ContactMessage::count(),
            'stories' => Story::count(),
            'workshops' => WorkshopEvent::count(),
            'blog_posts' => BlogPost::count(),
            'pending_stories' => Story::where('status', 'pending')->count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        // بيانات المبيعات الأخيرة
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // بيانات المنتجات الأكثر مبيعاً
        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
}