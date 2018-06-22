<?php

namespace App\Notifications;

use App\Member;
use App\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NeedToAffirmPlanNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Member */
    protected $member;

    /** @var Group */
    protected $group;

    /** @var integer */
    protected $threshold;

    /**
     * Create a new notification instance.
     *
     * @param Member $member
     */
    public function __construct(Member $member, Group $group, $threshold)
    {
        $this->member = $member;
        $this->group=$group;
        $this->threshold = $threshold;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->should_not_notify ? [] : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Are you working your plan?")
            ->from(config('mail.from.address'), $this->group->name)
            ->markdown('mail.need-to-affirm-plan', [
                'member' => $this->member,
                'group' => $this->group,
                'threshold'=>$this->threshold,
            ]);
    }
}
