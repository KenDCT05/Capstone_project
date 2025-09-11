<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Score;
use App\Models\Subject;
use App\Models\MaxScore;
use Illuminate\Http\Request;

class GradebookController extends Controller
{
    public function teacherView(Request $request)
    {
        $teacher = auth()->user();
        $subjects = Subject::where('teacher_id', $teacher->id)->get(); // ✅ Only teacher's subjects
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
            foreach ($row['scores'] as $label => $scoreValue) {
                if ($scoreValue === '' || $scoreValue === null) continue;

                // ✅ Auto-detect type
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

                // ✅ Save actual score
                Score::updateOrCreate([
                    'student_id' => $studentId,
                    'teacher_id' => $teacherId,
                    'subject_id' => $subjectId,
                    'label' => $label,
                ], [
                    'type' => $type,
                    'score' => $scoreValue,
                ]);

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

        // ✅ Still allow teacher to set max scores for quizzes/exams
        foreach ($maxScores as $label => $max) {
            if ($max === '' || $max === null) continue;

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

            if ($type !== 'activity') { // 👈 Activities stay locked at 100
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
        $subjects = $student->subjects; // ✅ Only enrolled subjects
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
            ->get();

        $scores = $scoresRaw->pluck('score', 'label');

        $maxScores = MaxScore::where('subject_id', $subject->id)
            ->pluck('max_score', 'label');

        $columns = $scores->keys()
            ->merge($maxScores->keys())
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
