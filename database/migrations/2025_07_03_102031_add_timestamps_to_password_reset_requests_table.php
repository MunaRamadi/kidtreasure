<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('password_reset_requests', function (Blueprint $table) {
            // أضف عمودي created_at و updated_at
            $table->timestamp('created_at')->nullable()->after('user_id'); // يمكنك تغيير after('user_id') حسب مكان العمود الذي تفضله
            $table->timestamp('updated_at')->nullable()->after('created_at'); // بعد created_at

            // ملاحظة: لجعلها non-nullable لاحقاً، ستحتاج إلى تحديث القيم الموجودة أولاً
            // حالياً، Laravel لا يقوم بملء created_at و updated_at للقيم القديمة تلقائياً عند إضافتها
            // إذا كنت تريدها non-nullable، يجب أن تملأها بقيمة افتراضية (مثلاً Carbon::now()) قبل جعلها non-nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_reset_requests', function (Blueprint $table) {
            // عند التراجع، احذف العمودين
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
};