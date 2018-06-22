<?php

namespace App\Events;

use App\Agreement;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AgreementDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Agreement */
    public $agreement;

    /**
     * Create a new event instance.
     *
     * @param Agreement $agreement
     */
    public function __construct(Agreement $agreement)
    {
        $this->agreement = $agreement;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("groups.{$this->agreement->group->id}");
    }
}
