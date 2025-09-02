<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // التصفية حسب الحالة
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        // التصفية حسب حالة الدفع
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // التصفية حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(perPage: 6)->withQueryString();
        
        // Check if we need to highlight a specific order
        $highlightId = $request->query('highlight');
        
        // If we have a highlight ID from a notification, mark related notifications as read
        if ($highlightId) {
            // Mark notifications related to this order as read
            auth()->user()->notifications()
                ->whereJsonContains('data->item_id', (int)$highlightId)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return view('admin.orders.index', compact('orders', 'highlightId'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }
    
    public function edit(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.edit', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,canceled,refunded',
            'payment_status' => 'nullable|in:pending,completed,canceled,refunded',
            'shipping_carrier' => 'nullable|string|max:255',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $updateData = [
            'order_status' => $request->status,
        ];

        if ($request->has('payment_status')) {
            $updateData['payment_status'] = $request->payment_status;
            
            // If payment is completed, set paid_at timestamp
            if ($request->payment_status == Order::STATUS_COMPLETED && !$order->paid_at) {
                $updateData['paid_at'] = now();
            }
            
            // If payment is canceled or refunded, clear paid_at timestamp
            if (in_array($request->payment_status, [Order::STATUS_CANCELED, Order::STATUS_REFUNDED])) {
                $updateData['paid_at'] = null;
            }
        }

        if ($request->has('shipping_carrier')) {
            $updateData['shipping_carrier'] = $request->shipping_carrier;
        }
        
        if ($request->has('tracking_number')) {
            $updateData['tracking_number'] = $request->tracking_number;
        }

        $order->update($updateData);

        // إرسال إشعار للعميل (يمكن إضافة هذه الوظيفة لاحقاً)

        return redirect()->route('admin.orders.index')->with('success', 'تم تحديث معلومات الطلب بنجاح');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,completed,canceled,refunded'
        ]);

        $order->update(['payment_status' => $request->payment_status]);

        return redirect()->route('admin.orders.index')->with('success', 'تم تحديث حالة الدفع بنجاح');
    }
}