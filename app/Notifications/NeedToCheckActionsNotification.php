<?php

namespace App\Notifications;

use App\Member;
use App\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NeedToCheckActionsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Member */
    protected $member;

    /** @var Group */
    protected $group;

    /**
     * Create a new notification instance.
     *
     * @param Member $member
     */
    public function __construct(Member $member, Group $group)
    {
        $this->member = $member;

        $this->group = $group;
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
            ->subject("You have actions due...")
            ->from(config('mail.from.address'),$this->group->name)
            ->markdown('mail.need-to-check-actions', [
                'member' => $this->member,
                'group' => $this->group,
            ]);
    }
}
