<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('tb_lamaran', function (Blueprint $table) {
        $table->unsignedBigInteger('perusahaan_id')
              ->after('lowongan_id')
              ->nullable();

        $table->index('perusahaan_id');
    });
}

public function down()
{
    Schema::table('tb_lamaran', function (Blueprint $table) {
        $table->dropColumn('perusahaan_id');
    });
}

};
