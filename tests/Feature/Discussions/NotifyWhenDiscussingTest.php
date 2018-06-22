<?php

namespace Tests\Feature\Discussions;

use App\Channel;
use App\Discussion;
use App\DiscussionSubscription;
use App\Group;
use App\Notifications\DiscussionWasRepliedToNotification;
use App\Notifications\NewChannelNotification;
use App\Notifications\PrivateDiscussionNotification;
use App\Notifications\PrivateReplyNotification;
use App\Reply;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\WithGroupMembership;

class NotifyWhenDiscussingTest extends TestCase
{
    use RefreshDatabase, WithGroupMembership;

    public function setUp()
    {
        parent::setUp();

        $this->addGroupMembership();
    }

    /** @test */
    public function a_member_should_be_notified_if_their_subscribed_discussion_was_replied_to()
    {
        Notification::fake();

        $discussion = $this->create(Discussion::class, [
            'author_id' => $this->member->id,
            'target_id' => $this->group->id,
            'target_type' => Group::class
        ]);

        $this->create(DiscussionSubscription::class, [
            'discussion_id' => $discussion->id,
            'user_id' => $this->user->id,
        ]);

        $this->create(Reply::class, ['discussion_id' => $discussion->id]);

        Notification::assertSentTo($this->user, DiscussionWasRepliedToNotification::class);
    }

    /** @test */
    public function a_member_should_be_notified_if_they_were_mentioned_in_a_discussion()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function a_member_should_be_notified_if_they_were_mentioned_in_a_reply()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function a_member_should_be_notified_if_they_were_sent_a_private_discussion()
    {
        Notification::fake();

        $privateDiscussion = factory(Discussion::class)->states(['private'])->create();

        Notification::assertSentTo($privateDiscussion->target->user, PrivateDiscussionNotification::class);
    }

    /** @test */
    public function a_member_should_be_notified_if_they_were_sent_a_reply_to_their_private_discussion()
    {
        Notification::fake();

        $privateDiscussion = factory(Discussion::class)->states(['private'])->create();

        factory(Reply::class)->create([
            'discussion_id' => $privateDiscussion->id,
        ]);

        Notification::assertSentTo($privateDiscussion->target->user, PrivateReplyNotification::class);
    }

    /** @test */
    public function a_member_should_be_notified_if_they_were_sent_an_urgent_discussion()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function a_member_should_be_notified_if_they_were_sent_an_urgent_reply()
    {
        $this->markTestIncomplete();
    }
}