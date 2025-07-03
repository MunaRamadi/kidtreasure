<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id', 'product_id', 'quantity', 'price',
        'product_name', 'product_image', 'options',
    ];

    protected $casts = [
        'options' => 'array', 'price' => 'decimal:2',
    ];

    public function cart() { return $this->belongsTo(Cart::class); }
    public function product() { return $this->belongsTo(Product::class); }

    // حساب السعر الإجمالي للعنصر (الكمية * السعر)
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
    
    // *** دوال لجلب البيانات المحدثة من المنتج المرتبط *** //
    
    // الحصول على صورة المنتج الحالية من نموذج Product
    public function getCurrentProductImageAttribute()
    {
        return $this->product ? $this->product->main_image_url : $this->product_image;
    }

    // الحصول على اسم المنتج الحالي من نموذج Product
    public function getCurrentProductNameAttribute()
    {
        return $this->product ? $this->product->name : $this->product_name;
    }

    // الحصول على السعر الحالي للمنتج من نموذج Product
    public function getCurrentProductPriceAttribute()
    {
        return $this->product ? $this->product->price_jod : $this->price;
    }

    /**
     * تحديث بيانات العنصر (الاسم، الصورة، السعر) من المنتج المرتبط به.
     * هذا يضمن أن البيانات في السلة دائمًا محدثة.
     */
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

    /**
     * التحقق مما إذا كان العنصر لا يزال صالحًا للشراء.
     */
    public function validate()
    {
        $errors = [];
        if (!$this->product) {
            $errors[] = 'المنتج المرتبط بهذا العنصر لم يعد موجوداً.';
        } elseif (!$this->product->is_active) {
            $errors[] = "منتج '{$this->product_name}' غير متوفر حاليًا.";
        } elseif ($this->product->stock_quantity < $this->quantity) {
            $errors[] = "الكمية المطلوبة لمنتج '{$this->product_name}' غير متوفرة.";
        }
        return $errors;
    }

    /**
     * يتم استدعاء هذه الأحداث تلقائيًا عند إنشاء أو تحديث أو حذف عنصر.
     * تقوم بإعادة حساب إجماليات السلة الأم لضمان التناسق.
     */
    protected static function boot()
    {
        parent::boot();

        $recalculateTotals = function ($cartItem) {
            if ($cartItem->cart) {
                $cartItem->cart->calculateTotals();
            }
        };

        static::created($recalculateTotals);
        static::updated($recalculateTotals);
        static::deleted($recalculateTotals);
    }
}