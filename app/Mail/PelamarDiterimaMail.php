<?php

namespace App\Mail;

use App\Models\Lamaran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;


class PelamarDiterimaMail extends Mailable
{
    use Queueable, SerializesModels;

    public Lamaran $lamaran;

    public function __construct(Lamaran $lamaran)
    {
        $this->lamaran = $lamaran;
    }

public function build()
{
    $mail = $this->subject('Lamaran Anda Diterima')
        ->view('emails.pelamar.diterima')
        ->with([
            'lamaran' => $this->lamaran,
        ]);

    // Jika ada surat diterima
    if ($this->lamaran->surat_diterima) {

        $filePath = storage_path('app/public/' . $this->lamaran->surat_diterima);

        if (file_exists($filePath)) {

            $extension = pathinfo($filePath, PATHINFO_EXTENSION);

            $mail->attach($filePath, [
                'as' => 'Surat_Penerimaan.' . $extension,
                'mime' => mime_content_type($filePath),
            ]);
        }
    }

    return $mail;
}
}