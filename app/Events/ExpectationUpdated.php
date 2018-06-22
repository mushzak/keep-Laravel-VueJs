<?php

namespace App\Events;

use App\Expectation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ExpectationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Expectation */
    public $expectation;

    /**
     * Create a new event instance.
     *
     * @param Expectation $expectation
     */
    public function __construct(Expectation $expectation)
    {
        $this->expectation = $expectation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("groups.{$this->expectation->group->id}");
    }
}
