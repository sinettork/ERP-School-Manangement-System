<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LibraryBookController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth', 'verified', 'school.permission'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (Breeze)
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== Phase 1: School & Academic =====
    Route::resource('academic-years', AcademicYearController::class);

    // ===== Phase 2: Academic Data =====
    Route::resource('subjects', SubjectController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('classes',  SchoolClassController::class);

    // ===== Phase 3: Students =====
    Route::resource('students', StudentController::class);

    // ===== Phase 4: Attendance =====
    Route::get('/attendance',         [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance',        [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/report',  [AttendanceController::class, 'report'])->name('attendance.report');

    // ===== Phase 5: Exams & Scores =====
    Route::resource('exams', ExamController::class)->except(['show']);
    Route::get('/scores',  [ScoreController::class, 'index'])->name('scores.index');
    Route::post('/scores', [ScoreController::class, 'store'])->name('scores.store');
    Route::resource('report-cards', ReportCardController::class)->only(['index', 'show', 'destroy']);

    // ===== Phase 6: Finance =====
    Route::resource('payments', PaymentController::class);
    Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');

    // ===== Phase 7: Staff =====
    Route::resource('staff', StaffController::class);

    // ===== Phase 8: Library =====
    Route::resource('library', LibraryBookController::class);

    // ===== Phase 9: Inventory =====
    Route::resource('inventory', InventoryController::class);

    // ===== Phase 10: Announcements =====
    Route::resource('announcements', AnnouncementController::class);

    // ===== Phase 11: Users & Settings =====
    Route::resource('users', UserController::class);
    Route::get('/settings',  [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

require __DIR__ . '/auth.php';
