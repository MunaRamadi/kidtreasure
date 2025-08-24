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
        // التحقق من تسجيل دخول المستخدم
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أو إنشاء حساب لإتمام عملية الشراء');
        }
        
        // التحقق من وجود عناصر في السلة
        $cartController = new \App\Http\Controllers\CartController();
        $cart = $cartController->getOrCreateCart();
        
        if ($cart->total_items == 0) {
            return redirect()->route('cart.index')->with('error', 'سلة التسوق فارغة');
        }
        
        // Check if shipping info exists in session
        if (!session()->has('shipping_info')) {
            return redirect()->route('checkout.shipping')->with('info', 'Please provide your shipping information first');
        }
        
        // Get shipping info from session
        $shippingInfo = session('shipping_info');
        
        // عرض صفحة الدفع
        return view('pages.checkout.index', compact('cart', 'shippingInfo'));
    }

    // Show shipping information page
    public function shipping()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to proceed with checkout');
        }
        
        // Check if cart has items
        $cartController = new \App\Http\Controllers\CartController();
        $cart = $cartController->getOrCreateCart();
        
        if ($cart->total_items == 0) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is empty');
        }
        
        // Get user's previous shipping info if available
        $user = Auth::user();
        $shippingInfo = session('shipping_info', [
            'first_name' => $user->name ?? '',
            'last_name' => '',
            'email' => $user->email ?? '',
            'phone' => $user->phone ?? '',
            'address' => '',
            'city' => '',
            'postal_code' => '',
        ]);
        
        // Show shipping info page
        return view('pages.checkout.shipping', compact('cart', 'shippingInfo'));
    }

    // Store shipping information
    public function storeShipping(Request $request)
    {
        // Validate shipping information
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'shipping_method' => 'required|string|in:standard,express,free',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Store shipping info in session
        $shippingInfo = $request->only([
            'first_name', 'last_name', 'email', 'phone',
            'address', 'city', 'postal_code',
            'shipping_method', 'notes'
        ]);
        
        session(['shipping_info' => $shippingInfo]);
        
        // Redirect to payment page
        return redirect()->route('checkout.index');
    }

    // معالجة عملية الدفع
    public function process(Request $request)
    {
        // التحقق من تسجيل دخول المستخدم
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أو إنشاء حساب لإتمام عملية الشراء');
        }
        
        // التحقق من صحة بيانات الطلب
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|string|in:cash_on_delivery,credit_card,paypal,bank_transfer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // جلب السلة الحالية
        $cartController = new \App\Http\Controllers\CartController();
        $cart = $cartController->getOrCreateCart();
        
        // التحقق من وجود عناصر في السلة
        if ($cart->total_items == 0) {
            return redirect()->route('cart.index')->with('error', 'سلة التسوق فارغة');
        }

        // التحقق من وجود معلومات الشحن
        if (!session()->has('shipping_info')) {
            return redirect()->route('checkout.shipping')->with('error', 'يرجى إدخال معلومات الشحن أولاً');
        }

        $shippingInfo = session('shipping_info');

        // تجهيز بيانات الطلب
        $orderData = [
            'shipping_address' => [
                'first_name' => $shippingInfo['first_name'],
                'last_name' => $shippingInfo['last_name'],
                'email' => $shippingInfo['email'],
                'phone' => $shippingInfo['phone'],
                'address' => $shippingInfo['address'],
                'city' => $shippingInfo['city'],
                'postal_code' => $shippingInfo['postal_code'] ?? null,
            ],
            'payment_method' => $request->payment_method,
            'notes' => $shippingInfo['notes'] ?? '',
            'shipping_method' => $shippingInfo['shipping_method'] ?? 'standard',
            'shipping_cost' => $this->calculateShippingCost($shippingInfo['shipping_method'] ?? 'standard'),
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
            
            // For cash on delivery, redirect to confirmation page
            if ($request->payment_method === 'cash_on_delivery') {
                return redirect()->route('checkout.confirm-cod', ['order' => $order->id]);
            }
            
            // معالجة الدفع حسب طريقة الدفع المختارة
            $paymentResult = $this->processPayment($order, $request->payment_method);
            
            if ($paymentResult['success']) {
                // تحديث حالة الدفع إذا نجحت عملية الدفع
                if ($request->payment_method != 'cash_on_delivery') {
                    $order->update([
                        'payment_status' => 'paid',
                        'order_status' => 'processing',
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
            return redirect()->route('checkout.index')
                             ->with('error', 'حدث خطأ أثناء معالجة طلبك: ' . $e->getMessage());
        }
    }

    // صفحة نجاح الطلب
    public function success(Order $order)
    {
        // التحقق من أن الطلب يخص المستخدم الحالي
        if (Auth::check() && $order->user_id != Auth::id()) {
            abort(403);
        }
        
        return view('pages.checkout.success', compact('order'));
    }

    // صفحة فشل الطلب
    public function failed(Order $order)
    {
        // التحقق من أن الطلب يخص المستخدم الحالي
        if (Auth::check() && $order->user_id != Auth::id()) {
            abort(403);
        }
        
        return view('pages.checkout.failed', compact('order'));
    }

    /**
     * Show the cash on delivery confirmation page
     */
    public function confirmCashOnDelivery(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if (Auth::check() && $order->user_id != Auth::id()) {
            abort(403);
        }
        
        // Check if the order is already confirmed
        if ($order->order_status != 'pending') {
            return redirect()->route('checkout.success', ['order' => $order->id])
                             ->with('info', 'This order has already been confirmed.');
        }
        
        return view('pages.checkout.confirm-cod', compact('order'));
    }
    
    /**
     * Process the cash on delivery confirmation
     */
    public function processCashOnDelivery(Request $request, Order $order)
    {
        // Check if the order belongs to the authenticated user
        if (Auth::check() && $order->user_id != Auth::id()) {
            abort(403);
        }
        
        // Check if the order is already confirmed
        if ($order->order_status != 'pending') {
            return redirect()->route('cart.index')
                             ->with('info', 'This order has already been confirmed.');
        }
        
        // Update order status
        $order->update([
            'order_status' => 'processing',
            'payment_status' => 'pending', // Payment will be collected upon delivery
        ]);
        
        // Clear cart
        $cartController = new \App\Http\Controllers\CartController();
        $cartController->clearCartProgrammatically();
        
        // Clear shipping info from session
        session()->forget('shipping_info');
        
        // Redirect to cart page with success message
        return redirect()->route('cart.index')
                         ->with('success', 'Your order has been confirmed! You will pay upon delivery. Thank you for shopping with us.');
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