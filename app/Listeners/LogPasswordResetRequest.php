<?php

namespace App\Listeners;

use App\Models\PasswordResetRequest; // استيراد نموذج طلب إعادة تعيين كلمة المرور المخصص
use Illuminate\Auth\Events\PasswordResetLinkSent; // استيراد الحدث الذي سنستمع إليه
use Illuminate\Contracts\Queue\ShouldQueue; // يمكن إزالته إذا لم تكن بحاجة لتشغيله في قائمة الانتظار
use Illuminate\Queue\InteractsWithQueue; // يمكن إزالته إذا لم تكن بحاجة لتشغيله في قائمة الانتظار

class LogPasswordResetRequest
{
    /**
     * قم بإنشاء مستمع الحدث.
     */
    public function __construct()
    {
        //
    }

    /**
     * تعامل مع الحدث.
     *
     * @param  \Illuminate\Auth\Events\PasswordResetLinkSent  $event
     * @return void
     */
public function handle(PasswordResetLinkSent $event): void
    {
        PasswordResetRequest::create([
            'email' => $event->user->email,
            // 'token' => $event->token, // **قم بإزالة هذا السطر أو التعليق عليه**
            'user_id' => $event->user->id,
            'is_resolved' => false,
        ]);
    }
}
