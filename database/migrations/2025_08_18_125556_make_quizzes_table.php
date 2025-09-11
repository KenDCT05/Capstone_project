<?php

// database/migrations/2025_08_01_000000_create_quizzes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->string('title');
            $table->enum('type', ['quiz', 'exam', 'activity'])->default('quiz');
            $table->unsignedInteger('time_limit_seconds')->nullable(); // whole quiz timer
            $table->boolean('randomize_questions')->default(true);
            $table->boolean('randomize_options')->default(true);
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('total_points')->default(0);
            $table->timestamps();

            $table->index(['subject_id', 'teacher_id', 'is_published']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('quizzes');
    }
};