<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // عرض سلة التسوق
    public function index()
    {
        $cart = $this->getOrCreateCart();
        return view('pages.cart.index', compact('cart'));
    }

    // إضافة منتج إلى السلة
    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();
        $product = Product::findOrFail($request->product_id);

        // التحقق من توفر المنتج
        if (!$product->is_active || $product->stock_quantity < $request->quantity) {
            return back()->with('error', 'المنتج غير متوفر بالكمية المطلوبة');
        }

        $cart->addItem(
            $request->product_id, 
            $request->quantity, 
            $product->price_jod
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تمت إضافة المنتج إلى سلة التسوق',
                'cart' => [
                    'total_items' => $cart->total_items,
                    'total_price' => $cart->total_price,
                ]
            ]);
        }

        return back()->with('success', 'تمت إضافة المنتج إلى سلة التسوق');
    }

    // تحديث كمية منتج في السلة
    public function updateItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = $this->getOrCreateCart();
        $cartItem = $cart->items()->findOrFail($itemId);
        
        // التحقق من توفر المنتج بالكمية المطلوبة
        $product = Product::findOrFail($cartItem->product_id);
        if ($product->stock_quantity < $request->quantity) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'الكمية المطلوبة غير متوفرة في المخزون'
                ], 422);
            }
            return back()->with('error', 'الكمية المطلوبة غير متوفرة في المخزون');
        }
        
        $cart->updateItemQuantity($itemId, $request->quantity);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث السلة',
                'cart' => [
                    'total_items' => $cart->total_items,
                    'total_price' => $cart->total_price,
                ],
                'item' => [
                    'id' => $cartItem->id,
                    'quantity' => $request->quantity,
                    'subtotal' => $request->quantity * $cartItem->price
                ]
            ]);
        }

        return back()->with('success', 'تم تحديث سلة التسوق');
    }

    // حذف منتج من السلة
    public function removeItem($itemId)
    {
        $cart = $this->getOrCreateCart();
        $cart->removeItem($itemId);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم حذف المنتج من سلة التسوق',
                'cart' => [
                    'total_items' => $cart->total_items,
                    'total_price' => $cart->total_price,
                ]
            ]);
        }

        return back()->with('success', 'تم حذف المنتج من سلة التسوق');
    }

    // تفريغ السلة بالكامل
    public function clearCart()
    {
        $cart = $this->getOrCreateCart();
        $cart->clearItems();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تفريغ سلة التسوق',
                'cart' => [
                    'total_items' => 0,
                    'total_price' => 0,
                ]
            ]);
        }

        return back()->with('success', 'تم تفريغ سلة التسوق');
    }

    // الحصول على السلة الحالية أو إنشاء سلة جديدة
    public function getOrCreateCart()
    {
        // استخدام معرف المستخدم إذا كان مسجلاً، وإلا استخدام معرف الجلسة
        $userId = Auth::id();
        $sessionId = Session::getId();
        
        $cart = null;
        
        if ($userId) {
            // البحث عن سلة نشطة للمستخدم المسجل
            $cart = Cart::where('user_id', $userId)
                        ->where('status', 'active')
                        ->first();
                
            if (!$cart) {
                // البحث عن سلة مرتبطة بمعرف الجلسة الحالية وتحديثها
                $sessionCart = Cart::where('session_id', $sessionId)
                                  ->where('status', 'active')
                                  ->first();
                
                if ($sessionCart) {
                    $sessionCart->update(['user_id' => $userId]);
                    $cart = $sessionCart;
                }
            }
        } else {
            // البحث عن سلة نشطة للجلسة الحالية
            $cart = Cart::where('session_id', $sessionId)
                        ->where('status', 'active')
                        ->first();
        }
        
        // إنشاء سلة جديدة إذا لم يتم العثور على أي سلة
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'status' => 'active',
                'total_items' => 0,
                'total_price' => 0,
                'last_activity' => now(),
            ]);
        }
        
        return $cart;
    }

    // عرض الميني كارت (السلة المصغرة) للاستخدام في AJAX
    public function miniCart()
    {
        $cart = $this->getOrCreateCart();
        return response()->json([
            'total_items' => $cart->total_items,
            'total_price' => $cart->total_price,
            'items' => $cart->items->map(function($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'image' => $item->product_image,
                    'total' => $item->total
                ];
            })
        ]);
    }
}