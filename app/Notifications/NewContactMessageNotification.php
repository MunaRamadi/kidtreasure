<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewContactMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The contact message instance.
     *
     * @var \App\Models\ContactMessage
     */
    protected $contactMessage;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return void
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->contactMessage->id,
            'type' => 'contact_message',
            'name' => $this->contactMessage->sender_name,
            'email' => $this->contactMessage->sender_email,
            'subject' => $this->contactMessage->subject,
            'created_at' => $this->contactMessage->created_at->toIso8601String(),
            'message' => 'New contact message from ' . $this->contactMessage->sender_name,
            'url' => route('admin.contact-messages.show', $this->contactMessage->id)
        ];
    }
}
