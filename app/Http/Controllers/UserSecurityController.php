<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Password as PasswordFacade;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

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

    /**
     * Display the password change form.
     *
     * @return \Illuminate\View\View
     */
    public function showPasswordForm()
    {
        return view('user.profile.password');
    }

    /**
     * Display the forgot password form.
     *
     * @return \Illuminate\View\View
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a password reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = PasswordFacade::sendResetLink(
            $request->only('email')
        );

        return $status == PasswordFacade::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }

    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = PasswordFacade::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == PasswordFacade::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
