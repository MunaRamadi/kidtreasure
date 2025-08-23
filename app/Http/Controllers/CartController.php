<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CartController extends Controller
{
    /**
     * عرض صفحة سلة التسوق.
     * يتم تنظيف السلة من العناصر غير الصالحة قبل عرضها.
     */
    public function index()
    {
        try {
            $cart = $this->getOrCreateCart();
            
            // تنظيف السلة من المنتجات التي لم تعد متوفرة أو تغير مخزونها
            $cart->cleanInvalidItems();
            
            // تحديث بيانات العناصر بناءً على أحدث بيانات المنتج
            $cart->refreshItemsData();

            return view('pages.cart.index', compact('cart'));

        } catch (Exception $e) {
            Log::error('Cart index error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ في تحميل سلة التسوق');
        }
    }

    /**
     * إضافة منتج إلى السلة.
     * يتم التحقق من توفر المنتج والمخزون قبل الإضافة.
     */
    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        DB::beginTransaction();
        try {
            $cart = $this->getOrCreateCart();
            $product = Product::findOrFail($validated['product_id']);

            // استخدام الدالة المخصصة في نموذج Cart لإضافة المنتج
            // هذه الدالة تعالج كل حالات التحقق من المخزون والتوفر
            $cart->addItem(
                $product, 
                $validated['quantity']
            );

            DB::commit();

            return $this->returnResponse($request, true, 'تمت إضافة المنتج إلى سلة التسوق بنجاح.', $this->getCartData($cart));

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Add item to cart error: ' . $e->getMessage());
            return $this->returnResponse($request, false, $e->getMessage());
        }
    }

    /**
     * تحديث كمية منتج في السلة باستخدام معرف العنصر.
     */
    public function update(Request $request, $itemId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0|max:100', // min:0 للسماح بالحذف
        ]);

        DB::beginTransaction();
        try {
            $cart = $this->getOrCreateCart();
            $cartItem = $cart->items()->where('id', $itemId)->firstOrFail();

            if ($validated['quantity'] === 0) {
                // إذا كانت الكمية صفر، يتم حذف العنصر
                $cart->removeItem($cartItem->id);
                $message = 'تم إزالة المنتج من سلة التسوق.';
            } else {
                // تحديث الكمية باستخدام الدالة المخصصة في نموذج Cart
                $cart->updateItemQuantity($cartItem->id, $validated['quantity']);
                $message = 'تم تحديث كمية المنتج بنجاح.';
            }

            DB::commit();
            
            // جلب أحدث بيانات السلة بعد التحديث
            $cart->refresh();

            // تجهيز بيانات الاستجابة
            $responseData = $this->getCartData($cart);
            $responseData['item_id'] = $cartItem->id; // Add item ID to response
            $updatedItem = $cart->items()->where('id', $itemId)->first();
            if ($updatedItem) {
                $responseData['item_subtotal'] = number_format($updatedItem->total, 2);
            } else {
                $responseData['item_subtotal'] = '0.00';
            }


            return $this->returnResponse($request, true, $message, $responseData);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Update cart item error: ' . $e->getMessage());
            return $this->returnResponse($request, false, $e->getMessage());
        }
    }

    /**
     * حذف منتج من السلة باستخدام معرف العنصر.
     */
    public function remove(Request $request, $itemId)
    {
        DB::beginTransaction();
        try {
            $cart = $this->getOrCreateCart();
            $cartItem = $cart->items()->where('id', $itemId)->firstOrFail();
            
            // Add item ID to response data
            $itemId = $cartItem->id;
            
            $cart->removeItem($cartItem->id);
            
            DB::commit();
            
            $responseData = $this->getCartData($cart);
            $responseData['item_id'] = $itemId; // Include the item ID in response

            return $this->returnResponse($request, true, 'تم حذف المنتج من سلة التسوق.', $responseData);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Remove item from cart error: ' . $e->getMessage());
            return $this->returnResponse($request, false, $e->getMessage());
        }
    }

    /**
     * حذف جميع منتجات السلة.
     */
    public function clearCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $cart = $this->getOrCreateCart();
            
            // Delete all items from the cart
            $cart->items()->delete();
            
            // Reset cart totals
            $cart->update([
                'total_price' => 0,
                'total_items' => 0
            ]);
            
            DB::commit();
            
            return $this->returnResponse($request, true, 'تم تفريغ السلة بنجاح.', $this->getCartData($cart));

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Clear cart error: ' . $e->getMessage());
            return $this->returnResponse($request, false, $e->getMessage());
        }
    }

    /**
     * تطبيق كوبون خصم على السلة
     */
    public function applyCoupon(Request $request)
    {
        $validated = $request->validate([
            'promo_code' => 'required|string|max:50',
        ]);

        try {
            $cart = $this->getOrCreateCart();
            $promoCode = $validated['promo_code'];
            
            // هنا يمكن إضافة منطق التحقق من الكوبون والخصم
            // مثال: التحقق من وجود الكوبون في قاعدة البيانات وصلاحيته
            
            // حالياً سنعيد رسالة بأن نظام الكوبونات غير مفعل بعد
            $message = 'نظام الكوبونات غير مفعل حالياً. سيتم تفعيله قريباً.';
            
            return $this->returnResponse($request, true, $message, $this->getCartData($cart));
            
        } catch (Exception $e) {
            Log::error('Apply coupon error: ' . $e->getMessage());
            return $this->returnResponse($request, false, 'حدث خطأ أثناء تطبيق الكوبون: ' . $e->getMessage());
        }
    }

    /**
     * الحصول على بيانات السلة المصغرة (Mini Cart) لطلبات AJAX.
     */
    public function miniCart()
    {
        try {
            $cart = $this->getOrCreateCart();
            $cart->refreshItemsData(); // تحديث البيانات قبل إرسالها

            $items = $cart->items->map(function($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'name' => $item->current_product_name, // استخدام الاسم المحدث
                    'quantity' => $item->quantity,
                    'price' => number_format($item->current_product_price, 2), // استخدام السعر المحدث
                    'image' => $item->current_product_image, // استخدام الصورة المحدثة
                    'url' => route('products.show', $item->product),
                    'subtotal' => number_format($item->total, 2)
                ];
            });

            return response()->json([
                'success' => true,
                'total_items' => $cart->total_items,
                'total_price' => number_format($cart->total_price, 2),
                'items' => $items
            ]);

        } catch (Exception $e) {
            Log::error('Mini cart error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'حدث خطأ في تحميل بيانات السلة'], 500);
        }
    }

    /**
     * الحصول على السلة الحالية أو إنشاء واحدة جديدة.
     * يعالج حالات المستخدمين المسجلين والزوار ويدمج السلات عند تسجيل الدخول.
     */
    public function getOrCreateCart()
    {
        $sessionId = Session::getId();
        $user = Auth::user();
        
        $cart = null;

        if ($user) {
            // 1. ابحث عن سلة المستخدم
            $cart = Cart::with('items.product')->where('user_id', $user->id)->first();
            
            // 2. ابحث عن سلة الجلسة (قد تكون للمستخدم قبل تسجيل الدخول)
            $sessionCart = Cart::with('items.product')->where('session_id', $sessionId)->whereNull('user_id')->first();

            if ($sessionCart) {
                if ($cart) {
                    // إذا كان لدى المستخدم سلة بالفعل، قم بدمج سلة الجلسة معها
                    $cart->mergeWith($sessionCart);
                } else {
                    // إذا لم يكن لدى المستخدم سلة، قم بتعيين سلة الجلسة له
                    $sessionCart->assignToUser($user->id);
                    $cart = $sessionCart;
                }
            }
        } else {
            // بالنسبة للزوار، ابحث عن سلة الجلسة
            $cart = Cart::with('items.product')->where('session_id', $sessionId)->first();
        }
        
        // إذا لم يتم العثور على أي سلة، قم بإنشاء واحدة جديدة
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $user->id ?? null,
                'session_id' => $sessionId,
            ]);
        }
        
        // تحديث آخر نشاط للسلة
        $cart->update(['last_activity' => now()]);
        
        return $cart;
    }

    /**
     * دالة مساعدة لتجهيز بيانات السلة للإرسال في الاستجابة.
     */
    protected function getCartData(Cart $cart)
    {
        $cart->refresh(); // التأكد من أن البيانات محدثة
        return [
            'id' => $cart->id,
            'total_items' => $cart->total_items,
            'total_price' => number_format($cart->total_price, 2),
            'subtotal' => number_format($cart->total_price, 2),
            'tax' => number_format(0, 2),
            'total' => number_format($cart->total_price, 2),
            'items' => $cart->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => number_format($item->price, 2),
                    'total' => number_format($item->total, 2),
                    'name' => $item->current_product_name,
                    'image' => $item->current_product_image
                ];
            })
        ];
    }
    
    /**
     * دالة مساعدة لإرجاع الاستجابات بشكل موحد (JSON أو Redirect).
     */
    protected function returnResponse(Request $request, $success, $message, $data = [])
    {
        if ($request->expectsJson() || $request->ajax()) {
            $response = [
                'success' => $success,
                'message' => $message,
            ];
            if (!empty($data)) {
                $response['cart'] = $data;
            }
            return response()->json($response, $success ? 200 : 400);
        }

        $sessionKey = $success ? 'success' : 'error';
        return redirect()->route('cart.index')->with($sessionKey, $message);
    }
}