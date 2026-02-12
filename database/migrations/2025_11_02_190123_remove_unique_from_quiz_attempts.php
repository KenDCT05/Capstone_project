<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Drop existing foreign keys
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->dropForeign('quiz_attempts_quiz_id_foreign');
            $table->dropForeign('quiz_attempts_student_id_foreign');
        });

        // Step 2: Drop the unique index
        DB::statement('ALTER TABLE quiz_attempts DROP INDEX quiz_attempts_quiz_id_student_id_unique');
        
        // Step 3: Re-add foreign keys without unique constraint
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->foreign('quiz_id', 'quiz_attempts_quiz_id_foreign')
                  ->references('id')
                  ->on('quizzes')
                  ->onDelete('cascade')
                  ->onUpdate('restrict');
            
            $table->foreign('student_id', 'quiz_attempts_student_id_foreign')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('restrict');
            
            // Step 4: Add regular index for performance
            $table->index(['quiz_id', 'student_id'], 'idx_quiz_student');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the regular index
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->dropIndex('idx_quiz_student');
            $table->dropForeign('quiz_attempts_quiz_id_foreign');
            $table->dropForeign('quiz_attempts_student_id_foreign');
        });
        
        // Restore unique constraint
        DB::statement('ALTER TABLE quiz_attempts ADD UNIQUE quiz_attempts_quiz_id_student_id_unique (quiz_id, student_id)');
        
        // Re-add foreign keys with unique constraint
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->foreign('quiz_id', 'quiz_attempts_quiz_id_foreign')
                  ->references('id')
                  ->on('quizzes')
                  ->onDelete('cascade')
                  ->onUpdate('restrict');
            
            $table->foreign('student_id', 'quiz_attempts_student_id_foreign')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('restrict');
        });
    }
};