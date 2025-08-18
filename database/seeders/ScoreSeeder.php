<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Score;

class ScoreSeeder extends Seeder
{
    public function run(): void
    {
        Score::create([
            'student_id' => 1,
            'teacher_id' => 1,
            'subject_id' => 1,
            'type' => 'quiz',
            'label' => 'Quiz 1',
            'score' => 18,
        ]);

        Score::create([
            'student_id' => 1,
            'teacher_id' => 1,
            'subject_id' => 1,
            'type' => 'activity',
            'label' => 'Activity 1',
            'score' => 15,
        ]);
    }
}
