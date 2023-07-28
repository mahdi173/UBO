<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendPwdWpUser extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $password;
    public $site;


    /**
     * Create a new message instance.
     */
    public function __construct($email, $password, $site)
    {
        $this->email = $email;
        $this->password = $password;
        $this->site = $site;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Pwd Wp User',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'Email.sendPassword',
            with: [
                    'email' => $this->email,
                    'password' => $this->password,
                    'site' => $this->site
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
