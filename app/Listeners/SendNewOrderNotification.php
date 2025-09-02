<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewOrderNotification implements ShouldQueue
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
     * @param  \App\Events\OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        
        // Get all admin users
        $adminUsers = User::where('is_admin', true)->get();
        
        // Notify each admin user
        foreach ($adminUsers as $admin) {
            $admin->notify(new NewOrderNotification($order));
        }
    }
}
