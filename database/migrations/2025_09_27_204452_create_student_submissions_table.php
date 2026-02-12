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
        Schema::create('student_submissions', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            
            // File information
            $table->string('file_name');
            $table->string('file_path');
            $table->string('original_name');
            $table->integer('file_size');
            $table->string('mime_type');
            
            // Status tracking
            $table->string('status', 50)->default('submitted'); // Can be: submitted, late, reviewed, late_reviewed
            $table->boolean('is_late')->default(false); // Separate timing tracker
            
            // Feedback and grading
            $table->text('teacher_feedback')->nullable();
            $table->decimal('grade', 5, 2)->nullable();
            
            // Timestamps
            $table->timestamp('submitted_at')->useCurrent(); // ✅ NO useCurrentOnUpdate()
            $table->timestamps(); // created_at and updated_at
            
            // Indexes for better performance
            $table->index(['material_id', 'student_id']);
            $table->index('status');
            $table->index('is_late');
            $table->index('submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_submissions');
    }
};