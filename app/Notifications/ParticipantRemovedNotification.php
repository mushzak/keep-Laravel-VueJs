<?php

namespace App\Notifications;

use App\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ParticipantRemovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Participant */
    public $participant;

    /**
     * Create a new notification instance.
     *
     * @param Participant $participant
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
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
            ->subject('You have been removed from our next meeting...')
            ->from(config('mail.from.address'),$this->participant->member->group->name)
            ->markdown('mail.participant-removed', [
                'participant' => $this->participant
            ]);
    }
}
