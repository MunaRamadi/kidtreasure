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
        // Check if we're modifying an existing table or creating a new one
        if (Schema::hasTable('products')) {
            // Modifying existing table
            Schema::table('products', function (Blueprint $table) {
                // Only add columns that don't exist
                if (!Schema::hasColumn('products', 'slug')) {
                    $table->string('slug')->unique()->nullable()->after('name');
                }
                // Add other columns as needed
            });
        } else {
            // Creating new table
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2);
                $table->integer('stock')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      // Safe rollback
        Schema::table('products', function (Blueprint $table) {
            // التحقق من وجود كل عمود قبل الحذف
            if (Schema::hasColumn('products', 'box_type')) {
                $table->dropColumn('box_type');
            }
            if (Schema::hasColumn('products', 'box_quantity')) {
                $table->dropColumn('box_quantity');
            }
            if (Schema::hasColumn('products', 'box_price')) {
                $table->dropColumn('box_price');
            }
        });

        
      
    }
};