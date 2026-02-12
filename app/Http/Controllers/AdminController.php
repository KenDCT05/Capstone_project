<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Section;
use App\Models\SubjectList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\AccountCreatedNotification;

class AdminController extends Controller
{
    // ========= Dashboard Redirect Based on Role =========
    public function redirectDashboard()
    {
        $user = auth()->user();
        // ADMIN DASHBOARD
        if ($user->role === 'admin') {
            $allTeachers = User::where('role', 'teacher')->latest()->get();
            $allStudents = User::where('role', 'student')->latest()->get();
            
            // Get counts for stats cards
            $totalTeachers = $allTeachers->count();
            $totalStudents = $allStudents->count();
            $totalUsers = $totalTeachers + $totalStudents;
            
            // Get counts for sections and subjects
            $sectionsCount = Section::count();
            $subjectsCount = SubjectList::count();

            return view('admin.dashboard', compact('allTeachers', 'allStudents', 'totalTeachers', 'totalStudents', 'totalUsers', 'sectionsCount', 'subjectsCount'));
        }
        // TEACHER DASHBOARD
        if ($user->role === 'teacher') {    
            return redirect()->route('dashboard.teacher');
        }
        // STUDENT DASHBOARD
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

        // Collect all unique students from all subjects
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:10',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'required|string|max:20',
        ]);

        $defaultPassword = 'GSSM2025';

        // Create full name
        $fullName = $request->last_name . ', ' . $request->first_name . ' ' . ($request->middle_initial ?? '');

        // Create teacher
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_initial' => $request->middle_initial,
            'name' => $fullName,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'role' => 'teacher',
            'password' => Hash::make($defaultPassword),
        ]);

        // Send mail notification with login credentials
        $user->notify(new AccountCreatedNotification($user->email, $defaultPassword, $user->role));

        return redirect()->route('admin.register.teacher')
            ->with('success', 'Teacher registered successfully! ID: ' . $user->user_id . ' - Credentials sent via email.');
    }

    public function registerStudent(Request $request)
{
    $request->validate([
        'user_id' => 'required|string|max:255|unique:users,user_id|regex:/^[A-Za-z0-9\-]+$/',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'middle_initial' => 'nullable|string|max:10',
        'gender' => 'required|in:male,female',
        'email' => 'required|email|unique:users,email',
        'guardian_first_name' => 'required|string|max:255',
        'guardian_last_name' => 'required|string|max:255',
        'guardian_middle_initial' => 'nullable|string|max:10',
        'guardian_email' => 'required|email',
        'guardian_contact' => 'required|string|max:20',
    ], [
        'user_id.required' => 'Student ID is required.',
        'user_id.unique' => 'This Student ID is already in use.',
        'user_id.regex' => 'Student ID can only contain letters, numbers, and hyphens.',
    ]);

    $defaultPassword = 'GSSM2025';

    // Create full names
    $fullName = $request->last_name . ', ' . $request->first_name . ' ' . ($request->middle_initial ?? '');
    $guardianFullName = $request->guardian_last_name . ', ' . $request->guardian_first_name . ' ' . ($request->guardian_middle_initial ?? '');

    // Create student with manual user_id
    $user = User::create([
        'user_id' => strtoupper($request->user_id), // Convert to uppercase for consistency
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'middle_initial' => $request->middle_initial,
        'name' => $fullName,
        'gender' => $request->gender,
        'email' => $request->email,
        'guardian_first_name' => $request->guardian_first_name,
        'guardian_last_name' => $request->guardian_last_name,
        'guardian_middle_initial' => $request->guardian_middle_initial,
        'guardian_name' => $guardianFullName,
        'guardian_email' => $request->guardian_email,
        'guardian_contact' => $request->guardian_contact,
        'role' => 'student',
        'password' => Hash::make($defaultPassword),
    ]);

    // Send mail notification with login credentials
    $user->notify(new AccountCreatedNotification($user->email, $defaultPassword, $user->role));

    return redirect()->route('admin.register.student')
        ->with('success', 'Student registered successfully! ID: ' . $user->user_id . ' - Credentials sent via email.');
}

    // ========= Delete User =========
    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'Admin accounts cannot be deleted.');
        }

        if ($user->role === 'teacher') {
            Subject::where('teacher_id', $user->id)->delete();
            $user->students()->detach();
        }

        if ($user->role === 'student') {
            $user->teachers()->detach();
            $user->subjects()->detach();
        }

        $user->delete();

        return back()->with('success', ucfirst($user->role) . ' deleted successfully.');
    }

    public function index()
    {
        $teacher = Auth::user();
        $subjects = Subject::with('students')
            ->where('teacher_id', $teacher->id)
            ->get();

        $subjectCount = $subjects->count();
        $students = $subjects->flatMap->students;
        $studentCount = $students->unique('id')->count();

        return view('dashboard.teacher', compact('subjectCount', 'studentCount', 'subjects'));
    }

    // ========= Toggle Account Status =========
    public function toggleAccountStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'Admin accounts cannot be deactivated.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', ucfirst($user->role) . ' account ' . $status . ' successfully.');
    }

    // =====================
    // SECTIONS MANAGEMENT
    // =====================
    
    /**
     * Display list of sections
     */
    public function sections()
    {
        $sections = Section::orderBy('name')->get();
        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Show form to create new section
     */
    public function createSection()
    {
        return view('admin.sections.create');
    }

    /**
     * Store new section
     */
    public function storeSection(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'year_level' => 'required|integer|min:1|max:12',
    ]);

    // Check if this section name already exists for this year level
    $exists = Section::where('name', $request->name)
                    ->where('year_level', $request->year_level)
                    ->exists();

    if ($exists) {
        return back()->withErrors([
            'name' => 'This section already exists for Grade ' . $request->year_level
        ])->withInput();
    }

    Section::create([
        'name' => $request->name,
        'year_level' => $request->year_level,
    ]);

    return redirect()->route('admin.sections')
        ->with('success', 'Section created successfully for Grade ' . $request->year_level . '!');
}
    /**
     * Show form to edit section
     */
    public function editSection(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    /**
     * Update section
     */
public function updateSection(Request $request, Section $section)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'year_level' => 'required|integer|min:1|max:12',
    ]);

    // Check if this section name already exists for this year level (excluding current section)
    $exists = Section::where('name', $request->name)
                    ->where('year_level', $request->year_level)
                    ->where('id', '!=', $section->id)
                    ->exists();

    if ($exists) {
        return back()->withErrors([
            'name' => 'This section already exists for Grade ' . $request->year_level
        ])->withInput();
    }

    $section->update([
        'name' => $request->name,
        'year_level' => $request->year_level,
    ]);

    return redirect()->route('admin.sections')
        ->with('success', 'Section updated successfully!');
}
    /**
     * Delete section
     */
    public function destroySection(Section $section)
    {
        $section->delete();

        return redirect()->route('admin.sections')
            ->with('success', 'Section deleted successfully!');
    }

    // =====================
    // SUBJECT LIST MANAGEMENT
    // =====================
    
    /**
     * Display list of subjects (for dropdown selection)
     */
    public function subjectList()
    {
        $subjects = SubjectList::orderBy('name')->get();
        return view('admin.subject-list.index', compact('subjects'));
    }

    /**
     * Show form to create new subject in the list
     */
    public function createSubjectList()
    {
        return view('admin.subject-list.create');
    }

    /**
     * Store new subject in the list
     */
    public function storeSubjectList(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subject_lists,name',
        ]);

        SubjectList::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.subject-list')
            ->with('success', 'Subject added to list successfully!');
    }

    /**
     * Show form to edit subject in the list
     */
    public function editSubjectList(SubjectList $subjectList)
    {
        return view('admin.subject-list.edit', compact('subjectList'));
    }

    /**
     * Update subject in the list
     */
    public function updateSubjectList(Request $request, SubjectList $subjectList)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subject_lists,name,' . $subjectList->id,
        ]);

        $subjectList->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.subject-list')
            ->with('success', 'Subject updated successfully!');
    }

    /**
     * Delete subject from the list
     */
    public function destroySubjectList(SubjectList $subjectList)
    {
        $subjectList->delete();

        return redirect()->route('admin.subject-list')
            ->with('success', 'Subject removed from list successfully!');
    }
    /**
 * Show the search form
 */
