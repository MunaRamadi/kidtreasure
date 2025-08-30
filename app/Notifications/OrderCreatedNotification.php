<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The order instance.
     *
     * @var \App\Models\Order
     */
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
        
        return (new MailMessage)
            ->subject(app()->getLocale() == 'ar' ? 'تم استلام طلبك بنجاح' : 'Your Order Has Been Received')
            ->greeting(app()->getLocale() == 'ar' ? 'مرحباً ' . $notifiable->name : 'Hello ' . $notifiable->name)
            ->line(app()->getLocale() == 'ar' 
                ? 'لقد تلقينا طلبك رقم ' . $this->order->order_number . ' وهو قيد المعالجة الآن.'
                : 'We have received your order #' . $this->order->order_number . ' and it is now being processed.')
            ->line(app()->getLocale() == 'ar'
                ? 'إجمالي الطلب: ' . $this->order->total_amount_jod . ' دينار'
                : 'Order total: JOD ' . $this->order->total_amount_jod)
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
            'amount' => $this->order->total_amount_jod,
            'status' => $this->order->order_status,
            'message' => app()->getLocale() == 'ar' 
                ? 'تم استلام طلبك رقم ' . $this->order->order_number
                : 'Your order #' . $this->order->order_number . ' has been received',
            'url' => '/orders/' . $this->order->id,
        ];
    }
}
