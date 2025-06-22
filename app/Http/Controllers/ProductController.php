<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * عرض صفحة الصناديق (Shop) مع التصفية
     */
    public function index(Request $request)
    {
        $query = Product::active();

        // التصفية حسب السعر
        if ($request->filled('min_price')) {
            $query->byPriceRange($request->min_price, null);
        }
        
        if ($request->filled('max_price')) {
            $query->byPriceRange(null, $request->max_price);
        }

        // التصفية حسب نوع الصندوق
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // التصفية حسب الفئة العمرية
        if ($request->filled('age_group')) {
            $query->byAgeGroup($request->age_group);
        }

        // التصفية حسب المستوى
        if ($request->filled('difficulty_level')) {
            $query->where('difficulty_level', $request->difficulty_level);
        }

        // الترتيب
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price_jod', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_jod', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'featured':
                $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy($sortBy, $sortOrder);
        }

        // البحث
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('category', 'like', "%{$searchTerm}%");
            });
        }

        $products = $query->paginate(12)->withQueryString();

        // بيانات التصفية
        $filters = [
            'categories' => Product::getCategories(),
            'age_groups' => Product::getAgeGroups(),
            'difficulty_levels' => ['مبتدئ', 'متوسط', 'متقدم'],
            'price_range' => [
                'min' => Product::active()->min('price_jod'),
                'max' => Product::active()->max('price_jod')
            ]
        ];

        return view('pages.products.index', compact('products', 'filters'));
    }

    /**
     * عرض صفحة تفاصيل المنتج - مُحسَّن
     */
    public function show($product)
    {
        try {
            // البحث عن المنتج بطريقة مرنة
            if (is_numeric($product)) {
                // إذا كان المعرف رقم
                $product = Product::where('id', $product)
                    ->where('is_active', true)
                    ->first();
            } else {
                // إذا كان slug
                $product = Product::where('slug', $product)
                    ->orWhere('id', $product)
                    ->where('is_active', true)
                    ->first();
            }

            // التحقق من وجود المنتج
            if (!$product) {
                abort(404, 'المنتج غير موجود أو غير نشط');
            }

            // تسجيل بيانات المنتج للتشخيص
            \Log::info('Product Show - تفاصيل المنتج:', [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'detailed_description' => $product->detailed_description,
                'difficulty_level' => $product->difficulty_level,
                'estimated_time' => $product->estimated_time,
                'material' => $product->material,
                'dimensions' => $product->dimensions,
                'features' => $product->features,
                'components' => $product->components,
                'skills_developed' => $product->skills_developed,
                'educational_benefits' => $product->educational_benefits,
                'price_jod' => $product->price_jod,
                'stock_quantity' => $product->stock_quantity,
                'category' => $product->category,
                'age_group' => $product->age_group,
                'is_active' => $product->is_active,
                'is_featured' => $product->is_featured,
                'image_paths' => [
                    'main' => $product->image_path,
                    'product' => $product->product_image_path,
                    'featured' => $product->featured_image_path,
                ],
                'gallery_images' => $product->gallery_images,
            ]);

            // جلب المنتجات ذات الصلة
            $relatedProducts = Product::where('category', $product->category)
                ->where('is_active', true)
                ->where('id', '!=', $product->id)
                ->limit(3)
                ->get();

            // تسجيل المنتجات ذات الصلة
            \Log::info('Related Products Count:', ['count' => $relatedProducts->count()]);

            return view('pages.products.show', compact('product', 'relatedProducts'));

        } catch (\Exception $e) {
            \Log::error('خطأ في عرض المنتج:', [
                'product_identifier' => $product,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            abort(500, 'حدث خطأ في تحميل المنتج');
        }
    }

    /**
     * البحث عن المنتجات (AJAX)
     */
    public function search(Request $request)
    {
        $searchTerm = $request->get('q');
        
        $products = Product::active()
            ->where('name', 'like', "%{$searchTerm}%")
            ->orWhere('description', 'like', "%{$searchTerm}%")
            ->orWhere('category', 'like', "%{$searchTerm}%")
            ->limit(10)
            ->get(['id', 'name', 'price_jod', 'image_path']);

        return response()->json($products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->formatted_price,
                'image' => $product->image_url,
                'url' => route('products.show', $product)
            ];
        }));
    }

    /**
     * الحصول على منتجات الفئة (AJAX)
     */
    public function getByCategory(Request $request, $category)
    {
        $products = Product::active()
            ->byCategory($category)
            ->limit(8)
            ->get(['id', 'name', 'price_jod', 'image_path', 'description']);

        return response()->json($products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->formatted_price,
                'image' => $product->image_url,
                'description' => Str::limit($product->description, 100),
                'url' => route('products.show', $product)
            ];
        }));
    }

    /**
     * المنتجات المميزة
     */
    public function featured()
    {
        $products = Product::active()
            ->featured()
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('pages.products.featured', compact('products'));
    }
}