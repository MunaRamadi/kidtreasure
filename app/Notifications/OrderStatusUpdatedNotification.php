<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The order instance.
     *
     * @var \App\Models\Order
     */
    protected $order;
    
    /**
     * The previous status.
     *
     * @var string
     */
    protected $previousStatus;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Order  $order
     * @param  string  $previousStatus
     * @return void
     */
    public function __construct(Order $order, string $previousStatus)
    {
        $this->order = $order;
        $this->previousStatus = $previousStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/orders/' . $this->order->id);
        $statusName = $this->order->status_name;
        
        return (new MailMessage)
            ->subject(app()->getLocale() == 'ar' ? 'تم تحديث حالة طلبك' : 'Your Order Status Has Been Updated')
            ->greeting(app()->getLocale() == 'ar' ? 'مرحباً ' . $notifiable->name : 'Hello ' . $notifiable->name)
            ->line(app()->getLocale() == 'ar' 
                ? 'تم تحديث حالة طلبك رقم ' . $this->order->order_number . ' إلى ' . $statusName
                : 'Your order #' . $this->order->order_number . ' status has been updated to ' . $this->order->order_status)
            ->action(
                app()->getLocale() == 'ar' ? 'عرض تفاصيل الطلب' : 'View Order Details',
                $url
            )
            ->line(app()->getLocale() == 'ar'
                ? 'شكراً لاختيارك كيد تريجر!'
                : 'Thank you for choosing Kid Treasure!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'previous_status' => $this->previousStatus,
            'current_status' => $this->order->order_status,
            'message' => app()->getLocale() == 'ar' 
                ? 'تم تحديث حالة طلبك رقم ' . $this->order->order_number . ' إلى ' . $this->order->status_name
                : 'Your order #' . $this->order->order_number . ' status has been updated to ' . $this->order->order_status,
            'url' => '/orders/' . $this->order->id,
        ];
    }
}
