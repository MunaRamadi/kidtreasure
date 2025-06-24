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
            // إضافة العمود الجديد بعد عمود 'educational_benefits' لترتيب الحقول
            if (!Schema::hasColumn('products', 'educational_goals')) {
                $table->text('educational_goals')->nullable()->after('educational_benefits');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'educational_goals')) {
                $table->dropColumn('educational_goals');
            }
        });
    }
};