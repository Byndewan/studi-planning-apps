<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\WeeklyPlanController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\SQ3RController;
use App\Http\Controllers\ConceptMapController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Semesters
    Route::resource('semesters', SemesterController::class);
    Route::post('/semesters/{semester}/generate-schedule', [SemesterController::class, 'generateSchedule'])
        ->name('semesters.generate-schedule');

    // Courses
    Route::resource('courses', CourseController::class);

    // Weekly Plans
    Route::resource('weekly-plans', WeeklyPlanController::class)->only(['index', 'create' ,'show', 'edit', 'update']);

    // Monitoring
    Route::resource('monitorings', MonitoringController::class);

    // SQ3R
    Route::resource('sq3r', SQ3RController::class);

    // Concept Maps
    Route::resource('concept-maps', ConceptMapController::class);
});

require __DIR__.'/auth.php';
