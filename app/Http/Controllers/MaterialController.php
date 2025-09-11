<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Subject;
use App\Models\User;
use App\Models\StudentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function teacherIndex(Request $request)
    {
        $subjects = Subject::where('teacher_id', Auth::id())->get();
        $selectedSubject = $request->subject_id;

        $materials = Material::where('teacher_id', Auth::id())
            ->when($selectedSubject, fn($q) => $q->where('subject_id', $selectedSubject))
            ->latest()
            ->withCount('submissions') 
            ->get();

        return view('materials.teacher.index', compact('materials', 'subjects', 'selectedSubject'));
    }

    public function create()
    {
        $subjects = Subject::where('teacher_id', Auth::id())->get();
        return view('materials.teacher.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
            'is_activity' => 'boolean',
            'due_date' => 'nullable|date|after:now',
        ]);

        $path = $request->file('file')->store('materials', 'public');

        Material::create([
            'teacher_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'is_activity' => $request->boolean('is_activity'),
            'due_date' => $request->due_date,
            'max_score'    => 100,
        ]);

        return redirect()->route('materials.teacher.index')->with('success', 'Material uploaded successfully.');
    }

    public function studentIndex(Request $request)
    {
        $student = Auth::user();
        $subjects = $student->subjects; // assumed relationship
        $selectedSubject = $request->subject_id;

        $materials = Material::whereIn('subject_id', $subjects->pluck('id'))
            ->when($selectedSubject, fn($q) => $q->where('subject_id', $selectedSubject))
            ->with(['submissions' => function($query) use ($student) {
                $query->where('student_id', $student->id);
            }])
            ->latest()
            ->get();

        return view('materials.student.index', compact('materials', 'subjects', 'selectedSubject'));
    }

    public function edit(Material $material)
    {
        // Optional: authorize teacher owns it
        if ($material->teacher_id !== Auth::id()) {
            abort(403);
        }
        $subjects = Subject::where('teacher_id', Auth::id())->get();
        return view('materials.teacher.edit', compact('material', 'subjects'));
    }

