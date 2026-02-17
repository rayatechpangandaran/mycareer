<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Lowongan;
use App\Models\User;

class LamaranMasukMail extends Mailable
{
    use SerializesModels;

    public User $pelamar;
    public Lowongan $lowongan;

    public function __construct(User $pelamar, Lowongan $lowongan)
    {
        $this->pelamar  = $pelamar;
        $this->lowongan = $lowongan;
    }

    public function build()
    {
        return $this
            ->subject('Lamaran Baru Masuk - ' . $this->lowongan->judul)
            ->from(
                config('mail.from.address'),
                config('mail.from.name')
            )
            ->replyTo(
                $this->pelamar->email,
                $this->pelamar->name ?? $this->pelamar->nama
            )
            ->view('emails.pelamar.masuk');
    }
}