<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'workshop_id',
        'workshop_event_id',
        'product_id',
        'sort_order',
        'is_main'
    ];

    /**
     * Get the workshop that owns the image.
     */
    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    /**
     * Get the workshop event that owns the image.
     */
    public function workshopEvent()
    {
        return $this->belongsTo(WorkshopEvent::class);
    }

    /**
     * Get the product that owns the image.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
