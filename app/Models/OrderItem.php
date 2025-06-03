<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price_jod',
        'subtotal_jod',
        'product_name',
        'product_image',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    // العلاقة مع الطلب
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // العلاقة مع المنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // حساب السعر الإجمالي للعنصر
    public function getTotalAttribute()
    {
        return $this->subtotal_jod;
    }
}