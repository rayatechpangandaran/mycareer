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
    Schema::table('tb_lowongan', function (Blueprint $table) {
            $table->string('pendidikan_terakhir')->after('tipe_pekerjaan')->nullable()->comment('Minimal pendidikan yang dibutuhkan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('tb_lowongan', function (Blueprint $table) {
        $table->dropColumn('pendidikan_terakhir');
    });
    }
};
