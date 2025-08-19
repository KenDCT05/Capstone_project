<?php
// app/Http/Controllers/Teacher/QuizController.php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\{Quiz, QuizQuestion, QuizOption, Subject};
use Illuminate\Http\Request;
use App\Models\MaxScore;
use App\Models\Score;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $quiz->load('questions.options','subject');
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

    // ----- Questions -----
    public function addQuestion(Request $request, Quiz $quiz)
{
    abort_unless($quiz->teacher_id === Auth::id(), 403);

    $data = $request->validate([
        'question_type' => 'required|in:mcq,tf',
        'question_text' => 'required|string',
        'points' => 'required|integer|min:1|max:100',
        'time_limit_seconds' => 'nullable|integer|min:5|max:3600',
        'options' => 'required|array|min:2|max:6',
        'options.*' => 'required|string|max:1000',
        'correct_index' => 'required|integer|min:0',
    ]);

    $displayOrder = ($quiz->questions()->max('display_order') ?? 0) + 1;

    $question = $quiz->questions()->create([
        'question_type' => $data['question_type'],
        'question_text' => $data['question_text'],
        'points' => $data['points'],
        'time_limit_seconds' => $data['time_limit_seconds'] ?? null,
        'display_order' => $displayOrder,
    ]);

    foreach ($data['options'] as $i => $text) {
        $question->options()->create([
            'option_text' => $text,
            'is_correct' => ($i == $data['correct_index']),
            'display_order' => $i + 1,
        ]);
    }

    // Refresh total points for quiz
    $quiz->update(['total_points' => $quiz->questions()->sum('points')]);

    // --- Update max_scores entry ---
    MaxScore::updateOrCreate(
        [
            'subject_id' => $quiz->subject_id,
            'label' => $quiz->title,
        ],
        [
            'max_score' => $quiz->questions()->sum('points'),
        ]
    );

    return back()->with('success', 'Question added and gradebook updated.');
}

    public function updateQuestion(Request $request, QuizQuestion $question)
    {
        $quiz = $question->quiz;
        abort_unless($quiz->teacher_id === Auth::id(), 403);

        $data = $request->validate([
            'question_text'       => 'required|string',
            'points'              => 'required|integer|min:1|max:100',
            'time_limit_seconds'  => 'nullable|integer|min:5|max:3600',
            'options'             => 'required|array|min:2|max:6',
            'options.*.id'        => 'nullable|integer|exists:quiz_options,id',
            'options.*.text'      => 'required|string|max:1000',
            'correct_index'       => 'required|integer|min:0',
        ]);

        $question->update([
            'question_text'      => $data['question_text'],
            'points'             => $data['points'],
            'time_limit_seconds' => $data['time_limit_seconds'] ?? null,
        ]);

        // Sync options
        $keepIds = [];
        foreach ($data['options'] as $i => $opt) {
            $isCorrect = ($i == $data['correct_index']);
            if (!empty($opt['id'])) {
                $option = $question->options()->whereKey($opt['id'])->firstOrFail();
                $option->update([
                    'option_text'   => $opt['text'],
                    'is_correct'    => $isCorrect,
                    'display_order' => $i + 1,
                ]);
                $keepIds[] = $option->id;
            } else {
                $option = $question->options()->create([
                    'option_text'   => $opt['text'],
                    'is_correct'    => $isCorrect,
                    'display_order' => $i + 1,
                ]);
                $keepIds[] = $option->id;
            }
        }
        $question->options()->whereNotIn('id', $keepIds)->delete();

        $quiz->update(['total_points' => $quiz->questions()->sum('points')]);

        return back()->with('success', 'Question updated.');
    }

    public function deleteQuestion(QuizQuestion $question)
    {
        $quiz = $question->quiz;
        abort_unless($quiz->teacher_id === Auth::id(), 403);

        $question->delete();

        $quiz->update(['total_points' => $quiz->questions()->sum('points')]);

        return back()->with('success', 'Question deleted.');
    }
}
