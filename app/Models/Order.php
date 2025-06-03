<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'payment_status', // pending, paid, failed
        'order_status', // pending, processing, shipped, delivered, cancelled
        'shipping_method',
        'shipping_cost',
        'discount_code',
        'discount_amount',
        'notes',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'order_date' => 'datetime',
    ];

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
        
        // إنشاء الطلب
        $order = self::create([
            'user_id' => $cart->user_id,
            'order_number' => $orderNumber,
            'customer_name' => $orderData['shipping_address']['first_name'] . ' ' . $orderData['shipping_address']['last_name'],
            'customer_email' => $orderData['shipping_address']['email'],
            'customer_phone' => $orderData['shipping_address']['phone'],
            'shipping_address' => $orderData['shipping_address'],
            'billing_address' => $orderData['billing_address'] ?? $orderData['shipping_address'],
            'order_date' => now(),
            'total_amount_jod' => $cart->total_price + $shippingCost - $discountAmount,
            'payment_method' => $orderData['payment_method'],
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'shipping_method' => $orderData['shipping_method'] ?? 'standard',
            'shipping_cost' => $shippingCost,
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
        
        // تفريغ السلة بعد إنشاء الطلب
        $cart->update(['status' => 'converted']);
        $cart->clearItems();
        
        return $order;
    }
}