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
        Schema::table('products', function (Blueprint $table) {
            // Add box_type column if it doesn't exist
            if (!Schema::hasColumn('products', 'box_type')) {
                $table->string('box_type')->nullable()->after('category');
            }
            
            // Add slug column if it doesn't exist (referenced in controller)
            if (!Schema::hasColumn('products', 'slug')) {
                $table->string('slug')->unique()->nullable()->after('name');
            }
            
            // Add educational_goals column if it doesn't exist
            if (!Schema::hasColumn('products', 'educational_goals')) {
                $table->text('educational_goals')->nullable()->after('educational_benefits');
            }
            
            // Add featured_image_path column if it doesn't exist
            if (!Schema::hasColumn('products', 'featured_image_path')) {
                $table->string('featured_image_path')->nullable()->after('image_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['box_type', 'slug', 'educational_goals', 'featured_image_path']);
        });
    }
};