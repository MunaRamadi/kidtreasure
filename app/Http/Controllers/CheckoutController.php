<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * عرض صفحة إتمام الطلب
     */
    public function index()
    {
        $cart = app(\App\Http\Controllers\CartController::class)->getOrCreateCart();
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة');
        }
        return view('pages.checkout.index', compact('cart'));
    }

    /**
     * تأكيد الطلب والانتقال لصفحة اختيار الدفع
     */
    public function confirm(Request $request)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string',
            'shipping_method' => 'required|in:standard,express',
            'discount_code' => 'nullable|string',
            'notes' => 'nullable|string|max:1000',
            'terms_accepted' => 'required|accepted',
        ]);

        $cart = app(\App\Http\Controllers\CartController::class)->getOrCreateCart();
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة');
        }

        // حساب التكاليف
        $subtotal = $cart->total_price;
        $shippingCost = $validatedData['shipping_method'] === 'express' ? 15.00 : 5.00;
        $tax = $subtotal * 0.10; // 10% ضريبة
        $discount = 0;

        // التحقق من كود الخصم
        if (!empty($validatedData['discount_code'])) {
            $discount = $this->calculateDiscount($validatedData['discount_code'], $subtotal);
        }

        $total = $subtotal + $shippingCost + $tax - $discount;

        // حفظ بيانات الطلب في الجلسة
        $orderData = [
            'customer_info' => [
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'postal_code' => $validatedData['postal_code'],
                'country' => $validatedData['country'],
            ],
            'shipping_method' => $validatedData['shipping_method'],
            'discount_code' => $validatedData['discount_code'] ?? null,
            'notes' => $validatedData['notes'],
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'tax' => $tax,
            'discount' => $discount,
            'total' => $total,
        ];

        Session::put('order_data', $orderData);

        // الانتقال لصفحة اختيار طريقة الدفع
        return redirect()->route('checkout.payment');
    }

    /**
     * عرض صفحة اختيار طريقة الدفع
     */
    public function payment()
    {
        // التأكد من وجود بيانات الطلب
        $orderData = Session::get('order_data');
        if (!$orderData) {
            return redirect()->route('checkout.index')->with('error', 'يرجى إكمال معلومات الطلب أولاً');
        }

        $cart = app(\App\Http\Controllers\CartController::class)->getOrCreateCart();
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة');
        }

        return view('pages.checkout.payment', compact('orderData', 'cart'));
    }

    /**
     * معالجة اختيار طريقة الدفع
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash_on_delivery,credit_card,cliq'
        ]);

        $orderData = Session::get('order_data');
        if (!$orderData) {
            return redirect()->route('checkout.index')->with('error', 'انتهت صلاحية الجلسة');
        }

        // إضافة طريقة الدفع لبيانات الطلب
        $orderData['payment_method'] = $request->payment_method;
        Session::put('order_data', $orderData);

        // توجيه حسب طريقة الدفع المختارة
        switch ($request->payment_method) {
            case 'cash_on_delivery':
                return $this->processCashOnDelivery();
            case 'credit_card':
                return $this->processCreditCard();
            case 'cliq':
                return $this->processCliq();
            default:
                return redirect()->back()->with('error', 'طريقة دفع غير صحيحة');
        }
    }

    /**
     * معالجة الدفع عند التوصيل
     */
    private function processCashOnDelivery()
    {
        // إنشاء الطلب مباشرة
        $order = $this->createOrder('cash_on_delivery', 'pending');

        // تنظيف الجلسة
        Session::forget(['cart', 'order_data']);

        return redirect()->route('checkout.success', $order->id)
            ->with('success', 'تم إنشاء طلبك بنجاح! سيتم التواصل معك قريباً.');
    }

    /**
     * معالجة الدفع بالبطاقة الائتمانية
     */
    private function processCreditCard()
    {
        // توجيه لصفحة إدخال بيانات البطاقة
        return redirect()->route('checkout.credit-card');
    }

    /**
     * معالجة الدفع عبر CliQ
     */
    private function processCliq()
    {
        // توجيه لصفحة CliQ
        return redirect()->route('checkout.cliq');
    }

    /**
     * إنشاء الطلب في قاعدة البيانات
     */
    private function createOrder($paymentMethod, $status = 'pending')
    {
        $orderData = Session::get('order_data');
        $cart = app(\App\Http\Controllers\CartController::class)->getOrCreateCart();

        // هنا يجب إنشاء الطلب في قاعدة البيانات
        // هذا مثال مبسط - يجب تعديله حسب نموذج البيانات الخاص بك

        /*
        $order = Order::create([
            'user_id' => auth()->id(),
            'first_name' => $orderData['customer_info']['first_name'],
            'last_name' => $orderData['customer_info']['last_name'],
            'email' => $orderData['customer_info']['email'],
            'phone' => $orderData['customer_info']['phone'],
            'address' => $orderData['customer_info']['address'],
            'city' => $orderData['customer_info']['city'],
            'postal_code' => $orderData['customer_info']['postal_code'],
            'country' => $orderData['customer_info']['country'],
            'shipping_method' => $orderData['shipping_method'],
            'payment_method' => $paymentMethod,
            'subtotal' => $orderData['subtotal'],
            'shipping_cost' => $orderData['shipping_cost'],
            'tax' => $orderData['tax'],
            'discount' => $orderData['discount'],
            'total' => $orderData['total'],
            'status' => $status,
            'notes' => $orderData['notes'],
        ]);

        // إضافة منتجات الطلب
        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'total' => $item->product->price * $item->quantity,
            ]);
        }

        return $order;
        */

        // للاختبار - إرجاع كائن وهمي
        return (object) ['id' => 'ORDER_' . time()];
    }

    /**
     * حساب قيمة الخصم
     */
    private function calculateDiscount($discountCode, $subtotal)
    {
        $discountCodes = [
            'WELCOME10' => ['type' => 'percentage', 'value' => 10],
            'SUMMER20' => ['type' => 'percentage', 'value' => 20],
            'FREESHIP' => ['type' => 'fixed', 'value' => 5],
        ];

        $code = strtoupper($discountCode);

        if (!isset($discountCodes[$code])) {
            return 0;
        }

        $discount = $discountCodes[$code];

        if ($discount['type'] === 'percentage') {
            return ($subtotal * $discount['value']) / 100;
            } else {
                return $discount['value'];
            }
        }

    /**
     * صفحة نجاح الطلب
     */
    public function success($orderId)
    {
        return view('pages.checkout.success', compact('orderId'));
    }
}
