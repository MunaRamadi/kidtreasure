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
        // Drop the existing table
        Schema::dropIfExists('contact_messages');
        
        // Recreate with proper structure
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id(); // This creates 'id' as primary key
            $table->string('sender_name');
            $table->string('sender_email');
            $table->string('sender_phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->dateTime('submission_date')->useCurrent();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->index(['is_read', 'submission_date']);
            $table->index('sender_email');
            $table->index('submission_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};