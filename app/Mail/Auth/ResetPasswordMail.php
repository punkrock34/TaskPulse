<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private string $token, private string $name) {}

    public function build()
    {
        $resetPasswordUrl = route('reset-password.index', ['token' => $this->token]);

        return $this->view('emails.reset-password')
            ->subject('Reset Your Password')
            ->with([
                'resetLink' => $resetPasswordUrl,
                'name' => $this->name,
            ]);
    }
}
