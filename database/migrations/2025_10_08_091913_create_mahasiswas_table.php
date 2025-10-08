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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id('mahasiswa_id');
            $table->string('nama');
            $table->string('nim');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_tlp')->nullable();
            $table->string('program_studi');
            $table->string('kelas');
            $table->integer('angkatan');
            $table->string('url_sosmed')->nullable();
            $table->string('status')->default('DRAFT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
