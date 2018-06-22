<?php

namespace App\Notifications;

use App\Objective;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MemberCompletedObjectiveNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Objective */
    protected $objective;

    /** @var Member */
    protected $member;

    /**
     * Create a new notification instance.
     *
     * @param Objective $objective
     */
    public function __construct(Objective $objective,$facilitator)
    {
        $this->facilitator = $facilitator;
        $this->objective = $objective;
        $this->member = $objective->goal->member;
    }
    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->facilitator->email;
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
            ->subject($this->member->user->name."  completed an objective...")
            ->from(config('mail.from.address'),$this->member->group->name)
            ->markdown('mail.member-completed-objective', [
                'objective' => $this->objective,
                'member' => $this->member,
            ]);
    }
}
