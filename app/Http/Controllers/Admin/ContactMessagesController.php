<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('sender_name', 'like', "%{$search}%")
                  ->orWhere('sender_email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // التصفية حسب الحالة
        if ($request->filled('status')) {
            $query->where('is_read', $request->status === 'read');
        }

        $messages = $query->latest('submission_date')->paginate(20)->withQueryString();

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        // تعليم الرسالة كمقروءة
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.contact-messages.show', compact('message'));
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'تم تعليم الرسالة كمقروءة');
    }

    public function markAsUnread(ContactMessage $message)
    {
        $message->update(['is_read' => false]);
        return back()->with('success', 'تم تعليم الرسالة كغير مقروءة');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'تم حذف الرسالة بنجاح');
    }

    public function bulkMarkAsRead(Request $request)
    {
        $messageIds = $request->input('messages', []);
        ContactMessage::whereIn('id', $messageIds)->update(['is_read' => true]);
        
        return back()->with('success', 'تم تعليم الرسائل المحددة كمقروءة');
    }

    public function bulkDelete(Request $request)
    {
        $messageIds = $request->input('messages', []);
        ContactMessage::whereIn('id', $messageIds)->delete();
        
        return back()->with('success', 'تم حذف الرسائل المحددة بنجاح');
    }
}