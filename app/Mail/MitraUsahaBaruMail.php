<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MitraUsahaBaruMail extends Mailable
{
     use Queueable, SerializesModels;

     public $mitra;

    public function __construct($mitra)
    {
        $this->mitra = $mitra;
    }

    public function build()
    {
        return $this->subject('Pendaftaran Mitra Usaha Baru')
            ->view('emails.mitra_usaha_baru')
            ->with([
                'mitra' => $this->mitra
            ]);
    }
}