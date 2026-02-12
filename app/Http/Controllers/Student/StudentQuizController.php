<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\{Quiz, QuizQuestion, QuizOption, QuizAttempt, QuizAnswer, Score};
use Illuminate\Http\Request;
use App\Mail\QuizScoreMail;
use App\Models\EngagementLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentQuizController extends Controller
{
public function index(Request $request)
{
    $studentId = Auth::id();
    
    // Get all subject IDs the student is enrolled in
    $enrolledSubjectIds = DB::table('subject_user')
        ->where('user_id', $studentId)
        ->pluck('subject_id')
        ->toArray();
    
    // Get enrolled subjects for the filter dropdown
    $enrolledSubjects = \App\Models\Subject::whereIn('id', $enrolledSubjectIds)
        ->orderBy('name')
        ->get();
    
    // Start query
    $query = Quiz::whereIn('subject_id', $enrolledSubjectIds);
    
    // Apply subject filter if provided
    $selectedSubjectId = $request->input('subject_id');
    if ($selectedSubjectId && in_array($selectedSubjectId, $enrolledSubjectIds)) {
        $query->where('subject_id', $selectedSubjectId);
    }
    
    // Get quizzes
    $quizzes = $query->latest()->paginate(10);
    
    return view('student.quizzes.index', compact('quizzes', 'enrolledSubjects', 'selectedSubjectId'));
}

    public function show(Quiz $quiz)
    {
        $studentId = Auth::id();
        
        // Check access
        abort_unless($quiz->is_published, 403, 'This quiz is not available.');

        // Get all completed attempts
        $completedAttempts = $quiz->attempts()
            ->where('student_id', $studentId)
            ->whereNotNull('submitted_at')
            ->orderBy('submitted_at', 'desc')
            ->get();

        // Check if student can attempt
        $canAttempt = $quiz->canStudentAttempt($studentId);

        // Get active (incomplete) attempt if exists
        $activeAttempt = $quiz->attempts()
            ->where('student_id', $studentId)
            ->whereNull('submitted_at')
            ->first();

        // Get final score based on retake policy
        $finalScore = $quiz->getFinalScore($studentId);

        return view('student.quizzes.show', compact(
            'quiz',
            'completedAttempts',
            'canAttempt',
            'activeAttempt',
            'finalScore'
        ));
    } 

    public function take(Quiz $quiz, Request $request)
    {
        $studentId = Auth::id();
        
        // Check for existing incomplete attempt FIRST
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->whereNull('submitted_at')
            ->first();

        // Access control: Allow if quiz is published OR student has active attempt
        abort_unless(
            $quiz->is_published || $attempt, 
            403, 
            'This quiz is not available.'
        );

        // Handle state persistence (music and timer)
        $musicState = $request->input('music', $request->get('music', '1'));
        $startTime = $request->input('start_time', $request->get('start_time'));

        \Log::info('=== QUIZ TAKE REQUEST ===', [
            'method' => $request->method(),
            'quiz_id' => $quiz->id,
            'student_id' => $studentId,
            'has_attempt' => !!$attempt,
            'music_state' => $musicState,
            'start_time' => $startTime,
            'query_param_q' => $request->get('q'),
        ]);

        // If no active attempt, check if can start new one
        if (!$attempt) {
            // ✅ NEW: Check retake policy
            $canAttempt = $quiz->canStudentAttempt($studentId);
            
            if (!$canAttempt['allowed']) {
                \Log::warning('Retake policy blocked attempt', [
                    'quiz_id' => $quiz->id,
                    'student_id' => $studentId,
                    'reason' => $canAttempt['reason'],
                    'attempts_used' => $canAttempt['attempts_used'] ?? 0,
                ]);

                return redirect()
                    ->route('student.quizzes.show', $quiz)
                    ->with('error', $canAttempt['reason']);
            }

            // Get quiz questions
            $quizQuestions = $quiz->questions;
            
            if ($quizQuestions->isEmpty()) {
                \Log::error('Quiz has no questions', ['quiz_id' => $quiz->id]);
                return redirect()->route('student.quizzes.show', $quiz)
                    ->with('error', 'This quiz has no questions available.');
            }

            // Randomize questions if enabled
            $questionIds = $quiz->randomize_questions
                ? $quizQuestions->pluck('id')->shuffle()->toArray()
                : $quizQuestions->pluck('id')->toArray();

            // Create new attempt
            $attempt = QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'student_id' => $studentId,
                'started_at' => now(),
                'max_score' => $quizQuestions->sum('points'),
                'question_order' => $questionIds,
            ]);

            \Log::info('Created new quiz attempt', [
                'attempt_id' => $attempt->id,
                'quiz_id' => $quiz->id,
                'student_id' => $studentId,
                'question_count' => count($questionIds),
                'max_score' => $attempt->max_score,
            ]);

            // Initialize start time if not already set
            if (!$startTime) {
                $startTime = round(microtime(true) * 1000);
            }
        }

        // Get question order from attempt
        $questionOrder = $attempt->question_order ?? [];
        
        if (empty($questionOrder)) {
            \Log::error('Empty question order in attempt', [
                'attempt_id' => $attempt->id,
                'quiz_id' => $quiz->id,
            ]);
            return redirect()->route('student.quizzes.show', $quiz)
                ->with('error', 'No questions found in quiz attempt. Please try again.');
        }

        // Determine current question index
        $requestedIndex = (int) ($request->get('q') ?? $request->input('current_question_index', 0));
        $currentIndex = max(0, min($requestedIndex, count($questionOrder) - 1));

        // ===== HANDLE POST REQUEST (Answer Submission) =====
        if ($request->isMethod('post')) {
            $questionId = $questionOrder[$currentIndex];
            $question = QuizQuestion::with(['options', 'acceptableAnswers'])->find($questionId);
            
            if (!$question) {
                \Log::error('Question not found', [
                    'question_id' => $questionId,
                    'quiz_id' => $quiz->id,
                ]);
                return redirect()->route('student.quizzes.show', $quiz)
                    ->with('error', 'Question not found.');
            }

            $answers = $request->input('answers', []);
            $isCorrect = false;
            $awarded = 0;
            $answerData = [
                'attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'option_id' => null,
                'text_answer' => null,
            ];

            // Process answer based on question type
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

            // Award points
            $awarded = $isCorrect ? ($question->points ?? 1) : 0;
            $answerData['is_correct'] = $isCorrect;
            $answerData['awarded_points'] = $awarded;

            // Save answer
            $savedAnswer = QuizAnswer::updateOrCreate(
                ['attempt_id' => $attempt->id, 'question_id' => $question->id],
                $answerData
            );

            \Log::info('Answer saved', [
                'answer_id' => $savedAnswer->id,
                'question_id' => $question->id,
                'question_type' => $question->question_type,
                'is_correct' => $isCorrect,
                'awarded_points' => $awarded,
            ]);

            // Determine next action
            $nextIndex = $currentIndex + 1;
            
            if ($nextIndex < count($questionOrder)) {
                // More questions remaining - go to next question
                $params = ['q' => $nextIndex];
                
                if ($musicState === '1') {
                    $params['music'] = '1';
                }
                
                if ($startTime) {
                    $params['start_time'] = $startTime;
                }
                
                \Log::info('Redirecting to next question', [
                    'next_index' => $nextIndex,
                    'params' => $params,
                ]);
                
                return redirect()->route('student.quizzes.take', array_merge([$quiz], $params));
            } else {
                // All questions answered - submit quiz
                $submitParams = [];
                if ($musicState === '1') {
                    $submitParams['music'] = '1';
                }
                
                \Log::info('All questions answered, redirecting to submit', [
                    'attempt_id' => $attempt->id,
                    'quiz_id' => $quiz->id,
                ]);
                
                return redirect()->route('student.quizzes.submit', array_merge([$quiz], $submitParams));
            }
        }

        // ===== HANDLE GET REQUEST (Display Question) =====
        
        $questionId = $questionOrder[$currentIndex];
        $question = QuizQuestion::with(['options', 'acceptableAnswers'])->find($questionId);
        
        if (!$question) {
            \Log::error('Question not found for display', [
                'question_id' => $questionId,
                'current_index' => $currentIndex,
            ]);
            return redirect()->route('student.quizzes.show', $quiz)
                ->with('error', 'Question not found.');
        }

        // Check for existing answer
        $existingAnswer = QuizAnswer::where('attempt_id', $attempt->id)
            ->where('question_id', $question->id)
            ->first();

        // Handle options for MCQ and TF questions
        $options = collect();
        if ($question->question_type !== 'fib') {
            $options = $question->options;
            
            // Randomize options if enabled and no existing answer
            if ($quiz->randomize_options && !$existingAnswer) {
                $options = $options->shuffle();
            }
            
            if ($options->isEmpty()) {
                \Log::error('No options found for MCQ/TF question', [
                    'question_id' => $question->id,
                    'question_type' => $question->question_type,
                ]);
                return redirect()->route('student.quizzes.show', $quiz)
                    ->with('error', 'No options found for this question.');
            }
        }

        \Log::info('Displaying question', [
            'attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'question_type' => $question->question_type,
            'current_index' => $currentIndex,
            'total_questions' => count($questionOrder),
            'has_existing_answer' => !!$existingAnswer,
        ]);

        // Return view with all necessary data
        return view('student.quizzes.take', [
            'quiz' => $quiz,
            'attempt' => $attempt,
            'question' => $question,
            'options' => $options,
            'currentIndex' => $currentIndex,
            'totalQuestions' => count($questionOrder),
            'existingAnswer' => $existingAnswer,
            'musicState' => $musicState,
            'startTime' => $startTime,
        ]);
    }


   public function submit(Quiz $quiz)
{
    $student = Auth::user();
    
    $attempt = QuizAttempt::where('quiz_id', $quiz->id)
        ->where('student_id', $student->id)
        ->whereNull('submitted_at')
        ->with('answers')
        ->first();

    if (!$attempt) {
        return redirect()->route('student.quizzes.show', $quiz)
            ->with('error', 'No active quiz attempt found.');
    }

    $totalScore = $attempt->answers->sum('awarded_points');
    $percentage = $attempt->max_score > 0 
        ? round(($totalScore / $attempt->max_score) * 100, 2) 
        : 0;

    $attempt->update([
        'score' => $totalScore,
        'submitted_at' => now(),
    ]);

    $finalScoreData = $quiz->getFinalScore($student->id);
    
    if (!$finalScoreData) {
        $finalScoreData = [
            'score' => $totalScore,
            'max_score' => $attempt->max_score,
            'percentage' => $percentage,
            'scoring_method' => 'first',
        ];
    }

    Score::updateOrCreate(
        [
            'student_id' => $student->id,
            'quiz_id' => $quiz->id,
            'teacher_id' => $quiz->teacher_id,
            'subject_id' => $quiz->subject_id,
            'label' => $quiz->title,
        ],
        [
            'type' => $quiz->type,
            'score' => $finalScoreData['score'],
            'max_score' => $finalScoreData['max_score'],
            'percentage' => $finalScoreData['percentage'],
        ]
    );


    \App\Models\EngagementLog::create([
        'user_id' => $student->id,
        'subject_id' => $quiz->subject_id,
        'action'  => 'quiz_attempt',
        'context' => 'quiz:' . $quiz->id . ':attempt:' . $attempt->id,
        'value'   => 1,
    ]);

    // ✅ FIXED: Redirect to SPECIFIC attempt that was just completed
    return redirect()->route('student.quizzes.result', [
            'quiz' => $quiz,
            'attempt' => $attempt->id  // ← Pass attempt ID
        ])
        ->with('success', 'Quiz submitted! Your score has been calculated.');
}


