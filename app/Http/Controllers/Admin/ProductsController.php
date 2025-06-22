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
                  ->orWhere('box_type', 'like', "%{$search}%")
                  ->orWhere('age_group', 'like', "%{$search}%");
            });
        }

        // التصفية حسب الحالة
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // التصفية حسب نوع الصندوق
        if ($request->filled('box_type')) {
            $query->where('box_type', $request->box_type);
        }

        // التصفية حسب الفئة العمرية
        if ($request->filled('age_group')) {
            $query->where('age_group', $request->age_group);
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $boxTypes = $this->getBoxTypes();
        $ageGroups = Product::distinct()->pluck('age_group')->filter();

        return view('admin.products.index', compact('products', 'boxTypes', 'ageGroups'));
    }

    public function create()
    {
        $boxTypes = $this->getBoxTypes();
        $ageGroups = Product::distinct()->pluck('age_group')->filter();
        $difficultyLevels = $this->getDifficultyLevels();
        
        return view('admin.products.create', compact('boxTypes', 'ageGroups', 'difficultyLevels'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'detailed_description' => 'nullable|string',
            'description' => 'required|string',
            'box_type' => 'required|string|in:innovation,creativity,treasure,discovery,science,art',
            'age_group' => 'required|string|max:50',
            'difficulty_level' => 'required|in:مبتدئ,متوسط,متقدم',
            'price_jod' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'contents' => 'nullable|string',
             'features' => 'nullable|string',             // -- ADDED --
            'components' => 'nullable|string',            // -- ADDED --
            'skills_developed' => 'nullable|string',      // -- ADDED --
            'educational_benefits' => 'nullable|string',  // -- ADDED --
            'material' => 'nullable|string|max:255',      // -- ADDED --
            'dimensions' => 'nullable|string|max:255',    // -- ADDED --
            'educational_goals' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|in:0,1,true,false,on',
            'is_featured' => 'nullable|in:0,1,true,false,on',
        ], [
            'name.required' => 'اسم الصندوق مطلوب',
            'name.max' => 'اسم الصندوق لا يجب أن يتجاوز 255 حرف',
            'description.required' => 'وصف الصندوق مطلوب',
            'box_type.required' => 'نوع الصندوق مطلوب',
            'box_type.in' => 'نوع الصندوق المحدد غير صحيح',
            'age_group.required' => 'الفئة العمرية مطلوبة',
            'difficulty_level.required' => 'مستوى الصعوبة مطلوب',
            'difficulty_level.in' => 'مستوى الصعوبة المحدد غير صحيح',
            'price_jod.required' => 'السعر مطلوب',
            'price_jod.numeric' => 'السعر يجب أن يكون رقم',
            'price_jod.min' => 'السعر لا يمكن أن يكون أقل من صفر',
            'stock_quantity.required' => 'كمية المخزون مطلوبة',
            'stock_quantity.integer' => 'كمية المخزون يجب أن تكون رقم صحيح',
            'stock_quantity.min' => 'كمية المخزون لا يمكن أن تكون أقل من صفر',
            'featured_image.image' => 'الملف المرفوع يجب أن يكون صورة (صورة الصندوق)',
            'featured_image.mimes' => 'نوع صورة الصندوق يجب أن يكون: jpeg, png, jpg, gif',
            'featured_image.max' => 'حجم صورة الصندوق لا يجب أن يتجاوز 2 ميجابايت',
            'product_image.image' => 'الملف المرفوع يجب أن يكون صورة (صورة المنتج)',
            'product_image.mimes' => 'نوع صورة المنتج يجب أن يكون: jpeg, png, jpg, gif',
            'product_image.max' => 'حجم صورة المنتج لا يجب أن يتجاوز 2 ميجابايت',
        ]);

      $productData = [
    'name' => $validatedData['name'],
    'description' => $validatedData['description'],
    'detailed_description' => $validatedData['detailed_description'] ?? '', // مضاف
    'box_type' => $validatedData['box_type'],
    'age_group' => $validatedData['age_group'],
    'difficulty_level' => $validatedData['difficulty_level'],
    'price_jod' => $validatedData['price_jod'],
    'stock_quantity' => $validatedData['stock_quantity'],
    'contents' => $validatedData['contents'] ?? '',
    'features' => $validatedData['features'] ?? '', // مضاف
    'components' => $validatedData['components'] ?? '', // مضاف
    'skills_developed' => $validatedData['skills_developed'] ?? '', // مضاف
    'educational_benefits' => $validatedData['educational_benefits'] ?? '', // مضاف
    'material' => $validatedData['material'] ?? '', // مضاف
    'dimensions' => $validatedData['dimensions'] ?? '', // مضاف
    'educational_goals' => $validatedData['educational_goals'] ?? '',
    'is_active' => $this->convertToBoolean($request->input('is_active')),
    'is_featured' => $this->convertToBoolean($request->input('is_featured')),
    'slug' => $this->generateUniqueSlug($validatedData['name']),
];
        

        try {
            // رفع صورة الصندوق (featured_image)
            if ($request->hasFile('featured_image')) {
                $featuredImage = $request->file('featured_image');
                $featuredImageName = 'box_' . time() . '_' . uniqid() . '.' . $featuredImage->getClientOriginalExtension();
                $productData['featured_image_path'] = $featuredImage->storeAs('products/boxes', $featuredImageName, 'public');
            }

            // رفع صورة المنتج (product_image)
            if ($request->hasFile('product_image')) {
                $productImage = $request->file('product_image');
                $productImageName = 'product_' . time() . '_' . uniqid() . '.' . $productImage->getClientOriginalExtension();
                $productData['product_image_path'] = $productImage->storeAs('products/items', $productImageName, 'public');
            }

            // التحقق من عدم تطابق الصورتين
            if (isset($productData['featured_image_path']) && isset($productData['product_image_path'])) {
                if ($productData['featured_image_path'] === $productData['product_image_path']) {
                    throw new \Exception('لا يمكن أن تكون صورة الصندوق وصورة المنتج متطابقتين');
                }
            }

            $product = Product::create($productData);
            
            return redirect()->route('admin.products.index')
                ->with('success', 'تم إضافة الصندوق التعليمي بنجاح');
                
        } catch (\Exception $e) {
            // حذف الصور في حالة فشل إنشاء المنتج
            if (isset($productData['featured_image_path']) && Storage::disk('public')->exists($productData['featured_image_path'])) {
                Storage::disk('public')->delete($productData['featured_image_path']);
            }
            if (isset($productData['product_image_path']) && Storage::disk('public')->exists($productData['product_image_path'])) {
                Storage::disk('public')->delete($productData['product_image_path']);
            }
            
            return back()->withErrors(['error' => 'حدث خطأ أثناء حفظ البيانات: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $boxTypes = $this->getBoxTypes();
        $ageGroups = Product::distinct()->pluck('age_group')->filter();
        $difficultyLevels = $this->getDifficultyLevels();
        
        return view('admin.products.edit', compact('product', 'boxTypes', 'ageGroups', 'difficultyLevels'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'box_type' => 'required|string|in:innovation,creativity,treasure,discovery,science,art',
            'age_group' => 'required|string|max:50',
            'difficulty_level' => 'required|in:مبتدئ,متوسط,متقدم',
            'price_jod' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'features' => 'nullable|string',             // -- ADDED --
            'components' => 'nullable|string',            // -- ADDED --
            'skills_developed' => 'nullable|string',      // -- ADDED --
            'educational_benefits' => 'nullable|string',  // -- ADDED --
            'material' => 'nullable|string|max:255',      // -- ADDED --
            'dimensions' => 'nullable|string|max:255',    // -- ADDED --
              'detailed_description' => 'nullable|string', // -- ADDED --
            'contents' => 'nullable|string',
            'educational_goals' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|in:0,1,true,false,on',
            'is_featured' => 'nullable|in:0,1,true,false,on',
        ], [
            'name.required' => 'اسم الصندوق مطلوب',
            'name.max' => 'اسم الصندوق لا يجب أن يتجاوز 255 حرف',
            'description.required' => 'وصف الصندوق مطلوب',
            'box_type.required' => 'نوع الصندوق مطلوب',
            'box_type.in' => 'نوع الصندوق المحدد غير صحيح',
            'age_group.required' => 'الفئة العمرية مطلوبة',
            'difficulty_level.required' => 'مستوى الصعوبة مطلوب',
            'difficulty_level.in' => 'مستوى الصعوبة المحدد غير صحيح',
            'price_jod.required' => 'السعر مطلوب',
            'price_jod.numeric' => 'السعر يجب أن يكون رقم',
            'price_jod.min' => 'السعر لا يمكن أن يكون أقل من صفر',
            'stock_quantity.required' => 'كمية المخزون مطلوبة',
            'stock_quantity.integer' => 'كمية المخزون يجب أن تكون رقم صحيح',
            'stock_quantity.min' => 'كمية المخزون لا يمكن أن تكون أقل من صفر',
            'featured_image.image' => 'الملف المرفوع يجب أن يكون صورة (صورة الصندوق)',
            'featured_image.mimes' => 'نوع صورة الصندوق يجب أن يكون: jpeg, png, jpg, gif',
            'featured_image.max' => 'حجم صورة الصندوق لا يجب أن يتجاوز 2 ميجابايت',
            'product_image.image' => 'الملف المرفوع يجب أن يكون صورة (صورة المنتج)',
            'product_image.mimes' => 'نوع صورة المنتج يجب أن يكون: jpeg, png, jpg, gif',
            'product_image.max' => 'حجم صورة المنتج لا يجب أن يتجاوز 2 ميجابايت',
        ]);

        $productData = [
    'name' => $validatedData['name'],
    'description' => $validatedData['description'],
    'detailed_description' => $validatedData['detailed_description'] ?? '', // مضاف
    'box_type' => $validatedData['box_type'],
    'age_group' => $validatedData['age_group'],
    'difficulty_level' => $validatedData['difficulty_level'],
    'price_jod' => $validatedData['price_jod'],
    'stock_quantity' => $validatedData['stock_quantity'],
    'contents' => $validatedData['contents'] ?? '',
    'features' => $validatedData['features'] ?? '', // مضاف
    'components' => $validatedData['components'] ?? '', // مضاف
    'skills_developed' => $validatedData['skills_developed'] ?? '', // مضاف
    'educational_benefits' => $validatedData['educational_benefits'] ?? '', // مضاف
    'material' => $validatedData['material'] ?? '', // مضاف
    'dimensions' => $validatedData['dimensions'] ?? '', // مضاف
    'educational_goals' => $validatedData['educational_goals'] ?? '',
    'is_active' => $this->convertToBoolean($request->input('is_active')),
    'is_featured' => $this->convertToBoolean($request->input('is_featured')),
];

        // تحديث slug إذا تغير الاسم
        if ($validatedData['name'] !== $product->name) {
            $productData['slug'] = $this->generateUniqueSlug($validatedData['name'], $product->id);
        }

        try {
            $oldFeaturedImage = null;
            $oldProductImage = null;

            // رفع صورة الصندوق الجديدة
            if ($request->hasFile('featured_image')) {
                $oldFeaturedImage = $product->featured_image_path;
                $featuredImage = $request->file('featured_image');
                $featuredImageName = 'box_' . time() . '_' . uniqid() . '.' . $featuredImage->getClientOriginalExtension();
                $productData['featured_image_path'] = $featuredImage->storeAs('products/boxes', $featuredImageName, 'public');
            }

            // رفع صورة المنتج الجديدة
            if ($request->hasFile('product_image')) {
                $oldProductImage = $product->product_image_path;
                $productImage = $request->file('product_image');
                $productImageName = 'product_' . time() . '_' . uniqid() . '.' . $productImage->getClientOriginalExtension();
                $productData['product_image_path'] = $productImage->storeAs('products/items', $productImageName, 'public');
            }

            // التحقق من عدم تطابق الصورتين
            $finalFeaturedPath = $productData['featured_image_path'] ?? $product->featured_image_path;
            $finalProductPath = $productData['product_image_path'] ?? $product->product_image_path;
            
            if ($finalFeaturedPath && $finalProductPath && $finalFeaturedPath === $finalProductPath) {
                throw new \Exception('لا يمكن أن تكون صورة الصندوق وصورة المنتج متطابقتين');
            }

            $product->update($productData);
            
            // حذف الصور القديمة بعد النجاح
            if ($oldFeaturedImage && Storage::disk('public')->exists($oldFeaturedImage)) {
                Storage::disk('public')->delete($oldFeaturedImage);
            }
            if ($oldProductImage && Storage::disk('public')->exists($oldProductImage)) {
                Storage::disk('public')->delete($oldProductImage);
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'تم تحديث الصندوق التعليمي بنجاح');
                
        } catch (\Exception $e) {
            // حذف الصور الجديدة في حالة الفشل
            if (isset($productData['featured_image_path']) && Storage::disk('public')->exists($productData['featured_image_path'])) {
                Storage::disk('public')->delete($productData['featured_image_path']);
            }
            if (isset($productData['product_image_path']) && Storage::disk('public')->exists($productData['product_image_path'])) {
                Storage::disk('public')->delete($productData['product_image_path']);
            }
            
            return back()->withErrors(['error' => 'حدث خطأ أثناء تحديث البيانات: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Product $product)
    {
        try {
            // حذف الصور
            if ($product->featured_image_path && Storage::disk('public')->exists($product->featured_image_path)) {
                Storage::disk('public')->delete($product->featured_image_path);
            }
            
            if ($product->product_image_path && Storage::disk('public')->exists($product->product_image_path)) {
                Storage::disk('public')->delete($product->product_image_path);
            }

            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', 'تم حذف الصندوق التعليمي بنجاح');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'حدث خطأ أثناء حذف الصندوق: ' . $e->getMessage()]);
        }
    }

    public function toggleStatus(Product $product)
    {
        try {
            $product->update(['is_active' => !$product->is_active]);
            
            $status = $product->is_active ? 'مفعل' : 'معطل';
            return back()->with('success', "تم تغيير حالة الصندوق إلى {$status}");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'حدث خطأ أثناء تغيير حالة الصندوق: ' . $e->getMessage()]);
        }
    }

    /**
     * تحويل القيم إلى boolean
     */
    private function convertToBoolean($value)
    {
        if (is_null($value)) {
            return false;
        }
        
        if (is_bool($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            $value = strtolower(trim($value));
            return in_array($value, ['1', 'true', 'on', 'yes'], true);
        }
        
        if (is_numeric($value)) {
            return (bool) $value;
        }
        
        return false;
    }

    /**
     * إنشاء slug فريد
     */
    private function generateUniqueSlug($name, $excludeId = null)
    {
        $slug = Str::slug($name, '-', 'ar');
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = Product::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * الحصول على أنواع الصناديق مع الأسماء العربية
     */
    private function getBoxTypes()
    {
        return [
            'innovation' => 'صندوق الابتكار',
            'creativity' => 'صندوق الإبداع',
            'treasure' => 'صندوق الكنز',
            'discovery' => 'صندوق الاستكشاف',
            'science' => 'صندوق العلوم',
            'art' => 'صندوق الفنون'
        ];
    }

    /**
     * الحصول على مستويات الصعوبة
     */
    private function getDifficultyLevels()
    {
        return [
            'مبتدئ' => 'مبتدئ',
            'متوسط' => 'متوسط',
            'متقدم' => 'متقدم'
        ];
    }

    /**
     * الحصول على إحصائيات المنتجات
     */
    public function getStats()
    {
        return [
            'total' => Product::count(),
            'active' => Product::where('is_active', true)->count(),
            'inactive' => Product::where('is_active', false)->count(),
            'featured' => Product::where('is_featured', true)->count(),
            'low_stock' => Product::where('stock_quantity', '<', 10)->count(),
        ];
    }

    /**
     * البحث المتقدم
     */
    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('box_type')) {
            $query->where('box_type', $request->box_type);
        }

        if ($request->filled('age_group')) {
            $query->where('age_group', $request->age_group);
        }

        if ($request->filled('difficulty_level')) {
            $query->where('difficulty_level', $request->difficulty_level);
        }

        if ($request->filled('price_from')) {
            $query->where('price_jod', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $query->where('price_jod', '<=', $request->price_to);
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->where('stock_quantity', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('stock_quantity', 0);
            } elseif ($request->stock_status === 'low_stock') {
                $query->where('stock_quantity', '>', 0)->where('stock_quantity', '<', 10);
            }
        }

        $products = $query->paginate(15)->withQueryString();

        return response()->json([
            'products' => $products,
            'html' => view('admin.products.partials.products-table', compact('products'))->render()
        ]);
    }
}