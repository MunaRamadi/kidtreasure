<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\WorkshopRegistration;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Redirect to orders page instead of profile
        return redirect()->route('profile.orders');
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
    
    public function orders(Request $request)
    {
        $user = Auth::user();
        $query = $user->orders()->with('items');
        
        // Filter by order status
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Sort by latest orders by default
        $query->latest();
        
        // Paginate results and preserve query parameters
        $orders = $query->paginate(5)->withQueryString();
        
        return view('user.orders', compact('user', 'orders'));
    }
    
    public function tickets()
    {
        $user = Auth::user();
        $tickets = $user->supportTickets()->latest()->paginate(10);
        
        return view('user.tickets', compact('user', 'tickets'));
    }
    
    public function activities(Request $request)
    {
        $user = Auth::user();
        $query = $user->workshopRegistrations()->with('event.workshop');
        
        // Update status for past events to "Done" (STATUS_CONFIRMED)
        $pastRegistrations = $user->workshopRegistrations()
            ->whereHas('event', function($q) {
                $q->whereDate('event_date', '<', now());
            })
            ->where('status', WorkshopRegistration::STATUS_PENDING)
            ->get();
            
        foreach ($pastRegistrations as $registration) {
            $registration->status = WorkshopRegistration::STATUS_CONFIRMED;
            $registration->save();
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereHas('event', function($q) use ($request) {
                $q->whereDate('event_date', '>=', $request->date_from);
            });
        }
        
        if ($request->filled('date_to')) {
            $query->whereHas('event', function($q) use ($request) {
                $q->whereDate('event_date', '<=', $request->date_to);
            });
        }
        
        // Sort by latest registrations by default
        $query->latest();
        
        // Paginate results and preserve query parameters
        $registrations = $query->paginate(5)->withQueryString();
        
        // Get statuses for filter dropdown
        $statuses = WorkshopRegistration::getStatuses();
        
        return view('user.activities', compact('user', 'registrations', 'statuses'));
    }
    
    public function account()
    {
        $user = Auth::user();
        $defaultAddress = $user->addresses()->where('is_default', true)->first();
        return view('user.account', compact('user', 'defaultAddress'));
    }
    
    /**
     * Cancel a workshop registration
     * 
     * @param int $registration
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelRegistration($registration)
    {
        $user = Auth::user();
        $registration = $user->workshopRegistrations()->findOrFail($registration);
        
        // Only allow cancellation if the registration is not already canceled
        // and the event date is in the future
        if ($registration->status !== WorkshopRegistration::STATUS_CANCELED && $registration->event->event_date->isFuture()) {
            $registration->status = WorkshopRegistration::STATUS_CANCELED;
            $registration->save();
            
            return redirect()->route('profile.activities')
                ->with('success', __('Your registration has been successfully canceled.'));
        }
        
        return redirect()->route('profile.activities')
            ->with('error', __('Unable to cancel this registration. It may be already canceled or the event has already taken place.'));
    }
}