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

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('sender_name', 'like', "%{$search}%")
                  ->orWhere('sender_email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_read', $request->status === 'read');
        }

        $messages = $query->latest('submission_date')->paginate(20)->withQueryString();

        // Add debug information
        \Log::info('Messages count: ' . $messages->count());
        if ($messages->count() > 0) {
            \Log::info('First message ID: ' . $messages->first()->id);
        }

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        // Mark the message as read
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.contact-messages.show', compact('message'));
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'Message marked as read successfully.');
    }

    public function markAsUnread(ContactMessage $message)
    {
        $message->update(['is_read' => false]);
        return back()->with('success', 'Message marked as unread successfully.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }

    public function bulkMarkAsRead(Request $request)
    {
        $messageIds = $request->input('messages', []);
        
        if (empty($messageIds)) {
            return back()->with('error', 'No messages selected.');
        }
        
        ContactMessage::whereIn('id', $messageIds)->update(['is_read' => true]);

        return back()->with('success', 'Selected messages marked as read.');
    }

    public function bulkDelete(Request $request)
    {
        $messageIds = $request->input('messages', []);
        
        if (empty($messageIds)) {
            return back()->with('error', 'No messages selected.');
        }
        
        ContactMessage::whereIn('id', $messageIds)->delete();

        return back()->with('success', 'Selected messages deleted successfully.');
    }
}