public function update(Request $request, Material $material)
{
    if ($material->teacher_id !== Auth::id()) {
        abort(403);
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'file' => 'nullable|file|max:10240', // 10 MB
        'is_activity' => 'boolean',
        'due_date' => 'nullable|date|after:now',
    ]);

    $material->title       = $request->title;
    $material->description = $request->description;
    $material->is_activity = $request->boolean('is_activity');
    $material->due_date    = $request->due_date;

    // ✅ Always enforce 100 if it's an activity
    if ($material->is_activity) {
        $material->max_score = 100;
    } else {
        $material->max_score = null; // or keep last value if you want
    }

    if ($request->hasFile('file')) {
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        $path = $request->file('file')->store('materials', 'public');
        $material->file_path = $path;
    }

    $material->save();

    return redirect()->route('materials.teacher.index')->with('success', 'Material updated successfully.');
}

    public function destroy(Material $material)
    {
        if ($material->teacher_id !== Auth::id()) {
            abort(403);
        }

        // Delete the file from storage
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        // Delete all submission files for this material
        $submissions = $material->submissions;
        foreach ($submissions as $submission) {
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }
        }

        $material->delete();
        return redirect()->route('materials.teacher.index')->with('success', 'Material deleted.');
    }

    public function download($id) 
    {
        $material = Material::findOrFail($id);
        
        // Optional: Add authorization check
        // For teachers - check if they own the material
        // For students - check if they're enrolled in the subject
        if (Auth::user()->role === 'teacher' && $material->teacher_id !== Auth::id()) {
            abort(403);
        }
        
        if (Auth::user()->role === 'student') {
            $studentSubjects = Auth::user()->subjects->pluck('id');
            if (!$studentSubjects->contains($material->subject_id)) {
                abort(403);
            }
        }
        
        // Get the full path using Laravel's Storage facade
        $filePath = storage_path('app/public/' . $material->file_path);
        
        // Security: check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }
        
        // Get original filename (you might want to store this in the database)
        $originalName = $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION);
        
        return response()->download($filePath, $originalName);
    }

    /**
     * Show form for student to submit activity
     */
    public function showSubmissionForm(Material $material)
    {
        // Check if it's an activity
        if (!$material->is_activity) {
            abort(404, 'This material does not accept submissions.');
        }

        // Check if student is enrolled in the subject
        $student = Auth::user();
        $studentSubjects = $student->subjects->pluck('id');
        if (!$studentSubjects->contains($material->subject_id)) {
            abort(403);
        }

        // Check if already submitted
        $existingSubmission = $material->submissions()->where('student_id', $student->id)->first();

        return view('materials.student.submit', compact('material', 'existingSubmission'));
    }

    /**
     * Store student submission
     */
    public function storeSubmission(Request $request, Material $material)
    {
        if (!$material->is_activity) {
            abort(404, 'This material does not accept submissions.');
        }

        $student = Auth::user();
        
        // Check if student is enrolled in the subject
        $studentSubjects = $student->subjects->pluck('id');
        if (!$studentSubjects->contains($material->subject_id)) {
            abort(403);
        }

        // Check if already submitted (unless allowing resubmission)
        $existingSubmission = $material->submissions()->where('student_id', $student->id)->first();
        if ($existingSubmission) {
            return redirect()->back()->with('error', 'You have already submitted this activity.');
        }

        $request->validate([
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,txt,jpg,jpeg,png,zip,rar', // Add allowed file types
        ]);

        $file = $request->file('file');
        $path = $file->store('submissions', 'public');

        // Determine if submission is late
        $status = 'submitted';
        if ($material->due_date && now() > $material->due_date) {
            $status = 'late';
        }

        StudentSubmission::create([
            'material_id' => $material->id,
            'student_id' => $student->id,
            'file_name' => $file->hashName(),
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'status' => $status,
            'submitted_at' => now(),
        ]);

        return redirect()->route('materials.student.index')->with('success', 'Activity submitted successfully!');
    }

    /**
     * View activity submissions (for teachers)
     */
    public function viewSubmissions(Material $material)
    {
        // Check if teacher owns the material
        if ($material->teacher_id !== Auth::id()) {
            abort(403);
        }

        $submissions = $material->submissions()
            ->with('student')
            ->orderBy('submitted_at', 'desc')
            ->get();

        // Get list of enrolled students who haven't submitted
        $submittedStudentIds = $submissions->pluck('student_id');
        $enrolledStudents = User::whereHas('subjects', function($query) use ($material) {
            $query->where('subject_id', $material->subject_id);
        })
        ->where('role', 'student')
        ->whereNotIn('id', $submittedStudentIds)
        ->get();

        return view('materials.teacher.submissions', compact('material', 'submissions', 'enrolledStudents'));
    }

    /**
     * Download student submission
     */
    public function downloadSubmission(StudentSubmission $submission)
    {
        $material = $submission->material;
        
        // Check if teacher owns the material or if it's the student's own submission
        if ($material->teacher_id !== Auth::id() && $submission->student_id !== Auth::id()) {
            abort(403);
        }

        $filePath = storage_path('app/public/' . $submission->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $submission->original_name);
    }

    /**
     * Provide feedback on submission
     */
