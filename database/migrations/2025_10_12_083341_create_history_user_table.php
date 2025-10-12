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
        Schema::create('history_user', function (Blueprint $table) {
            $table->unsignedBigInteger('history_id');
            $table->unsignedBigInteger('lecture_id');

            $table->foreign('history_id')->references('id')->on('application_histories')->onDelete('cascade');
            $table->foreign('lecture_id')->references('id')->on('lecturers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_user');
    }
};
