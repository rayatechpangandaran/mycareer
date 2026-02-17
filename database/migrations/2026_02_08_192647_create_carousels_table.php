<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('carousels', function (Blueprint $table) {
            
            if (!Schema::hasColumn('carousels', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }

            
            $columns = ['title', 'description', 'link', 'position', 'order'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('carousels', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    public function down()
    {
        Schema::table('carousels', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->integer('position')->default(0);
            $table->integer('order')->default(0);
            $table->dropColumn('is_active');
        });
    }
};