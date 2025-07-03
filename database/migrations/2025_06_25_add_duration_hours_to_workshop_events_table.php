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
        Schema::table('workshop_events', function (Blueprint $table) {
            $table->decimal('duration_hours', 3, 1)->default(2.0)->after('event_time');
            // Drop the duration_minutes column
            $table->dropColumn('duration_minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshop_events', function (Blueprint $table) {
            // Add back duration_minutes if we need to rollback
            $table->integer('duration_minutes')->default(120)->after('event_time');
            $table->dropColumn('duration_hours');
        });
    }
};
