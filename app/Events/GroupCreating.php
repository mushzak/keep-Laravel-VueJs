<?php

namespace App\Events;

use App\Group;
use Illuminate\Queue\SerializesModels;

class GroupCreating
{
    use SerializesModels;

    /** @var Group */
    public $group;

    /**
     * Create a new event instance.
     *
     * @param \App\Group $group
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
    }
}
