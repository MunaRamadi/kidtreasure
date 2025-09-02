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
            $table->string('payment_status', 20)->change();
        });

        // Update existing values to match the new format
        DB::table('orders')->where('payment_status', 'paid')->update(['payment_status' => 'completed']);
        DB::table('orders')->where('payment_status', 'failed')->update(['payment_status' => 'canceled']);

        // No need to modify 'pending' as it exists in both old and new schemas
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert back existing values to the old format
        DB::table('orders')->where('payment_status', 'completed')->update(['payment_status' => 'paid']);
        DB::table('orders')->where('payment_status', 'canceled')->update(['payment_status' => 'failed']);
        DB::table('orders')->where('payment_status', 'refunded')->update(['payment_status' => 'failed']);

        // Convert back to enum with original values
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->change();
        });
    }
};
