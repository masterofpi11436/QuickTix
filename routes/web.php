<?php

use App\Enums\UserRole;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

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
