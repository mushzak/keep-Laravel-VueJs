<?php

namespace App\Events;

use App\Group;
use Illuminate\Queue\SerializesModels;


class GroupDeleting 
{
    use SerializesModels;

    /**
     * @var Group
     */
    public $group;

    /**
     * Create a new event instance.
     *
     * @param Group $group
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
    }

}
