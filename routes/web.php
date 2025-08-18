<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GradebookController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\GradebookAdminController;
use App\Http\Controllers\SubjectController;
use App\Models\Subject;
use App\Models\Score;
use App\Models\User;

// 🌐 Public homepage
Route::get('/', function () {
    return view('welcome');
});

// 🔐 Dashboard (Role-based redirect)
Route::get('/dashboard', [AdminController::class, 'redirectDashboard'])
    ->middleware('auth')
    ->name('dashboard');

// 👤 Password change for first-time login
Route::middleware('auth')->group(function () {
    Route::get('/change-password', [PasswordController::class, 'edit'])->name('password.change');
    Route::put('/change-password', [PasswordController::class, 'update'])->name('password.update');
});

// 👤 Profile management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🛠️ Admin-only routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // 🧭 Admin Dashboard
    Route::get('/dashboard', fn() => view('dashboard.admin'))->name('dashboard');

    // 🧑‍🎓 Student Registration
    Route::get('/register-student', [AdminController::class, 'showStudentForm'])->name('register.student');
    Route::post('/register-student', [AdminController::class, 'registerStudent'])->name('register.student.submit');

    // 🧑‍🏫 Teacher Registration
    Route::get('/register-teacher', [AdminController::class, 'showTeacherForm'])->name('register.teacher');
    Route::post('/register-teacher', [AdminController::class, 'registerTeacher'])->name('register.teacher.submit');

    // 👥 Student Assignment
    Route::get('/assign-students', [AdminController::class, 'assignForm'])->name('assign');
    Route::post('/assign-random', [AdminController::class, 'assignRandom'])->name('assign.random');
    Route::post('/assign-manual', [AdminController::class, 'assignManual'])->name('assign.manual');
    Route::delete('/unassign-teacher', [AdminController::class, 'unassignTeacher'])->name('unassign.teacher');

    // 📊 Gradebook Admin View
    Route::get('/gradebook', [GradebookAdminController::class, 'index'])->name('gradebook');
    Route::post('/gradebook/save', [GradebookAdminController::class, 'save'])->name('gradebook.save');
});
// 🧑‍🎓 Student routes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard/student', function () {
        return view('dashboard.student');
    })->name('dashboard.student');

    Route::get('/student/materials', [MaterialController::class, 'studentIndex'])->name('materials.student.index');
    Route::get('/student/materials/{material}/download', [MaterialController::class, 'download'])->name('materials.student.download');

    Route::get('/gradebook/student', [GradebookController::class, 'studentView'])->name('gradebook.student');

    Route::get('/subjects/join', [SubjectController::class, 'joinForm'])->name('subjects.joinForm');
    Route::post('/subjects/join', [SubjectController::class, 'join'])->name('subjects.join');
    Route::get('/my-subjects', [SubjectController::class, 'studentSubjects'])->name('student.subjects');
    Route::get('/student/subjects', [SubjectController::class, 'studentIndex'])->name('student.subjects.index');



});
// 🧑‍🏫 Teacher routes
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/dashboard/teacher', [AdminController::class, 'teacherDashboard'])->name('dashboard.teacher');

    Route::get('/materials', [MaterialController::class, 'teacherIndex'])->name('materials.teacher.index');
    Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.teacher.create');
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.teacher.store');
        Route::get('/materials/{material}/download', [MaterialController::class, 'download'])->name('materials.teacher.download');

     // Edit + Update
    Route::get('/{material}/edit', [MaterialController::class, 'edit'])->name('materials.teacher.edit');
    Route::put('/{material}', [MaterialController::class, 'update'])->name('materials.teacher.update');

    // Delete
    Route::delete('/{material}', [MaterialController::class, 'destroy'])->name('materials.teacher.destroy');

    // gradebook
    Route::get('/gradebook/teacher', [GradebookController::class, 'teacherView'])->name('gradebook.teacher');
    Route::post('/gradebook/update', [GradebookController::class, 'updateScores'])->name('gradebook.update');

    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects/store', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/{id}', [SubjectController::class, 'show'])->name('subjects.show');
    Route::delete('/subjects/{subject}/remove-student/{student}', [SubjectController::class, 'removeStudent'])->name('subjects.removeStudent');
    Route::delete('/subjects/{id}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
    Route::get('/dashboard/teacher', [AdminController::class, 'teacherDashboard'])->name('dashboard.teacher');

    Route::get('/subjects', function () {
    $subjects = Subject::where('teacher_id', auth()->id())->get();
    return view('subjects.index', compact('subjects'));
})->name('subjects.index')->middleware('auth');
});


Route::get('/debug/handsontest', function () {
    return view('debug.handsontest');
});
// 🔑 Authentication (login, logout, etc.)
require __DIR__.'/auth.php';
