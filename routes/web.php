<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\Auth\RegisterController;
use Laravel\Fortify\Features;

Route::get('/custom-login', [\App\Http\Controllers\Auth\CustomLoginController::class, 'showLoginForm'])->name('custom.login');
Route::post('/custom-login', [\App\Http\Controllers\Auth\CustomLoginController::class, 'login'])->name('custom.login.post');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Admin-only registration routes
Route::middleware(['admin.registration'])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
});

Route::middleware(['auth'])->group(function () {
    // Admin-only settings routes
    Route::middleware('role:admin')->group(function () {
        Route::redirect('settings', 'settings/profile');

        Route::get('settings/profile', Profile::class)->name('profile.edit');
        Route::get('settings/password', Password::class)->name('user-password.edit');
        Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

        Route::get('settings/two-factor', TwoFactor::class)
            ->middleware(
                when(
                    Features::canManageTwoFactorAuthentication()
                        && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                    ['password.confirm'],
                    [],
                ),
            )
            ->name('two-factor.show');
    });
    
    // Admin-only period routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/periods', [PeriodController::class, 'index'])->name('periods.index');
        Route::get('/periods/create', [PeriodController::class, 'create'])->name('periods.create');
        Route::post('/periods', [PeriodController::class, 'store'])->name('periods.store');
        Route::get('/periods/{period}/edit', [PeriodController::class, 'edit'])->name('periods.edit');
        Route::put('/periods/{period}', [PeriodController::class, 'update'])->name('periods.update');
        Route::delete('/periods/{period}', [PeriodController::class, 'destroy'])->name('periods.destroy');
        Route::post('/periods/{period}/complete', [PeriodController::class, 'complete'])->name('periods.complete');
        Route::post('/periods/{period}/restore', [PeriodController::class, 'restore'])->name('periods.restore');
        Route::get('/periods/import', [PeriodController::class, 'showImportForm'])->name('periods.import');
        Route::post('/periods/import', [PeriodController::class, 'import'])->name('periods.import.store');
        Route::get('/periods/import/example', [PeriodController::class, 'downloadImportExample'])->name('periods.import.example');
        Route::post('/periods/export', [PeriodController::class, 'export'])->name('periods.export');
    });

    // Surat routes (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/surats', [\App\Http\Controllers\SuratController::class, 'index'])->name('surats.index');
        Route::get('/surats/create', [\App\Http\Controllers\SuratController::class, 'create'])->name('surats.create');
        Route::post('/surats', [\App\Http\Controllers\SuratController::class, 'store'])->name('surats.store');
        Route::get('/surats/{surat}/edit', [\App\Http\Controllers\SuratController::class, 'edit'])->name('surats.edit');
        Route::put('/surats/{surat}', [\App\Http\Controllers\SuratController::class, 'update'])->name('surats.update');
        Route::post('/surats/{surat}', [\App\Http\Controllers\SuratController::class, 'destroy'])->name('surats.destroy');
        Route::post('/surats/{surat}/move-status', [\App\Http\Controllers\SuratController::class, 'moveStatus'])->name('surats.move-status');
        Route::get('/surats/export', [\App\Http\Controllers\SuratController::class, 'export'])->name('surats.export');
    });

    // Meetings routes
    Route::get('/meetings', [\App\Http\Controllers\MeetingController::class, 'index'])->name('meetings.index');
    Route::get('/meetings/create', [\App\Http\Controllers\MeetingController::class, 'create'])->name('meetings.create');
    Route::post('/meetings', [\App\Http\Controllers\MeetingController::class, 'store'])->name('meetings.store');
    Route::get('/meetings/{meeting}/edit', [\App\Http\Controllers\MeetingController::class, 'edit'])->name('meetings.edit');
    Route::put('/meetings/{meeting}', [\App\Http\Controllers\MeetingController::class, 'update'])->name('meetings.update');
    Route::delete('/meetings/{meeting}', [\App\Http\Controllers\MeetingController::class, 'destroy'])->name('meetings.destroy');
    Route::post('/meetings/{id}/restore', [\App\Http\Controllers\MeetingController::class, 'restore'])->name('meetings.restore');
    Route::get('/meetings/export', [\App\Http\Controllers\MeetingController::class, 'export'])->name('meetings.export');
    Route::post('/meetings/slides', [\App\Http\Controllers\MeetingController::class, 'storeSlide'])->name('meetings.slides.store');
    
    // Slides management routes (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/slides/manage', [\App\Http\Controllers\SlideController::class, 'manage'])->name('slides.manage');
        Route::post('/slides', [\App\Http\Controllers\SlideController::class, 'store'])->name('slides.store');
        Route::put('/slides/{slide}/toggle', [\App\Http\Controllers\SlideController::class, 'toggleActive'])->name('slides.toggle');
        Route::put('/slides/{slide}', [\App\Http\Controllers\SlideController::class, 'update'])->name('slides.update');
        Route::delete('/slides/{slide}', [\App\Http\Controllers\SlideController::class, 'destroy'])->name('slides.destroy');
        Route::post('/slides/{id}/restore', [\App\Http\Controllers\SlideController::class, 'restore'])->name('slides.restore');
        
        // Dashboard slides management routes (separate from meeting slides)
        Route::get('/dashboard-slides/manage', [\App\Http\Controllers\DashboardSlideController::class, 'manage'])->name('dashboard_slides.manage');
        Route::post('/dashboard-slides', [\App\Http\Controllers\DashboardSlideController::class, 'store'])->name('dashboard_slides.store');
        Route::put('/dashboard-slides/{slide}/toggle', [\App\Http\Controllers\DashboardSlideController::class, 'toggleActive'])->name('dashboard_slides.toggle');
        Route::put('/dashboard-slides/{slide}', [\App\Http\Controllers\DashboardSlideController::class, 'update'])->name('dashboard_slides.update');
        Route::delete('/dashboard-slides/{slide}', [\App\Http\Controllers\DashboardSlideController::class, 'destroy'])->name('dashboard_slides.destroy');
        Route::post('/dashboard-slides/{id}/restore', [\App\Http\Controllers\DashboardSlideController::class, 'restore'])->name('dashboard_slides.restore');
    });

    
});
