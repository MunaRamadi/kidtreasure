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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->text('detailed_description')->nullable(); // وصف تفصيلي
            $table->json('contents')->nullable(); // محتويات الصندوق
            $table->decimal('price_jod', 8, 2);
            $table->integer('stock_quantity')->default(0);
            $table->string('image_path')->nullable();
            $table->json('gallery_images')->nullable(); // صور إضافية
            $table->string('video_url')->nullable(); // رابط فيديو
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('category')->nullable(); // نوع الصندوق
            $table->string('age_group')->nullable(); // الفئة العمرية
            $table->json('educational_benefits')->nullable(); // الفوائد التعليمية
            $table->enum('difficulty_level', ['مبتدئ', 'متوسط', 'متقدم'])->default('مبتدئ');
            $table->integer('estimated_time')->nullable(); // الوقت المقدر بالدقائق
            $table->decimal('min_price', 8, 2)->nullable(); // للتصفية
            $table->decimal('max_price', 8, 2)->nullable(); // للتصفية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};