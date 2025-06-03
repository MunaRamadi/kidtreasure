<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('workshop_events', function (Blueprint $table) {
            $table->id('event_id');
            $table->foreignId('workshop_id')->constrained('workshops', 'workshop_id')->cascadeOnDelete();
            $table->date('event_date');
            $table->time('event_time');
            $table->string('location');
            $table->decimal('price_jod', 8, 2);
            $table->integer('max_attendees');
            $table->integer('current_attendees')->default(0);
            $table->boolean('is_open_for_registration')->default(true);
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('workshop_events');
    }
};