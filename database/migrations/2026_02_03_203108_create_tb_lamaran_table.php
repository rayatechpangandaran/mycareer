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
        Schema::create('tb_lamaran', function (Blueprint $table) {
            $table->id();

            // FK ke tb_lowongan
            $table->foreignId('lowongan_id')
                  ->constrained('tb_lowongan')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            // FK ke users.user_id (pelamar)
            $table->unsignedBigInteger('pelamar_id');
            $table->foreign('pelamar_id')
                  ->references('user_id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->enum('status', ['Dikirim','Dilihat','Diproses','Ditolak','Diterima'])->default('Dikirim');
            $table->string('cv'); // File CV pelamar
            $table->text('catatan')->nullable(); // Catatan admin opsional

            $table->timestamps();

            // Index untuk query cepat
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_lamaran');
    }
};
