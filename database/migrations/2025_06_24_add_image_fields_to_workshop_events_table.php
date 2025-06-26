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
        Schema::table('workshop_events', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('is_open_for_registration');
            $table->json('gallery_images')->nullable()->after('image_path');
            $table->string('featured_image_path')->nullable()->after('gallery_images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshop_events', function (Blueprint $table) {
            $table->dropColumn('image_path');
            $table->dropColumn('gallery_images');
            $table->dropColumn('featured_image_path');
        });
    }
};
