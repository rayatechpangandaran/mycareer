<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    protected $table = 'tb_lamaran';

    protected $fillable = [
        'lowongan_id',
        'perusahaan_id',
        'pelamar_id',
        'status',
        'cv',
        'catatan',
        'surat_diterima',
    ];

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(MitraUsaha::class, 'perusahaan_id', 'usaha_id');
    }

    public function pelamar()
    {
        return $this->belongsTo(User::class, 'pelamar_id', 'user_id');
    }
}

