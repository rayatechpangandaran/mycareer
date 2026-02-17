<?php

namespace App\Mail;
use App\Models\MitraUsaha;
use Illuminate\Mail\Mailable;

class AdminUsahaRejectedMail extends Mailable
{
    public MitraUsaha $usaha;
    public string $alasan;

    public function __construct(MitraUsaha $usaha, string $alasan)
    {
        $this->usaha = $usaha;
        $this->alasan = $alasan;
    }

    public function build()
    {
        return $this->subject('Pengajuan Usaha Ditolak')
            ->view('emails.admin_usaha_rejected');
    }
}