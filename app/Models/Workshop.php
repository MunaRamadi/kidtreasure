<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany

class Workshop extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'target_age_group',
        'is_active',
        'is_featured',
        'image',
    ];

     /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    // Relationships

    /**
     * Get the events for the workshop type.
     */
    public function events(): HasMany
    {
        return $this->hasMany(WorkshopEvent::class);
    }
    
    /**
     * Get the images for the workshop.
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}