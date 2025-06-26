<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
    use HasFactory;

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'post_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'author_id',
        'author_name',
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
        'publication_date',
        'image_url',
        'is_published',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'publication_date' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Get the route key for the model.
     * This tells Laravel to use post_id instead of id for route model binding
     */
    public function getRouteKeyName()
    {
        return 'post_id';
    }

    /**
     * Get the author of the blog post.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Accessor for title (prioritize Arabic, fallback to English)
    public function getTitleAttribute()
    {
        return $this->title_ar ?: $this->title_en;
    }

    // Accessor for content (prioritize Arabic, fallback to English)
    public function getContentAttribute()
    {
        return $this->content_ar ?: $this->content_en;
    }

    // Accessor for featured image
    public function getFeaturedImageAttribute()
    {
        return $this->image_url;
    }

    // Mutator for title (set Arabic version)
    public function setTitleAttribute($value)
    {
        $this->attributes['title_ar'] = $value;
    }

    // Mutator for content (set Arabic version)
    public function setContentAttribute($value)
    {
        $this->attributes['content_ar'] = $value;
    }

    // Mutator for featured image
    public function setFeaturedImageAttribute($value)
    {
        $this->attributes['image_url'] = $value;
    }
}