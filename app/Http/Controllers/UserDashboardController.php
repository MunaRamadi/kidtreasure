<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Make sure to import the User model

class UserDashboardController extends Controller
{
    public function index()
    {
        // Redirect to profile as the main page
        return $this->profile();
    }
    
    public function profile()
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
    
    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->paginate(10);
        
        return view('user.orders', compact('user', 'orders'));
    }
    
    public function tickets()
    {
        $user = Auth::user();
        $tickets = $user->supportTickets()->latest()->paginate(10);
        
        return view('user.tickets', compact('user', 'tickets'));
    }
}