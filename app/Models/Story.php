<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

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
}