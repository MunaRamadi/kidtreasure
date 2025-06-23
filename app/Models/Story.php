<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Story extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        'submission_date',
        'status',
        'image_url',
        'video_url',
        'admin_notes',
        'reviewed_at',
        'reviewed_by',
        'is_featured', // للقصص المميزة (الـ 4 بطاقات)
        'display_order', // ترتيب عرض القصص المميزة
        'views_count', // عدد المشاهدات
        'likes_count', // عدد الإعجابات
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'submission_date' => 'datetime',
            'reviewed_at' => 'datetime',
            'child_age' => 'integer',
            'is_featured' => 'boolean',
            'display_order' => 'integer',
            'views_count' => 'integer',
            'likes_count' => 'integer',
        ];
    }

    // Relationships

    /**
     * Get the user that submitted the story.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin user who reviewed the story.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Accessors & Mutators

    /**
     * Get the status label in Arabic.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'في الانتظار',
            'approved' => 'مقبولة',
            'rejected' => 'مرفوضة',
            default => 'غير محدد'
        };
    }

    /**
     * Get the status color for display.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get the story type label.
     */
    public function getStoryTypeLabelAttribute(): string
    {
        return $this->is_featured ? 'قصة مميزة' : 'مرسلة من مستخدم';
    }

    /**
     * Get the content based on locale.
     */
    public function getContentAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && !empty($this->content_en)) {
            return $this->content_en;
        }
        return $this->content_ar ?? $this->content_en ?? '';
    }

    /**
     * Get the title based on locale.
     */
    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && !empty($this->title_en)) {
            return $this->title_en;
        }
        return $this->title_ar ?? $this->title_en ?? '';
    }

    /**
     * Get the full image URL.
     */
    public function getImageFullUrlAttribute(): ?string
    {
        if (!$this->image_url) {
            return null;
        }
        
        // إذا كان الرابط يحتوي على storage/ فهو رابط كامل
        if (str_contains($this->image_url, 'storage/')) {
            return asset($this->image_url);
        }
        
        // وإلا فهو مسار فقط
        return Storage::url($this->image_url);
    }

    /**
     * Get the full video URL.
     */
    public function getVideoFullUrlAttribute(): ?string
    {
        if (!$this->video_url) {
            return null;
        }
        
        // إذا كان الرابط يحتوي على storage/ فهو رابط كامل
        if (str_contains($this->video_url, 'storage/')) {
            return asset($this->video_url);
        }
        
        // وإلا فهو مسار فقط
        return Storage::url($this->video_url);
    }

    /**
     * Get a short excerpt from the content.
     */
    public function getExcerptAttribute(): string
    {
        $content = strip_tags($this->content);
        return mb_substr($content, 0, 150) . (mb_strlen($content) > 150 ? '...' : '');
    }

    /**
     * Check if story has media files.
     */
    public function getHasMediaAttribute(): bool
    {
        return !empty($this->image_url) || !empty($this->video_url);
    }

    /**
     * Get the submission time in a human readable format.
     */
    public function getSubmissionTimeAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get the review time in a human readable format.
     */
    public function getReviewTimeAttribute(): ?string
    {
        return $this->reviewed_at ? $this->reviewed_at->diffForHumans() : null;
    }

    // Scopes

    /**
     * Scope a query to only include approved stories.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending stories.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include rejected stories.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}