<?php

namespace App\Http\Controllers;
use App\Models\Product; 
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function index()
    {
        // // مثال: جلب جميع المنتجات النشطة
        $products = Product::where('is_active', true)->get();
        return view('pages.products.index', compact('products'));
       
    }

    
    public function show(Product $product)
    {
        // // مثال: عرض تفاصيل منتج واحد
        if (!$product->is_active) {
            abort(404); 
        }
        return view('pages.products.show', compact('product'));
    }


}