public function searchUserForm()
{
    return view('admin.search-user');
}

/**
 * Search for user by user_id
 */
public function searchUser(Request $request)
{
    $request->validate([
        'user_id' => 'required|string',
    ]);

    $userId = strtoupper(trim($request->user_id));
    
    $user = User::where('user_id', $userId)->first();

    if (!$user) {
        return back()->with('error', 'User not found with ID: ' . $userId);
    }

    return redirect()->route('admin.user.profile', ['userId' => $user->user_id]);
}

/**
 * Show detailed user profile with all system information
 */
public function showUserProfile($userId)
{
    $user = User::where('user_id', $userId)->firstOrFail();
    
    $profileData = [
        'user' => $user,
        'subjects' => collect(),
        'sections' => collect(),
        'teachers' => collect(),
        'students' => collect(),
        'statistics' => [],
    ];

    // Get role-specific data
    if ($user->role === 'teacher') {
        // Get subjects created by this teacher
        $subjects = Subject::with(['students', 'section', 'subjectList'])
            ->where('teacher_id', $user->id)
            ->get();
        
        $profileData['subjects'] = $subjects;
        
        // Get all unique students from all subjects
        $students = $subjects->flatMap->students->unique('id');
        $profileData['students'] = $students;
        
        // Get sections this teacher teaches
        $profileData['sections'] = $subjects->pluck('section')->unique('id')->filter();
        
        // Statistics
        $profileData['statistics'] = [
            'total_subjects' => $subjects->count(),
            'total_students' => $students->count(),
            'active_subjects' => $subjects->count(), // You can add is_active field to subjects if needed
        ];
        
    } elseif ($user->role === 'student') {
        // Get subjects the student is enrolled in
        $subjects = $user->subjects()->with(['teacher', 'section', 'subjectList'])->get();
        $profileData['subjects'] = $subjects;
        
        // Get all teachers teaching this student
        $teachers = $subjects->pluck('teacher')->unique('id')->filter();
        $profileData['teachers'] = $teachers;
        
        // Get sections
        $profileData['sections'] = $subjects->pluck('section')->unique('id')->filter();
        
        // Statistics
        $profileData['statistics'] = [
            'total_subjects' => $subjects->count(),
            'total_teachers' => $teachers->count(),
          
        ];
    }

    return view('admin.user-profile', $profileData);
}

}