<?php

namespace App\Events;

use App\Discussion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DiscussionDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Discussion */
    public $discussion;

    /**
     * Create a new event instance.
     *
     * @param Discussion $discussion
     */
    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
      //  return new PrivateChannel("discussions.{$this->discussion->id}");

        return new PrivateChannel("group.{$this->discussion->author->group->id}");
    }

    public function broadcastWith()
    {
        return [
            'discussion' => $this->discussion->loadMissing('author.user')
        ];
    }
}
