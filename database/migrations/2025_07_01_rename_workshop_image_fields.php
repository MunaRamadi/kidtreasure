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
        Schema::table('workshops', function (Blueprint $table) {
            // First rename image_path to image
            $table->renameColumn('image_path', 'image');
            
            // Then drop the other image columns
            $table->dropColumn('gallery_images');
            $table->dropColumn('featured_image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshops', function (Blueprint $table) {
            // First add back the dropped columns
            $table->json('gallery_images')->nullable()->after('image');
            $table->string('featured_image_path')->nullable()->after('gallery_images');
            
            // Then rename image back to image_path
            $table->renameColumn('image', 'image_path');
        });
    }
};
