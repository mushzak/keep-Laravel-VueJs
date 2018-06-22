<?php

namespace App\Notifications;

use App\Discussion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PrivateDiscussionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Discussion */
    public $discussion;

    /**
     * Create a new notification instance.
     *
     * @param Discussion $discussion
     */
    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
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
            ->subject('You have a private discussion...')
            ->from(config('mail.from.address'),$this->discussion->author->group->name)
            ->markdown('mail.private-discussion', [
                'discussion' => $this->discussion,
            ]);
    }
}
