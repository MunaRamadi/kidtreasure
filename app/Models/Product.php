<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        'box_type',
        'educational_goals',
        'featured_image_path', 
        'product_image_path',   
        'slug',
        'features',
        'components',
        'skills_developed',
        'material',
        'dimensions'
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
     * تحويل القيم التلقائي للحقول Boolean
     */
    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = $this->convertToBoolean($value);
    }

    public function setIsFeaturedAttribute($value)
    {
        $this->attributes['is_featured'] = $this->convertToBoolean($value);
    }

    /**
     * دالة مساعدة لتحويل القيم إلى boolean
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
     * التحقق من وجود الصورة فعلياً
     */
    private function imageExists($imagePath)
    {
        if (empty($imagePath)) {
            return false;
        }
        
        try {
            return Storage::disk('public')->exists($imagePath);
        } catch (\Exception $e) {
            Log::warning("خطأ في التحقق من وجود الصورة: " . $imagePath, ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * الحصول على صورة المنتج فقط - منفصلة تماماً
     */
    public function getProductImageUrlAttribute()
    {
        if (!empty($this->product_image_path) && $this->imageExists($this->product_image_path)) {
            return asset('storage/' . $this->product_image_path);
        }
        
        return null;
    }

    /**
     * الحصول على صورة الصندوق فقط - منفصلة تماماً
     */
    public function getBoxImageUrlAttribute()
    {
        if (!empty($this->featured_image_path) && $this->imageExists($this->featured_image_path)) {
            return asset('storage/' . $this->featured_image_path);
        }
        
        return null;
    }

    /**
     * الحصول على صورة الصندوق (alias للتوافق مع blade)
     */
    public function getFeaturedImageUrlAttribute()
    {
        return $this->getBoxImageUrlAttribute();
    }

    /**
     * التحقق من وجود صورة المنتج - بدون fallback
     */
    public function getHasProductImageAttribute()
    {
        return !empty($this->product_image_path) && $this->imageExists($this->product_image_path);
    }

    /**
     * التحقق من وجود صورة الصندوق - بدون fallback
     */
    public function getHasBoxImageAttribute()
    {
        return !empty($this->featured_image_path) && $this->imageExists($this->featured_image_path);
    }

    /**
     * التحقق من وجود صورة الصندوق (alias للتوافق مع blade)
     */
    public function getHasFeaturedImageAttribute()
    {
        return $this->getHasBoxImageAttribute();
    }

    /**
     * التحقق من وجود الصورة القديمة
     */
    public function getHasLegacyImageAttribute()
    {
        return !empty($this->image_path) && $this->imageExists($this->image_path);
    }

    /**
     * الحصول على الصورة الرئيسية للعرض العام - مع أولوية منطقية
     */
    public function getMainImageUrlAttribute()
    {
        // أولوية العرض: صورة الصندوق أولاً، ثم صورة المنتج، ثم الصورة القديمة
        if ($this->has_box_image) {
            return $this->box_image_url;
        }
        
        if ($this->has_product_image) {
            return $this->product_image_url;
        }
        
        if ($this->has_legacy_image) {
            return asset('storage/' . $this->image_path);
        }
        
        return asset('images/default-product.jpg');
    }

    /**
     * الحصول على الصورة الافتراضية (للتوافق مع النظام القديم)
     */
    public function getImageUrlAttribute()
    {
        return $this->getMainImageUrlAttribute();
    }

    /**
     * الحصول على معرض الصور مع إضافة كل صورة بشكل منفصل
     */
    public function getGalleryUrlsAttribute()
    {
        $galleryImages = [];
        
        // إضافة صورة الصندوق إلى المعرض إذا كانت موجودة
        if ($this->has_box_image) {
            $galleryImages[] = [
                'url' => $this->box_image_url,
                'type' => 'box',
                'alt' => 'صورة الصندوق: ' . $this->name
            ];
        }
        
        // إضافة صورة المنتج إلى المعرض إذا كانت موجودة
        if ($this->has_product_image) {
            $galleryImages[] = [
                'url' => $this->product_image_url,
                'type' => 'product',
                'alt' => 'صورة المنتج: ' . $this->name
            ];
        }

        // إضافة الصورة القديمة إذا كانت موجودة
        if ($this->has_legacy_image) {
            $galleryImages[] = [
                'url' => asset('storage/' . $this->image_path),
                'type' => 'legacy',
                'alt' => 'صورة: ' . $this->name
            ];
        }
        
        // إضافة صور المعرض الأخرى
        if (!empty($this->gallery_images) && is_array($this->gallery_images)) {
            $additionalImages = collect($this->gallery_images)
                ->filter(function($image) {
                    return !empty($image) && $this->imageExists($image);
                })
                ->map(function($image) {
                    return [
                        'url' => asset('storage/' . $image),
                        'type' => 'gallery',
                        'alt' => 'صورة إضافية: ' . $this->name
                    ];
                })
                ->values()
                ->toArray();
                
            $galleryImages = array_merge($galleryImages, $additionalImages);
        }
        
        return $galleryImages;
    }

    /**
     * الحصول على مصفوفة بسيطة من روابط الصور فقط (للتوافق)
     */
    public function getSimpleGalleryUrlsAttribute()
    {
        $urls = [];
        
        if ($this->has_box_image) {
            $urls[] = $this->box_image_url;
        }
        
        if ($this->has_product_image) {
            $urls[] = $this->product_image_url;
        }

        if ($this->has_legacy_image) {
            $urls[] = asset('storage/' . $this->image_path);
        }
        
        if (!empty($this->gallery_images) && is_array($this->gallery_images)) {
            $additionalUrls = collect($this->gallery_images)
                ->filter(function($image) {
                    return !empty($image) && $this->imageExists($image);
                })
                ->map(function($image) {
                    return asset('storage/' . $image);
                })
                ->values()
                ->toArray();
                
            $urls = array_merge($urls, $additionalUrls);
        }
        
        return array_unique($urls);
    }

    /**
     * دالة للتحقق من نوع الصور المتاحة
     */
    public function getAvailableImageTypesAttribute()
    {
        $types = [];
        
        if ($this->has_box_image) {
            $types[] = 'box';
        }
        
        if ($this->has_product_image) {
            $types[] = 'product';
        }
        
        if ($this->has_legacy_image) {
            $types[] = 'legacy';
        }
        
        return $types;
    }

    /**
     * الحصول على العدد الإجمالي للصور المتاحة
     */
    public function getTotalImagesCountAttribute()
    {
        $count = 0;
        
        if ($this->has_box_image) $count++;
        if ($this->has_product_image) $count++;
        if ($this->has_legacy_image) $count++;
        
        if (!empty($this->gallery_images) && is_array($this->gallery_images)) {
            $count += collect($this->gallery_images)
                ->filter(function($image) {
                    return !empty($image) && $this->imageExists($image);
                })
                ->count();
        }
        
        return $count;
    }

    /**
     * دالة للتحقق من صحة البيانات قبل الحفظ
     */
    public function validateImageData()
    {
        $issues = [];
        
        // التحقق من وجود الملفات
        if (!empty($this->product_image_path) && !$this->imageExists($this->product_image_path)) {
            $issues[] = 'صورة المنتج غير موجودة: ' . $this->product_image_path;
        }
        
        if (!empty($this->featured_image_path) && !$this->imageExists($this->featured_image_path)) {
            $issues[] = 'صورة الصندوق غير موجودة: ' . $this->featured_image_path;
        }

        if (!empty($this->image_path) && !$this->imageExists($this->image_path)) {
            $issues[] = 'الصورة القديمة غير موجودة: ' . $this->image_path;
        }
        
        return $issues;
    }

    /**
     * دالة للتحقق من صحة مسارات الصور (للتشخيص)
     */
    public function debugImagePaths()
    {
        return [
            'product_image_path' => $this->product_image_path,
            'featured_image_path' => $this->featured_image_path,
            'image_path' => $this->image_path,
            'product_image_exists' => $this->has_product_image,
            'featured_image_exists' => $this->has_featured_image,
            'legacy_image_exists' => $this->has_legacy_image,
            'total_images_count' => $this->total_images_count,
            'available_types' => $this->available_image_types,
            'storage_path' => storage_path('app/public'),
            'public_path' => public_path('storage'),
        ];
    }

    // باقي الدوال تبقى كما هي...
    
    /**
     * الحصول على السعر مع العملة
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price_jod, 2) . ' JOD';
    }

    /**
     * الحصول على السعر بالعملة العربية
     */
    public function getFormattedPriceArabicAttribute()
    {
        return number_format($this->price_jod, 2) . ' دينار';
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
     * الحصول على لون حالة المخزون
     */
    public function getStockStatusColorAttribute()
    {
        if ($this->stock_quantity <= 0) {
            return 'danger';
        } elseif ($this->stock_quantity <= 5) {
            return 'warning';
        } else {
            return 'success';
        }
    }

    // باقي الدوال الموجودة...
    public function getBoxTypeArabicAttribute()
    {
        $boxTypes = [
            'innovation' => 'صندوق الابتكار',
            'creativity' => 'صندوق الإبداع',
            'treasure' => 'صندوق الكنز',
            'discovery' => 'صندوق الاستكشاف',
            'science' => 'صندوق العلوم',
            'art' => 'صندوق الفنون'
        ];

        return $boxTypes[$this->box_type] ?? $this->box_type;
    }

    public static function getCategories()
    {
        return self::where('is_active', true)
                   ->whereNotNull('category')
                   ->where('category', '!=', '')
                   ->distinct()
                   ->pluck('category')
                   ->sort()
                   ->values();
    }

    public static function getAgeGroups()
    {
        return self::where('is_active', true)
                   ->whereNotNull('age_group')
                   ->where('age_group', '!=', '')
                   ->distinct()
                   ->pluck('age_group')
                   ->sort()
                   ->values();
    }

    public static function getBoxTypes()
    {
        return self::where('is_active', true)
                   ->whereNotNull('box_type')
                   ->where('box_type', '!=', '')
                   ->distinct()
                   ->pluck('box_type')
                   ->sort()
                   ->values();
    }

    public static function getDifficultyLevels()
    {
        return self::where('is_active', true)
                   ->whereNotNull('difficulty_level')
                   ->where('difficulty_level', '!=', '')
                   ->distinct()
                   ->pluck('difficulty_level')
                   ->sort()
                   ->values();
    }

    // Scopes
    public function scopeByPriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice !== null) {
            $query->where('price_jod', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price_jod', '<=', $maxPrice);
        }
        return $query;
    }

    public function scopeByCategory($query, $category)
    {
        if (!empty($category)) {
            return $query->where('category', $category);
        }
        return $query;
    }

    public function scopeByAgeGroup($query, $ageGroup)
    {
        if (!empty($ageGroup)) {
            return $query->where('age_group', $ageGroup);
        }
        return $query;
    }

    public function scopeByBoxType($query, $boxType)
    {
        if (!empty($boxType)) {
            return $query->where('box_type', $boxType);
        }
        return $query;
    }

    public function scopeByDifficultyLevel($query, $difficultyLevel)
    {
        if (!empty($difficultyLevel)) {
            return $query->where('difficulty_level', $difficultyLevel);
        }
        return $query;
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeLowStock($query, $threshold = 5)
    {
        return $query->where('stock_quantity', '>', 0)
                    ->where('stock_quantity', '<=', $threshold);
    }

    public function scopeSearch($query, $search)
    {
        if (!empty($search)) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('box_type', 'like', "%{$search}%")
                  ->orWhere('age_group', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    public function decrementStock($quantity = 1)
    {
        if ($this->stock_quantity >= $quantity) {
            $this->decrement('stock_quantity', $quantity);
            return true;
        }
        return false;
    }

    public function incrementStock($quantity = 1)
    {
        $this->increment('stock_quantity', $quantity);
        return true;
    }

    public function canOrder($quantity = 1)
    {
        return $this->is_active && $this->stock_quantity >= $quantity;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            // حذف صورة الصندوق
            if ($product->featured_image_path && Storage::disk('public')->exists($product->featured_image_path)) {
                Storage::disk('public')->delete($product->featured_image_path);
            }
            
            // حذف صورة المنتج
            if ($product->product_image_path && Storage::disk('public')->exists($product->product_image_path)) {
                Storage::disk('public')->delete($product->product_image_path);
            }
            
            // حذف الصورة العادية (القديمة)
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            
            // حذف معرض الصور
            if ($product->gallery_images && is_array($product->gallery_images)) {
                foreach ($product->gallery_images as $image) {
                    if (!empty($image) && Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)->where('is_active', true)->firstOrFail();
    }
}