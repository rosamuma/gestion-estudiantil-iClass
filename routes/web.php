<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Education\DashboardController;
use App\Http\Controllers\Education\StudentController;
use App\Http\Controllers\Education\CourseController;
use App\Http\Controllers\Education\GradeController;
use App\Http\Controllers\Education\AttendanceController;
use App\Http\Controllers\Education\TeacherController;
use App\Http\Controllers\Education\ProgramController;

// ── Raíz redirige al dashboard educativo ─────────────────────────────────────
Route::get('/', fn() => redirect('/education/dashboard'))->middleware('auth');
Route::get('/dashboard', fn() => redirect('/education/dashboard'))->name('dashboard')->middleware('auth');

// ── Rutas originales del template (sin tocar) ─────────────────────────────────
Route::get('/tables',  fn() => view('tables'))->name('tables')->middleware('auth');
Route::get('/wallet',  fn() => view('wallet'))->name('wallet')->middleware('auth');
Route::get('/RTL',     fn() => view('RTL'))->name('RTL')->middleware('auth');
Route::get('/profile', fn() => view('account-pages.profile'))->name('profile')->middleware('auth');
Route::get('/signin',  fn() => view('account-pages.signin'))->name('signin');
Route::get('/signup',  fn() => view('account-pages.signup'))->name('signup')->middleware('guest');

Route::get('/sign-up',  [RegisterController::class, 'create'])->middleware('guest')->name('sign-up');
Route::post('/sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('/sign-in',  [LoginController::class, 'create'])->middleware('guest')->name('sign-in');
Route::post('/sign-in', [LoginController::class, 'store'])->middleware('guest');
Route::post('/logout',  [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::get('/forgot-password',        [ForgotPasswordController::class, 'create'])->middleware('guest')->name('password.request');
Route::post('/forgot-password',       [ForgotPasswordController::class, 'store'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->middleware('guest')->name('password.reset');
Route::post('/reset-password',        [ResetPasswordController::class, 'store'])->middleware('guest');

Route::get('/laravel-examples/user-profile',    [ProfileController::class, 'index'])->name('users.profile')->middleware('auth');
Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('users.update')->middleware('auth');
Route::get('/laravel-examples/users-management', [UserController::class, 'index'])->name('users-management')->middleware('auth');
Route::resource('employees', App\Http\Controllers\EmployeeController::class);

// ── EduPlatform ───────────────────────────────────────────────────────────────
Route::middleware('auth')->prefix('education')->name('education.')->group(function () {

    // Dashboard — todos los roles autenticados
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Estudiantes — admin y docente
    Route::resource('students', StudentController::class)->middleware('role:admin,teacher');

    // Cursos — todos ven; admin/docente gestionan
    Route::get('courses',             [CourseController::class, 'index'])->name('courses.index');
    Route::get('courses/{course}',    [CourseController::class, 'show'])->name('courses.show');
    Route::middleware('role:admin,teacher')->group(function () {
        Route::get('courses/create',         [CourseController::class, 'create'])->name('courses.create');
        Route::post('courses',               [CourseController::class, 'store'])->name('courses.store');
        Route::get('courses/{course}/edit',  [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('courses/{course}',       [CourseController::class, 'update'])->name('courses.update');
        Route::delete('courses/{course}',    [CourseController::class, 'destroy'])->name('courses.destroy');
    });

    // Calificaciones — todos ven; admin/docente gestionan
    Route::get('grades',              [GradeController::class, 'index'])->name('grades.index');
    Route::middleware('role:admin,teacher')->group(function () {
        Route::get('grades/create',        [GradeController::class, 'create'])->name('grades.create');
        Route::post('grades',              [GradeController::class, 'store'])->name('grades.store');
        Route::get('grades/{grade}/edit',  [GradeController::class, 'edit'])->name('grades.edit');
        Route::put('grades/{grade}',       [GradeController::class, 'update'])->name('grades.update');
        Route::delete('grades/{grade}',    [GradeController::class, 'destroy'])->name('grades.destroy');
        Route::post('grades/bulk',         [GradeController::class, 'bulkStore'])->name('grades.bulk');
    });

    // Asistencia — admin y docente
    Route::resource('attendance', AttendanceController::class)->middleware('role:admin,teacher');
    Route::post('attendance/bulk', [AttendanceController::class, 'bulkStore'])
        ->name('attendance.bulk')->middleware('role:admin,teacher');

    // Docentes y Programas — solo admin
    Route::resource('teachers', TeacherController::class)->middleware('role:admin');
    Route::resource('programs', ProgramController::class)->middleware('role:admin');
});
