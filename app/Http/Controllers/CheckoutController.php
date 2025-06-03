<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    // عرض صفحة الدفع
    public function index()
    {
        // التحقق من وجود عناصر في السلة
        $cart = app(CartController::class)->getOrCreateCart();
        
        if ($cart->total_items == 0) {
            return redirect()->route('cart.index')->with('error', 'سلة التسوق فارغة');
        }
        
        // عرض صفحة الدفع
        return view('pages.checkout.index', compact('cart'));
    }

    // معالجة عملية الدفع
    public function process(Request $request)
    {
        // التحقق من صحة بيانات الطلب
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'payment_method' => 'required|string|in:cash_on_delivery,credit_card,paypal,bank_transfer',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // جلب السلة الحالية
        $cart = app(CartController::class)->getOrCreateCart();
        
        // التحقق من وجود عناصر في السلة
        if ($cart->total_items == 0) {
            return redirect()->route('cart.index')->with('error', 'سلة التسوق فارغة');
        }

        // تجهيز بيانات الطلب
        $orderData = [
            'shipping_address' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
            ],
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'shipping_method' => $request->shipping_method ?? 'standard',
            'shipping_cost' => $this->calculateShippingCost($request->shipping_method ?? 'standard'),
        ];
        
        // تطبيق كود الخصم إذا كان موجوداً
        if ($request->has('discount_code') && !empty($request->discount_code)) {
            $discountAmount = $this->applyDiscountCode($request->discount_code, $cart->total_price);
            $orderData['discount_code'] = $request->discount_code;
            $orderData['discount_amount'] = $discountAmount;
        }

        // إنشاء الطلب من السلة
        try {
            $order = Order::createFromCart($cart, $orderData);
            
            // معالجة الدفع حسب طريقة الدفع المختارة
            $paymentResult = $this->processPayment($order, $request->payment_method);
            
            if ($paymentResult['success']) {
                // تحديث حالة الدفع إذا نجحت عملية الدفع
                if ($request->payment_method != 'cash_on_delivery') {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'processing',
                    ]);
                }
                
                // إعادة التوجيه إلى صفحة التأكيد
                return redirect()->route('checkout.success', ['order' => $order->id]);
            } else {
                // إعادة التوجيه في حالة فشل الدفع
                return redirect()->route('checkout.failed', ['order' => $order->id])
                                 ->with('error', $paymentResult['message']);
            }
        } catch (\Exception $e) {
            // معالجة الأخطاء
            return back()->with('error', 'حدث خطأ أثناء معالجة الطلب: ' . $e->getMessage())->withInput();
        }
    }

    // صفحة نجاح الطلب
    public function success(Order $order)
    {
        // التحقق من ملكية الطلب
        if (Auth::check() && $order->user_id != Auth::id()) {
            abort(403);
        }
        
        return view('pages.checkout.success', compact('order'));
    }

    // صفحة فشل الطلب
    public function failed(Order $order)
    {
        // التحقق من ملكية الطلب
        if (Auth::check() && $order->user_id != Auth::id()) {
            abort(403);
        }
        
        return view('pages.checkout.failed', compact('order'));
    }

    // حساب تكلفة الشحن
    protected function calculateShippingCost($shippingMethod)
    {
        // يمكنك تخصيص هذه الدالة حسب احتياجات موقعك
        $shippingCosts = [
            'standard' => 5.00,
            'express' => 15.00,
            'free' => 0.00,
        ];
        
        return $shippingCosts[$shippingMethod] ?? 5.00;
    }

    // تطبيق كود الخصم
    protected function applyDiscountCode($code, $totalPrice)
    {
        // هذه مجرد دالة توضيحية. يجب تنفيذ منطق حقيقي للتعامل مع أكواد الخصم
        // مثلاً، التحقق من قاعدة البيانات، صلاحية الكود، إلخ.
        $discountCodes = [
            'WELCOME10' => ['type' => 'percentage', 'value' => 10],
            'SUMMER20' => ['type' => 'percentage', 'value' => 20],
            'FREESHIP' => ['type' => 'fixed', 'value' => 5],
        ];
        
        if (isset($discountCodes[strtoupper($code)])) {
            $discount = $discountCodes[strtoupper($code)];
            
            if ($discount['type'] == 'percentage') {
                return ($totalPrice * $discount['value']) / 100;
            } else {
                return $discount['value'];
            }
        }
        
        return 0;
    }

    // معالجة الدفع
    protected function processPayment($order, $paymentMethod)
    {
        // هذه دالة توضيحية. يجب تنفيذ منطق حقيقي للتعامل مع بوابات الدفع
        switch ($paymentMethod) {
            case 'cash_on_delivery':
                // لا حاجة لمعالجة الدفع في حالة الدفع عند الاستلام
                return [
                    'success' => true,
                    'message' => 'تم تأكيد الطلب. سيتم الدفع عند الاستلام.',
                    'transaction_id' => null
                ];
                
            case 'credit_card':
                // هنا يتم الاتصال ببوابة دفع حقيقية مثل Stripe أو PayTabs
                // هذا مجرد مثال توضيحي
                $transactionId = 'CC-' . uniqid();
                return [
                    'success' => true,
                    'message' => 'تمت عملية الدفع بنجاح',
                    'transaction_id' => $transactionId
                ];
                
            case 'paypal':
                // هنا يتم الاتصال ببوابة PayPal
                $transactionId = 'PP-' . uniqid();
                return [
                    'success' => true,
                    'message' => 'تمت عملية الدفع بنجاح عبر PayPal',
                    'transaction_id' => $transactionId
                ];
                
            case 'bank_transfer':
                // في حالة التحويل البنكي، يتم تأكيد الطلب ويتم التحقق من التحويل لاحقاً
                return [
                    'success' => true,
                    'message' => 'تم تأكيد الطلب. يرجى إكمال التحويل البنكي وإرسال إيصال الدفع.',
                    'transaction_id' => 'BT-' . uniqid()
                ];
                
            default:
                return [
                    'success' => false,
                    'message' => 'طريقة الدفع غير مدعومة',
                    'transaction_id' => null
                ];
        }
    }
}