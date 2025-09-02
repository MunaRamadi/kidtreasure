<?php

namespace App\Events;

use App\Models\ContactMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactMessageCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The contact message instance.
     *
     * @var \App\Models\ContactMessage
     */
    public $contactMessage;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return void
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('admin-notifications');
    }
}
