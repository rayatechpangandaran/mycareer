<?php

namespace App\Mail;
use Illuminate\Mail\Mailable;

class ResetPasswordMail extends Mailable
{
    public function __construct(public $token) {}

    public function build()
    {
        return $this->subject('Reset Password')
            ->view('emails.reset_password');
    }
}