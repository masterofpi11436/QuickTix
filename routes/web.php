<?php

use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Default Redirect
Route::get('/', function () {
    // If user is not logged in → go to login
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Otherwise, send them to their correct dashboard
    return match (Auth::user()->role) {
        UserRole::Administrator => redirect()->route('admin.dashboard'),
        UserRole::Controller => redirect()->route('controller.dashboard'),
        UserRole::Technician => redirect()->route('technician.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
});

// Theme Toggle
Route::post('/user/theme', function (Request $request) {
    $request->validate(['theme' => 'in:light,dark']);

    $user = $request->user();
    $user->theme = $request->theme;
    $user->save();

    session(['theme' => $request->theme]);

    return back();
})->middleware('auth')->name('user.theme');

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:' . UserRole::Administrator->value])
    ->group(function () {
        Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
        Route::view('/admin/profile', 'admin.profile')->name('admin.profile');
    });

Route::middleware(['auth', 'role:' . UserRole::Controller->value])
    ->group(function () {
        Route::view('/controller/dashboard', 'controller.dashboard')->name('controller.dashboard');
        Route::view('/controller/profile', 'controller.profile')->name('controller.profile');
    });

Route::middleware(['auth', 'role:' . UserRole::Technician->value])
    ->group(function () {
        Route::view('/technician/dashboard', 'technician.dashboard')->name('technician.dashboard');
        Route::view('/technician/profile', 'technician.profile')->name('technician.profile');
    });

Route::middleware(['auth', 'role:' . UserRole::User->value])
    ->group(function () {
        Route::view('/user/dashboard', 'user.dashboard')->name('user.dashboard');
        Route::view('/user/profile', 'user.profile')->name('user.profile');
    });
