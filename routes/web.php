<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SessionExpiredController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return redirect('login');
});
Route::get('logout', [LoginController::class, 'logout'])->name('logout2');
Route::resource('doctor', DoctorController::class);
Route::resource('department', DepartmentController::class);
Route::resource('patient', PatientController::class);
Route::resource('appointment', AppointmentController::class);
Route::resource('schedule', ScheduleController::class);
Route::get('session-expired', [SessionExpiredController::class, 'index']);
