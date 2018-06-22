<?php

namespace App\Events;

use App\Flag;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FlagUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Flag */
    public $flag;

    /**
     * Create a new event instance.
     *
     * @param Flag $flag
     */
    public function __construct(Flag $flag)
    {
        $this->flag = $flag;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        
        //if($this->flag->flaggable_type="App\Member"){
            return new PrivateChannel("members.{$this->flag->flaggable_id}");
        //}

        //TODO need to broadcast flags for groups or ther flaggable table

    }

}