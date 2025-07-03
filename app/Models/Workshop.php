<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workshop extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workshops';

    /**
     * The primary key for the model.
     * قم بتغيير هذا إلى اسم المفتاح الأساسي الصحيح في جدولك
     *
     * @var string
     */
    protected $primaryKey = 'id'; // أو 'workshop_id' إذا كان هذا هو اسم المفتاح الأساسي

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

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
        'image_path',
        'gallery_images',
        'featured_image_path',
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
            'gallery_images' => 'array',
        ];
    }

    // Relationships

    /**
     * Get the events for the workshop type.
     */
    public function events(): HasMany
    {
        return $this->hasMany(WorkshopEvent::class, 'workshop_id', $this->primaryKey);
    }
    
    /**
     * Get the images for the workshop.
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'workshop_id', $this->primaryKey);
    }
}