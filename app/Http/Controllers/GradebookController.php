<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Score;
use App\Models\Subject;
use App\Models\MaxScore;
use App\Models\Quiz;
use Illuminate\Http\Request;

class GradebookController extends Controller
{
    public function teacherView(Request $request)
    {
        $teacher = auth()->user();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        $selectedSubject = $request->subject_id ?? $subjects->first()?->id;

        $selectedSubjectModel = Subject::with('students')->find($selectedSubject);
        $students = $selectedSubjectModel ? $selectedSubjectModel->students : collect();

        $scores = Score::where('teacher_id', $teacher->id)
            ->where('subject_id', $selectedSubject)
            ->whereNotNull('student_id')
            ->get()
            ->groupBy('student_id');

        $columns = Score::where('teacher_id', $teacher->id)
            ->where('subject_id', $selectedSubject)
            ->whereNotNull('student_id')
            ->pluck('label')
            ->unique()
            ->filter()
            ->values()
            ->toArray();

        $maxScores = MaxScore::where('subject_id', $selectedSubject)
            ->pluck('max_score', 'label');

        return view('gradebook.teacher.sheet', compact(
            'students', 'subjects', 'selectedSubject', 'scores', 'columns', 'maxScores'
        ));
    }

    public function updateScores(Request $request)
    {
        $teacherId = auth()->id();
        $subjectId = $request->input('subject_id');
        $data = $request->input('data', []);
        $maxScores = $request->input('max_scores', []);

        foreach ($data as $row) {
            $studentId = $row['student_id'];
            foreach ($row['scores'] as $label => $scoreData) {
                // Handle both old format (just score) and new format (object with score and type)
                $scoreValue = is_array($scoreData) ? ($scoreData['score'] ?? null) : $scoreData;
                $providedType = is_array($scoreData) ? ($scoreData['type'] ?? null) : null;
                
                if ($scoreValue === '' || $scoreValue === null) continue;

                // ✅ BEST FIX: Check if this score is linked to a quiz
                $existingScore = Score::where('student_id', $studentId)
                    ->where('teacher_id', $teacherId)
                    ->where('subject_id', $subjectId)
                    ->where('label', $label)
                    ->first();

                $type = null;

                // Priority 1: If score has quiz_id, get type from quiz table
                if ($existingScore && $existingScore->quiz_id) {
                    $quiz = Quiz::find($existingScore->quiz_id);
                    if ($quiz) {
                        $type = $quiz->type; // Get actual type from quiz
                    }
                }

                // Priority 2: Type provided from frontend (has database context)
                if (!$type && $providedType) {
                    $type = $providedType;
                }

                // Priority 3: Existing score type in database
                if (!$type && $existingScore && $existingScore->type) {
                    $type = $existingScore->type;
                }

                // Priority 4: Check if label matches any quiz title
                if (!$type) {
                    $matchingQuiz = Quiz::where('teacher_id', $teacherId)
                        ->where('subject_id', $subjectId)
                        ->where('title', $label)
                        ->first();
                    
                    if ($matchingQuiz) {
                        $type = $matchingQuiz->type;
                    }
                }

                // Priority 5: Auto-detect from label (last resort)
                if (!$type) {
                    $labelLower = strtolower($label);
                    if (str_contains($labelLower, 'quiz')) {
                        $type = 'quiz';
                    } elseif (str_contains($labelLower, 'exam')) {
                        $type = 'exam';
                    } elseif (str_contains($labelLower, 'attendance') || str_contains($labelLower, 'character')) {
                        $type = 'attendance';
                    } else {
                        $type = 'activity';
                    }
                }

                // ✅ Save score while preserving quiz_id if it exists
                $scoreUpdateData = [
                    'type' => $type,
                    'score' => $scoreValue,
                ];

                // Preserve quiz_id if updating an existing quiz score
                if ($existingScore && $existingScore->quiz_id) {
                    $scoreUpdateData['quiz_id'] = $existingScore->quiz_id;
                }

                Score::updateOrCreate([
                    'student_id' => $studentId,
                    'teacher_id' => $teacherId,
                    'subject_id' => $subjectId,
                    'label' => $label,
                ], $scoreUpdateData);

                // ✅ Always enforce activity max = 100
                if ($type === 'activity') {
                    MaxScore::updateOrCreate([
                        'subject_id' => $subjectId,
                        'label' => $label,
                    ], [
                        'max_score' => 100,
                    ]);
                }
            }
        }

        // ✅ Handle max scores
        foreach ($maxScores as $label => $max) {
            if ($max === '' || $max === null) continue;

            // Check if this label is linked to a quiz
            $existingScoreWithQuizId = Score::where('subject_id', $subjectId)
                ->where('label', $label)
                ->whereNotNull('quiz_id')
                ->first();

            $type = null;

            // Get type from quiz if linked
            if ($existingScoreWithQuizId && $existingScoreWithQuizId->quiz_id) {
                $quiz = Quiz::find($existingScoreWithQuizId->quiz_id);
                if ($quiz) {
                    $type = $quiz->type;
                }
            }

            // Check if label matches a quiz title
            if (!$type) {
                $matchingQuiz = Quiz::where('subject_id', $subjectId)
                    ->where('title', $label)
                    ->first();
                
                if ($matchingQuiz) {
                    $type = $matchingQuiz->type;
                }
            }

            // Fallback to existing score type
            if (!$type) {
                $type = Score::where('subject_id', $subjectId)
                    ->where('label', $label)
                    ->value('type');
            }

            // Last resort: detect from label
            if (!$type) {
                $labelLower = strtolower($label);
                if (str_contains($labelLower, 'quiz')) {
                    $type = 'quiz';
                } elseif (str_contains($labelLower, 'exam')) {
                    $type = 'exam';
                } elseif (str_contains($labelLower, 'attendance') || str_contains($labelLower, 'character')) {
                    $type = 'attendance';
                } else {
                    $type = 'activity';
                }
            }

            // Activities stay locked at 100
            if ($type !== 'activity') {
                MaxScore::updateOrCreate([
                    'subject_id' => $subjectId,
                    'label' => $label,
                ], [
                    'max_score' => $max,
                ]);
            }
        }

        return response()->json(['message' => 'Scores and max scores updated']);
    }

public function studentView(Request $request)
    {
        $student = auth()->user();
        $subjects = $student->subjects;
        $subjectId = $request->input('subject_id');
        $subject = Subject::find($subjectId) ?? $subjects->first();

        if (!$subject) {
            return view('gradebook.student.view', [
                'scores' => [],
                'columns' => [],
                'maxScores' => [],
                'subject' => null,
                'subjects' => [],
            ]);
        }

        $scoresRaw = Score::where('student_id', $student->id)
            ->where('subject_id', $subject->id)
            ->whereNotNull('score')  // Only get graded entries
            ->get();

        $scores = $scoresRaw->pluck('score', 'label');

        $maxScores = MaxScore::where('subject_id', $subject->id)
            ->pluck('max_score', 'label');

        // Only include columns that have scores (filter out ungraded)
        $columns = $scores->keys()
            ->unique()
            ->values()
            ->toArray();

        return view('gradebook.student.view', [
            'scores' => $scores,
            'columns' => $columns,
            'maxScores' => $maxScores,
            'subject' => $subject,
            'subjects' => $subjects,
        ]);
    }

    public function show($subjectId)
    {
        $subject = Subject::with('students')->findOrFail($subjectId);

        return view('gradebook.teacher.index', compact('subject'));
    }
}