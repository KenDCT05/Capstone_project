<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\EngagementLog;

class SubjectController extends Controller
{
    // Show create form (for teachers)
public function create()
{
    // Get all sections with year_level
    $sections = \App\Models\Section::orderBy('year_level')
                                   ->orderBy('name')
                                   ->get();
    
    $subjects = \App\Models\SubjectList::orderBy('name')->get();
    
    return view('subjects.create', compact('sections', 'subjects'));
}

    // Store new subject
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $subject = Subject::create([
            'name' => $request->name,
            'description' => $request->description,
            'teacher_id' => auth()->id(),
            'join_code' => strtoupper(Str::random(6)), 
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject created!');
    }

    // Show join form for students
    public function joinForm()
    {
        return view('subjects.join');
    }

    // Process student joining via code
    public function join(Request $request)
    {
        $request->validate([
            'join_code' => 'required|string|exists:subjects,join_code',
        ]);

        $subject = Subject::where('join_code', $request->join_code)->first();

        // Avoid duplicate enroll
        if (! $subject->students->contains(auth()->id())) {
            $subject->students()->attach(auth()->id());
        }
        EngagementLog::create([
            'user_id' => auth()->id(),
            'subject_id' => $subject->id,
            'action'  => 'course_enrollment',
            'context' => 'subject:' . $subject->id,
            'value'   => 1,
        ]);
        return redirect()->route('student.subjects.index')->with('success', 'Joined subject successfully!');
    }
    public function index()
{
    $teacher = auth()->user();

    // Only fetch subjects created by this teacher
    $subjects = Subject::with('students')->where('teacher_id', $teacher->id)->get();

    return view('subjects.index', compact('subjects'));
}
public function studentSubjects()
{
    $user = auth()->user();

    // Get all subjects the student is enrolled in
    $subjects = $user->subjects()->with('teacher')->get();

    return view('subjects.student-index', compact('subjects'));
}
public function show($id)
{
    $subject = Subject::with('students')->findOrFail($id);
    return view('subjects.show', compact('subject'));
}
public function removeStudent($subjectId, $studentId)
{
    $subject = Subject::findOrFail($subjectId);
    $student = User::findOrFail($studentId);

    // Detach the student
    $subject->students()->detach($studentId);

    return redirect()->back()->with('success', 'Student removed successfully.');
}
public function destroy($id)
{
    $subject = Subject::findOrFail($id);

    // Optionally detach students first to clean up pivot table
    $subject->students()->detach();

    $subject->delete();

    return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
}
public function studentIndex()
{
    $user = auth()->user();

    // Fetch subjects the student is enrolled in
    $subjects = $user->subjects;

    return view('subjects.student-index', compact('subjects'));
}

}
