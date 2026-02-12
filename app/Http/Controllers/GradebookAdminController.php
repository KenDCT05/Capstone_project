<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Score;
use App\Models\Subject;
use App\Models\MaxScore;
use Illuminate\Http\Request;

class GradebookAdminController extends Controller
{
    public function index(Request $request)
    {
        $teachers = User::where('role', 'teacher')->get();

        // Early exit if no teachers
        if ($teachers->isEmpty()) {
            return view('gradebook.admin.override', [
                'teachers' => $teachers,
                'subjects' => collect(),
                'selectedTeacher' => null,
                'selectedSubject' => null,
                'students' => collect(),
                'scores' => collect(),
                'columns' => [],
                'maxScores' => [],
            ]);
        }

        $selectedTeacher = $request->teacher_id ?? $teachers->first()->id;
        
        // Get subjects for the selected teacher
        $subjects = Subject::where('teacher_id', $selectedTeacher)->get();

        // Early exit if teacher has no subjects
        if ($subjects->isEmpty()) {
            return view('gradebook.admin.override', [
                'teachers' => $teachers,
                'subjects' => $subjects,
                'selectedTeacher' => $selectedTeacher,
                'selectedSubject' => null,
                'students' => collect(),
                'scores' => collect(),
                'columns' => [],
                'maxScores' => [],
            ]);
        }

        // FIX: Validate that the selected subject belongs to the selected teacher
        $selectedSubject = null;
        if ($request->subject_id) {
            // Check if the requested subject belongs to the selected teacher
            $requestedSubject = $subjects->where('id', $request->subject_id)->first();
            if ($requestedSubject) {
                $selectedSubject = $request->subject_id;
            }
        }
        
        // If no valid subject selected, default to first subject of the teacher
        if (!$selectedSubject) {
            $selectedSubject = $subjects->first()->id;
        }

        // Get students enrolled in the selected subject
        $selectedSubjectModel = Subject::with('students')->find($selectedSubject);
        $students = $selectedSubjectModel ? $selectedSubjectModel->students : collect();

        // Get scores for the specific subject and teacher combination
        $scores = Score::where('subject_id', $selectedSubject)
            ->where('teacher_id', $selectedTeacher)
            ->whereNotNull('student_id')
            ->get()
            ->groupBy('student_id');

        // Get all unique labels including attendance
        $columns = Score::where('teacher_id', $selectedTeacher)
            ->where('subject_id', $selectedSubject)
            ->whereNotNull('student_id')
            ->pluck('label')
            ->unique()
            ->filter()
            ->values()
            ->toArray();

        // Ensure Attendance is always included
        if (!in_array('Attendance', $columns)) {
            $columns[] = 'Attendance';
        }

        // Get max scores
        $maxScores = MaxScore::where('subject_id', $selectedSubject)
            ->pluck('max_score', 'label');

        // Set default max score for Attendance if not exists
        if (!isset($maxScores['Attendance'])) {
            MaxScore::updateOrCreate([
                'subject_id' => $selectedSubject,
                'label' => 'Attendance',
            ], [
                'max_score' => 10, // Default attendance max score
            ]);
            $maxScores['Attendance'] = 10;
        }

        return view('gradebook.admin.override', compact(
            'teachers',
            'subjects',
            'selectedTeacher',
            'selectedSubject',
            'students',
            'scores',
            'columns',
            'maxScores'
        ));
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'data' => 'required|array',
            'max_scores' => 'array',
        ]);

        $subjectId = $validated['subject_id'];
        $teacherId = $validated['teacher_id'];

        foreach ($validated['data'] as $entry) {
            $studentId = $entry['student_id'];
            $scores = $entry['scores'] ?? [];

            foreach ($scores as $label => $score) {
                // Skip empty scores
                if ($score === '' || $score === null) continue;
                
                // Auto-detect type based on label
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

                Score::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'teacher_id' => $teacherId,
                        'subject_id' => $subjectId,
                        'label' => $label,
                    ],
                    [
                        'score' => $score,
                        'type' => $type
                    ]
                );
            }
        }

        // Handle max scores updates
        if (isset($validated['max_scores'])) {
            foreach ($validated['max_scores'] as $label => $maxScore) {
                if ($maxScore === '' || $maxScore === null) continue;

                MaxScore::updateOrCreate([
                    'subject_id' => $subjectId,
                    'label' => $label,
                ], [
                    'max_score' => $maxScore,
                ]);
            }
        }

        return response()->json(['message' => 'Gradebook saved successfully.']);
    }
}