public function result(Quiz $quiz, Request $request)
{
    $studentId = Auth::id();
    
    // Get ALL submitted attempts for this student
    $allAttempts = QuizAttempt::where('quiz_id', $quiz->id)
        ->where('student_id', $studentId)
        ->whereNotNull('submitted_at')
        ->orderByDesc('submitted_at')
        ->get();

    if ($allAttempts->isEmpty()) {
        return redirect()->route('student.quizzes.show', $quiz)
            ->with('error', 'No completed attempts found.');
    }

    // Check if specific attempt ID is requested
    $attemptId = $request->get('attempt');
    
    if ($attemptId) {
        // Find the requested attempt
        $attempt = $allAttempts->firstWhere('id', $attemptId);
        
        // If not found or doesn't belong to student, use latest
        if (!$attempt) {
            $attempt = $allAttempts->first();
        }
    } else {
        // Default to latest attempt
        $attempt = $allAttempts->first();
    }

    // ✅ FIXED: Always load relationships - we need them for the view
    $attempt->load(['answers.question.options', 'answers.question.acceptableAnswers']);

    // ✅ Determine if question review should be shown
    $showQuestionReview = $quiz->show_previous_answers;

    // Get final score for comparison
    $finalScore = $quiz->getFinalScore($studentId);

    return view('student.quizzes.result', compact(
        'quiz', 
        'attempt', 
        'allAttempts',
        'finalScore',
        'showQuestionReview' // ✅ Pass this to the view
    ));
}


     public function attempts(Quiz $quiz)
    {
        $studentId = Auth::id();
        
        $attempts = $quiz->attempts()
            ->where('student_id', $studentId)
            ->whereNotNull('submitted_at')
            ->with(['answers.question.options', 'answers.question.acceptableAnswers'])
            ->orderBy('submitted_at', 'desc')
            ->get();

        $finalScore = $quiz->getFinalScore($studentId);

        return view('student.quizzes.attempts', compact('quiz', 'attempts', 'finalScore'));
    }
}