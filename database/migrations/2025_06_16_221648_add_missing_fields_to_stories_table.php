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
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('stories', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('status');
            }
            
            if (!Schema::hasColumn('stories', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('admin_notes');
            }
            
            if (!Schema::hasColumn('stories', 'reviewed_by')) {
                $table->unsignedBigInteger('reviewed_by')->nullable()->after('reviewed_at');
                $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
            }

            // Ensure other columns exist with proper types
            if (!Schema::hasColumn('stories', 'content_ar')) {
                $table->text('content_ar')->nullable()->after('title_en');
            }
            
            if (!Schema::hasColumn('stories', 'content_en')) {
                $table->text('content_en')->nullable()->after('content_ar');
            }

            // Make sure status has correct default
            if (Schema::hasColumn('stories', 'status')) {
                $table->string('status')->default('pending')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn(['admin_notes', 'reviewed_at', 'reviewed_by']);
        });
    }
};