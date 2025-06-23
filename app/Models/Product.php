<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\CartItem;
use App\Models\OrderItem;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'detailed_description',
        'contents',
        'price_jod',
        'stock_quantity',
        'image_path',
        'gallery_images',
        'video_url',
        'is_featured',
        'is_active',
        'category',
        'age_group',
        'educational_benefits',
        'difficulty_level',
        'estimated_time',
        'min_price',
        'max_price',
    ];

    protected $casts = [
        'contents' => 'array',
        'gallery_images' => 'array',
        'educational_benefits' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price_jod' => 'decimal:2',
        'min_price' => 'decimal:2',
        'max_price' => 'decimal:2',
    ];

    /**
     * الصورة الرئيسية للمنتج
     */
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : asset('images/default-product.jpg');
    }

    /**
     * معرض الصور الإضافية
     */
    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery_images) {
            return [];
        }
        
        return collect($this->gallery_images)->map(function($image) {
            return asset('storage/' . $image);
        })->toArray();
    }

    /**
     * Get all images associated with this product
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * الحصول على سعر المنتج
     */
    public function getPriceAttribute()
    {
        return $this->price_jod;
    }

    /**
     * الحصول على السعر مع العملة
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price_jod, 2) . ' JOD';
    }

    /**
     * العلاقة مع عناصر السلة
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * العلاقة مع عناصر الطلبات
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * التحقق من توفر المنتج للبيع
     */
    public function getIsAvailableAttribute()
    {
        return $this->is_active && $this->stock_quantity > 0;
    }

    /**
     * الحصول على حالة المخزون
     */
    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity <= 0) {
            return 'نفد من المخزن';
        } elseif ($this->stock_quantity <= 5) {
            return 'كمية محدودة';
        } else {
            return 'متوفر';
        }
    }

    /**
     * الحصول على الفئات الفريقة
     */
    public static function getCategories()
    {
        return self::where('is_active', true)
                   ->whereNotNull('category')
                   ->distinct()
                   ->pluck('category')
                   ->filter()
                   ->sort()
                   ->values();
    }

    /**
     * الحصول على الفئات العمرية الفريقة
     */
    public static function getAgeGroups()
    {
        return self::where('is_active', true)
                   ->whereNotNull('age_group')
                   ->distinct()
                   ->pluck('age_group')
                   ->filter()
                   ->sort()
                   ->values();
    }

    /**
     * نطاق السعر للتصفية
     */
    public function scopeByPriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice) {
            $query->where('price_jod', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price_jod', '<=', $maxPrice);
        }
        return $query;
    }

    /**
     * نطاق التصفية حسب الفئة
     */
    public function scopeByCategory($query, $category)
    {
        if ($category) {
            return $query->where('category', $category);
        }
        return $query;
    }

    /**
     * نطاق التصفية حسب الفئة العمرية
     */
    public function scopeByAgeGroup($query, $ageGroup)
    {
        if ($ageGroup) {
            return $query->where('age_group', $ageGroup);
        }
        return $query;
    }

    /**
     * نطاق التصفية للمنتجات المميزة
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * نطاق التصفية للمنتجات النشطة
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}