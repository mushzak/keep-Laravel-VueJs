<?php

namespace App\Notifications;

use App\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ParticipantMeetingSummaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Meeting */
    public $meeting;

    /**
     * Create a new notification instance.
     *
     * @param Meeting $meeting
     */
    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
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
            ->subject('Meeting summary')
            ->from(config('mail.from.address'),$this->participant->member->group->name)
            ->markdown('mail.participant-meeting-summary', [
                //
            ]);
    }
}
