<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = Product::query();

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // التصفية حسب الحالة
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // التصفية حسب الفئة
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Product::distinct()->pluck('category')->filter();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Product::getCategories();
        $ageGroups = Product::getAgeGroups();
        
        return view('admin.products.create', compact('categories', 'ageGroups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'age_group' => 'required|string|max:50',
            'difficulty_level' => 'required|in:مبتدئ,متوسط,متقدم',
            'price_jod' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $productData = $request->all();

        // رفع الصورة
        if ($request->hasFile('image')) {
            $productData['image_path'] = $request->file('image')->store('products', 'public');
        }

        // إنشاء slug
        $productData['slug'] = Str::slug($request->name);

        Product::create($productData);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Product::getCategories();
        $ageGroups = Product::getAgeGroups();
        
        return view('admin.products.edit', compact('product', 'categories', 'ageGroups'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'age_group' => 'required|string|max:50',
            'difficulty_level' => 'required|in:مبتدئ,متوسط,متقدم',
            'price_jod' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $productData = $request->all();

        // رفع الصورة الجديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $productData['image_path'] = $request->file('image')->store('products', 'public');
        }

        // تحديث slug إذا تغير الاسم
        if ($request->name !== $product->name) {
            $productData['slug'] = Str::slug($request->name);
        }

        $product->update($productData);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function destroy(Product $product)
    {
        // حذف الصورة
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        
        $status = $product->is_active ? 'مفعل' : 'معطل';
        return back()->with('success', "تم تغيير حالة المنتج إلى {$status}");
    }
}
