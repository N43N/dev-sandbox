<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NoteModule\NoteController;
use App\Http\Controllers\KanbanModule\KanbanController;
use App\Http\Controllers\ApiModule\ApiClientController;
use Illuminate\Support\Facades\Route;


// ZONE 1: PUBLIC GATEKEEPER PIPELINES
Route::get('/', function () {
    return view('welcome');
});

// ZONE 2: CORE AUTHENTICATED CORE INTERFACES
Route::get('/dashboard', function () {
    return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware(['auth', 'verified'])->group(function () {

    // Profile Designer Modules Sandbox Sandbox Engine Routes
    Route::get('/modules/profile-designer', [ApiClientController::class, 'profileDesignerIndex'])->name('profile.designer.index');
    Route::post('/modules/profile-designer/generate', [ApiClientController::class, 'profileDesignerGenerate'])->name('profile.designer.generate');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ZONE 3: AUTHENTICATED LEARNING MODULES & EXPERIMENTS LAB
Route::middleware(['auth', 'verified'])->group(function () {

    // 📝 Note Sandbox Module Route Hooks
    Route::get('/modules/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/modules/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::delete('/modules/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    // 📋 Kanban Board Sandbox Module Route Hooks
    Route::get('/modules/kanban', [KanbanController::class, 'index'])->name('kanban.index');
    Route::post('/modules/kanban', [KanbanController::class, 'store'])->name('kanban.store');
    Route::patch('/modules/kanban/{task}/status', [KanbanController::class, 'updateStatus'])->name('kanban.updateStatus');
    Route::delete('/modules/kanban/{task}', [KanbanController::class, 'destroy'])->name('kanban.destroy');

    // 📡 Live API Dashboard Hooks
    Route::get('/modules/api', [ApiClientController::class, 'index'])->name('api.index');
    Route::get('/modules/api-sandbox', [ApiClientController::class, 'index']);
    Route::get('/modules/api/refresh-advice', [ApiClientController::class, 'refreshAdvice'])->name('api.refresh.advice');
    Route::get('/modules/api/refresh-weather', [ApiClientController::class, 'refreshWeather'])->name('api.refresh.weather');

    // 💵 Currency Exchange Matrix
    Route::get('/modules/currency', [ApiClientController::class, 'currencyIndex'])->name('api.currency');

    // ✉️ Isolated Email Verification Engine Sandbox
    Route::get('/modules/email-verify', [ApiClientController::class, 'emailVerifyIndex'])->name('email.verify.index');
    Route::post('/modules/email-verify/send', [ApiClientController::class, 'sendVerificationEmail'])->name('email.verify.send');
    Route::get('/modules/email-verify/confirm/{email}', [ApiClientController::class, 'confirmVerification'])
        ->name('email.verify.confirm')
        ->middleware('signed'); // 🔒 Cryptographic tampering gatekeeper

    // 🎨 Profile Designer & QR Engine Laboratory
    Route::get('/modules/profile-designer', [ApiClientController::class, 'profileDesignerIndex'])->name('profile.designer.index');
    Route::post('/modules/profile-designer/generate', [ApiClientController::class, 'profileDesignerGenerate'])->name('profile.designer.generate');
    
    Route::get('/dashboard', [ApiClientController::class, 'dashboardIndex'])->name('dashboard');

});

// =========================================================================
// ZONE 4: SYSTEM ENGINES
// =========================================================================
require __DIR__.'/auth.php';
