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
        Schema::create('stories', function (Blueprint $table) {
            $table->id('story_id');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('child_name');
            $table->integer('child_age');
            $table->string('parent_name')->nullable();
            $table->string('parent_contact')->nullable();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->text('content_ar');
            $table->text('content_en')->nullable();
            $table->dateTime('submission_date')->useCurrent();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('image_url')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
