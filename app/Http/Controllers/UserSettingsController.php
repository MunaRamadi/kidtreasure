<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Address;

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

    /**
     * Show the form for editing the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);
        
        $user->update($validated);
        
        return redirect()->route('profile.account')->with('success', 'تم تحديث معلومات الحساب بنجاح');
    }

    /**
     * Show the user's address book.
     *
     * @return \Illuminate\View\View
     */
    public function addressBook()
    {
        $user = Auth::user();
        $addresses = $user->addresses;
        $defaultAddress = $user->addresses()->where('is_default', true)->first();
        
        return view('user.profile.address', compact('user', 'addresses', 'defaultAddress'));
    }

    /**
     * Store a new address for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAddress(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'is_default' => ['sometimes', 'boolean'],
        ]);
        
        // If this is set as default, unset any other default address
        if ($request->has('is_default')) {
            $user->addresses()->update(['is_default' => false]);
        }
        
        $user->addresses()->create($validated);
        
        return redirect()->route('profile.address')->with('success', 'تم إضافة العنوان بنجاح');
    }

    /**
     * Delete an address from the user's address book.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAddress(Address $address)
    {
        $user = Auth::user();
        
        // Check if the address belongs to the authenticated user
        if ($address->user_id !== $user->id) {
            abort(403);
        }
        
        $address->delete();
        
        return redirect()->route('profile.address')->with('success', 'تم حذف العنوان بنجاح');
    }

    /**
     * Set an address as the default address.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setDefaultAddress(Address $address)
    {
        $user = Auth::user();
        
        // Check if the address belongs to the authenticated user
        if ($address->user_id !== $user->id) {
            abort(403);
        }
        
        // Unset any existing default address
        $user->addresses()->update(['is_default' => false]);
        
        // Set the selected address as default
        $address->update(['is_default' => true]);
        
        return redirect()->route('profile.address')->with('success', 'تم تعيين العنوان الافتراضي بنجاح');
    }

    /**
     * Show the newsletter preferences form.
     *
     * @return \Illuminate\View\View
     */
    public function newsletterPreferences()
    {
        $user = Auth::user();
        $preferences = $user->preferences;
        
        return view('user.profile.newsletter', compact('user', 'preferences'));
    }

    /**
     * Update the user's newsletter preferences.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateNewsletterPreferences(Request $request)
    {
        $user = Auth::user();
        
        $user->preferences()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'newsletter' => $request->has('newsletter'),
                'promotional_emails' => $request->has('promotional_emails'),
                'product_updates' => $request->has('product_updates'),
                'event_notifications' => $request->has('event_notifications'),
            ]
        );
        
        return redirect()->route('profile.newsletter')->with('success', 'تم تحديث تفضيلات النشرة الإخبارية بنجاح');
    }
}
