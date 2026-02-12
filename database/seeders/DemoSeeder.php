<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // --- Teacher ---
        $teacherId = DB::table('users')->insertGetId([
            'name' => 'Demo Teacher',
            'email' => 'teacher@example.com',
            'password' => bcrypt('GSSM2025'),
            'role' => 'teacher',
            'first_login' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- Subject ---
        $subjectId = DB::table('subjects')->insertGetId([
            'name' => 'Mathematics',
            'description' => 'Demo subject for testing',
            'teacher_id' => $teacherId,
            'join_code' => Str::random(8),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- Material (Homework) ---
        $materialId = DB::table('materials')->insertGetId([
            'teacher_id' => $teacherId,
            'subject_id' => $subjectId,
            'title' => 'Algebra Homework',
            'description' => 'Solve basic algebra problems',
            'file_path' => 'materials/homework1.pdf',
            'is_activity' => true,
            'due_date' => now()->addDays(7),
            'max_score' => 100,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- Quiz ---
        $quizId = DB::table('quizzes')->insertGetId([
            'teacher_id' => $teacherId,
            'subject_id' => $subjectId,
            'title' => 'Quiz 1',
            'type' => 'quiz',
            'time_limit_seconds' => 300,
            'is_published' => true,
            'total_points' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- Quiz Question ---
        $questionId = DB::table('quiz_questions')->insertGetId([
            'quiz_id' => $quizId,
            'question_type' => 'mcq',
            'question_text' => 'What is 2 + 2?',
            'points' => 1,
            'display_order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- Quiz Options ---
        $optionCorrect = DB::table('quiz_options')->insertGetId([
            'question_id' => $questionId,
            'option_text' => '4',
            'is_correct' => true,
            'display_order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('quiz_options')->insert([
            'question_id' => $questionId,
            'option_text' => '5',
            'is_correct' => false,
            'display_order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- Create 10 Students ---
        for ($i = 1; $i <= 20; $i++) {
            $studentId = DB::table('users')->insertGetId([
                'name' => "Student $i",
                'email' => "student$i@example.com",
                'password' => bcrypt('GSSM2025'),
                'role' => 'student',
                'first_login' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Enroll in subject
            DB::table('subject_user')->insert([
                'subject_id' => $subjectId,
                'user_id' => $studentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Submit homework
            DB::table('student_submissions')->insert([
                'material_id' => $materialId,
                'student_id' => $studentId,
                'file_name' => "homework_student{$i}.pdf",
                'file_path' => "submissions/homework_student{$i}.pdf",
                'original_name' => "homework{$i}.pdf",
                'file_size' => rand(100, 500),
                'mime_type' => 'application/pdf',
                'status' => 'submitted',
                'teacher_feedback' => "Good job, Student $i",
                'grade' => null,
                'submitted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
