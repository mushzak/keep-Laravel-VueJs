<?php

namespace App\Events;

use App\Participant;
use Illuminate\Queue\SerializesModels;

class ParticipantCreated
{
    use SerializesModels;

    /** @var Participant */
    public $participant;

    /**
     * Create a new event instance.
     *
     * @param Participant $participant
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }
}
