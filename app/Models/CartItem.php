<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'product_name',
        'product_image',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    // العلاقة مع السلة
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // العلاقة مع المنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // حساب السعر الإجمالي للعنصر
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}