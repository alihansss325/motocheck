<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiagnosisController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = auth()->user();
    $csrfToken = csrf_token();

    if ($user === null) {
        $desktopAccountAction = '<a href="/login" class="inline-flex items-center px-4 py-2 border border-orange-500/30 rounded-xl text-sm font-semibold text-orange-400 bg-orange-500/10 hover:bg-orange-500 hover:text-white transition-all duration-200 shadow-sm">Masuk / Daftar</a>';
        $mobileAccountAction = '<a href="/login" class="w-full text-left px-4 py-3 rounded-xl font-medium text-sm flex items-center space-x-3 text-slate-200 hover:bg-slate-800"><span>Masuk / Daftar</span></a>';
        $logoutAction = '';
    } else {
        $accountUrl = $user->isAdmin() ? '/admin' : '/account';
        $accountLabel = $user->isAdmin() ? 'Dashboard admin' : 'Akun saya';
        $desktopAccountAction = '<a href="'.$accountUrl.'" aria-label="'.$accountLabel.'" title="'.$accountLabel.'" class="inline-flex items-center justify-center w-10 h-10 border border-slate-600 rounded-xl text-slate-200 hover:bg-slate-800 hover:text-white transition-all duration-200">'
            .'<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21a8 8 0 0 0-16 0m8-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/></svg>'
            .'</a>';
        $mobileAccountAction = ($user->isAdmin()
            ? '<a href="/admin" class="w-full text-left px-4 py-3 rounded-xl font-medium text-sm flex items-center space-x-3 text-slate-200 hover:bg-slate-800"><span>Dashboard admin</span></a>'
            : '<a href="/account" class="w-full text-left px-4 py-3 rounded-xl font-medium text-sm flex items-center space-x-3 text-slate-200 hover:bg-slate-800"><span>Akun saya</span></a>');
        $logoutAction = '<form method="post" action="/logout"><input type="hidden" name="_token" value="'
            .e($csrfToken)
            .'"><button type="submit" class="inline-flex items-center px-4 py-2 border border-slate-600 rounded-xl text-sm font-semibold text-slate-300 hover:bg-slate-800 transition-all duration-200">Keluar</button></form>';
        $mobileAccountAction .= '<form method="post" action="/logout"><input type="hidden" name="_token" value="'
            .e($csrfToken)
            .'"><button type="submit" class="w-full text-left px-4 py-3 rounded-xl font-medium text-sm text-slate-200 hover:bg-slate-800">Keluar</button></form>';
    }

    $html = str_replace(
        ['__CSRF_TOKEN__', '__DESKTOP_ACCOUNT_ACTION__', '__MOBILE_ACCOUNT_ACTION__', '__LOGOUT_ACTION__'],
        [e($csrfToken), $desktopAccountAction, $mobileAccountAction, $logoutAction],
        File::get(base_path('index.html')),
    );

    return response($html)
        ->header('Content-Type', 'text/html; charset=UTF-8')
        ->header('Cache-Control', 'private, no-store');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegistration'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::post('/api/diagnoses', [DiagnosisController::class, 'store'])->middleware('throttle:20,1')->name('diagnoses.store');

Route::middleware('auth')->group(function () {
    Route::get('/account', AccountController::class)->name('account');
    Route::middleware('regular-user')->group(function () {
        Route::patch('/account/profile', [AccountSettingsController::class, 'updateProfile'])->name('account.profile.update');
        Route::put('/account/password', [AccountSettingsController::class, 'updatePassword'])->name('account.password.update');
        Route::delete('/account', [AccountSettingsController::class, 'destroy'])->name('account.destroy');
    });
    Route::get('/admin', AdminDashboardController::class)
        ->middleware('admin')
        ->name('admin.dashboard');
});