public function provideFeedback(Request $request, StudentSubmission $submission)
{
    $material = $submission->material;

    // Check if teacher owns the material
    if ($material->teacher_id !== Auth::id()) {
        abort(403);
    }

    $request->validate([
        'feedback' => 'nullable|string|max:1000',
        'grade' => 'nullable|numeric|min:0|max:100',
    ]);

    // Update the submission record
    $submission->update([
        'teacher_feedback' => $request->feedback,
        'grade' => $request->grade,
        'status' => 'reviewed',
    ]);

    // ✅ Sync grade to Gradebook
    if ($submission->grade !== null) {
        $label = $material->title; // e.g. "Activity 1"
        $teacherId = Auth::id();
        $subjectId = $material->subject_id;

        // Save actual score
        \App\Models\Score::updateOrCreate(
            [
                'student_id' => $submission->student_id,
                'teacher_id' => $teacherId,
                'subject_id' => $subjectId,
                'label' => $label,
            ],
            [
                'type' => $material->is_activity ? 'activity' : 'assignment',
                'score' => $submission->grade,
            ]
        );

        // Save max score (always 100 if activity)
        \App\Models\MaxScore::updateOrCreate(
            [
                'subject_id' => $subjectId,
                'label' => $label,
            ],
            [
                'max_score' => $material->max_score ?? 100,
            ]
        );
    }

    return redirect()->back()->with('success', 'Feedback and grade saved, gradebook updated!');
}


    /**
     * Delete student submission (for students to delete their own before deadline)
     */
    public function deleteSubmission(StudentSubmission $submission)
    {
        $material = $submission->material;
        $user = Auth::user();

        // Check permissions
        if ($user->role === 'student') {
            // Students can only delete their own submissions before deadline
            if ($submission->student_id !== $user->id) {
                abort(403, 'You can only delete your own submissions.');
            }
            
            if ($material->due_date && now() > $material->due_date) {
                return redirect()->back()->with('error', 'Cannot delete submission after due date.');
            }
        } elseif ($user->role === 'teacher') {
            // Teachers can only delete submissions for their materials
            if ($material->teacher_id !== $user->id) {
                abort(403, 'Unauthorized access.');
            }
        } else {
            abort(403, 'Unauthorized access.');
        }

        // Delete the file from storage
        if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
            Storage::disk('public')->delete($submission->file_path);
        }

        $submission->delete();

        return redirect()->back()->with('success', 'Submission deleted successfully.');
    }

    /**
     * Show individual submission details
     */
    public function showSubmission(StudentSubmission $submission)
    {
        $material = $submission->material;
        
        // Check if teacher owns the material or if it's the student's own submission
        if ($material->teacher_id !== Auth::id() && $submission->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('materials.submission-details', compact('submission', 'material'));
    }

    /**
     * Get student's own submissions
     */
    public function mySubmissions()
    {
        $student = Auth::user();
        
        if ($student->role !== 'student') {
            abort(403);
        }
        
        $submissions = StudentSubmission::where('student_id', $student->id)
            ->with(['material', 'material.subject', 'material.teacher'])
            ->orderBy('submitted_at', 'desc')
            ->get();

        return view('materials.student.my-submissions', compact('submissions'));
    }

    /**
     * Allow students to resubmit (if enabled by teacher)
     */
    public function resubmit(Material $material)
    {
        if (!$material->is_activity) {
            abort(404, 'This material does not accept submissions.');
        }

        $student = Auth::user();
        
        // Check if student is enrolled in the subject
        $studentSubjects = $student->subjects->pluck('id');
        if (!$studentSubjects->contains($material->subject_id)) {
            abort(403);
        }

        // Check if past due date
        if ($material->due_date && now() > $material->due_date) {
            return redirect()->back()->with('error', 'Cannot resubmit after due date.');
        }

        $existingSubmission = $material->submissions()->where('student_id', $student->id)->first();

        return view('materials.student.resubmit', compact('material', 'existingSubmission'));
    }

    /**
     * Update/replace student submission
     */
    public function updateSubmission(Request $request, StudentSubmission $submission)
    {
        $material = $submission->material;
        $student = Auth::user();

        // Check if it's student's own submission
        if ($submission->student_id !== $student->id) {
            abort(403);
        }

        // Check if past due date
        if ($material->due_date && now() > $material->due_date) {
            return redirect()->back()->with('error', 'Cannot update submission after due date.');
        }

        $request->validate([
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,txt,jpg,jpeg,png,zip,rar',
        ]);

        $file = $request->file('file');

        // Delete old file
        if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
            Storage::disk('public')->delete($submission->file_path);
        }

        // Store new file
        $path = $file->store('submissions', 'public');

        // Determine if submission is late
        $status = 'submitted';
        if ($material->due_date && now() > $material->due_date) {
            $status = 'late';
        }

        $submission->update([
            'file_name' => $file->hashName(),
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'status' => $status,
            'submitted_at' => now(),
            // Reset feedback when resubmitted
            'teacher_feedback' => null,
            'grade' => null,
        ]);

        return redirect()->route('materials.student.index')->with('success', 'Activity resubmitted successfully!');
    }
}