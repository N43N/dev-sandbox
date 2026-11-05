<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ROUTE 1: PUBLIC GATEKEEPER SECURITY REDIRECT
Route::get('/', function () {
    return view('welcome');
});


// ROUTE 2: AUTHENTICATED SANDBOX LAUNCHPAD HUB
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================================================================
// ZONE 3: FUTURE LEARNING MODULES REGISTRY PIPELINES
// =========================================================================

// 1st ADD = KANBAN
Route::middleware(['auth', 'verified'])->group(function () {
    // 📝 Note Sandbox Module Route Hooks
    Route::get('/modules/notes', [App\Http\Controllers\NoteModule\NoteController::class, 'index'])->name('notes.index');
    Route::post('/modules/notes', [App\Http\Controllers\NoteModule\NoteController::class, 'store'])->name('notes.store');
    Route::delete('/modules/notes/{note}', [App\Http\Controllers\NoteModule\NoteController::class, 'destroy'])->name('notes.destroy');

    // 📋 Kanban Board Sandbox Module Route Hooks
    Route::get('/modules/kanban', [App\Http\Controllers\KanbanModule\KanbanController::class, 'index'])->name('kanban.index');
    Route::post('/modules/kanban', [App\Http\Controllers\KanbanModule\KanbanController::class, 'store'])->name('kanban.store');
    Route::patch('/modules/kanban/{task}/status', [App\Http\Controllers\KanbanModule\KanbanController::class, 'updateStatus'])->name('kanban.updateStatus');
    Route::delete('/modules/kanban/{task}', [App\Http\Controllers\KanbanModule\KanbanController::class, 'destroy'])->name('kanban.destroy');
});


    // 📡 Live API Client Sandbox Module Route Hooks
    // Weather
    Route::get('/modules/api', [App\Http\Controllers\ApiModule\ApiClientController::class, 'index'])->name('api.index');
    Route::get('/modules/api-sandbox', [App\Http\Controllers\ApiModule\ApiClientController::class, 'index']);
    
    // 📡 Individual Card AJAX Hooks
    Route::get('/modules/api/refresh-advice', [App\Http\Controllers\ApiModule\ApiClientController::class, 'refreshAdvice'])->name('api.refresh.advice');
    Route::get('/modules/api/refresh-weather', [App\Http\Controllers\ApiModule\ApiClientController::class, 'refreshWeather'])->name('api.refresh.weather');


    // Currency Exchange
    Route::get('/modules/currency', [App\Http\Controllers\ApiModule\ApiClientController::class, 'currencyIndex'])->name('api.currency');

    use App\Http\Controllers\ApiModule\ApiClientController;

    // ✉️ Isolated Email Verification Sandbox Routes
    Route::get('/modules/email-verify', [ApiClientController::class, 'emailVerifyIndex'])->name('email.verify.index');
    Route::post('/modules/email-verify/send', [ApiClientController::class, 'sendVerificationEmail'])->name('email.verify.send');
    Route::get('/modules/email-verify/confirm/{email}', [ApiClientController::class, 'confirmVerification'])
        ->name('email.verify.confirm')
        ->middleware('signed'); // 🔒 This ensures the URL cannot be manipulated




// FOR LATER ADD

require __DIR__.'/auth.php';
