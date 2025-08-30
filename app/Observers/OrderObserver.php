<?php

namespace App\Observers;

use App\Models\Order;
use App\Events\OrderCreated;
use App\Notifications\OrderStatusChanged;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        // Dispatch the OrderCreated event
        event(new OrderCreated($order));
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        // Check if status has changed
        if ($order->isDirty('status')) {
            $this->notifyStatusChange($order);
        }
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
    
    /**
     * Send notification about status change.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    protected function notifyStatusChange(Order $order)
    {
        $user = $order->user;
        
        if (!$user) {
            return;
        }
        
        $statusMessages = [
            'pending' => 'Your order has been received and is pending processing.',
            'processing' => 'Your order is now being processed.',
            'shipped' => 'Your order has been shipped and is on its way!',
            'delivered' => 'Your order has been delivered. Enjoy!',
            'cancelled' => 'Your order has been cancelled.',
            'refunded' => 'Your order has been refunded.',
        ];
        
        $message = $statusMessages[$order->status] ?? "Your order status has been updated to {$order->status}.";
        
        $orderData = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'status' => $order->status,
            'message' => $message,
            'url' => route('profile.orders.show', $order->id)
        ];
        
        $user->notify(new OrderStatusChanged($orderData));
    }
}
