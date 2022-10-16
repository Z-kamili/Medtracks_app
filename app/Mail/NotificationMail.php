<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $title;
    private $message;
    private $metadata;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $title, $message, $metadata)
    {
        $this->user = $user;
        $this->title = $title;
        $this->message = $message;
        $this->metadata = $metadata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->markdown('emails.notification', [
                'user' => $this->user,
                'message' => $this->message,
                'metadata' => $this->metadata,
            ]);
    }
}
