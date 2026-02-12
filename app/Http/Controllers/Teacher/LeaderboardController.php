<?php
// app/Http/Controllers/Teacher/LeaderboardController.php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function show(Quiz $quiz)
    {
        // Verify teacher ownership
        abort_unless($quiz->teacher_id === Auth::id(), 403);

        // Get final scores per student based on retake policy
        $studentScores = $this->getStudentFinalScores($quiz);

        return view('quizzes.leaderboards', [  
            'quiz' => $quiz,
            'attempts' => $studentScores,
            'totalAttempts' => count($studentScores),
            'averageScore' => count($studentScores) > 0 
                ? round(collect($studentScores)->avg('percentage'), 2) 
                : 0,
        ]);
    }

    public function api(Quiz $quiz)
    {
        // Verify teacher ownership
        abort_unless($quiz->teacher_id === Auth::id(), 403);

        // Get final scores per student based on retake policy
        $studentScores = $this->getStudentFinalScores($quiz);

        return response()->json([
            'quiz_id' => $quiz->id,
            'quiz_title' => $quiz->title,
            'attempts' => $studentScores,
            'total_attempts' => count($studentScores),
            'average_score' => count($studentScores) > 0 
                ? round(collect($studentScores)->avg('percentage'), 2) 
                : 0,
        ]);
    }

    public function studentLeaderboard(Quiz $quiz)
    {
        // Get final scores per student for student result page
        $studentScores = $this->getStudentFinalScores($quiz, true);

        return response()->json([
            'attempts' => $studentScores,
        ]);
    }

    /**
     * Get final score for each student based on retake policy
     */
    private function getStudentFinalScores(Quiz $quiz, $simpleFormat = false)
    {
        // Get all completed attempts grouped by student
        $allAttempts = QuizAttempt::where('quiz_id', $quiz->id)
            ->whereNotNull('submitted_at')
            ->with('student')
            ->orderBy('submitted_at')
            ->get()
            ->groupBy('student_id');

        $studentScores = [];

        foreach ($allAttempts as $studentId => $attempts) {
            $finalAttempt = null;

            // Apply retake scoring policy
            switch ($quiz->retake_scoring) {
                case 'highest':
                    // Get attempt with highest score
                    $finalAttempt = $attempts->sortByDesc('score')->first();
                    break;

                case 'latest':
                    // Get most recent attempt
                    $finalAttempt = $attempts->sortByDesc('submitted_at')->first();
                    break;

                case 'first':
                    // Get first attempt
                    $finalAttempt = $attempts->sortBy('submitted_at')->first();
                    break;

                case 'average':
                    // Calculate average score
                    $avgScore = $attempts->avg('score');
                    $avgPercentage = $attempts->first()->max_score > 0 
                        ? round(($avgScore / $attempts->first()->max_score) * 100, 2) 
                        : 0;
                    
                    // Use latest attempt as base, but with averaged score
                    $finalAttempt = $attempts->sortByDesc('submitted_at')->first();
                    $finalAttempt->score = round($avgScore, 2);
                    $finalAttempt->percentage = $avgPercentage;
                    $finalAttempt->is_averaged = true;
                    break;

                default:
                    // Fallback to highest
                    $finalAttempt = $attempts->sortByDesc('score')->first();
            }

            if ($finalAttempt) {
                // Calculate percentage if not already set
                if (!isset($finalAttempt->percentage) || !$finalAttempt->is_averaged) {
                    $percentage = $finalAttempt->max_score > 0 
                        ? round(($finalAttempt->score / $finalAttempt->max_score) * 100, 2) 
                        : 0;
                } else {
                    $percentage = $finalAttempt->percentage;
                }

                if ($simpleFormat) {
                    // Simple format for student leaderboard
                    $studentScores[] = [
                        'student_id' => $finalAttempt->student_id,
                        'student_name' => $finalAttempt->student->name,
                        'percentage' => $percentage,
                        'score' => $finalAttempt->score ?? 0,
                        'max_score' => $finalAttempt->max_score,
                    ];
                } else {
                    // Detailed format for teacher leaderboard
                    $studentScores[] = [
                        'student_id' => $finalAttempt->student_id,
                        'student_name' => $finalAttempt->student->name,
                        'student_email' => $finalAttempt->student->email,
                        'score' => $finalAttempt->score ?? 0,
                        'max_score' => $finalAttempt->max_score,
                        'percentage' => $percentage,
                        'correct_answers' => $finalAttempt->answers()->where('is_correct', true)->count(),
                        'total_questions' => $finalAttempt->answers()->count(),
                        'submitted_at' => $finalAttempt->submitted_at,
                        'duration' => $finalAttempt->duration,
                        'attempt_count' => $attempts->count(),
                        'scoring_method' => $quiz->retake_scoring,
                    ];
                }
            }
        }

        // Sort by percentage (highest first)
        return collect($studentScores)
            ->sortByDesc('percentage')
            ->values()
            ->toArray();
    }
}