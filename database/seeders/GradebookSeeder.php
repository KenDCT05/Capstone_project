<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Score;
use App\Models\Subject;

class GradebookSeeder extends Seeder
{
    public function run(): void
    {
        // Get all teachers
        $teachers = User::where('role', 'teacher')->get();

        foreach ($teachers as $teacher) {
            $subjects = Subject::all();
            $students = $teacher->students;

            foreach ($subjects as $subject) {
                foreach ($students as $student) {

                    // Predefined labels
                    $quizzes = ['Quiz 1', 'Quiz 2'];
                    $activities = ['Activity 1', 'Activity 2'];
                    $exams = ['Exam 1'];

                    // Populate quizzes
                    foreach ($quizzes as $label) {
                        Score::updateOrCreate([
                            'student_id' => $student->id,
                            'teacher_id' => $teacher->id,
                            'subject_id' => $subject->id,
                            'label' => $label,
                        ], [
                            'type' => 'quiz',
                            'score' => 0, // ✅ prefill with 0
                        ]);
                    }

                    // Populate activities
                    foreach ($activities as $label) {
                        Score::updateOrCreate([
                            'student_id' => $student->id,
                            'teacher_id' => $teacher->id,
                            'subject_id' => $subject->id,
                            'label' => $label,
                        ], [
                            'type' => 'activity',
                            'score' => 0, // ✅ prefill with 0
                        ]);
                    }

                    // Populate exams
                    foreach ($exams as $label) {
                        Score::updateOrCreate([
                            'student_id' => $student->id,
                            'teacher_id' => $teacher->id,
                            'subject_id' => $subject->id,
                            'label' => $label,
                        ], [
                            'type' => 'exam',
                            'score' => 0, // ✅ prefill with 0
                        ]);
                    }
                }
            }
        }
    }
}
