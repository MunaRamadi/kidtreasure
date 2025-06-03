<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo if linking to User

class BlogPost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'author_name',
        // 'user_id', // if linking to User
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
            'publication_date' => 'date',
            'is_published' => 'boolean',
        ];
    }

 
}