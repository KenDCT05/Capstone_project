<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Subject;
use App\Models\User;
use App\Models\StudentSubmission;
use Illuminate\Http\Request;
use App\Models\EngagementLog;
use App\Models\MaxScore;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
    Log::info('Material Store Request', [
    'all_data' => $request->all(),
    'is_activity' => $request->boolean('is_activity'),
    'due_date' => $request->due_date,
]);

 
    $request->validate([
        'subject_id' => 'required|exists:subjects,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'file' => 'required|file|max:10240',
        'is_activity' => 'boolean',
        'due_date' => 'nullable|date|after_or_equal:' . now()->subMinutes(5)->toDateTimeString(),
    ]);

    try {
        DB::beginTransaction();

        if ($request->due_date) {
            $dueDate = Carbon::parse($request->due_date);
            $now = Carbon::now();
        if ($dueDate->lt($now->subMinutes(10))) {
                DB::rollback();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Due date cannot be more than 10 minutes in the past.');
            }
        }

        // Store file first
        $path = $request->file('file')->store('materials', 'public');

        $material = Material::create([
            'teacher_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'is_activity' => $request->boolean('is_activity'),
            'max_score' => $request->boolean('is_activity') ? 100 : null,
            'due_date' => $request->due_date,
        ]);

        DB::commit();

        return redirect()->route('materials.teacher.index')
            ->with('success', 'Material uploaded successfully.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors specifically
        DB::rollback();
        
        if (isset($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
        
        return redirect()->back()
            ->withInput()
            ->withErrors($e->validator);
            
    } catch (\Exception $e) {
        DB::rollback();
        
        // Clean up uploaded file if database operation failed
        if (isset($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        Log::error('Material creation failed', [
            'user_id' => Auth::id(),
            'error' => $e->getMessage(),
            'due_date' => $request->due_date,
            'current_time' => now()->toDateTimeString(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to upload material: ' . $e->getMessage());
    }
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

        // ✅ Fixed validation for updates too
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'is_activity' => 'boolean',
            'due_date' => 'nullable|date|after_or_equal:now', // ✅ Allow current time
        ]);

        try {
            DB::beginTransaction();

            $oldFilePath = null;

            // Handle file upload if present
            if ($request->hasFile('file')) {
                $oldFilePath = $material->file_path;
                $path = $request->file('file')->store('materials', 'public');
                $material->file_path = $path;
            }

            $material->title = $request->title;
            $material->description = $request->description;
            $material->is_activity = $request->boolean('is_activity');
            $material->due_date = $request->due_date;

            // Always enforce 100 if it's an activity
            if ($material->is_activity) {
                $material->max_score = 100;
            } else {
                $material->max_score = 0; // Instead of null
            }

            $material->save();

            // Delete old file after successful save
            if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            DB::commit();

            return redirect()->route('materials.teacher.index')->with('success', 'Material updated successfully.');

        } catch (\Exception $e) {
            DB::rollback();

            // Clean up new file if upload succeeded but database failed
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            Log::error('Material update failed', [
                'material_id' => $material->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update material. Please try again.');
        }
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
            EngagementLog::create([             
                'user_id' => Auth::id(),  
                'subject_id' => $material->subject_id,           
                'action'  => 'material_download',             
                'context' => 'material:' . $material->id,
                'value'   => 1,         
            ]); 
        
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

        // Check for existing submission
        $existingSubmission = $material->submissions()->where('student_id', $student->id)->first();
        if ($existingSubmission) {
            return redirect()->back()->with('error', 'You have already submitted this activity.');
        }

        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240', // 10MB
                'mimes:pdf,doc,docx,txt,jpg,jpeg,png,zip,rar,ppt,pptx,xls,xlsx'
            ],
        ], [
            'file.required' => 'Please select a file to upload.',
            'file.max' => 'File size cannot exceed 10MB.',
            'file.mimes' => 'Invalid file type. Allowed types: PDF, DOC, DOCX, TXT, JPG, JPEG, PNG, ZIP, RAR, PPT, PPTX, XLS, XLSX.',
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            $now = Carbon::now();
            
            // Better file storage with collision prevention
            $fileName = time() . '_' . $student->id . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('submissions', $fileName, 'public');

            // ✅ UPDATED: Use compound status system
            $isLate = false;
            if ($material->due_date) {
                $dueDate = Carbon::parse($material->due_date);
                if ($now->gt($dueDate)) {
                    $isLate = true;
                }
            }

            // Set initial status based on timing
            $status = $isLate ? 'late' : 'submitted';

            $submission = StudentSubmission::create([
                'material_id' => $material->id,
                'student_id' => $student->id,
                'file_name' => $fileName,
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'status' => $status,
                'is_late' => $isLate, // ✅ NEW: Track timing separately
                'submitted_at' => $now,
            ]);

            // Log engagement
            EngagementLog::create([
                'user_id' => $student->id,
                'subject_id' => $material->subject_id,
                'action' => 'activity_upload',
                'context' => 'material:' . $material->id,
                'value' => 1,
            ]);
            
            DB::commit();

            $message = $isLate 
                ? 'Activity submitted successfully, but marked as LATE submission!'
                : 'Activity submitted successfully!';

            return redirect()->route('materials.student.index')->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            
            return redirect()->back()
                ->withInput()
                ->withErrors($e->validator);
                
        } catch (\Exception $e) {
            DB::rollback();

            // Clean up uploaded file if database operation failed
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            Log::error('Submission failed', [
                'material_id' => $material->id,
                'student_id' => $student->id,
                'error' => $e->getMessage(),
                'due_date' => $material->due_date,
                'current_time' => $now->toDateTimeString(),
                'file_size' => $file ? $file->getSize() : null,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to submit activity: ' . $e->getMessage())
                ->withInput();
        }
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

    $newStatus = $submission->is_late ? 'late_reviewed' : 'reviewed';

    // ✅ SOLUTION 1: Use timestamps => false to prevent automatic timestamp updates
    $submission->timestamps = false;
    
    // ✅ Only update feedback, grade, and status — leave submitted_at untouched
    $submission->update([
        'teacher_feedback' => $request->feedback,
        'grade' => $request->grade,
        'status' => $newStatus,
    ]);
    
    // ✅ Re-enable timestamps for future operations
    $submission->timestamps = true;

    // Sync grade to Gradebook (unchanged)
    if ($submission->grade !== null) {
        $label = $material->title;
        $teacherId = Auth::id();
        $subjectId = $material->subject_id;

        Score::updateOrCreate(
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

        MaxScore::updateOrCreate(
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
            // Students can only delete their own submissions
            if ($submission->student_id !== $user->id) {
                abort(403, 'You can only delete your own submissions.');
            }
            
            // ✅ OPTIONAL: You can remove this restriction entirely, or add a teacher setting
            // For now, let's allow deletion but warn if past due date
            if ($material->due_date && now() > $material->due_date) {
                // Still allow deletion but add warning in the redirect message
                $warningMessage = 'Submission deleted (note: this was submitted after the due date).';
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

        $message = isset($warningMessage) ? $warningMessage : 'Submission deleted successfully.';
        return redirect()->back()->with('success', $message);
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

        // ✅ REMOVED: Due date checking - students can resubmit anytime
        // Status will be determined based on current time vs due date

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

        $request->validate([
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,txt,jpg,jpeg,png,zip,rar,ppt,pptx,xls,xlsx',
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            $oldFilePath = $submission->file_path;
            $now = Carbon::now();

            // Store new file
            $fileName = time() . '_' . $student->id . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('submissions', $fileName, 'public');

            // ✅ UPDATED: Determine if this resubmission is late
            $isLate = false;
            if ($material->due_date) {
                $dueDate = Carbon::parse($material->due_date);
                if ($now->gt($dueDate)) {
                    $isLate = true;
                }
            }

            // ✅ Keep the "worse" timing status (once late, always late for this submission)
            $finalIsLate = $submission->is_late || $isLate;
            $status = $finalIsLate ? 'late' : 'submitted';

            $submission->update([
                'file_name' => $fileName,
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'status' => $status,
                'is_late' => $finalIsLate, // ✅ Preserve timing status
                'submitted_at' => $now,
                // Reset feedback when resubmitted
                'teacher_feedback' => null,
                'grade' => null,
            ]);

            // Delete old file after successful update
            if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            DB::commit();

            $message = $finalIsLate 
                ? 'Activity resubmitted successfully, but marked as LATE!'
                : 'Activity resubmitted successfully!';

            return redirect()->route('materials.student.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();

            // Clean up new file if database operation failed
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            Log::error('Submission update failed', [
                'submission_id' => $submission->id,
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to update submission. Please try again.')
                ->withInput();
        }
    }
public function view($id) 
{
    $material = Material::findOrFail($id);
    
    // Authorization check
    if (Auth::user()->role === 'teacher' && $material->teacher_id !== Auth::id()) {
        abort(403);
    }
    
    if (Auth::user()->role === 'student') {
        $studentSubjects = Auth::user()->subjects->pluck('id');
        if (!$studentSubjects->contains($material->subject_id)) {
            abort(403);
        }
    }
    
    $filePath = storage_path('app/public/' . $material->file_path);
    
    if (!file_exists($filePath)) {
        abort(404, 'File not found');
    }

    // // Log engagement
    // EngagementLog::create([             
    //     'user_id' => Auth::id(),  
    //     'subject_id' => $material->subject_id,           
    //     'action'  => 'material_download', // Using existing action
    //     'context' => 'material:' . $material->id . ':view',
    //     'value'   => 1,         
    // ]);
    
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $mimeType = mime_content_type($filePath);
    
    // Check if file can be viewed in browser
    $viewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt', 'svg', 'webp'];
    
    if (in_array($extension, $viewableTypes)) {
        // Return file for inline viewing
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $material->title . '.' . $extension . '"'
        ]);
    } else {
        // For non-viewable files, show a viewer page
        return view('materials.viewer', [
            'material' => $material,
            'fileUrl' => asset('storage/' . $material->file_path),
            'extension' => $extension,
            'mimeType' => $mimeType
        ]);
    }
}
public function serveFile(Material $material)
{
    // ✅ OPTIONAL: Keep basic auth check if you want
    // Or remove it completely for full public access
    if (Auth::check()) {
        if (Auth::user()->role === 'teacher' && $material->teacher_id !== Auth::id()) {
            // Still check if teacher owns material
            abort(403);
        }
        
        if (Auth::user()->role === 'student') {
            $studentSubjects = Auth::user()->subjects->pluck('id');
            if (!$studentSubjects->contains($material->subject_id)) {
                abort(403);
            }
        }
    }
    
    // Check if file exists
    if (!Storage::disk('public')->exists($material->file_path)) {
        abort(404, 'File not found');
    }
    
    // ✅ Serve file directly without decryption
    $fileContent = Storage::disk('public')->get($material->file_path);
    
    $extension = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));
    $mimeType = $this->getMimeType($extension);
    
    // ✅ IMPORTANT: Add headers for Office viewer compatibility
    return response($fileContent)
        ->header('Content-Type', $mimeType)
        ->header('Content-Disposition', 'inline; filename="' . $material->title . '.' . $extension . '"')
        ->header('Cache-Control', 'public, max-age=3600') // Allow caching
        ->header('Access-Control-Allow-Origin', '*'); // Allow Office viewer to access
}
// Helper method
private function getMimeType($extension)
{
    $mimeTypes = [
        'pdf' => 'application/pdf',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'txt' => 'text/plain',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    ];
    
    return $mimeTypes[$extension] ?? 'application/octet-stream';
}
/**
 * View submission file in browser
 */
public function viewSubmissionFile(StudentSubmission $submission)
{
    $material = $submission->material;
    
    // Authorization check
    if (Auth::user()->role === 'teacher' && $material->teacher_id !== Auth::id()) {
        abort(403);
    }
    
    if (Auth::user()->role === 'student' && $submission->student_id !== Auth::id()) {
        abort(403);
    }
    
    $filePath = storage_path('app/public/' . $submission->file_path);
    
    if (!file_exists($filePath)) {
        abort(404, 'File not found');
    }
    
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $mimeType = mime_content_type($filePath);
    
    // Check if file can be viewed in browser
    $viewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt', 'svg', 'webp'];
    
    if (in_array($extension, $viewableTypes)) {
        // Return file for inline viewing
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $submission->original_name . '"'
        ]);
    } else {
        // For non-viewable files, show a viewer page
        return view('submissions.viewer', [
            'submission' => $submission,
            'material' => $material,
            'fileUrl' => asset('storage/' . $submission->file_path),
            'extension' => $extension,
            'mimeType' => $mimeType
        ]);
    }
}

/**
 * Serve submission file content
 */
public function serveSubmissionFile(StudentSubmission $submission)
{
    $material = $submission->material;
    
    // Authorization check
    if (Auth::user()->role === 'teacher' && $material->teacher_id !== Auth::id()) {
        abort(403);
    }
    
    if (Auth::user()->role === 'student' && $submission->student_id !== Auth::id()) {
        abort(403);
    }
    
    // Check if file exists
    if (!Storage::disk('public')->exists($submission->file_path)) {
        abort(404, 'File not found');
    }
    
    // Serve file directly
    $fileContent = Storage::disk('public')->get($submission->file_path);
    
    $extension = strtolower(pathinfo($submission->file_path, PATHINFO_EXTENSION));
    $mimeType = $this->getMimeType($extension);
    
    return response($fileContent)
        ->header('Content-Type', $mimeType)
        ->header('Content-Disposition', 'inline; filename="' . $submission->original_name . '"')
        ->header('Cache-Control', 'public, max-age=3600')
        ->header('Access-Control-Allow-Origin', '*');
}
}