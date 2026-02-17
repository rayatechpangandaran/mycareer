<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mitra_usaha', function (Blueprint $table) {
            $table->id('usaha_id'); // PK

            $table->string('nama_bisnis_usaha');
            $table->text('deskripsi_perusahaan');

            $table->enum('jenis_usaha', [
                'PT',
                'CV',
                'Hotel',
                'UMKM'
            ]);

            $table->string('nama_penanggung_jawab');
            $table->string('email')->unique();
            $table->string('no_wa', 20);

            $table->text('alamat_lengkap');
            $table->string('kota');

            $table->enum('bidang_usaha', [
                'kuliner',
                'jasa',
                'manufaktur',
                'retail'
            ]);

            $table->integer('jml_karyawan')->unsigned();

            $table->string('nib')->nullable();
            $table->string('banner_logo_usaha')->nullable();

            // tambahan sesuai request
            $table->string('bukti_usaha')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mitra_usaha');
    }
};