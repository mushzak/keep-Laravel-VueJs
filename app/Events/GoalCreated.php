<?php

namespace App\Events;

use App\Goal;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GoalCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Goal */
    public $goal;

    /**
     * Create a new event instance.
     *
     * @param Goal $goal
     */
    public function __construct(Goal $goal)
    {
        $this->goal = $goal;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("members.{$this->goal->member->id}");
    }
}
