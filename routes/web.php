<?php

use App\Http\Controllers\DefenseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Models\User;
use App\Models\Score;
use App\Models\Subject;
use App\Models\EngagementLog;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\GradebookController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\GradebookAdminController;
use App\Http\Controllers\ProfilePasswordController;
use App\Http\Controllers\Student\StudentQuizController;
use App\Http\Controllers\Teacher\LeaderboardController; 
use App\Http\Controllers\Teacher\QuizController as TeacherQuizController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'));

// Dashboard (Role-based redirect)
Route::get('/dashboard', [AdminController::class, 'redirectDashboard'])
    ->middleware(['auth', 'check.account.status'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authentication & Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Password change for first-time login
    Route::get('/change-password', [PasswordController::class, 'edit'])->name('change-password.edit');
    Route::put('/change-password', [PasswordController::class, 'update'])->name('change-password.update');
    Route::put('/profile-change-password', [ProfilePasswordController::class, 'update'])->name('profile-change.password');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('password.confirm');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.admin'))->name('dashboard');

    // Registration
    Route::get('/register-student', [AdminController::class, 'showStudentForm'])->name('register.student');
    Route::post('/register-student', [AdminController::class, 'registerStudent'])->name('register.student.submit');
    Route::get('/register-teacher', [AdminController::class, 'showTeacherForm'])->name('register.teacher');
    Route::post('/register-teacher', [AdminController::class, 'registerTeacher'])->name('register.teacher.submit');
    Route::delete('/admin/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('delete.user');

    // Assignment
    Route::get('/assign-students', [AdminController::class, 'assignForm'])->name('assign');
    Route::post('/assign-random', [AdminController::class, 'assignRandom'])->name('assign.random');
    Route::post('/assign-manual', [AdminController::class, 'assignManual'])->name('assign.manual');
    Route::delete('/unassign-teacher', [AdminController::class, 'unassignTeacher'])->name('unassign.teacher');

    // Gradebook
    Route::get('/gradebook', [GradebookAdminController::class, 'index'])->name('gradebook');
    Route::post('/gradebook/save', [GradebookAdminController::class, 'save'])->name('gradebook.save');
    Route::patch('/users/{id}/toggle-status', [AdminController::class, 'toggleAccountStatus'])
    ->name('toggle.status');

        // Sections Management
    Route::get('/sections', [AdminController::class, 'sections'])->name('sections');
    Route::get('/sections/create', [AdminController::class, 'createSection'])->name('sections.create');
    Route::post('/sections', [AdminController::class, 'storeSection'])->name('sections.store');
    Route::get('/sections/{section}/edit', [AdminController::class, 'editSection'])->name('sections.edit');
    Route::put('/sections/{section}', [AdminController::class, 'updateSection'])->name('sections.update');
    Route::delete('/sections/{section}', [AdminController::class, 'destroySection'])->name('sections.destroy');
    
    // Subject List Management
    Route::get('/subject-list', [AdminController::class, 'subjectList'])->name('subject-list');
    Route::get('/subject-list/create', [AdminController::class, 'createSubjectList'])->name('subject-list.create');
    Route::post('/subject-list', [AdminController::class, 'storeSubjectList'])->name('subject-list.store');
    Route::get('/subject-list/{subjectList}/edit', [AdminController::class, 'editSubjectList'])->name('subject-list.edit');
    Route::put('/subject-list/{subjectList}', [AdminController::class, 'updateSubjectList'])->name('subject-list.update');
    Route::delete('/subject-list/{subjectList}', [AdminController::class, 'destroySubjectList'])->name('subject-list.destroy');
    // Search
    Route::get('/search-user', [AdminController::class, 'searchUserForm'])->name('search.user.form');
    Route::post('/search-user', [AdminController::class, 'searchUser'])->name('search.user');
    Route::get('/user-profile/{userId}', [AdminController::class, 'showUserProfile'])->name('user.profile');
});

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard/student', fn() => view('dashboard.student'))->name('dashboard.student');

    // Materials
    Route::get('/student/materials', [MaterialController::class, 'studentIndex'])->name('materials.student.index');
    Route::get('/student/materials/{material}/download', [MaterialController::class, 'download'])->name('materials.student.download');
    Route::get('/materials/{material}/submit', [MaterialController::class, 'showSubmissionForm'])->name('materials.student.submit');
    Route::post('/materials/{material}/submit', [MaterialController::class, 'storeSubmission'])->name('materials.student.submit.store');
    Route::get('/my-submissions', [MaterialController::class, 'mySubmissions'])->name('submissions.my');
    Route::get('/materials/{material}/resubmit', [MaterialController::class, 'resubmit'])->name('submissions.resubmit');
    Route::patch('/submissions/{submission}/update', [MaterialController::class, 'updateSubmission'])->name('submissions.update');

    // Gradebook
    Route::get('/gradebook/student', [GradebookController::class, 'studentView'])->name('gradebook.student');

    // Subjects
    Route::get('/subjects/join', [SubjectController::class, 'joinForm'])->name('subjects.joinForm');
    Route::post('/subjects/join', [SubjectController::class, 'join'])->name('subjects.join');
    Route::get('/my-subjects', [SubjectController::class, 'studentSubjects'])->name('student.subjects');
    Route::get('/student/subjects', [SubjectController::class, 'studentIndex'])->name('student.subjects.index');

    // Quizzes
    Route::get('/quizzes', [StudentQuizController::class, 'index'])->name('student.quizzes.index');
    Route::get('/quizzes/{quiz}', [StudentQuizController::class, 'show'])->name('student.quizzes.show');
    Route::match(['get', 'post'], '/quizzes/{quiz}/take', [StudentQuizController::class, 'take'])->name('student.quizzes.take');
    Route::match(['get', 'post'], '/quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])->name('student.quizzes.submit');
    Route::get('/quizzes/{quiz}/result', [StudentQuizController::class, 'result'])->name('student.quizzes.result');
    Route::get('/quizzes/{quiz}/attempts', [StudentQuizController::class, 'attempts'])->name('student.quizzes.attempts');
    Route::get('/student/quizzes/{quiz}/leaderboard', [LeaderboardController::class, 'studentLeaderboard'])->name('student.quizzes.leaderboard');
});

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:teacher'])->group(function () {
    // Dashboard
    Route::get('/dashboard/teacher', [AdminController::class, 'teacherDashboard'])->name('dashboard.teacher');

    // Materials
    Route::get('/materials', [MaterialController::class, 'teacherIndex'])->name('materials.teacher.index');
    Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.teacher.create');
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.teacher.store');
    Route::get('/materials/{material}/download', [MaterialController::class, 'download'])->name('materials.teacher.download');
    Route::get('/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.teacher.edit');
    Route::put('/materials/{material}', [MaterialController::class, 'update'])->name('materials.teacher.update');
    Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.teacher.destroy');
    Route::get('/materials/{material}/view', [MaterialController::class, 'view'])->name('materials.view');
    Route::get('/submissions/{submission}/view', [MaterialController::class, 'viewSubmissionFile'])
        ->name('submissions.view');


    // Submissions
    Route::get('/materials/{material}/submissions', [MaterialController::class, 'viewSubmissions'])->name('materials.submissions');
    Route::patch('/submissions/{submission}/feedback', [MaterialController::class, 'provideFeedback'])->name('submissions.feedback');
    Route::delete('/submissions/{submission}', [MaterialController::class, 'deleteSubmission'])->name('submissions.destroy');

    // Gradebook
    Route::get('/gradebook/teacher', [GradebookController::class, 'teacherView'])->name('gradebook.teacher');
    Route::post('/gradebook/update', [GradebookController::class, 'updateScores'])->name('gradebook.update');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'dashboard'])->name('analytics.dashboard');
    Route::get('/analytics/risk-alerts', [AnalyticsController::class, 'riskAlerts'])->name('analytics.risk-alerts');
    Route::get('/analytics/insights/{studentId}', [AnalyticsController::class, 'insights'])->name('analytics.insights');
    Route::get('/analytics/subject-comparison', [AnalyticsController::class, 'subjectComparison'])->name('analytics.subject-comparison');
    Route::get('/analytics/export', [AnalyticsController::class, 'exportData'])->name('analytics.export');
    Route::get('/analytics/engagement', [AnalyticsController::class, 'engagementAnalytics'])->name('analytics.engagement');
    Route::get('/analytics/communication-logs', [AnalyticsController::class, 'communicationLogs'])->name('analytics.communication-logs');
    Route::get('/analytics/email-log/{id}', [AnalyticsController::class, 'viewEmailLog'])->name('analytics.email-log');
    Route::post('/analytics/retry-sms', [AnalyticsController::class, 'retrySms'])->name('analytics.retry-sms');
    Route::post('/analytics/retry-email', [AnalyticsController::class, 'retryEmail'])->name('analytics.retry-email');

    // Subjects
    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects/store', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/{id}', [SubjectController::class, 'show'])->name('subjects.show');
    Route::delete('/subjects/{subject}/remove-student/{student}', [SubjectController::class, 'removeStudent'])->name('subjects.removeStudent');
    Route::delete('/subjects/{id}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
    Route::get('/subjects', function () {
        $subjects = Subject::where('teacher_id', auth()->id())->get();
        return view('subjects.index', compact('subjects'));
    })->name('subjects.index');

    // Quizzes (Teacher)
    Route::prefix('teacher')->group(function () {
        Route::resource('quizzes', TeacherQuizController::class)->names([
            'index'   => 'quizzes.index',
            'create'  => 'quizzes.create',
            'store'   => 'quizzes.store',
            'edit'    => 'quizzes.edit',
            'update'  => 'quizzes.update',
            'destroy' => 'quizzes.destroy',
            'show'    => 'quizzes.show',
        ]);
        Route::post('quizzes/{quiz}/publish', [TeacherQuizController::class, 'publish'])->name('quizzes.publish');
    });
    Route::post('quizzes/{quiz}/unpublish', [TeacherQuizController::class, 'unpublish'])
    ->name('quizzes.unpublish');

    Route::get('/quizzes/{quiz}/leaderboard', [LeaderboardController::class, 'show'])->name('quizzes.leaderboard');
    Route::get('/quizzes/{quiz}/leaderboard/api', [LeaderboardController::class, 'api'])->name('quizzes.leaderboard.api');
    
    Route::post('quizzes/{quiz}/questions', [TeacherQuizController::class, 'addQuestion'])->name('quizzes.questions.store');
    Route::put('questions/{question}', [TeacherQuizController::class, 'updateQuestion'])->name('quizzes.questions.update');
    Route::delete('questions/{question}', [TeacherQuizController::class, 'deleteQuestion'])->name('quizzes.questions.destroy');
});

