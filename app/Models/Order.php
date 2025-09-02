<?php

namespace App\Models;

use App\Events\OrderCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'billing_address',
        'order_date',
        'total_amount_jod',
        'payment_method',
        'payment_status', 
        'order_status', 
        'shipping_method',
        'shipping_cost',
        'shipping_carrier',
        'tracking_number',
        'discount_code',
        'discount_amount',
        'notes',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'order_date' => 'datetime',
        'paid_at' => 'datetime',
        'order_status' => 'string',
        'payment_status' => 'string',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    // Removed event dispatching
    // protected $dispatchesEvents = [
    //     'created' => OrderCreated::class,
    // ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELED = 'canceled';
    const STATUS_REFUNDED = 'refunded';

    // Get all available statuses
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'قيد الانتظار',
            self::STATUS_COMPLETED => 'تم',
            self::STATUS_CANCELED => 'ملغي',
            self::STATUS_REFUNDED => 'مسترجع',
        ];
    }

    // Get Arabic status name
    public function getStatusNameAttribute()
    {
        return self::getStatuses()[$this->order_status] ?? $this->order_status;
    }

    // Get Arabic payment status name
    public function getPaymentStatusNameAttribute()
    {
        return self::getStatuses()[$this->payment_status] ?? $this->payment_status;
    }

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع عناصر الطلب
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // إنشاء طلب من السلة
    public static function createFromCart(Cart $cart, array $orderData)
    {
        // إنشاء رقم طلب فريد
        $orderNumber = 'ORD-' . strtoupper(uniqid());
        
        // حساب تكلفة الشحن والخصم
        $shippingCost = $orderData['shipping_cost'] ?? 0;
        $discountAmount = $orderData['discount_amount'] ?? 0;
        
        // Get user data if the user is logged in
        $user = $cart->user;
        
        // إنشاء الطلب
        $order = self::create([
            'user_id' => $cart->user_id,
            'order_number' => $orderNumber,
            'customer_name' => $user ? $user->name : $orderData['shipping_address']['first_name'] . ' ' . $orderData['shipping_address']['last_name'],
            'customer_email' => $user ? $user->email : $orderData['shipping_address']['email'],
            'customer_phone' => $user ? $user->phone : $orderData['shipping_address']['phone'],
            'shipping_address' => $orderData['shipping_address'],
            'billing_address' => $orderData['billing_address'] ?? $orderData['shipping_address'],
            'order_date' => now(),
            'total_amount_jod' => $cart->total_price + $shippingCost - $discountAmount,
            'payment_method' => $orderData['payment_method'],
            'payment_status' => self::STATUS_PENDING,
            'order_status' => self::STATUS_PENDING,
            'shipping_method' => $orderData['shipping_method'] ?? 'standard',
            'shipping_cost' => $shippingCost,
            'shipping_carrier' => $orderData['shipping_carrier'] ?? null,
            'tracking_number' => $orderData['tracking_number'] ?? null,
            'discount_code' => $orderData['discount_code'] ?? null,
            'discount_amount' => $discountAmount,
            'notes' => $orderData['notes'] ?? null,
        ]);
        
        // نقل عناصر السلة إلى عناصر الطلب
        foreach ($cart->items as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'unit_price_jod' => $cartItem->price,
                'subtotal_jod' => $cartItem->price * $cartItem->quantity,
                'product_name' => $cartItem->product_name,
                'product_image' => $cartItem->product_image,
                'options' => $cartItem->options,
            ]);
        }
        
        // Direct notification creation instead of using events
        try {
            Log::info('Creating order notifications for admin users');
            
            // Get all admin users
            $adminUsers = User::where('is_admin', true)->get();
            
            if ($adminUsers->isEmpty()) {
                Log::warning('No admin users found, trying with role=admin');
                $adminUsers = User::where('role', 'admin')->get();
            }
            
            Log::info('Found ' . $adminUsers->count() . ' admin users');
            
            foreach ($adminUsers as $admin) {
                Log::info('Creating notification for admin: ' . $admin->id . ' - ' . $admin->name);
                
                // Create notification data
                $notificationData = [
                    'id' => $order->id,
                    'type' => 'order',
                    'order_number' => $order->order_number,
                    'customer_name' => $order->user->name ?? 'Guest',
                    'total_amount' => $order->total_amount_jod,
                    'currency' => 'JOD',
                    'created_at' => $order->created_at->toIso8601String(),
                    'message' => 'New order #' . $order->order_number . ' has been placed',
                    'url' => route('admin.orders.index', ['highlight' => $order->id]),
                    'item_id' => $order->id
                ];
                
                // Direct database insertion
                DB::table('notifications')->insert([
                    'id' => Str::uuid()->toString(),
                    'type' => 'App\\Notifications\\NewOrderNotification',
                    'notifiable_type' => 'App\\Models\\User',
                    'notifiable_id' => $admin->id,
                    'data' => json_encode($notificationData),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                Log::info('Successfully created notification for admin: ' . $admin->id);
            }
        } catch (\Exception $e) {
            Log::error('Error creating order notifications: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
        
        // تفريغ السلة بعد إنشاء الطلب
        $cart->update(['status' => 'converted']);
        $cart->clearItems();
        
        return $order;
    }
}