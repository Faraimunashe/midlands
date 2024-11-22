<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\MdaController;
use App\Http\Controllers\Admin\QuarterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Mda\ProgressController;
use App\Http\Controllers\Mda\TargetController;
use App\Http\Middleware\IsNewUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('WelcomePage');
});


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login');
Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('password.change');
Route::post('/change-password', [ChangePasswordController::class, 'store'])->name('password.change');

Route::middleware(['auth'])->group(function () {
    Route::get('/authentication', [AuthenticationController::class, 'index'])->name('authentication');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');


});

Route::group(['middleware' => ['auth', 'role:admin']], function(){
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin-dashboard');

    Route::resource('users', UserController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('quarters', QuarterController::class);
    Route::resource('mdas', MdaController::class);
});


Route::group(['middleware' => ['auth', 'role:mda']], function(){
    Route::resource('targets', TargetController::class);

    Route::get('targets/{id}/progress', [ProgressController::class, 'create']);
    Route::post('targets/{id}/progress', [ProgressController::class, 'store']);
});