/*
|--------------------------------------------------------------------------
| Shared Routes (All Authenticated Users)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/submissions/{submission}/download', [MaterialController::class, 'downloadSubmission'])->name('submissions.download');
    Route::get('/submissions/{submission}', [MaterialController::class, 'showSubmission'])->name('submissions.show');
    // Route::get('/materials/{material}/file', [MaterialController::class, 'serveFile'])->name('materials.serve');

});

/*
|--------------------------------------------------------------------------
| Debug & Utility Routes
|--------------------------------------------------------------------------
*/

Route::get('/debug/handsontest', fn() => view('debug.handsontest'));
Route::view('/test', 'test');
Route::post('/log-time-spent', [AnalyticsController::class, 'logTimeSpent'])->name('analytics.log-time-spent');
Route::get('/sample', [DefenseController::class, 'defense'])->name('defense');
Route::get('/sample2', [DefenseController::class, 'newview'])->name('new.view');

// Queue (Hostinger workaround)
Route::get('/run-queue', function () {
    Artisan::call('queue:work --stop-when-empty');
    return 'Queue executed!';
});
Route::get('/materials/{material}/serve', [MaterialController::class, 'serveFile'])
    ->name('materials.serve');
Route::get('/submissions/{submission}/serve', [MaterialController::class, 'serveSubmissionFile'])
        ->name('submissions.serve');

// Auth Scaffolding
require __DIR__ . '/auth.php';
