<?php

use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\TicketTemplateController;

use App\Http\Controllers\Controller\ControllerUserController;
use App\Http\Controllers\Controller\ControllerTicketController;
use App\Http\Controllers\Controller\ControllerReportsController;

use App\Http\Controllers\ReportingUser\ReportingUserTicketController;
use App\Http\Controllers\ReportingUser\ReportingUserReportsController;

use App\Http\Controllers\User\UserTicketController;

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login'); // or redirect('/login')
})->middleware('auth')->name('logout');

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Otherwise, send them to their correct dashboard
    return match (Auth::user()->role) {
        UserRole::Administrator => redirect()->route('admin.dashboard'),
        UserRole::Controller => redirect()->route('controller.dashboard'),
        UserRole::Technician => redirect()->route('technician.dashboard'),
        UserRole::ReportingUser => redirect()->route('reporting-user.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
});

// Theme Toggle
Route::post('/user/theme', function (Request $request) {
    $request->user()->update(['theme' => $request->theme]);
    return response()->noContent();
})->middleware('auth');


require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:' . UserRole::Administrator->value])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
        Route::view('/profile', 'admin.profile')->name('profile');
        Route::resource('tickettemplates', TicketTemplateController::class);
        Route::resource('tickets', TicketController::class);
        Route::put('tickets/{ticket}/assign', [TicketController::class, 'assign'])
            ->name('tickets.assign');
        Route::put('status-type-defaults/{statusType}', [TicketController::class, 'updateStatusTypeDefault'])
            ->name('status-type-defaults.update');

        // Administrative pages
        Route::view('/administration', 'admin.administration')->name('administration');
        Route::resource('users', UserController::class);
        Route::resource('statuses', StatusController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('areas', AreaController::class);

        // Reoprt pages
        Route::resource('reports', ReportsController::class);
    });

Route::middleware(['auth', 'role:' . UserRole::Controller->value])
    ->prefix('controller')
    ->name('controller.')
    ->group(function () {
        Route::view('/dashboard', 'controller.dashboard')->name('dashboard');
        Route::view('/profile', 'controller.profile')->name('profile');
        Route::resource('tickets', ControllerTicketController::class);
        Route::put('tickets/{ticket}/assign', [ControllerTicketController::class, 'assign'])
            ->name('tickets.assign');
        Route::put('status-type-defaults/{statusType}', [ControllerTicketController::class, 'updateStatusTypeDefault'])
            ->name('status-type-defaults.update');

        // Administrative pages
        Route::resource('users', ControllerUserController::class);

        // Reoprt pages
        Route::resource('reports', ControllerReportsController::class);
    });

Route::middleware(['auth', 'role:' . UserRole::Technician->value])
    ->prefix('technician')
    ->name('technician.')
    ->group(function () {
        Route::view('/dashboard', 'technician.dashboard')->name('dashboard');
        Route::view('/profile', 'technician.profile')->name('profile');
    });

Route::middleware(['auth', 'role:' . UserRole::ReportingUser->value])
    ->prefix('reporting-user')
    ->name('reporting-user.')
    ->group(function () {
        Route::view('/dashboard', 'reporting-user.dashboard')->name('dashboard');
        Route::view('/profile', 'reporting-user.profile')->name('profile');
        Route::resource('tickets', ReportingUserTicketController::class);

        // Reoprt pages
        Route::resource('reports', ReportingUserReportsController::class);
    });

Route::middleware(['auth', 'role:' . UserRole::User->value])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::view('/dashboard', 'user.dashboard')->name('dashboard');
        Route::view('/profile', 'user.profile')->name('profile');
        Route::resource('tickets', UserTicketController::class);
    });
