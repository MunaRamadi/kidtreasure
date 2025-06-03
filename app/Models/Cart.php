<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'total_price',
        'total_items',
        'status', // active, abandoned, converted
        'last_activity',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع عناصر السلة
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // حساب إجمالي عناصر السلة
    public function calculateTotals()
    {
        $totalItems = $this->items()->sum('quantity');
        $totalPrice = $this->items()->sum(\DB::raw('price * quantity'));

        $this->update([
            'total_items' => $totalItems,
            'total_price' => $totalPrice,
            'last_activity' => now(),
        ]);

        return $this;
    }

    // إضافة منتج للسلة
    public function addItem($productId, $quantity = 1, $price = null)
    {
        $product = Product::findOrFail($productId);
        
        // البحث عن العنصر في السلة إذا كان موجوداً
        $cartItem = $this->items()->where('product_id', $productId)->first();
        
        if ($cartItem) {
            // تحديث الكمية إذا كان العنصر موجوداً في السلة
            $cartItem->increment('quantity', $quantity);
        } else {
            // إنشاء عنصر جديد في السلة
            $this->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price ?? $product->price_jod,
                'product_name' => $product->name,
                'product_image' => $product->image_url,
            ]);
        }

        // إعادة حساب الإجماليات
        return $this->calculateTotals();
    }

    // تحديث كمية منتج في السلة
    public function updateItemQuantity($cartItemId, $quantity)
    {
        $cartItem = $this->items()->findOrFail($cartItemId);
        
        if ($quantity <= 0) {
            $cartItem->delete();
        } else {
            $cartItem->update(['quantity' => $quantity]);
        }

        // إعادة حساب الإجماليات
        return $this->calculateTotals();
    }

    // حذف منتج من السلة
    public function removeItem($cartItemId)
    {
        $this->items()->findOrFail($cartItemId)->delete();
        
        // إعادة حساب الإجماليات
        return $this->calculateTotals();
    }

    // تفريغ السلة بالكامل
    public function clearItems()
    {
        $this->items()->delete();
        
        // إعادة حساب الإجماليات
        return $this->calculateTotals();
    }
}