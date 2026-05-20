<?php

declare(strict_types=1);

use App\Http\Controllers\GraduationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('users', UserController::class);

    Route::resource('graduations', GraduationController::class);

    Route::resource('graduations.students', StudentController::class)
        ->only(['show', 'edit', 'update']);

    Route::patch(
        'graduations/{graduation}/students/{student}/verify',
        [StudentController::class, 'verify']
    )->name('graduations.students.verify');
});

require __DIR__.'/settings.php';
