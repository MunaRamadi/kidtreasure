<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CartController extends Controller
{
    // عرض سلة التسوق
    public function index()
    {
        try {
            $cart = $this->getOrCreateCart();

            // تنظيف العناصر غير الصالحة قبل العرض
            $cart->cleanInvalidItems();

            return view('pages.cart.index', compact('cart'));
        } catch (Exception $e) {
            Log::error('Cart index error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ في تحميل سلة التسوق');
        }
    }

    // إضافة منتج إلى السلة
    public function addItem(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1|max:100', // حد أقصى للكمية
            ]);

            $cart = $this->getOrCreateCart();
            $product = Product::findOrFail($validated['product_id']);

            // التحقق من توفر المنتج وحالته
            if (!$product->is_active) {
                throw new Exception('المنتج غير متوفر حاليًا');
            }

            if ($product->stock_quantity < $validated['quantity']) {
                throw new Exception('المنتج غير متوفر بالكمية المطلوبة');
            }

            // التحقق من الكمية الموجودة في السلة
            $existingItem = $cart->items()->where('product_id', $validated['product_id'])->first();
            $currentQuantityInCart = $existingItem ? $existingItem->quantity : 0;
            $totalQuantityRequested = $currentQuantityInCart + $validated['quantity'];

            if ($product->stock_quantity < $totalQuantityRequested) {
                throw new Exception('الكمية المطلوبة تتجاوز المخزون المتوفر');
            }

            // إضافة العنصر للسلة
            // هذه الدالة (addItem) يجب أن تكون معرفة في نموذج Cart.php
            $cart->addItem(
                $validated['product_id'],
                $validated['quantity'],
                $product->price_jod
            );

            DB::commit();

            $cartData = [
                'total_items' => $cart->total_items,
                'total_price' => $cart->total_price,
            ];

            return $this->returnResponse($request, true, 'تمت إضافة المنتج إلى سلة التسوق', $cartData);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Add item to cart error: ' . $e->getMessage());
            return $this->returnResponse($request, false, $e->getMessage() ?: 'حدث خطأ أثناء إضافة المنتج');
        }
    }

    // تحديث كمية منتج في السلة (تم التعديل هنا)
    public function update(Request $request, $productId) // تم تغيير الاسم من updateItem إلى update وتغيير itemId إلى productId
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:0|max:100', // min:0 للسماح بالحذف عن طريق تعيين الكمية إلى صفر
            ]);

            $cart = $this->getOrCreateCart();

            // نبحث عن عنصر السلة باستخدام product_id الخاص به
            $cartItem = $cart->items()->where('product_id', $productId)->first();

            if (!$cartItem) {
                throw new Exception('المنتج غير موجود في سلة التسوق');
            }

            // إذا كانت الكمية المطلوبة صفرًا، قم بإزالة العنصر
            if ($validated['quantity'] === 0) {
                $cart->removeItem($cartItem->id); // استخدم معرف عنصر السلة هنا
                DB::commit();
                $cart->refresh(); // تحديث إجماليات السلة بعد الحذف

                $cartData = [
                    'total_items' => $cart->total_items,
                    'total_price' => $cart->total_price,
                ];
                return $this->returnResponse($request, true, 'تم إزالة المنتج من سلة التسوق', $cartData);
            }

            // التحقق من توفر المنتج بالكمية المطلوبة
            $product = Product::findOrFail($cartItem->product_id); // المنتج مرتبط بـ cartItem

            if (!$product->is_active) {
                throw new Exception('المنتج غير متوفر حاليًا');
            }

            if ($product->stock_quantity < $validated['quantity']) {
                throw new Exception("الكمية المطلوبة غير متوفرة في المخزون. الكمية المتوفرة هي: " . $product->stock_quantity);
            }

            // هذه الدالة (updateItemQuantity) يجب أن تكون معرفة في نموذج Cart.php
            $cart->updateItemQuantity($cartItem->id, $validated['quantity']); // استخدم معرف عنصر السلة هنا

            DB::commit();

            // إعادة تحميل البيانات بعد التحديث
            $cart->refresh();
            $cartItem->refresh();

            $responseData = [
                'total_items' => $cart->total_items,
                'total_price' => number_format($cart->total_price, 2), // تنسيق السعر
                'item' => [
                    'id' => $cartItem->id,
                    'quantity' => $cartItem->quantity,
                    'price' => number_format($cartItem->price, 2), // تنسيق سعر العنصر
                    'subtotal' => number_format($cartItem->quantity * $cartItem->price, 2) // تنسيق الإجمالي الفرعي
                ]
            ];

            return $this->returnResponse($request, true, 'تم تحديث السلة', $responseData);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Update cart item error: ' . $e->getMessage());
            return $this->returnResponse($request, false, $e->getMessage() ?: 'حدث خطأ أثناء تحديث السلة');
        }
    }

    // حذف منتج من السلة (تم التعديل هنا)
    public function remove($productId) // تم تغيير الاسم من removeItem إلى remove وتغيير itemId إلى productId
    {
        DB::beginTransaction();

        try {
            $cart = $this->getOrCreateCart();

            // البحث عن عنصر السلة باستخدام product_id الخاص به
            $cartItem = $cart->items()->where('product_id', $productId)->first();

            if (!$cartItem) {
                throw new Exception('المنتج غير موجود في سلة التسوق');
            }

            // هذه الدالة (removeItem) يجب أن تكون معرفة في نموذج Cart.php
            $cart->removeItem($cartItem->id); // استخدم معرف عنصر السلة هنا

            DB::commit();

            $cartData = [
                'total_items' => $cart->total_items,
                'total_price' => $cart->total_price,
            ];

            return $this->returnResponse(request(), true, 'تم حذف المنتج من سلة التسوق', $cartData);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Remove item from cart error: ' . $e->getMessage());
            return $this->returnResponse(request(), false, $e->getMessage() ?: 'حدث خطأ أثناء حذف المنتج');
        }
    }

    // تفريغ السلة بالكامل
    public function clearCart()
    {
        DB::beginTransaction();

        try {
            $cart = $this->getOrCreateCart();
            // هذه الدالة (clearItems) يجب أن تكون معرفة في نموذج Cart.php
            $cart->clearItems();

            DB::commit();

            $cartData = [
                'total_items' => 0,
                'total_price' => 0,
            ];

            return $this->returnResponse(request(), true, 'تم تفريغ سلة التسوق', $cartData);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Clear cart error: ' . $e->getMessage());
            return $this->returnResponse(request(), false, $e->getMessage() ?: 'حدث خطأ أثناء تفريغ السلة');
        }
    }

    // الحصول على السلة الحالية أو إنشاء سلة جديدة
    public function getOrCreateCart()
    {
        try {
            // استخدام معرف المستخدم إذا كان مسجلاً، وإلا استخدام معرف الجلسة
            $userId = Auth::id();
            $sessionId = Session::getId();

            $cart = null;

            if ($userId) {
                // البحث عن سلة نشطة للمستخدم المسجل
                $cart = Cart::with('items.product')
                    ->where('user_id', $userId)
                    ->where('status', 'active')
                    ->first();

                if (!$cart) {
                    // البحث عن سلة مرتبطة بمعرف الجلسة الحالية وتحديثها
                    $sessionCart = Cart::with('items.product')
                        ->where('session_id', $sessionId)
                        ->where('status', 'active')
                        ->first();

                    if ($sessionCart) {
                        $sessionCart->update(['user_id' => $userId]);
                        $cart = $sessionCart;
                    }
                }
            } else {
                // البحث عن سلة نشطة للجلسة الحالية
                $cart = Cart::with('items.product')
                    ->where('session_id', $sessionId)
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
            } else {
                // تحديث آخر نشاط للسلة الموجودة
                $cart->update(['last_activity' => now()]);
            }

            return $cart;

        } catch (Exception $e) {
            Log::error('Get or create cart error: ' . $e->getMessage());
            // في حالة الخطأ، إنشاء سلة جديدة كحل بديل
            return Cart::create([
                'user_id' => Auth::id(),
                'session_id' => Session::getId(),
                'status' => 'active',
                'total_items' => 0,
                'total_price' => 0,
                'last_activity' => now(),
            ]);
        }
    }

    // عرض الميني كارت (السلة المصغرة) للاستخدام في AJAX
    public function miniCart()
    {
        try {
            $cart = $this->getOrCreateCart();

            return response()->json([
                'success' => true,
                'total_items' => $cart->total_items,
                'total_price' => number_format($cart->total_price, 2),
                'items' => $cart->items->map(function($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product_id, // إضافة product_id هنا لسهولة التعامل في JS
                        'name' => $item->product_name,
                        'quantity' => $item->quantity,
                        'price' => number_format($item->price, 2),
                        'image' => $item->product_image,
                        'total' => number_format($item->total, 2)
                    ];
                })
            ]);

        } catch (Exception $e) {
            Log::error('Mini cart error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحميل بيانات السلة'
            ], 500);
        }
    }

    // دالة مساعدة لإرجاع الاستجابات
    protected function returnResponse($request, $success, $message, $data = [])
    {
        $response = [
            'success' => $success,
            'message' => $message
        ];

        if ($success && !empty($data)) {
            $response['cart'] = $data;

            // إضافة بيانات العنصر إذا كانت موجودة (خاصة بالتحديث)
            if (isset($data['item'])) {
                $response['item'] = $data['item'];
            }
        }

        if ($request->ajax()) {
            // حالة 422 (Unprocessable Entity) لرسائل الخطأ
            return response()->json($response, $success ? 200 : 422);
        }

        $sessionKey = $success ? 'success' : 'error';
        return back()->with($sessionKey, $message);
    }
}