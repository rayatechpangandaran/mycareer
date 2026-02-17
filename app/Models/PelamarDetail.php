<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelamarDetail extends Model
{
    use HasFactory;

    protected $table = 'pelamar_detail';

    protected $fillable = [
        'user_id',
        'no_wa',
        'alamat',
        'cv',
        'keahlian',
        'pendidikan_terakhir',
        'jurusan',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
