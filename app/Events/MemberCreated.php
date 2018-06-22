<?php

namespace App\Events;

use App\Member;
use Illuminate\Queue\SerializesModels;

class MemberCreated
{
    use SerializesModels;

    /** @var Member */
    public $member;

    /**
     * Create a new event instance.
     *
     * @param \App\Member $member
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }
}
