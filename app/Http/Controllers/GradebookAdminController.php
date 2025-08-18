<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Score;

class GradebookAdminController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::all();
        $teachers = User::where('role', 'teacher')->get();

        // Early exit if no subjects or teachers
        if ($subjects->isEmpty() || $teachers->isEmpty()) {
            return view('gradebook.admin.override', [
                'subjects' => $subjects,
                'teachers' => $teachers,
                'selectedSubject' => null,
                'selectedTeacher' => null,
                'students' => collect(),
                'scores' => collect(),
            ]);
        }

        $selectedSubject = $request->subject_id ?? $subjects->first()->id;
        $selectedTeacher = $request->teacher_id ?? $teachers->first()->id;

        $students = User::where('role', 'student')
            ->whereHas('teachers', function ($q) use ($selectedTeacher) {
                $q->where('teacher_id', $selectedTeacher);
            })->get();

        $scores = Score::where('subject_id', $selectedSubject)
            ->where('teacher_id', $selectedTeacher)
            ->get();

        return view('gradebook.admin.override', compact(
            'subjects',
            'teachers',
            'selectedSubject',
            'selectedTeacher',
            'students',
            'scores'
        ));
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'data' => 'required|array',
        ]);

        foreach ($validated['data'] as $entry) {
            $studentId = $entry['student_id'];
            $scores = $entry['scores'] ?? [];

            foreach ($scores as $label => $score) {
                Score::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'teacher_id' => $validated['teacher_id'],
                        'subject_id' => $validated['subject_id'],
                        'label' => $label,
                    ],
                    ['score' => $score ?? 0]
                );
            }
        }

        return response()->json(['message' => 'Gradebook saved successfully.']);
    }
}
