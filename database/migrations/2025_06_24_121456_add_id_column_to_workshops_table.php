<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // أولاً: التحقق من وجود العمود
        if (!Schema::hasColumn('workshops', 'id')) {
            Schema::table('workshops', function (Blueprint $table) {
                // إضافة عمود ID كمفتاح أساسي في بداية الجدول
                $table->id()->first();
            });
            
            // إذا كان هناك بيانات موجودة، قم بتعبئة الIDs
            $workshops = DB::table('workshops')->get();
            foreach ($workshops as $index => $workshop) {
                DB::table('workshops')
                    ->where('name_ar', $workshop->name_ar) // استخدم عمود فريد للتحديد
                    ->update(['id' => $index + 1]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshops', function (Blueprint $table) {
            if (Schema::hasColumn('workshops', 'id')) {
                $table->dropColumn('id');
            }
        });
    }
};