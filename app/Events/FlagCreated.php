<?php

namespace App\Events;

use App\Flag;
use Illuminate\Queue\SerializesModels;

class FlagCreated
{
    use SerializesModels;

    /** @var Flag */
    public $flag;

    /**
     * Create a new event instance.
     *
     * @param \App\Flag $flag
     */
    public function __construct(Flag $flag)
    {
        $this->flag = $flag;
    }
}
