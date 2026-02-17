<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Lamaran;

class LamaranMasukNotif extends Notification
{
    use Queueable;

    public Lamaran $lamaran;

    public function __construct(Lamaran $lamaran)
    {
        $this->lamaran = $lamaran;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Lamaran Baru Masuk',
            'message' => 'Pelamar ' . ($this->lamaran->pelamar->nama ?? '-') .
                         ' melamar posisi ' . $this->lamaran->lowongan->judul,
            'lamaran_id' => $this->lamaran->id,
            'lowongan_id' => $this->lamaran->lowongan_id, 
            'url' => route('admin_usaha.lamaran.show', [
                'id' => $this->lamaran->lowongan_id
            ]),
        ];
    }
}