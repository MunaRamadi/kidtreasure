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
        'price' => 'decimal:2',
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

    // الحصول على السعر الإجمالي المنسق
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total, 2) . ' JOD';
    }

    // الحصول على السعر المنسق
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' JOD';
    }

    // التحقق من توفر المنتج
    public function getIsAvailableAttribute()
    {
        return $this->product && 
               $this->product->is_active && 
               $this->product->stock_quantity >= $this->quantity;
    }

    // الحصول على صورة المنتج الحالية
    public function getCurrentProductImageAttribute()
    {
        return $this->product ? $this->product->main_image_url : $this->product_image;
    }

    // الحصول على اسم المنتج الحالي
    public function getCurrentProductNameAttribute()
    {
        return $this->product ? $this->product->name : $this->product_name;
    }

    // الحصول على السعر الحالي للمنتج
    public function getCurrentProductPriceAttribute()
    {
        return $this->product ? $this->product->price_jod : $this->price;
    }

    // التحقق من تغير السعر
    public function getHasPriceChangedAttribute()
    {
        return $this->product && 
               $this->product->price_jod != $this->price;
    }

    // الحصول على الحد الأقصى للكمية المتاحة
    public function getMaxQuantityAttribute()
    {
        return $this->product ? $this->product->stock_quantity : 0;
    }

    // تحديث بيانات العنصر من المنتج الحالي
    public function updateFromProduct()
    {
        if ($this->product) {
            $this->update([
                'product_name' => $this->product->name,
                'product_image' => $this->product->main_image_url,
                'price' => $this->product->price_jod,
            ]);
        }
        return $this;
    }

    // التحقق من صحة العنصر
    public function validate()
    {
        $errors = [];
        
        if (!$this->product) {
            $errors[] = 'المنتج غير موجود';
        } elseif (!$this->product->is_active) {
            $errors[] = 'المنتج غير متوفر حاليًا';
        } elseif ($this->product->stock_quantity < $this->quantity) {
            $errors[] = 'الكمية المطلوبة غير متوفرة';
        }
        
        return $errors;
    }

    // Events
    protected static function boot()
    {
        parent::boot();

        // إعادة حساب إجماليات السلة عند إنشاء أو تحديث أو حذف عنصر
        static::created(function ($cartItem) {
            $cartItem->cart->calculateTotals();
        });

        static::updated(function ($cartItem) {
            $cartItem->cart->calculateTotals();
        });

        static::deleted(function ($cartItem) {
            $cartItem->cart->calculateTotals();
        });
    }
}