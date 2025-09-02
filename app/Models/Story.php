<?php

namespace App\Models;

use App\Events\StoryRequestCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Story extends Model
{
    use HasFactory;

    // إضافة هذا السطر لتحديد المفتاح الأساسي
    protected $primaryKey = 'story_id';

    protected $fillable = [
        'user_id',
        'child_name',
        'child_age',
        'parent_name',
        'parent_contact',
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
        'image_url',
        'video_url',
        'submission_date',
        'status',
        'reviewed_at',
        'reviewed_by',
        'admin_notes',
        'is_featured',
        'display_order'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => StoryRequestCreated::class,
    ];

    protected $casts = [
        'submission_date' => 'datetime',
        'reviewed_at' => 'datetime',
        'is_featured' => 'boolean',
        'child_age' => 'integer',
        'display_order' => 'integer'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'submission_date',
        'reviewed_at'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'في الانتظار',
            'approved' => 'مقبولة',
            'rejected' => 'مرفوضة'
        ];
        
        return $labels[$this->status] ?? 'غير محدد';
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger'
        ];
        
        return $colors[$this->status] ?? 'secondary';
    }

    public function getImageFullUrlAttribute()
    {
        if (!$this->image_url) {
            return null;
        }
        
        // إذا كان المسار يحتوي على دومين كامل
        if (str_starts_with($this->image_url, 'http')) {
            return $this->image_url;
        }
        
        // إضافة رابط التخزين
        return asset('storage/' . $this->image_url);
    }

    public function getVideoFullUrlAttribute()
    {
        if (!$this->video_url) {
            return null;
        }
        
        if (str_starts_with($this->video_url, 'http')) {
            return $this->video_url;
        }
        
        return asset('storage/' . $this->video_url);
    }

    public function getHasMediaAttribute()
    {
        return !empty($this->image_url) || !empty($this->video_url);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeUserSubmitted($query)
    {
        return $query->where(function($q) {
            $q->where('is_featured', false)->orWhereNull('is_featured');
        });
    }
}