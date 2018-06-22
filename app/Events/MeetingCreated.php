<?php

namespace App\Events;

use App\Meeting;
use Illuminate\Queue\SerializesModels;

class MeetingCreated
{
    use SerializesModels;

    /** @var Meeting */
    public $meeting;

    /**
     * Create a new event instance.
     *
     * @param Meeting $meeting
     */
    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
    }
}
