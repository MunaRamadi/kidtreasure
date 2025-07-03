<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany

class WorkshopEvent extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workshop_events'; // Change this to your actual table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'workshop_id',
        'title',
        'description',
        'event_date',
        'event_time',
        'location',
        'price_jod',
        'max_attendees',
        'current_attendees',
        'is_open_for_registration',
        'image_path',
        'gallery_images',
        'age_group',
        'duration_hours',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'event_time' => 'datetime:H:i', // Cast time to handle easily
            'price_jod' => 'decimal:2',
            'is_open_for_registration' => 'boolean',
            'gallery_images' => 'array',
            'age_group' => 'string',
            'duration_hours' => 'decimal:1',
        ];
    }


    // Relationships

    /**
     * Get the workshop type that the event belongs to.
     */
    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }

    /**
     * Get the registrations for the workshop event.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(WorkshopRegistration::class, 'event_id'); // Explicitly define FK if needed, though convention works here
    }
    
    /**
     * Get the images for the workshop event.
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'workshop_event_id');
    }
    
    /**
     * Get the current number of attendees by counting actual registrations
     * 
     * @return int
     */
    public function getCurrentAttendeesAttribute(): int
    {
        return $this->registrations()->count();
    }
    
    /**
     * Get the URL for adding this event to Google Calendar
     * 
     * @return string
     */
    public function getGoogleCalendarUrl()
    {
        // Format start date and time
        $startDateTime = $this->event_date->format('Ymd') . 'T' . \Carbon\Carbon::parse($this->event_time)->format('His');
        
        // Calculate end date and time by adding duration hours
        $endDateTime = $this->event_date->copy()->addHours((int)$this->duration_hours)->format('Ymd') . 'T' . 
                       \Carbon\Carbon::parse($this->event_time)->addHours((int)$this->duration_hours)->format('His');
        
        // Build the Google Calendar URL with all event details
        return "https://calendar.google.com/calendar/render?" . http_build_query([
            'action' => 'TEMPLATE',
            'text' => $this->title,
            'dates' => $startDateTime . '/' . $endDateTime,
            'details' => strip_tags($this->description ?? ''),
            'location' => $this->location
        ]);
    }
}