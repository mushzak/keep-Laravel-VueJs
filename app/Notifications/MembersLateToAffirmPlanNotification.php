<?php

namespace App\Notifications;

use App\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MembersLateToAffirmPlanNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Group */
    protected $group;

    /** @var Collection */
    protected $members;

    /**
     * Create a new notification instance.
     *
     * @param Group $group
     * @param Collection $members
     */
    public function __construct(Group $group, Collection $members)
    {
        $this->group = $group;
        $this->members = $members;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->should_not_notify ? [] : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Members late to affirm plan ...")
            ->from(config('mail.from.address'),$this->group->name)
            ->markdown('mail.members-late-to-affirm-plan', [
                'group' => $this->group,
                'members' => $this->members,
            ]);
    }
}
