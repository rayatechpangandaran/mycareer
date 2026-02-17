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
      // database/migrations/xxxx_xx_xx_create_about_webs_table.php
Schema::create('about_webs', function (Blueprint $table) {
    $table->id();
    $table->string('title');              // Judul halaman
    $table->text('description');          // Deskripsi utama
    $table->text('vision')->nullable();   // Visi
    $table->text('mission')->nullable();  // Misi
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_webs');
    }
};
