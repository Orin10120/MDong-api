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
        Schema::create('application_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            // $table->unsignedBigInteger('lecturer_id'); // Bagian adrian
            $table->string('status')->default('PENDING');
            $table->string('is_pembimbing');
            $table->timestamp('submission_date');
            $table->timestamp('response_date')->nullable();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_histories');
    }
};
