<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Subject;
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
        ]);

        $path = $request->file('file')->store('materials', 'public');

        Material::create([
            'teacher_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
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
    return view('materials.teacher.edit', compact('material'));
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
    ]);

    $material->title = $request->title;
    $material->description = $request->description;

    if ($request->hasFile('file')) {
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
} 