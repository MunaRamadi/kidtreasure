<?php

namespace App\Console\Commands;

use App\Models\WorkshopEvent;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateWorkshopEventStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workshop:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update workshop event statuses based on event date and time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating workshop event statuses...');
        $now = Carbon::now();
        $count = 0;

        try {
            // Get all events
            $events = WorkshopEvent::all();
            
            foreach ($events as $event) {
                $eventDate = Carbon::parse($event->event_date);
                $eventEndTime = (clone $eventDate)->addHours($event->duration_hours);
                $oldStatus = $event->status;
                
                // Determine the new status
                if ($now < $eventDate) {
                    // Event hasn't started yet
                    $newStatus = 'upcoming';
                } elseif ($now >= $eventDate && $now <= $eventEndTime) {
                    // Event is currently happening
                    $newStatus = 'in_progress';
                } else {
                    // Event has ended
                    $newStatus = 'completed';
                }
                
                // Update the status if it has changed
                if ($oldStatus !== $newStatus) {
                    $event->status = $newStatus;
                    $event->save();
                    $count++;
                    
                    $this->info("Updated event #{$event->id} '{$event->title}' from '{$oldStatus}' to '{$newStatus}'");
                }
            }
            
            $this->info("Completed updating statuses. Updated {$count} events.");
            Log::info("Workshop event statuses updated. {$count} events were updated.");
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Error updating workshop event statuses: {$e->getMessage()}");
            Log::error("Error updating workshop event statuses: {$e->getMessage()}");
            
            return Command::FAILURE;
        }
    }
}
