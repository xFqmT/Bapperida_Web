<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodController;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [PeriodController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
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
    
    // Period routes
    Route::get('/periods/create', [PeriodController::class, 'create'])->name('periods.create');
    Route::post('/periods', [PeriodController::class, 'store'])->name('periods.store');
    Route::get('/periods/{period}/edit', [PeriodController::class, 'edit'])->name('periods.edit');
    Route::put('/periods/{period}', [PeriodController::class, 'update'])->name('periods.update');
    Route::delete('/periods/{period}', [PeriodController::class, 'destroy'])->name('periods.destroy');
    Route::get('/periods/import', [PeriodController::class, 'showImportForm'])->name('periods.import');
    Route::post('/periods/import', [PeriodController::class, 'import'])->name('periods.import.store');
    Route::post('/periods/export', [PeriodController::class, 'export'])->name('periods.export');
    Route::post('/periods/{period}/complete', [PeriodController::class, 'complete'])->name('periods.complete');
    Route::post('/periods/{period}/hide', [PeriodController::class, 'hide'])->name('periods.hide');
    Route::post('/periods/{id}/restore', [PeriodController::class, 'restore'])->name('periods.restore');

    
});
