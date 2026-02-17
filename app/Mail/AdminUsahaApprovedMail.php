<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class AdminUsahaApprovedMail extends Mailable
{
    public User $user;
    public string $password;

    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Akun Admin Usaha Disetujui')
            ->view('emails.admin_usaha_approved');
    }
}