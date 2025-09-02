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
        // First, convert the enum to a string to avoid constraints
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_status', 20)->change();
        });

        // Update existing values to match the new format
        DB::table('orders')->where('order_status', 'processing')->update(['order_status' => 'pending']);
        DB::table('orders')->where('order_status', 'shipped')->update(['order_status' => 'pending']);
        DB::table('orders')->where('order_status', 'delivered')->update(['order_status' => 'completed']);
        DB::table('orders')->where('order_status', 'cancelled')->update(['order_status' => 'canceled']);

        // No need to modify 'pending' as it exists in both old and new schemas
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert back existing values to the old format
        DB::table('orders')->where('order_status', 'completed')->update(['order_status' => 'delivered']);
        DB::table('orders')->where('order_status', 'canceled')->update(['order_status' => 'cancelled']);
        DB::table('orders')->where('order_status', 'refunded')->update(['order_status' => 'cancelled']);

        // Convert back to enum with original values
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('order_status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->change();
        });
    }
};
