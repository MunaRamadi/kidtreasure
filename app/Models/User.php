<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',               // تمت الإضافة: حقل رقم الهاتف
        'address',             // تمت الإضافة: حقل العنوان
        'language_preference', // تمت الإضافة: حقل تفضيل اللغة
        'role',                // تمت الإضافة: حقل الدور (user/admin)
        'is_active',           // تمت الإضافة: حقل حالة التفعيل/التعطيل
        'is_admin',            // تمت الإضافة: حقل تحديد ما إذا كان المستخدم مسؤولاً أم لا
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean', // تم التحويل إلى نوع بيانات منطقي
            'is_admin' => 'boolean',  // تم التحويل إلى نوع بيانات منطقي
        ];
    }

    // العلاقات (Relationships)

    /**
     * Get the orders for the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the workshop registrations for the user.
     */
    public function workshopRegistrations(): HasMany
    {
        return $this->hasMany(WorkshopRegistration::class);
    }

    /**
     * Get the stories submitted by the user.
     */
    public function stories(): HasMany
    {
        return $this->hasMany(Story::class);
    }

    /**
     * Get the password reset requests for the user.
     * (إذا كنت تخطط لربط طلبات إعادة تعيين كلمة المرور بالمستخدم)
     */
    public function passwordResetRequests(): HasMany
    {
        return $this->hasMany(PasswordResetRequest::class, 'email', 'email');
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
}