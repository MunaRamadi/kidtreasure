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
        Schema::create('password_reset_requests', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index(); // البريد الإلكتروني للمستخدم الذي طلب إعادة التعيين
            $table->string('token')->unique(); // الرمز المميز (token) المستخدم لإعادة التعيين
            $table->boolean('is_resolved')->default(false); // حقل جديد لتتبع إذا ما تمت معالجة الطلب
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // ربط الطلب بـ user_id مع السماح بالقيمة الفارغة في حالة حذف المستخدم
            $table->timestamps(); // created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_requests');
    }
};