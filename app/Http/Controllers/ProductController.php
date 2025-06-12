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
     * عرض صفحة تفاصيل المنتج
     */
    public function show(Product $product)
    {
        // التحقق من أن المنتج نشط
        if (!$product->is_active) {
            abort(404);
        }

        // منتجات مشابهة
        $relatedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->limit(4)
            ->get();

        // إذا لم توجد منتجات مشابهة، اختر منتجات عشوائية
        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::active()
                ->where('id', '!=', $product->id)
                ->inRandomOrder()
                ->limit(4)
                ->get();
        }

        return view('pages.products.show', compact('product', 'relatedProducts'));
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