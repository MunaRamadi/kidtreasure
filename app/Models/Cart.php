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
        'user_id', 'session_id', 'total_price', 'total_items',
        'status', 'last_activity',
    ];

    protected $casts = [
        'last_activity' => 'datetime', 'total_price' => 'decimal:2',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(CartItem::class); }

    /**
     * إضافة منتج للسلة أو تحديث كميته.
     * يتحقق من كل الشروط قبل تنفيذ العملية.
     */
    public function addItem(Product $product, $quantity = 1)
    {
        if (!$product->is_active) {
            throw new \Exception('عذراً، هذا المنتج غير متوفر حالياً.');
        }

        $cartItem = $this->items()->where('product_id', $product->id)->first();
        $currentQuantity = $cartItem ? $cartItem->quantity : 0;
        $newQuantity = $currentQuantity + $quantity;

        if (!$product->canOrder($newQuantity)) {
            throw new \Exception("الكمية المطلوبة غير متوفرة. المخزون الحالي: {$product->stock_quantity}");
        }

        return DB::transaction(function () use ($product, $newQuantity, $cartItem) {
            if ($cartItem) {
                $cartItem->update(['quantity' => $newQuantity]);
            } else {
                $this->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $newQuantity,
                    'price' => $product->price_jod,
                    'product_name' => $product->name,
                    'product_image' => $product->main_image_url,
                ]);
            }
            return $this->calculateTotals();
        });
    }

    /**
     * تحديث كمية منتج معين في السلة.
     */
    public function updateItemQuantity($cartItemId, $quantity)
    {
        return DB::transaction(function () use ($cartItemId, $quantity) {
            $cartItem = $this->items()->findOrFail($cartItemId);
            
            if (!$cartItem->product->canOrder($quantity)) {
                throw new \Exception("الكمية المطلوبة غير متوفرة. المخزون الحالي: {$cartItem->product->stock_quantity}");
            }
            
            $cartItem->update(['quantity' => $quantity]);
            return $this->calculateTotals();
        });
    }

    /**
     * حذف منتج من السلة.
     */
    public function removeItem($cartItemId)
    {
        return DB::transaction(function () use ($cartItemId) {
            $this->items()->where('id', $cartItemId)->delete();
            return $this->calculateTotals();
        });
    }

    /**
     * تفريغ السلة بالكامل.
     */
    public function clearItems()
    {
        return DB::transaction(function () {
            $this->items()->delete();
            return $this->calculateTotals();
        });
    }

    /**
     * حساب إجماليات السلة (السعر والكمية).
     * هذه الدالة هي المحور الرئيسي للحفاظ على تحديث بيانات السلة.
     */
    public function calculateTotals()
    {
        $totalItems = $this->items()->sum('quantity');
        $totalPrice = $this->items()->with('product')->get()->sum(function ($item) {
            // استخدام سعر المنتج الحالي لضمان الدقة
            $price = $item->product ? $item->product->price_jod : $item->price;
            return $price * $item->quantity;
        });

        $this->update([
            'total_items' => $totalItems ?: 0,
            'total_price' => $totalPrice ?: 0,
            'last_activity' => now(),
        ]);
        return $this;
    }

    /**
     * تنظيف السلة من العناصر غير الصالحة.
     * (منتج محذوف، غير نشط، أو نفد من المخزون)
     */
    public function cleanInvalidItems()
    {
        $invalidItemIds = [];
        $itemsToUpdate = [];

        foreach ($this->items()->with('product')->get() as $item) {
            if (!$item->product || !$item->product->is_active) {
                $invalidItemIds[] = $item->id;
            } elseif ($item->product->stock_quantity < $item->quantity) {
                if ($item->product->stock_quantity > 0) {
                    $itemsToUpdate[] = ['id' => $item->id, 'quantity' => $item->product->stock_quantity];
                } else {
                    $invalidItemIds[] = $item->id;
                }
            }
        }

        if (!empty($invalidItemIds)) {
            $this->items()->whereIn('id', $invalidItemIds)->delete();
        }
        
        if (!empty($itemsToUpdate)) {
            foreach ($itemsToUpdate as $update) {
                $this->items()->find($update['id'])->update(['quantity' => $update['quantity']]);
            }
        }
        
        if (!empty($invalidItemIds) || !empty($itemsToUpdate)) {
            $this->calculateTotals();
        }
    }
    
    /**
     * تحديث بيانات العناصر (السعر، الاسم، الصورة) بناءً على بيانات المنتج الحالية.
     */
    public function refreshItemsData()
    {
        DB::transaction(function () {
            foreach ($this->items()->with('product')->get() as $item) {
                if ($item->product) {
                    $item->updateFromProduct();
                }
            }
        });
        return $this;
    }
    
    /**
     * دمج سلة أخرى (عادة سلة الجلسة) مع السلة الحالية.
     */
    public function mergeWith(Cart $otherCart)
    {
        return DB::transaction(function () use ($otherCart) {
            foreach ($otherCart->items as $otherItem) {
                $this->addItem($otherItem->product, $otherItem->quantity);
            }
            $otherCart->delete();
            return $this->calculateTotals();
        });
    }
    
    /**
     * تعيين السلة لمستخدم معين.
     */
    public function assignToUser($userId)
    {
        $this->update(['user_id' => $userId, 'session_id' => null]);
        return $this;
    }
}