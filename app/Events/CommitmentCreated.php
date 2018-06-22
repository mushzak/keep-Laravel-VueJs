<?php

namespace App\Events;

use App\Commitment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommitmentCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Commitment */
    public $commitment;

    /**
     * Create a new event instance.
     *
     * @param Commitment $commitment
     */
    public function __construct(Commitment $commitment)
    {
        $this->commitment = $commitment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("members.{$this->commitment->member->id}");
    }
}
