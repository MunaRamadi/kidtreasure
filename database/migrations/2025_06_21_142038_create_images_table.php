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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->foreignId('workshop_id')->nullable()->constrained('workshops')->onDelete('cascade');
            $table->foreignId('workshop_event_id')->nullable()->constrained('workshop_events')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->integer('sort_order')->default(0); // For controlling the display order
            $table->boolean('is_main')->default(false); // Flag for main/featured image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
