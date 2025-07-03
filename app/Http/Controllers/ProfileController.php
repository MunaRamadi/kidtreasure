<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's dashboard instead of profile form.
     */
    public function edit(Request $request): View
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

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
