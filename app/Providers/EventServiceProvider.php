<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
// استيراد الحدث والمستمع الذي قمنا بتطويره مسبقاً
use Illuminate\Auth\Events\PasswordResetLinkSent; // هذا هو الحدث الذي نحتاجه
use App\Listeners\LogPasswordResetRequest; // هذا هو المستمع الذي قمنا بإنشائه
// Import our new event and listener
use App\Events\OrderCreated;
use App\Listeners\SendOrderCreatedNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * تعيينات الحدث إلى المستمعين للتطبيق.
     * هنا نحدد أن عند وقوع حدث معين (مفتاح المصفوفة)، يجب تشغيل مستمعين معينين (قيم المصفوفة).
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderCreated::class => [
            SendOrderCreatedNotification::class,
        ],
        // هذا هو الجزء الأهم الذي قمنا بإضافته لربط طلبات إعادة تعيين كلمة المرور
        PasswordResetLinkSent::class => [
            LogPasswordResetRequest::class,
        ],
        // إذا كان لديك أي أحداث أو مستمعين آخرين معرفين في مشروعك، أضفهم هنا
    ];

    /**
     * سجل أي أحداث لتطبيقك.
     * هذه الدالة يتم استدعاؤها أثناء بدء تشغيل التطبيق لتسجيل جميع الأحداث.
     */
    public function boot(): void
    {
        // يمكنك إضافة كود هنا إذا كنت بحاجة لتسجيل الأحداث بشكل ديناميكي أو تعاريف إضافية
    }

    /**
     * حدد ما إذا كان يجب اكتشاف الأحداث والمستمعين تلقائيًا.
     * إذا كانت 'true'، سيقوم Laravel بفحص المجلدات تلقائياً عن الأحداث والمستمعين.
     * ولكن عادة ما نفضل 'false' لتحديدها يدوياً للتحكم الأفضل.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}