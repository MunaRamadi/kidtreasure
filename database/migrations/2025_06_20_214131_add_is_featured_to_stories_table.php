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
        Schema::table('stories', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('status');
            $table->integer('display_order')->default(0)->after('is_featured');
            $table->integer('views_count')->default(0)->after('display_order');
            $table->integer('likes_count')->default(0)->after('views_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'display_order', 'views_count', 'likes_count']);
        });
    }
};