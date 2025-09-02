<?php

namespace App\Events;

use App\Models\Story;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoryRequestCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The story instance.
     *
     * @var \App\Models\Story
     */
    public $story;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Story  $story
     * @return void
     */
    public function __construct(Story $story)
    {
        $this->story = $story;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('admin-notifications');
    }
}
