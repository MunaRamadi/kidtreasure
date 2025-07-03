<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
    /**
     * Display the user settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }

    /**
     * Update general settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        
        // Update user preferences in the database
        $user->preferences()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'email_notifications' => $request->has('email_notifications'),
                'order_updates' => $request->has('order_updates'),
                'newsletter' => $request->has('newsletter'),
                'theme' => $request->theme,
            ]
        );
        
        return redirect()->route('settings')->with('success', 'تم تحديث الإعدادات العامة بنجاح');
    }

    /**
     * Update notification settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        // Update notification preferences
        $notificationSettings = [
            'order_placed' => $request->has('order_placed'),
            'order_shipped' => $request->has('order_shipped'),
            'order_delivered' => $request->has('order_delivered'),
            'account_updates' => $request->has('account_updates'),
            'security_alerts' => $request->has('security_alerts'),
            'password_changes' => $request->has('password_changes'),
            'promotions' => $request->has('promotions'),
            'new_products' => $request->has('new_products'),
            'events' => $request->has('events'),
        ];
        
        $user->notificationPreferences()->updateOrCreate(
            ['user_id' => $user->id],
            $notificationSettings
        );
        
        return redirect()->route('settings')->with('success', 'تم تحديث إعدادات الإشعارات بنجاح');
    }

    /**
     * Update privacy settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePrivacy(Request $request)
    {
        $user = Auth::user();
        
        // Update privacy preferences
        $privacySettings = [
            'share_usage_data' => $request->has('share_usage_data'),
            'personalized_ads' => $request->has('personalized_ads'),
            'third_party_sharing' => $request->has('third_party_sharing'),
            'functional_cookies' => $request->has('functional_cookies'),
            'analytics_cookies' => $request->has('analytics_cookies'),
            'marketing_cookies' => $request->has('marketing_cookies'),
        ];
        
        $user->privacyPreferences()->updateOrCreate(
            ['user_id' => $user->id],
            $privacySettings
        );
        
        return redirect()->route('settings')->with('success', 'تم تحديث إعدادات الخصوصية بنجاح');
    }

    /**
     * Update language and region settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLanguage(Request $request)
    {
        $user = Auth::user();
        
        // Update language and region preferences
        $user->regionPreferences()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'language' => $request->language,
                'timezone' => $request->timezone,
                'date_format' => $request->date_format,
                'currency' => $request->currency,
            ]
        );
        
        // Update session language
        session(['locale' => $request->language]);
        
        return redirect()->route('settings')->with('success', 'تم تحديث إعدادات اللغة والمنطقة بنجاح');
    }

    /**
     * Request account deletion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function requestDeletion(Request $request)
    {
        $user = Auth::user();
        
        // Mark account for deletion or send notification to admin
        $user->update(['deletion_requested_at' => now()]);
        
        // Send email notification to user and admin
        // Mail::to($user->email)->send(new AccountDeletionRequested($user));
        // Mail::to(config('mail.admin_address'))->send(new UserDeletionRequest($user));
        
        return redirect()->route('settings')->with('success', 'تم استلام طلب حذف الحساب وسيتم مراجعته قريبًا');
    }
}
