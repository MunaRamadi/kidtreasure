<?php

namespace App\Notifications;

use App\Models\Story;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewStoryRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The story instance.
     *
     * @var \App\Models\Story
     */
    protected $story;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Story  $story
     * @return void
     */
    public function __construct(Story $story)
    {
        $this->story = $story;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->story->story_id,
            'type' => 'story_request',
            'title' => $this->story->title_en ?? $this->story->title_ar,
            'child_name' => $this->story->child_name,
            'parent_name' => $this->story->parent_name,
            'created_at' => $this->story->created_at->toIso8601String(),
            'message' => 'New story request from ' . $this->story->parent_name,
            'url' => route('admin.stories.index', ['highlight' => $this->story->story_id])
        ];
    }
}
