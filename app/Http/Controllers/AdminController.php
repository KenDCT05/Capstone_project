<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ========= Dashboard Redirect Based on Role =========
    public function redirectDashboard()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Make sure this view exists: resources/views/admin/dashboard.blade.php
            $recentTeachers = User::where('role', 'teacher')->latest()->take(5)->get();
            $recentStudents = User::where('role', 'student')->latest()->take(5)->get();

            return view('admin.dashboard', compact('recentTeachers', 'recentStudents'));
        }

        if ($user->role === 'teacher') {
            return redirect()->route('dashboard.teacher');
        }

        if ($user->role === 'student') {
            return redirect()->route('dashboard.student');
        }

        abort(403, 'Unauthorized role.');
    }

    // ========= Dashboard Views =========
public function teacherDashboard()
{
    $teacherId = auth()->id();

    // Get the subjects created by this teacher
    $subjects = Subject::with('students')
        ->where('teacher_id', $teacherId)
        ->get();

    // Count of subjects created
    $subjectCount = $subjects->count();

    // Collect all unique students from all subjects (avoid duplicate students across multiple subjects)
    $studentIds = $subjects->flatMap(function ($subject) {
        return $subject->students->pluck('id');
    })->unique();

    $studentCount = $studentIds->count();

    return view('dashboard.teacher', compact('subjectCount', 'studentCount', 'subjects'));
}
    // ========= Registration Forms =========
    public function showStudentForm()
    {
        return view('admin.register-student');
    }

    public function showTeacherForm()
    {
        return view('admin.register-teacher');
    }

    // ========= Register Users =========
    public function registerTeacher(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'birthday' => 'required|date',
            'contact_number' => 'required|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'contact_number' => $request->contact_number,
            'role' => 'teacher',
            'password' => Hash::make('GSSM2025'),
        ]);

        return redirect()->route('admin.register.teacher')->with('success', 'Teacher registered successfully!');
    }

    public function registerStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'birthday' => 'required|date',
            'gender' => 'required|in:male,female',
            'grade_level' => 'required|string',
            'section' => 'required|string',
            'guardian_name' => 'required|string|max:255',
            'guardian_email' => 'required|email',
            'guardian_contact' => 'required|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'grade_level' => $request->grade_level,
            'section' => $request->section,
            'guardian_name' => $request->guardian_name,
            'guardian_email' => $request->guardian_email,
            'guardian_contact' => $request->guardian_contact,
            'role' => 'student',
            'password' => Hash::make('GSSM2025'),
        ]);

        return redirect()->route('admin.register.student')->with('success', 'Student registered successfully!');
    }

    // ========= Assignment =========
    public function assignForm()
    {
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();

        return view('admin.assign', compact('students', 'teachers'));
    }

    public function assignRandom()
    {
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();

        // Check if we have students and teachers
        if ($students->isEmpty()) {
            return back()->with('error', 'No students found to assign.');
        }

        if ($teachers->isEmpty()) {
            return back()->with('error', 'No teachers found for assignment.');
        }

        // Clear all existing assignments first
        foreach ($teachers as $teacher) {
            $teacher->students()->detach();
        }

        // Calculate how many students each teacher should get
        $studentsPerTeacher = intval($students->count() / $teachers->count());
        $remainingStudents = $students->count() % $teachers->count();

        // Shuffle students for random distribution
        $shuffledStudents = $students->shuffle();
        $studentIndex = 0;

        foreach ($teachers as $index => $teacher) {
            // Calculate how many students this teacher gets
            $currentTeacherStudentCount = $studentsPerTeacher;
            
            // Distribute remaining students to first few teachers
            if ($index < $remainingStudents) {
                $currentTeacherStudentCount++;
            }

            // Get the students for this teacher
            $studentsForTeacher = $shuffledStudents->slice($studentIndex, $currentTeacherStudentCount);
            
            // Assign students to teacher
            if ($studentsForTeacher->isNotEmpty()) {
                $teacher->students()->sync($studentsForTeacher->pluck('id')->toArray());
            }

            // Move to next batch of students
            $studentIndex += $currentTeacherStudentCount;
        }

        return back()->with('success', 'Students assigned randomly and evenly across all teachers.');
    }

    public function assignManual(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        $teacher = User::findOrFail($request->teacher_id);
        $teacher->students()->syncWithoutDetaching($request->student_ids);

        return back()->with('success', 'Students assigned manually.');
    }

    public function unassignTeacher(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $student = User::where('role', 'student')->findOrFail($request->student_id);
        $student->teachers()->detach($request->teacher_id);

        return back()->with('success', 'Teacher unassigned from student successfully.');
    }
public function index()
{
    $teacher = Auth::user();

    // Get all subjects created by the teacher
    $subjects = Subject::with('students')
        ->where('teacher_id', $teacher->id)
        ->get();

    // Count of subjects
    $subjectCount = $subjects->count();

    // Unique students across all subjects
    $students = $subjects->flatMap->students;
    $studentCount = $students->unique('id')->count();

    return view('dashboard.teacher', compact('subjectCount', 'studentCount', 'subjects'));
}

}