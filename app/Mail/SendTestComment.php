<?php

namespace App\Mail;

use App\Test;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTestComment extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Test */
    public $test_comment;

    /**
     * Create a new message instance.
     */
    public function __construct(Test $test_comment)
    {
        $this->test_comment = $test_comment;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('New comment from Gantry Test Comment Page')
            ->view('emails.send-test-comment');
    }
}