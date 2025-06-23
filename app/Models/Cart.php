<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

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
        'total_price' => 'decimal:2',
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
        try {
            // استخدام raw SQL لضمان الدقة في الحسابات
            $totalItems = $this->items()->sum('quantity');
            $totalPrice = $this->items()->sum(DB::raw('price * quantity'));

            $this->update([
                'total_items' => $totalItems ?: 0,
                'total_price' => $totalPrice ?: 0,
                'last_activity' => now(),
            ]);

            return $this;
        } catch (\Exception $e) {
            // في حالة حدوث خطأ، نعيد القيم الافتراضية
            $this->update([
                'total_items' => 0,
                'total_price' => 0,
                'last_activity' => now(),
            ]);
            
            return $this;
        }
    }

    // إضافة منتج للسلة
    public function addItem($productId, $quantity = 1, $price = null)
    {
        try {
            $product = Product::findOrFail($productId);
            
            // استخدام المعاملة لضمان تناسق البيانات
            DB::transaction(function () use ($productId, $quantity, $price, $product) {
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
                        'product_image' => $product->image_url ?? null,
                    ]);
                }
            });

            // إعادة حساب الإجماليات
            return $this->calculateTotals();

        } catch (\Exception $e) {
            // إعادة حساب الإجماليات حتى في حالة الخطأ
            return $this->calculateTotals();
        }
    }

    // تحديث كمية منتج في السلة
    public function updateItemQuantity($cartItemId, $quantity)
    {
        try {
            DB::transaction(function () use ($cartItemId, $quantity) {
                $cartItem = $this->items()->findOrFail($cartItemId);
                
                if ($quantity <= 0) {
                    $cartItem->delete();
                } else {
                    $cartItem->update(['quantity' => $quantity]);
                }
            });

            // إعادة حساب الإجماليات
            return $this->calculateTotals();

        } catch (\Exception $e) {
            // إعادة حساب الإجماليات حتى في حالة الخطأ
            return $this->calculateTotals();
        }
    }

    // حذف منتج من السلة
    public function removeItem($cartItemId)
    {
        try {
            DB::transaction(function () use ($cartItemId) {
                $cartItem = $this->items()->find($cartItemId);
                if ($cartItem) {
                    $cartItem->delete();
                }
            });
            
            // إعادة حساب الإجماليات
            return $this->calculateTotals();

        } catch (\Exception $e) {
            // إعادة حساب الإجماليات حتى في حالة الخطأ
            return $this->calculateTotals();
        }
    }

    // تفريغ السلة بالكامل
    public function clearItems()
    {
        try {
            DB::transaction(function () {
                $this->items()->delete();
            });
            
            // إعادة حساب الإجماليات
            return $this->calculateTotals();

        } catch (\Exception $e) {
            // في حالة الخطأ، محاولة تحديث الإجماليات يدوياً
            $this->update([
                'total_items' => 0,
                'total_price' => 0,
                'last_activity' => now(),
            ]);
            
            return $this;
        }
    }

    // التحقق من صحة السلة
    public function isValid()
    {
        foreach ($this->items as $item) {
            $product = Product::find($item->product_id);
            if (!$product || !$product->is_active || $product->stock_quantity < $item->quantity) {
                return false;
            }
        }
        return true;
    }

    // تنظيف العناصر غير المتوفرة
    public function cleanInvalidItems()
    {
        $invalidItems = [];
        
        foreach ($this->items as $item) {
            $product = Product::find($item->product_id);
            if (!$product || !$product->is_active) {
                $invalidItems[] = $item->id;
            } elseif ($product->stock_quantity < $item->quantity) {
                // تحديث الكمية للحد الأقصى المتوفر
                $item->update(['quantity' => $product->stock_quantity]);
            }
        }
        
        // حذف العناصر غير المتوفرة
        if (!empty($invalidItems)) {
            $this->items()->whereIn('id', $invalidItems)->delete();
        }
        
        return $this->calculateTotals();
    }
}