<?php

namespace App\Notifications;

use App\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MeetingParticipantsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Meeting */
    public $meeting;

    /** @var Collection */
    public $accepted;

    /** @var Collection */
    public $declined;

    /** @var Collection */
    public $no_response;

    /**
     * Create a new notification instance.
     *
     * @param Meeting $meeting
     * @param Collection $participants
     */
    public function __construct(Meeting $meeting, Collection $accepted, Collection $declined, Collection $no_response)
    {
        $this->meeting = $meeting;
        $this->accepted = $accepted;
        $this->declined = $declined;
        $this->no_response = $no_response;
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
            ->subject('RSVP Status...')
            ->from(config('mail.from.address'),$this->meeting->group->name)
            ->markdown('mail.meeting-participants', [
                'meeting' => $this->meeting,
                'accepted' => $this->accepted,
                'declined' => $this->declined,
                'no_response' => $this->no_response,

            ]);
    }
}
