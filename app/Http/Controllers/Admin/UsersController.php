<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordResetRequest; // إضافة هذا السطر لاستيراد النموذج الجديد
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // إضافة هذا السطر لاستخدام التشفير

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = User::query();

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // التصفية حسب النوع
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        // جلب طلبات إعادة تعيين كلمة المرور المعلقة
        $passwordResetRequests = PasswordResetRequest::with('user') // جلب بيانات المستخدم المرتبطة
                                    ->where('is_resolved', false) // فقط الطلبات غير المعالجة
                                    ->latest()
                                    ->paginate(10, ['*'], 'password_reset_page'); // اسم صفحة مختلف لتجنب التعارض

        return view('admin.users.index', compact('users', 'passwordResetRequests'));
    }

    public function show(User $user)
    {
        $user->load(['orders', 'stories', 'workshopRegistrations']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // تحديث قواعد التحقق من الصحة مع إضافة حقول كلمة المرور والحقول الأخرى
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20', // أضفتها بناءً على نموذجك
            'address' => 'nullable|string|max:255', // أضفتها بناءً على نموذجك
            'language_preference' => 'nullable|string|max:50', // أضفتها بناءً على نموذجك
            'role' => 'required|in:user,admin',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:8|confirmed', // إضافة التحقق من كلمة المرور
        ]);

        // الحصول على جميع البيانات ما عدا حقول كلمة المرور
        $userData = $request->except('password', 'password_confirmation');

        // إذا تم إدخال كلمة مرور جديدة، قم بتشفيرها
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData); // تحديث المستخدم بالبيانات الجديدة

        return redirect()->route('admin.users.index')
            ->with('snackbar', 'تم تحديث المستخدم بنجاح');
    }

    public function destroy(User $user)
    {
        // منع حذف المدير الحالي
        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكن حذف حسابك الخاص');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('snackbar', 'تم حذف المستخدم بنجاح');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        $message = $user->is_active ? 'تم تفعيل المستخدم بنجاح' : 'تم تعطيل المستخدم بنجاح';
        
        return redirect()->route('admin.users.index')
            ->with('snackbar', $message);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'language_preference' => 'nullable|string|max:50',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $userData = $request->except('password', 'password_confirmation');
        $userData['password'] = Hash::make($request->password);
        
        // Set default role as 'user'
        $userData['role'] = 'user';
        
        // Handle is_admin field (convert checkbox to boolean)
        $userData['is_admin'] = $request->has('is_admin');
        
        $user = User::create($userData);

        return redirect()->route('admin.users.index')
            ->with('snackbar', 'تم إنشاء المستخدم ' . $user->name . ' بنجاح');
    }

    // دالة جديدة لمعالجة طلب إعادة تعيين كلمة المرور (وضع علامة كـ "معالج")
    public function resolvePasswordResetRequest(PasswordResetRequest $request)
    {
        $request->update(['is_resolved' => true]);
        return back()->with('snackbar', 'تم وضع علامة على الطلب كتمت معالجته بنجاح.');
    }
}