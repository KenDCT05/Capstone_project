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
        Schema::create('max_scores', function (Blueprint $table) {
  
        $table->id();
        $table->unsignedBigInteger('subject_id');
        $table->string('label'); // e.g. 'Quiz 1', 'Exam 2'
        $table->integer('max_score');
        $table->timestamps();

        $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        $table->unique(['subject_id', 'label']);
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('max_scores');
    }
};
