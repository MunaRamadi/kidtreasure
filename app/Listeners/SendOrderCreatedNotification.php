<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Notifications\OrderStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderCreatedNotification implements ShouldQueue
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
        $user = $order->user;
        
        if (!$user) {
            return;
        }
        
        $orderData = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'status' => 'created',
            'message' => 'Thank you for your order! We have received your order and will process it shortly.',
            'url' => route('profile.orders.show', $order->id)
        ];
        
        $user->notify(new OrderStatusChanged($orderData));
    }
}
