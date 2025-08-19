<?php

// database/migrations/2025_08_01_000010_create_quiz_questions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->enum('question_type', ['mcq', 'tf']); // multiple choice / true-false
            $table->text('question_text');
            $table->unsignedInteger('points')->default(1);
            $table->unsignedInteger('time_limit_seconds')->nullable(); // per-question timer
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('quiz_questions');
    }
};
