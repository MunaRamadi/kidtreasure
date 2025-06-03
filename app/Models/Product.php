<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_jod',
        'stock_quantity',
        'image_path',
        'is_featured',
        'is_active',
        'category',
    ];

    /**
     * الصورة الافتراضية للمنتج
     */
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : asset('images/default-product.jpg');
    }

    /**
     * الحصول على سعر المنتج
     */
    public function getPriceAttribute()
    {
        return $this->price_jod;
    }

    /**
     * العلاقة مع عناصر السلة
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * العلاقة مع عناصر الطلبات
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * التحقق من توفر المنتج للبيع
     */
    public function getIsAvailableAttribute()
    {
        return $this->is_active && $this->stock_quantity > 0;
    }
}