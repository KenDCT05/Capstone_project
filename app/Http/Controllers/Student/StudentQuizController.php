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

    // Handle state persistence - get music and timer states
    $musicState = $request->input('music', $request->get('music', '0'));
    $startTime = $request->input('start_time', $request->get('start_time'));

    // DEBUG: Log EVERY request including state parameters
    \Log::info('=== QUIZ TAKE REQUEST ===', [
        'method' => $request->method(),
        'url' => $request->fullUrl(),
        'all_input' => $request->all(),
        'query_param_q' => $request->get('q'),
        'music_state' => $musicState,
        'start_time' => $startTime,
        'student_id' => $studentId,
        'quiz_id' => $quiz->id
    ]);

    // Debug: Check if quiz has questions
    $quizQuestions = $quiz->questions;
    if ($quizQuestions->isEmpty()) {
        return redirect()->route('student.quizzes.show', $quiz)
            ->with('error', 'This quiz has no questions available.');
    }

    // Get existing attempt or create a new one
    $attempt = QuizAttempt::where('quiz_id', $quiz->id)
        ->where('student_id', $studentId)
        ->first();

    if (!$attempt) {
        $questionIds = $quiz->randomize_questions
            ? $quizQuestions->pluck('id')->shuffle()->toArray()
            : $quizQuestions->pluck('id')->toArray();

        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'student_id' => $studentId,
            'started_at' => now(),
            'max_score' => $quizQuestions->sum('points'),
            'question_order' => $questionIds,
        ]);

        // Set start time for new attempts (JavaScript uses milliseconds)
        if (!$startTime) {
            $startTime = round(microtime(true) * 1000);
        }
    }

    $questionOrder = $attempt->question_order ?? [];
    
    // Debug: Additional check
    if (empty($questionOrder)) {
        return redirect()->route('student.quizzes.show', $quiz)
            ->with('error', 'No questions found in quiz attempt. Please try again.');
    }

    // Figure out current question index
    $requestedIndex = (int) ($request->get('q') ?? $request->input('current_question_index', 0));
    $currentIndex = max(0, min($requestedIndex, count($questionOrder) - 1));

    // Handle POST (answer submitted)
    if ($request->isMethod('post')) {
        $questionId = $questionOrder[$currentIndex];
        $question = QuizQuestion::with(['options', 'acceptableAnswers'])->find($questionId);
        
        if (!$question) {
            return redirect()->route('student.quizzes.show', $quiz)
                ->with('error', 'Question not found.');
        }

        // Extract answer based on question type
        $answers = $request->input('answers', []);
        $isCorrect = false;
        $awarded = 0;
        $answerData = [
            'attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'option_id' => null,
            'text_answer' => null,
        ];

        switch ($question->question_type) {
            case 'mcq':
            case 'tf':
                $selectedOptionId = $answers[$question->id] ?? null;
                $option = $selectedOptionId ? $question->options()->find($selectedOptionId) : null;
                
                $isCorrect = $option?->is_correct ?? false;
                $answerData['option_id'] = $selectedOptionId;
                
                \Log::info('Processing MCQ/TF answer', [
                    'question_id' => $question->id,
                    'question_type' => $question->question_type,
                    'selected_option_id' => $selectedOptionId,
                    'is_correct' => $isCorrect,
                ]);
                break;

            case 'fib':
                $textAnswer = $answers[$question->id] ?? '';
                $textAnswer = trim($textAnswer);
                
                $isCorrect = $textAnswer ? $question->checkTextAnswer($textAnswer) : false;
                $answerData['text_answer'] = $textAnswer;
                
                \Log::info('Processing FIB answer', [
                    'question_id' => $question->id,
                    'text_answer' => $textAnswer,
                    'correct_answer' => $question->correct_answer,
                    'case_sensitive' => $question->case_sensitive,
                    'allow_partial_match' => $question->allow_partial_match,
                    'is_correct' => $isCorrect,
                ]);
                break;
        }

        $awarded = $isCorrect ? ($question->points ?? 1) : 0;
        $answerData['is_correct'] = $isCorrect;
        $answerData['awarded_points'] = $awarded;

        // Save the answer
        $savedAnswer = QuizAnswer::updateOrCreate(
            ['attempt_id' => $attempt->id, 'question_id' => $question->id],
            $answerData
        );

        \Log::info('Answer saved', [
            'answer_id' => $savedAnswer->id,
            'question_id' => $question->id,
            'question_type' => $question->question_type,
            'option_id' => $savedAnswer->option_id,
            'text_answer' => $savedAnswer->text_answer,
            'is_correct' => $isCorrect,
            'awarded_points' => $awarded,
            'was_recently_created' => $savedAnswer->wasRecentlyCreated
        ]);

        // Move to next or finish - PRESERVE STATE PARAMETERS
        $nextIndex = $currentIndex + 1;
        if ($nextIndex < count($questionOrder)) {
            // Build URL parameters to preserve state
            $params = ['q' => $nextIndex];
            
            // Preserve music state
            if ($musicState === '1') {
                $params['music'] = '1';
            }
            
            // Preserve timer start time
            if ($startTime) {
                $params['start_time'] = $startTime;
            }
            
            \Log::info('Redirecting to next question with state', [
                'next_index' => $nextIndex,
                'params' => $params
            ]);
            
            return redirect()->route('student.quizzes.take', array_merge([$quiz], $params));
        } else {
            // Quiz completed - redirect to submit (could preserve celebration music here too)
            $submitParams = [];
            if ($musicState === '1') {
                $submitParams['music'] = '1';
            }
            
            return redirect()->route('student.quizzes.submit', array_merge([$quiz], $submitParams));
        }
    }

    // GET request - Show current question
    $questionId = $questionOrder[$currentIndex];
    $question = QuizQuestion::with(['options', 'acceptableAnswers'])->find($questionId);
    
    if (!$question) {
        return redirect()->route('student.quizzes.show', $quiz)
            ->with('error', 'Question not found.');
    }

    $existingAnswer = QuizAnswer::where('attempt_id', $attempt->id)
        ->where('question_id', $question->id)
        ->first();

    // Handle options for MCQ/TF questions
    $options = collect();
    if ($question->question_type !== 'fib') {
        $options = $question->options;
        
        if ($quiz->randomize_options && !$existingAnswer) {
            $options = $options->shuffle();
        }
        
        // Ensure options exist for MCQ/TF
        if ($options->isEmpty()) {
            \Log::error('No options found for MCQ/TF question', ['question_id' => $question->id]);
            return redirect()->route('student.quizzes.show', $quiz)
                ->with('error', 'No options found for this question.');
        }
    }

    // Pass state information to the view
    return view('student.quizzes.take', [
        'quiz' => $quiz,
        'attempt' => $attempt,
        'question' => $question,
        'options' => $options,
        'currentIndex' => $currentIndex,
        'totalQuestions' => count($questionOrder),
        'existingAnswer' => $existingAnswer,
        // NEW: Pass state parameters to view for JavaScript access
        'musicState' => $musicState,
        'startTime' => $startTime,
    ]);
}

 public function submit(Quiz $quiz)
{
    $student = Auth::user();
    $attempt = QuizAttempt::where('quiz_id', $quiz->id)
        ->where('student_id', $student->id)
        ->with('answers')
        ->first();

    if (!$attempt) {
        return redirect()->route('student.quizzes.show', $quiz)
            ->with('error', 'No quiz attempt found.');
    }

    if ($attempt->submitted_at) {
        return redirect()->route('student.quizzes.result', $quiz);
    }

    // ✅ Recalculate total score
    $totalScore = $attempt->answers->sum('awarded_points');
    $percentage = $attempt->max_score > 0 ? round(($totalScore / $attempt->max_score) * 100, 2) : 0;

    $attempt->update([
        'score' => $totalScore,
        'submitted_at' => now(),
    ]);

    // ✅ Save to Score table
    Score::updateOrCreate(
        ['student_id' => $student->id, 'quiz_id' => $quiz->id],
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

    // ✅ Send quiz score email
    \Mail::to($student->email)->queue(
        new \App\Mail\QuizScoreMail($student, $quiz, $totalScore, $attempt->max_score, $percentage)
    );

    return redirect()->route('student.quizzes.result', $quiz)
        ->with('success', 'Quiz submitted successfully! Your score has been sent to your email.');
}


    public function result(Quiz $quiz)
    {
        $studentId = Auth::id();
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->with(['answers.question.options', 'answers.question.acceptableAnswers'])
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
            ->with(['answers.question.options', 'answers.question.acceptableAnswers'])
            ->first();

        return view('student.quizzes.attempts', compact('quiz', 'attempt'));
    }
}