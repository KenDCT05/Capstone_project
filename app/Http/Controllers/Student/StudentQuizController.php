<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\{Quiz, QuizQuestion, QuizOption, QuizAttempt, QuizAnswer, Score};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentQuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('is_published', true)->latest()->paginate(10);
        return view('student.quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz)
    {
        abort_unless($quiz->is_published, 403);
        return view('student.quizzes.show', compact('quiz'));
    }

    public function take(Quiz $quiz, Request $request)
    {
        abort_unless($quiz->is_published, 403);
        $studentId = Auth::id();

        // Fetch or create attempt
        $attempt = QuizAttempt::firstOrCreate(
            ['quiz_id' => $quiz->id, 'student_id' => $studentId],
            [
                'started_at' => now(),
                'max_score' => $quiz->questions()->sum('points'),
                'question_order' => $quiz->randomize_questions
                    ? $quiz->questions->pluck('id')->shuffle()->toArray()
                    : $quiz->questions->pluck('id')->toArray(),
            ]
        );

        $questionOrder = $attempt->question_order ?? [];
        if (empty($questionOrder)) {
            return redirect()->route('student.quizzes.show', $quiz)
                ->with('error', 'No questions found for this quiz.');
        }

        $requestedIndex = (int) ($request->get('q') ?? $request->input('current_question_index', 0));
        $currentIndex = max(0, min($requestedIndex, count($questionOrder) - 1));

        // Save answer if POST
        if ($request->isMethod('post')) {
            $questionId = $questionOrder[$currentIndex];
            $question = QuizQuestion::with('options')->findOrFail($questionId);
            $selectedOptionId = $request->input("answers.{$question->id}");
            $option = $selectedOptionId ? $question->options()->find($selectedOptionId) : null;

            $isCorrect = $option?->is_correct ?? false;
            $awarded = $isCorrect ? ($question->points ?? 1) : 0;

            QuizAnswer::updateOrCreate(
                ['attempt_id' => $attempt->id, 'question_id' => $question->id],
                [
                    'option_id' => $selectedOptionId,
                    'is_correct' => $isCorrect,
                    'awarded_points' => $awarded,
                ]
            );

            // Redirect to next question or submit
            $nextIndex = $currentIndex + 1;
            if ($nextIndex < count($questionOrder)) {
                return redirect()->route('student.quizzes.take', [$quiz, 'q' => $nextIndex]);
            } else {
                return redirect()->route('student.quizzes.submit', $quiz);
            }
        }

        // Show current question
        $questionId = $questionOrder[$currentIndex];
        $question = QuizQuestion::with('options')->findOrFail($questionId);
        $existingAnswer = QuizAnswer::where('attempt_id', $attempt->id)
            ->where('question_id', $question->id)
            ->first();
        $options = $question->options->toArray();

        if ($quiz->randomize_options && !$existingAnswer) {
            shuffle($options);
        }

        return view('student.quizzes.take', [
            'quiz' => $quiz,
            'attempt' => $attempt,
            'question' => $question,
            'options' => $options,
            'currentIndex' => $currentIndex,
            'totalQuestions' => count($questionOrder),
            'existingAnswer' => $existingAnswer,
        ]);
    }

    public function submit(Quiz $quiz)
    {
        $studentId = Auth::id();
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->with('answers')
            ->first();

        if (!$attempt) {
            return redirect()->route('student.quizzes.show', $quiz)
                ->with('error', 'No quiz attempt found.');
        }

        if ($attempt->submitted_at) {
            return redirect()->route('student.quizzes.result', $quiz);
        }

        // Recalculate total score
        $totalScore = $attempt->answers->sum('awarded_points');
        $percentage = $attempt->max_score > 0 ? round(($totalScore / $attempt->max_score) * 100, 2) : 0;

        $attempt->update([
            'score' => $totalScore,
            'submitted_at' => now(),
        ]);

        // Save to Score table
        Score::updateOrCreate(
            ['student_id' => $studentId, 'quiz_id' => $quiz->id],
            [
                'score' => $totalScore,
                'max_score' => $attempt->max_score,
                'percentage' => $percentage,
                'teacher_id' => $quiz->teacher_id,
                'subject_id' => $quiz->subject_id,
                'type' => $quiz->type,
                'label' => $quiz->title,
            ]
        );

        return redirect()->route('student.quizzes.result', $quiz)
            ->with('success', 'Quiz submitted successfully!');
    }

    public function result(Quiz $quiz)
    {
        $studentId = Auth::id();
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->with(['answers.question.options'])
            ->firstOrFail();

        if (!$attempt->submitted_at) {
            return redirect()->route('student.quizzes.show', $quiz)
                ->with('error', 'Quiz not completed.');
        }

        return view('student.quizzes.result', compact('quiz', 'attempt'));
    }

    public function attempts(Quiz $quiz)
    {
        $studentId = Auth::id();
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->with('answers.question.options')
            ->first();

        return view('student.quizzes.attempts', compact('quiz', 'attempt'));
    }
}
