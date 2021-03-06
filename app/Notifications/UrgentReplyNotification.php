<?php

namespace App\Notifications;

use App\Discussion;
use App\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UrgentReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Reply
     */
    public $reply;

    /**
     * Create a new notification instance.
     *
     * @param Reply $reply
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
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
            ->subject('This is an urgent message...')
            ->from(config('mail.from.address'),$this->reply->author->group->name)
            ->markdown('mail.urgent-reply', [
                'reply' => $this->reply,
            ]);
    }
}
