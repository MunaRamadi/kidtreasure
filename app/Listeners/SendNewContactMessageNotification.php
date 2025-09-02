<?php

namespace App\Listeners;

use App\Events\ContactMessageCreated;
use App\Models\User;
use App\Notifications\NewContactMessageNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewContactMessageNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ContactMessageCreated  $event
     * @return void
     */
    public function handle(ContactMessageCreated $event): void
    {
        $contactMessage = $event->contactMessage;
        
        // Get all admin users
        $adminUsers = User::where('is_admin', true)->get();
        
        // Notify each admin user
        foreach ($adminUsers as $admin) {
            $admin->notify(new NewContactMessageNotification($contactMessage));
        }
    }
}
