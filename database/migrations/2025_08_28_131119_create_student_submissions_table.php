<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('student_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('original_name');
            $table->integer('file_size');
            $table->string('mime_type');
            $table->enum('status', ['submitted', 'late', 'reviewed'])->default('submitted');
            $table->text('teacher_feedback')->nullable();
            $table->decimal('grade', 5, 2)->nullable();
            $table->timestamp('submitted_at');
            $table->timestamps();
            
            // Prevent duplicate submissions per student per material
            $table->unique(['material_id', 'student_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_submissions');
    }
}