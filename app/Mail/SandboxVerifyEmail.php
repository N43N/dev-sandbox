<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SandboxVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $email;

    public function __construct($url, $email)
    {
        $this->url = $url;
        $this->email = $email;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📡 Lab Sandbox: Verify Your Email Address',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.sandbox_verify',
        );
    }
}
