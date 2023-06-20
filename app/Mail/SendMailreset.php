<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailreset extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;
    public $route;

    /**
     * Create a new message instance.
     */
    public function __construct($token, $email, $route)
    {
        $this->token = $token;
        $this->email = $email;
        $this->route = $route;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Mailreset',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'Email.passwordReset',
            with: [
                    'token' => $this->token,
                    'email' => $this->email,
                    'route' => $this->route
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
