<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserSecurityController extends Controller
{
    /**
     * Display the user security page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get login history (this would need to be implemented with a proper login history tracking system)
        $loginHistory = $user->loginHistory()->latest()->take(10)->get() ?? collect();
        
        // Get connected devices (this would need to be implemented with a proper device tracking system)
        $connectedDevices = $user->devices()->latest()->get() ?? collect();
        
        return view('user.security', compact('user', 'loginHistory', 'connectedDevices'));
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.security')->with('success', 'تم تحديث كلمة المرور بنجاح');
    }

    /**
     * Enable two-factor authentication for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enableTwoFactor(Request $request)
    {
        $user = Auth::user();
        
        // Generate 2FA secret and QR code (this would need to be implemented with a proper 2FA library)
        // For example, using Laravel Fortify or a package like pragmarx/google2fa
        
        // For demonstration purposes:
        $user->update([
            'two_factor_enabled' => true,
            'two_factor_secret' => 'secret_key_would_be_generated_here',
        ]);
        
        return redirect()->route('user.security')->with('success', 'تم تفعيل المصادقة الثنائية بنجاح');
    }

    /**
     * Disable two-factor authentication for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disableTwoFactor(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
        ]);
        
        return redirect()->route('user.security')->with('success', 'تم تعطيل المصادقة الثنائية');
    }

    /**
     * Verify the two-factor authentication code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = Auth::user();
        
        // Verify the code (this would need to be implemented with a proper 2FA library)
        // For example: $valid = Google2FA::verifyKey($user->two_factor_secret, $request->code);
        
        // For demonstration purposes:
        $valid = true;
        
        if ($valid) {
            $user->update([
                'two_factor_confirmed_at' => now(),
            ]);
            
            return redirect()->route('user.security')->with('success', 'تم تأكيد المصادقة الثنائية بنجاح');
        }
        
        return back()->withErrors(['code' => 'الرمز غير صحيح. يرجى المحاولة مرة أخرى.']);
    }

    /**
     * Remove a connected device.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $deviceId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeDevice(Request $request, $deviceId)
    {
        $user = Auth::user();
        
        // Remove the device (this would need to be implemented with a proper device tracking system)
        $user->devices()->where('id', $deviceId)->delete();
        
        return redirect()->route('user.security')->with('success', 'تم إزالة الجهاز بنجاح');
    }

    /**
     * Remove all connected devices except the current one.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeAllDevices(Request $request)
    {
        $user = Auth::user();
        
        // Get current device ID (this would need to be implemented with a proper device tracking system)
        $currentDeviceId = session()->getId();
        
        // Remove all devices except the current one
        $user->devices()->where('session_id', '!=', $currentDeviceId)->delete();
        
        return redirect()->route('user.security')->with('success', 'تم تسجيل الخروج من جميع الأجهزة الأخرى بنجاح');
    }
}
