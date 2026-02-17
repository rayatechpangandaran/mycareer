<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_lowongan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();

            // FK ke mitra_usaha.usaha_id
            $table->unsignedBigInteger('perusahaan_id');
            $table->foreign('perusahaan_id')
                  ->references('usaha_id')
                  ->on('mitra_usaha')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->string('kategori', 100);
            $table->enum('tipe_pekerjaan', ['Fulltime','Parttime','Magang','Freelance','Kontrak'])->default('Fulltime');
            $table->string('lokasi');
            $table->text('deskripsi');
            $table->text('kualifikasi');
            $table->decimal('gaji_min', 15, 2)->nullable();
            $table->decimal('gaji_max', 15, 2)->nullable();
            $table->integer('jumlah_lowongan')->default(1);
            $table->date('deadline');
            $table->enum('status', ['Draft','Publish','Ditutup'])->default('Draft');

            // FK ke users.user_id (admin yang buat lowongan)
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                  ->references('user_id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

            // Index untuk query cepat
            $table->index('status');
            $table->index('deadline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_lowongan');
    }
};
