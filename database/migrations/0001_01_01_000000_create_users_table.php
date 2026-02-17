<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');

            $table->string('nama');
            $table->string('email')->unique();

            $table->string('password')->nullable();

            // OAuth (Google, dll)
            $table->string('provider')->nullable(); // google
            $table->string('provider_id')->nullable(); // google_id
            $table->string('avatar')->nullable();

            $table->enum('role', [
                'superadmin',
                'admin_usaha',
                'pelamar'
            ])->default('pelamar');

            $table->boolean('is_active')->default(true);

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->rememberToken();

            $table->timestamps();

            $table->index(['provider', 'provider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};