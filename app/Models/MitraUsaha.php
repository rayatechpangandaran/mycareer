<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MitraUsaha extends Model
{
    protected $table = 'mitra_usaha';
    protected $primaryKey = 'usaha_id';

    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'nama_bisnis_usaha',
        'deskripsi_perusahaan',
        'jenis_usaha',
        'nama_penanggung_jawab',
        'email',
        'user_id',
        'no_wa',
        'alamat_lengkap',
        'bidang_usaha',
        'jml_karyawan',
        'nib',
        'banner_logo_usaha',
        'bukti_usaha',
        'is_verify'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

}