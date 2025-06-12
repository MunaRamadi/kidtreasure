<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Make sure to import the User model

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // إحصائيات المستخدم
             $stats = [
            'orders' => $user->orders()->count(),
            'completed_orders' => $user->orders()->where('order_status', 'delivered')->count(),
            'pending_orders' => $user->orders()->where('order_status', 'pending')->count(),
            'stories' => $user->stories()->count(),
            'approved_stories' => $user->stories()->where('status', 'approved')->count(),
            'workshop_registrations' => $user->workshopRegistrations()->count(),
            'products' => 0, // أضف هذا إذا لم يكن لديك علاقة للمنتجات، أو استخدم العدد الفعلي
            'users' => User::count(), // هذا قد يكون لعرض المسؤول، فكر في إزالته إذا كانت لوحة تحكم مستخدمة فقط
            // 'messages' => $user->messages()->where('is_read', false)->count(), // مثال: رسائل غير مقروءة للمستخدم
            // أو إذا كانت الرسائل تشير إلى رسائل الاتصال التي أرسلها المستخدم:
            // 'messages' => $user->contactMessages()->count(),
        ];

        // آخر الطلبات
        $recentOrders = $user->orders()
            ->with('items.product')
            ->latest()
            ->limit(5)
            ->get();

        // آخر القصص المقدمة
        $recentStories = $user->stories()
            ->latest()
            ->limit(3)
            ->get();

        // التسجيلات في الورش القادمة
        $upcomingWorkshops = $user->workshopRegistrations()
            ->latest()
            ->limit(3)
            ->get();

        return view('user.dashboard', compact(
            'user', 
            'stats', 
            'recentOrders', 
            'recentStories', 
            'upcomingWorkshops'
        ));
    }
}