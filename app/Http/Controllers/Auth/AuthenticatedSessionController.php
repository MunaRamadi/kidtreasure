<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        // Check if there's a redirect parameter for checkout
        if ($request->has('redirect') && $request->redirect === 'checkout') {
            session(['redirect_to_checkout' => true]);
        }
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Add welcome message with user's name
        $request->session()->flash('welcome', auth()->user()->name);

        // التحقق من كون المستخدم admin وتوجيهه للوحة الإدارة
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // Check if user should be redirected to checkout
        if (session('redirect_to_checkout')) {
            session()->forget('redirect_to_checkout');
            return redirect()->route('checkout.index');
        }

        // توجيه المستخدمين العاديين للصفحة المقصودة أو الرئيسية
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}