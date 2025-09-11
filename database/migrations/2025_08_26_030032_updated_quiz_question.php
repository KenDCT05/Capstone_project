<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Update quiz_questions to support fill-in-the-blank
        Schema::table('quiz_questions', function (Blueprint $table) {
            // Update enum to include 'fib' (fill in the blank)
            DB::statement("ALTER TABLE quiz_questions MODIFY COLUMN question_type ENUM('mcq', 'tf', 'fib')");
            
            // Add answer field for fill-in-the-blank questions
            $table->text('correct_answer')->nullable()->after('question_text');
            
            // Add case sensitivity option for fill-in-the-blank
            $table->boolean('case_sensitive')->default(false)->after('correct_answer');
            
            // Add partial matching option (for typos, etc.)
            $table->boolean('allow_partial_match')->default(false)->after('case_sensitive');
        });

        // 2. Update quiz_answers to support text answers
        Schema::table('quiz_answers', function (Blueprint $table) {
            // Add text_answer field for fill-in-the-blank responses
            $table->text('text_answer')->nullable()->after('option_id');
            
            // Make option_id nullable since FIB doesn't use options
            // (Already nullable in your schema, so this is just a comment)
        });

        // 3. Optional: Create a table for multiple correct answers (if you want to support multiple acceptable answers)
        Schema::create('quiz_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('quiz_questions')->cascadeOnDelete();
            $table->text('answer_text');
            $table->boolean('is_primary')->default(false); // mark the main/preferred answer
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_question_answers');
        
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->dropColumn('text_answer');
        });
        
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->dropColumn(['correct_answer', 'case_sensitive', 'allow_partial_match']);
            DB::statement("ALTER TABLE quiz_questions MODIFY COLUMN question_type ENUM('mcq', 'tf')");
        });
    }
};