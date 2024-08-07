<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private string $token, private string $name) {}

    public function build()
    {
        $verificationUrl = route('verify-email.index', ['token' => $this->token]);

        return $this->view('emails.verify-email')
            ->subject('Verify Your Email Address')
            ->with([
                'verificationUrl' => $verificationUrl,
                'name' => $this->name,
            ]);
    }
}
