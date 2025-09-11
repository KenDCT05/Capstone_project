<?php
// app/Http/Controllers/Teacher/QuizController.php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\{Quiz, QuizQuestion, QuizOption, Subject, QuizQuestionAnswer};
use Illuminate\Http\Request;
use App\Models\MaxScore;
use App\Models\Score;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\QuizScoreMail;
use Illuminate\Support\Facades\Mail;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::where('teacher_id', Auth::id())->get();
        $subjectId = $request->subject_id;

        $quizzes = Quiz::withCount('questions')
            ->where('teacher_id', Auth::id())
            ->when($subjectId, fn($q)=>$q->where('subject_id',$subjectId))
            ->latest()->paginate(10);

        return view('quizzes.index', compact('quizzes','subjects','subjectId'));
    }

    public function create()
    {
        $subjects = Subject::where('teacher_id', Auth::id())->get();
        return view('quizzes.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:quiz,exam,activity',
            'time_limit_seconds' => 'nullable|integer|min:10|max:86400',
            'randomize_questions' => 'boolean',
            'randomize_options' => 'boolean',
        ]);

        // ensure teacher owns subject
        abort_unless(
            Subject::where('id',$data['subject_id'])
                   ->where('teacher_id',Auth::id())->exists(),
            403
        );

        $quiz = Quiz::create([
            ...$data,
            'teacher_id' => Auth::id(),
        ]);

        return redirect()
            ->route('quizzes.edit', $quiz)
            ->with('success','Quiz created. Add questions below.');
    }

    public function edit(Quiz $quiz)
    {
        abort_unless($quiz->teacher_id === Auth::id(), 403);
        $quiz->load('questions.options','questions.acceptableAnswers','subject');
        $subjects = Subject::where('teacher_id', Auth::id())->get();

        return view('quizzes.edit', compact('quiz','subjects'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        abort_unless($quiz->teacher_id === Auth::id(), 403);

        $data = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:quiz,exam,activity',
            'time_limit_seconds' => 'nullable|integer|min:10|max:86400',
            'randomize_questions' => 'boolean',
            'randomize_options' => 'boolean',
            'is_published' => 'boolean',
        ]);

        abort_unless(
            Subject::where('id',$data['subject_id'])
                   ->where('teacher_id',Auth::id())->exists(),
            403
        );

        $quiz->update($data);

        // recompute total_points
        $quiz->update(['total_points' => $quiz->questions()->sum('points')]);

        return back()->with('success','Quiz updated.');
    }

    public function destroy(Quiz $quiz)
    {
        abort_unless($quiz->teacher_id === Auth::id(), 403);
        $quiz->delete();

        return redirect()
            ->route('quizzes.index')
            ->with('success','Quiz deleted.');
    }

    public function publish(Quiz $quiz)
    {
        abort_unless($quiz->teacher_id === Auth::id(), 403);

        $quiz->update([
            'is_published' => true,
            'total_points' => $quiz->questions()->sum('points')
        ]);

        return back()->with('success','Quiz published.');
    }

    // ----- Questions ----- UPDATED FOR AJAX AND MULTIPLE QUESTION TYPES
    public function addQuestion(Request $request, Quiz $quiz)
    {
        abort_unless($quiz->teacher_id === Auth::id(), 403);

        // Base validation rules
        $rules = [
            'question_type' => 'required|in:mcq,tf,fib',
            'question_text' => 'required|string|max:2000',
            'points' => 'required|integer|min:1|max:100',
            'time_limit_seconds' => 'nullable|integer|min:5|max:3600',
        ];

        // Question type specific validation
        switch ($request->question_type) {
            case 'mcq':
                $rules['options'] = 'required|array|min:2|max:6';
                $rules['options.*'] = 'required|string|max:1000';
                $rules['correct_index'] = 'required|integer|min:0';
                break;
                
            case 'tf':
                $rules['correct_answer_tf'] = 'required|in:true,false';
                break;
                
            case 'fib':
                $rules['correct_answer'] = 'required|string|max:500';
                $rules['case_sensitive'] = 'nullable|boolean';
                $rules['allow_partial_match'] = 'nullable|boolean';
                $rules['alternative_answers'] = 'nullable|array|max:5';
                $rules['alternative_answers.*'] = 'nullable|string|max:500';
                break;
        }

        $data = $request->validate($rules);

        $displayOrder = ($quiz->questions()->max('display_order') ?? 0) + 1;

        // Create question with type-specific data
        $questionData = [
            'question_type' => $data['question_type'],
            'question_text' => $data['question_text'],
            'points' => $data['points'],
            'time_limit_seconds' => $data['time_limit_seconds'] ?? null,
            'display_order' => $displayOrder,
        ];

        // Add FIB-specific fields
        if ($data['question_type'] === 'fib') {
            $questionData['correct_answer'] = $data['correct_answer'];
            $questionData['case_sensitive'] = $data['case_sensitive'] ?? false;
            $questionData['allow_partial_match'] = $data['allow_partial_match'] ?? false;
        }

        $question = $quiz->questions()->create($questionData);

        // Handle question type specific options/answers
        switch ($data['question_type']) {
            case 'mcq':
                $this->createMCQOptions($question, $data['options'], $data['correct_index']);
                break;
                
            case 'tf':
                $this->createTrueFalseOptions($question, $data['correct_answer_tf'] === 'true');
                break;
                
            case 'fib':
                // Create alternative answers if provided
                if (!empty($data['alternative_answers'])) {
                    foreach ($data['alternative_answers'] as $altAnswer) {
                        if (trim($altAnswer)) {
                            $question->acceptableAnswers()->create([
                                'answer_text' => trim($altAnswer),
                                'is_primary' => false,
                            ]);
                        }
                    }
                }
                break;
        }

        // Refresh total points for quiz
        $quiz->update(['total_points' => $quiz->questions()->sum('points')]);

        // Update max_scores entry
        MaxScore::updateOrCreate(
            [
                'subject_id' => $quiz->subject_id,
                'label' => $quiz->title,
            ],
            [
                'max_score' => $quiz->questions()->sum('points'),
            ]
        );

        // AJAX Response Support
        if ($request->expectsJson()) {
            // Load the question with relationships for JSON response
            $question->load('options', 'acceptableAnswers');
            
            return response()->json([
                'success' => true,
                'message' => 'Question added successfully!',
                'question' => [
                    'id' => $question->id,
                    'question_text' => $question->question_text,
                    'question_type' => $question->question_type,
                    'question_type_label' => $question->getQuestionTypeLabel(),
                    'points' => $question->points,
                    'time_limit_seconds' => $question->time_limit_seconds,
                    'correct_answer' => $question->correct_answer,
                    'case_sensitive' => $question->case_sensitive,
                    'allow_partial_match' => $question->allow_partial_match,
                    'options' => $question->options->map(function($option) {
                        return [
                            'id' => $option->id,
                            'option_text' => $option->option_text,
                            'is_correct' => $option->is_correct,
                            'display_order' => $option->display_order,
                        ];
                    }),
                    'alternative_answers' => $question->acceptableAnswers->pluck('answer_text')->toArray(),
                ]
            ]);
        }

        return back()->with('success', 'Question added successfully!');
    }

    private function createMCQOptions($question, $options, $correctIndex)
    {
        foreach ($options as $i => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct' => $i == $correctIndex,
                'display_order' => $i + 1,
            ]);
        }
    }

    private function createTrueFalseOptions($question, $correctAnswerIsTrue)
    {
        $question->options()->create([
            'option_text' => 'True',
            'is_correct' => $correctAnswerIsTrue,
            'display_order' => 1,
        ]);
        
        $question->options()->create([
            'option_text' => 'False',
            'is_correct' => !$correctAnswerIsTrue,
            'display_order' => 2,
        ]);
    }

    public function updateQuestion(Request $request, QuizQuestion $question)
    {
        $quiz = $question->quiz;
        abort_unless($quiz->teacher_id === Auth::id(), 403);

        // Base validation
        $rules = [
            'question_text' => 'required|string|max:2000',
            'points' => 'required|integer|min:1|max:100',
            'time_limit_seconds' => 'nullable|integer|min:5|max:3600',
        ];

        // Question type specific validation
        switch ($question->question_type) {
            case 'mcq':
            case 'tf':
                $rules['options'] = 'required|array|min:2|max:6';
                $rules['options.*.id'] = 'nullable|integer|exists:quiz_options,id';
                $rules['options.*.text'] = 'required|string|max:1000';
                $rules['correct_index'] = 'required|integer|min:0';
                break;
                
            case 'fib':
                $rules['correct_answer'] = 'required|string|max:500';
                $rules['case_sensitive'] = 'nullable|boolean';
                $rules['allow_partial_match'] = 'nullable|boolean';
                $rules['alternative_answers'] = 'nullable|array|max:5';
                $rules['alternative_answers.*'] = 'nullable|string|max:500';
                break;
        }

        $data = $request->validate($rules);

        // Update base question data
        $updateData = [
            'question_text' => $data['question_text'],
            'points' => $data['points'],
            'time_limit_seconds' => $data['time_limit_seconds'] ?? null,
        ];

        // Add FIB-specific updates
        if ($question->question_type === 'fib') {
            $updateData['correct_answer'] = $data['correct_answer'];
            $updateData['case_sensitive'] = $data['case_sensitive'] ?? false;
            $updateData['allow_partial_match'] = $data['allow_partial_match'] ?? false;
        }

        $question->update($updateData);

        // Handle question type specific updates
        switch ($question->question_type) {
            case 'mcq':
            case 'tf':
                // Sync options
                $keepIds = [];
                foreach ($data['options'] as $i => $opt) {
                    $isCorrect = ($i == $data['correct_index']);
                    if (!empty($opt['id'])) {
                        $option = $question->options()->whereKey($opt['id'])->firstOrFail();
                        $option->update([
                            'option_text' => $opt['text'],
                            'is_correct' => $isCorrect,
                            'display_order' => $i + 1,
                        ]);
                        $keepIds[] = $option->id;
                    } else {
                        $option = $question->options()->create([
                            'option_text' => $opt['text'],
                            'is_correct' => $isCorrect,
                            'display_order' => $i + 1,
                        ]);
                        $keepIds[] = $option->id;
                    }
                }
                $question->options()->whereNotIn('id', $keepIds)->delete();
                break;
                
            case 'fib':
                // Update alternative answers
                $question->acceptableAnswers()->delete(); // Clear existing
                if (!empty($data['alternative_answers'])) {
                    foreach ($data['alternative_answers'] as $altAnswer) {
                        if (trim($altAnswer)) {
                            $question->acceptableAnswers()->create([
                                'answer_text' => trim($altAnswer),
                                'is_primary' => false,
                            ]);
                        }
                    }
                }
                break;
        }

        $quiz->update(['total_points' => $quiz->questions()->sum('points')]);

        return back()->with('success', 'Question updated successfully!');
    }

    public function deleteQuestion(QuizQuestion $question)
    {
        $quiz = $question->quiz;
        abort_unless($quiz->teacher_id === Auth::id(), 403);

        $question->delete();

        $quiz->update(['total_points' => $quiz->questions()->sum('points')]);

        // AJAX Response Support
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Question deleted successfully!'
            ]);
        }

        return back()->with('success', 'Question deleted.');
    }
}