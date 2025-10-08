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
        Schema::create('application__histories', function (Blueprint $table) {
            $table->id('application_id');
            $table->unsignedBigInteger('mahasiswa_id');
            // $table->unsignedBigInteger('dosen_id'); //Bagian Adrian
            $table->string('status')->default('PENDING');
            $table->string('is_pembimbing');
            $table->timestamp('tanggal_submit');
            $table->timestamp('tanggal_response')->nullable();

            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('mahasiswas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application__histories');
    }
};
