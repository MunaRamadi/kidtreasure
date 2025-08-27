<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class WorkshopRegistration extends Model
{
    use HasFactory;

    /**
     * Registration status constants
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELED = 'canceled';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'attendee_name',
        'parent_name',
        'parent_contact',
        'event_id',
        'registration_date',
        'status',
        'payment_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'registration_date' => 'datetime',
        ];
    }

    // Relationships

    /**
     * Get the user that the registration belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the workshop event that the registration belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(WorkshopEvent::class);
    }
    
    /**
     * Get all available statuses with their Arabic translations
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'قيد الانتظار',
            self::STATUS_CONFIRMED => 'تم',
            self::STATUS_CANCELED => 'ملغي',
        ];
    }
    
    /**
     * Get the Arabic translation of the status
     *
     * @return string
     */
    public function getStatusNameAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }
}