<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display the settings index page
     */
    public function index()
    {
        $settings = $this->getAllSettings();
        
        return view('admin.settings.index');
    }

    /**
     * Update general settings
     */
    public function updateGeneral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check the form for errors.');
        }

        try {
            $settings = $request->only([
                'site_name', 'site_description', 'contact_email', 
                'contact_phone', 'address', 'facebook_url', 
                'instagram_url', 'twitter_url', 'youtube_url'
            ]);

            foreach ($settings as $key => $value) {
                $this->updateSetting($key, $value);
            }

            // Clear cache
            Cache::forget('site_settings');

            return redirect()->back()->with('success', 'General settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

    /**
     * Update email settings
     */
    public function updateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mail_driver' => 'required|in:smtp,sendmail,mailgun,postmark',
            'mail_host' => 'required_if:mail_driver,smtp|nullable|string',
            'mail_port' => 'required_if:mail_driver,smtp|nullable|integer',
            'mail_username' => 'required_if:mail_driver,smtp|nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|in:tls,ssl',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check the email settings form for errors.');
        }

        try {
            $settings = $request->only([
                'mail_driver', 'mail_host', 'mail_port', 
                'mail_username', 'mail_password', 'mail_encryption',
                'mail_from_address', 'mail_from_name'
            ]);

            foreach ($settings as $key => $value) {
                if ($key === 'mail_password' && empty($value)) {
                    continue; // Don't update password if empty
                }
                $this->updateSetting($key, $value);
            }

            Cache::forget('site_settings');

            return redirect()->back()->with('success', 'Email settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update email settings: ' . $e->getMessage());
        }
    }

    /**
     * Update SEO settings
     */
    public function updateSeo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'google_analytics_id' => 'nullable|string|max:50',
            'google_search_console' => 'nullable|string|max:100',
            'facebook_pixel_id' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check the SEO settings form for errors.');
        }

        try {
            $settings = $request->only([
                'meta_title', 'meta_description', 'meta_keywords',
                'google_analytics_id', 'google_search_console', 'facebook_pixel_id'
            ]);

            foreach ($settings as $key => $value) {
                $this->updateSetting($key, $value);
            }

            Cache::forget('site_settings');

            return redirect()->back()->with('success', 'SEO settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update SEO settings: ' . $e->getMessage());
        }
    }

    /**
     * Update payment settings
     */
    public function updatePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currency' => 'required|string|size:3',
            'currency_symbol' => 'required|string|max:5',
            'payment_methods' => 'required|array',
            'payment_methods.*' => 'in:credit_card,paypal,bank_transfer,cash_on_delivery',
            'stripe_publishable_key' => 'nullable|string',
            'stripe_secret_key' => 'nullable|string',
            'paypal_client_id' => 'nullable|string',
            'paypal_client_secret' => 'nullable|string',
            'paypal_mode' => 'required|in:sandbox,live',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check the payment settings form for errors.');
        }

        try {
            $settings = $request->only([
                'currency', 'currency_symbol', 'paypal_mode'
            ]);

            // Handle payment methods array
            $settings['payment_methods'] = json_encode($request->payment_methods);

            // Handle sensitive data
            $sensitiveFields = ['stripe_publishable_key', 'stripe_secret_key', 'paypal_client_id', 'paypal_client_secret'];
            foreach ($sensitiveFields as $field) {
                if ($request->filled($field)) {
                    $settings[$field] = $request->$field;
                }
            }

            foreach ($settings as $key => $value) {
                $this->updateSetting($key, $value);
            }

            Cache::forget('site_settings');

            return redirect()->back()->with('success', 'Payment settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update payment settings: ' . $e->getMessage());
        }
    }

    /**
     * Upload logo
     */
    public function uploadLogo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Please select a valid image file (max 2MB).');
        }

        try {
            // Delete old logo
            $oldLogo = $this->getSetting('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Upload new logo
            $logoPath = $request->file('logo')->store('logos', 'public');
            $this->updateSetting('site_logo', $logoPath);

            Cache::forget('site_settings');

            return redirect()->back()->with('success', 'Logo uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to upload logo: ' . $e->getMessage());
        }
    }

    /**
     * Upload favicon
     */
    public function uploadFavicon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'favicon' => 'required|image|mimes:ico,png|max:512',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Please select a valid favicon file (ICO or PNG, max 512KB).');
        }

        try {
            // Delete old favicon
            $oldFavicon = $this->getSetting('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }

            // Upload new favicon
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            $this->updateSetting('site_favicon', $faviconPath);

            Cache::forget('site_settings');

            return redirect()->back()->with('success', 'Favicon uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to upload favicon: ' . $e->getMessage());
        }
    }

    /**
     * Clear application cache
     */
    public function clearCache()
    {
        try {
            Cache::flush();
            return redirect()->back()->with('success', 'Application cache cleared successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    /**
     * Get all settings
     */
    private function getAllSettings()
    {
        return Cache::remember('site_settings', 3600, function () {
            $settings = DB::table('settings')->pluck('value', 'key')->toArray();
            
            // Default settings
            $defaults = [
                'site_name' => 'Kids Treasure',
                'site_description' => 'A wonderful place for children',
                'contact_email' => 'admin@kidstreasure.com',
                'contact_phone' => '',
                'address' => '',
                'facebook_url' => '',
                'instagram_url' => '',
                'twitter_url' => '',
                'youtube_url' => '',
                'site_logo' => '',
                'site_favicon' => '',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'google_analytics_id' => '',
                'google_search_console' => '',
                'facebook_pixel_id' => '',
                'currency' => 'USD',
                'currency_symbol' => '$',
                'payment_methods' => json_encode(['credit_card', 'paypal']),
                'stripe_publishable_key' => '',
                'stripe_secret_key' => '',
                'paypal_client_id' => '',
                'paypal_client_secret' => '',
                'paypal_mode' => 'sandbox',
                'mail_driver' => 'smtp',
                'mail_host' => '',
                'mail_port' => '587',
                'mail_username' => '',
                'mail_password' => '',
                'mail_encryption' => 'tls',
                'mail_from_address' => 'noreply@kidstreasure.com',
                'mail_from_name' => 'Kids Treasure',
            ];

            return array_merge($defaults, $settings);
        });
    }

    /**
     * Get a specific setting
     */
    private function getSetting($key, $default = null)
    {
        $settings = $this->getAllSettings();
        return $settings[$key] ?? $default;
    }

    /**
     * Update a specific setting
     */
    private function updateSetting($key, $value)
    {
        DB::table('settings')->updateOrInsert(
            ['key' => $key],
            [
                'value' => $value,
                'updated_at' => now()
            ]
        );
    }
}