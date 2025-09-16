<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SQ3RSessionController;
use App\Http\Controllers\WeeklyPlanController;
use App\Http\Controllers\ConceptMapController;

Route::middleware(['auth:sanctum'])->group(function () {
    // SQ3R Sessions API
    Route::apiResource('sq3r-sessions', SQ3RSessionController::class);

    // Weekly Plans API
    Route::prefix('weekly-plans')->group(function () {
        Route::post('/{weeklyPlan}/autosave', [WeeklyPlanController::class, 'autosave']);
    });

    // Concept Maps API
    Route::prefix('concept-maps')->group(function () {
        Route::post('/{conceptMap}/autosave', [ConceptMapController::class, 'autosave']);
        Route::post('/generate-from-sq3r/{sq3rSession}', [ConceptMapController::class, 'generateFromSQ3R']);
    });
});
