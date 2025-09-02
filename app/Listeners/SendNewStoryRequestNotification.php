<?php

namespace App\Listeners;

use App\Events\StoryRequestCreated;
use App\Models\User;
use App\Notifications\NewStoryRequestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewStoryRequestNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\StoryRequestCreated  $event
     * @return void
     */
    public function handle(StoryRequestCreated $event): void
    {
        $story = $event->story;
        
        // Get all admin users
        $adminUsers = User::where('is_admin', true)->get();
        
        // Notify each admin user
        foreach ($adminUsers as $admin) {
            $admin->notify(new NewStoryRequestNotification($story));
        }
    }
}
