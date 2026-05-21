<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GraduationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::resource('users', UserController::class);

    Route::resource('graduations', GraduationController::class);

    Route::get(
        'graduations/{graduation}/students/export',
        [StudentController::class, 'export']
    )->name('graduations.students.export');

    Route::post(
        'graduations/{graduation}/students/import',
        [StudentController::class, 'import']
    )->name('graduations.students.import');

    Route::post(
        'graduations/{graduation}/students/bulk',
        [StudentController::class, 'bulk']
    )->name('graduations.students.bulk');

    Route::resource('graduations.students', StudentController::class);

    Route::patch(
        'graduations/{graduation}/students/{student}/verify',
        [StudentController::class, 'verify']
    )->name('graduations.students.verify');

    Route::patch(
        'graduations/{graduation}/students/{student}/revoke',
        [StudentController::class, 'revoke']
    )->name('graduations.students.revoke');
});

require __DIR__.'/settings.php';
