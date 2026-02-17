<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lowongan extends Model
{
    use SoftDeletes;

    protected $table = 'tb_lowongan';

    protected $fillable = [
        'judul','slug','perusahaan_id','kategori','tipe_pekerjaan','pendidikan_terakhir','jurusan','lokasi',
        'deskripsi','kualifikasi','gaji_min','gaji_max','jumlah_lowongan',
        'deadline','brosur','status','created_by'
    ];


    public function perusahaan() {
        return $this->belongsTo(MitraUsaha::class, 'perusahaan_id', 'usaha_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function lamaran() {
        return $this->hasMany(Lamaran::class, 'lowongan_id', 'id');
    }
}

