<?php
// database/migrations/2025_08_01_000030_create_quiz_attempts_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('score')->default(0);
            $table->unsignedInteger('max_score')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->json('question_order')->nullable(); // store randomized order
            $table->timestamps();

            $table->unique(['quiz_id', 'student_id']); // one attempt for simplicity (can remove if multiple attempts)
            $table->index(['student_id', 'quiz_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('quiz_attempts');
    }
};
