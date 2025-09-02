<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage; 
use App\Models\User;
use App\Notifications\NewContactMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
   
    public function create()
    {
        return view('pages.contact.create');
    }

   
    public function store(Request $request)
    {
        // مثال: التحقق من صحة بيانات النموذج
        $request->validate([
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|email|max:255',
            'sender_phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            Log::info('Starting contact message creation');
            
            // مثال: حفظ الرسالة في قاعدة البيانات
            $contactMessage = ContactMessage::create([
                'sender_name' => $request->sender_name,
                'sender_email' => $request->sender_email,
                'sender_phone' => $request->sender_phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'submission_date' => now(),
                'is_read' => false, // افتراضياً الرسالة غير مقروءة
            ]);

            Log::info('Contact message created successfully', [
                'id' => $contactMessage->id,
                'sender_name' => $contactMessage->sender_name
            ]);

            // Find admin users
            $adminUsers = User::where('is_admin', true)->get();
            
            if ($adminUsers->count() == 0) {
                Log::info('No users with is_admin=true found, trying with role=admin');
                $adminUsers = User::where('role', 'admin')->get();
            }
            
            if ($adminUsers->count() == 0) {
                // If still no admin users found, get the first user as a fallback
                Log::info('No admin users found, using first user as fallback');
                $adminUsers = User::first() ? [User::first()] : [];
            }
            
            Log::info('Found users to notify', [
                'count' => count($adminUsers),
                'user_ids' => collect($adminUsers)->pluck('id')->toArray()
            ]);
            
            if (count($adminUsers) > 0) {
                // Create database notification for each admin
                foreach ($adminUsers as $admin) {
                    // Create a database notification record directly
                    DB::table('notifications')->insert([
                        'id' => \Illuminate\Support\Str::uuid()->toString(),
                        'type' => NewContactMessageNotification::class,
                        'notifiable_type' => User::class,
                        'notifiable_id' => $admin->id,
                        'data' => json_encode([
                            'id' => $contactMessage->id,
                            'type' => 'contact_message',
                            'name' => $contactMessage->sender_name,
                            'email' => $contactMessage->sender_email,
                            'subject' => $contactMessage->subject,
                            'created_at' => $contactMessage->created_at->toIso8601String(),
                            'message' => 'New contact message from ' . $contactMessage->sender_name,
                            'url' => route('admin.contact-messages.index', ['highlight' => $contactMessage->id]),
                            'item_id' => $contactMessage->id
                        ]),
                        'read_at' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } else {
                Log::warning('No users found to notify');
            }

            // إعادة التوجيه بعد النجاح
            return redirect()->route('contact.create')->with('success', 'شكراً لك! تم استلام رسالتك وسنتواصل معك قريباً.');
        } catch (\Exception $e) {
            Log::error('Error creating contact message or notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'حدث خطأ أثناء إرسال رسالتك. يرجى المحاولة مرة أخرى لاحقاً.');
        }
    }
}