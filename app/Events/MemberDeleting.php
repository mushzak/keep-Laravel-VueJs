<?php

namespace App\Events;

use App\Member;
use Illuminate\Queue\SerializesModels;

class MemberDeleting
{
    use SerializesModels;

    /** @var Member */
    public $member;

    /**
     * Create a new event instance.
     *
     * @param Member $member
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }
}