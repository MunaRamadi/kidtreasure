<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            Log::error('Cart calculation error: ' . $e->getMessage());
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
            
            // التحقق من صحة البيانات
            if (!$product->is_active) {
                throw new \Exception('المنتج غير متوفر حاليًا');
            }

            if (!$product->canOrder($quantity)) {
                throw new \Exception('الكمية المطلوبة غير متوفرة');
            }
            
            // استخدام المعاملة لضمان تناسق البيانات
            return DB::transaction(function () use ($productId, $quantity, $price, $product) {
                // البحث عن العنصر في السلة إذا كان موجوداً
                $cartItem = $this->items()->where('product_id', $productId)->first();
                
                if ($cartItem) {
                    // التحقق من الكمية الإجمالية بعد الإضافة
                    $newQuantity = $cartItem->quantity + $quantity;
                    if (!$product->canOrder($newQuantity)) {
                        throw new \Exception('الكمية الإجمالية تتجاوز المخزون المتوفر');
                    }
                    
                    // تحديث الكمية إذا كان العنصر موجوداً في السلة
                    $cartItem->update(['quantity' => $newQuantity]);
                } else {
                    // إنشاء عنصر جديد في السلة
                    $this->items()->create([
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $price ?? $product->price_jod,
                        'product_name' => $product->name,
                        'product_image' => $product->main_image_url,
                    ]);
                }

                // إعادة حساب الإجماليات
                return $this->calculateTotals();
            });

        } catch (\Exception $e) {
            Log::error('Add item to cart error: ' . $e->getMessage());
            throw $e;
        }
    }

    // تحديث كمية منتج في السلة
    public function updateItemQuantity($cartItemId, $quantity)
    {
        try {
            return DB::transaction(function () use ($cartItemId, $quantity) {
                $cartItem = $this->items()->findOrFail($cartItemId);
                $product = $cartItem->product;
                
                if ($quantity <= 0) {
                    $cartItem->delete();
                } else {
                    // التحقق من توفر الكمية
                    if (!$product->canOrder($quantity)) {
                        throw new \Exception('الكمية المطلوبة غير متوفرة');
                    }
                    
                    $cartItem->update(['quantity' => $quantity]);
                }

                // إعادة حساب الإجماليات
                return $this->calculateTotals();
            });

        } catch (\Exception $e) {
            Log::error('Update cart item error: ' . $e->getMessage());
            throw $e;
        }
    }

    // حذف منتج من السلة
    public function removeItem($cartItemId)
    {
        try {
            return DB::transaction(function () use ($cartItemId) {
                $cartItem = $this->items()->find($cartItemId);
                if ($cartItem) {
                    $cartItem->delete();
                }
                
                // إعادة حساب الإجماليات
                return $this->calculateTotals();
            });

        } catch (\Exception $e) {
            Log::error('Remove cart item error: ' . $e->getMessage());
            throw $e;
        }
    }

    // تفريغ السلة بالكامل
    public function clearItems()
    {
        try {
            return DB::transaction(function () {
                $this->items()->delete();
                
                // إعادة حساب الإجماليات
                return $this->calculateTotals();
            });

        } catch (\Exception $e) {
            Log::error('Clear cart error: ' . $e->getMessage());
            throw $e;
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
                if ($product->stock_quantity > 0) {
                    $item->update(['quantity' => $product->stock_quantity]);
                } else {
                    $invalidItems[] = $item->id;
                }
            }
        }
        
        // حذف العناصر غير المتوفرة
        if (!empty($invalidItems)) {
            $this->items()->whereIn('id', $invalidItems)->delete();
        }
        
        return $this->calculateTotals();
    }

    // الحصول على الإجمالي المنسق
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_price, 2) . ' JOD';
    }

    // التحقق من وجود عناصر في السلة
    public function getHasItemsAttribute()
    {
        return $this->total_items > 0;
    }

    // حفظ السلة للمستخدم المسجل
    public function assignToUser($userId)
    {
        $this->update(['user_id' => $userId]);
        return $this;
    }

    // دمج سلة الجلسة مع سلة المستخدم
    public function mergeWith(Cart $otherCart)
    {
        try {
            return DB::transaction(function () use ($otherCart) {
                foreach ($otherCart->items as $item) {
                    $existingItem = $this->items()
                        ->where('product_id', $item->product_id)
                        ->first();
                    
                    if ($existingItem) {
                        // دمج الكميات
                        $newQuantity = $existingItem->quantity + $item->quantity;
                        $existingItem->update(['quantity' => $newQuantity]);
                    } else {
                        // نقل العنصر إلى السلة الحالية
                        $item->update(['cart_id' => $this->id]);
                    }
                }
                
                // حذف السلة الأخرى
                $otherCart->delete();
                
                // إعادة حساب الإجماليات
                return $this->calculateTotals();
            });
        } catch (\Exception $e) {
            Log::error('Cart merge error: ' . $e->getMessage());
            throw $e;
        }
    }

    // تحويل السلة إلى مصفوفة للطلب
    public function toOrderArray()
    {
        return [
            'items' => $this->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->quantity * $item->price,
                ];
            })->toArray(),
            'total_items' => $this->total_items,
            'total_price' => $this->total_price,
        ];
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeOldCarts($query, $days = 30)
    {
        return $query->where('last_activity', '<', now()->subDays($days));
    }
}