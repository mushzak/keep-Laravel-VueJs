<?php

namespace App\Notifications;

use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NeedToCheckInNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Member */
    protected $member;

    /**
     * Create a new notification instance.
     *
     * @param Member $member
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
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
            ->subject("We have not heard from you in a while...")
            ->from(config('mail.from.address'),$this->member->group->name)
            ->markdown('mail.need-to-check-in', [
                'member' => $this->member,
            ]);
    }
}
