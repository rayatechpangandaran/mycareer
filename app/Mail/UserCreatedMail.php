<?php

namespace App\Mail;
use Illuminate\Mail\Mailable;


class UserCreatedMail extends Mailable
{
    public function __construct(
        public $nama,
        public $email,
        public $password
    ) {}

    public function build()
    {
        return $this->subject('Selamat Bergabung')
            ->view('emails.user_created');
    }
}