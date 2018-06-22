<?php

namespace App\Events;

use App\Invite;
use Illuminate\Queue\SerializesModels;

class InviteCreating
{
    use SerializesModels;

    /**
     * @var Invite
     */
    public $invite;

    /**
     * Create a new event instance.
     *
     * @param Invite $invite
     */
    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
    }
}
