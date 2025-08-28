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
            // Check if created_at column doesn't exist before adding it
            if (!Schema::hasColumn('password_reset_requests', 'created_at')) {
                $table->timestamp('created_at')->nullable()->after('user_id'); // يمكنك تغيير after('user_id') حسب مكان العمود الذي تفضله
            }
            
            // Check if updated_at column doesn't exist before adding it
            if (!Schema::hasColumn('password_reset_requests', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at'); // بعد created_at
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_reset_requests', function (Blueprint $table) {
            // Only drop columns if they exist
            if (Schema::hasColumn('password_reset_requests', 'created_at')) {
                $table->dropColumn('created_at');
            }
            
            if (Schema::hasColumn('password_reset_requests', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });
    }
};