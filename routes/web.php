<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;
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

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return redirect('login');
});
Route::get('logout', [LoginController::class, 'logout'])->name('logout2');
Route::resource('doctor', DoctorController::class);
Route::resource('department', DepartmentController::class);
Route::resource('patient', PatientController::class);
Route::resource('appointment', AppointmentController::class);
Route::resource('schedule', ScheduleController::class);
// routes/web.php

Route::get('/get-doctors/{department}', [DoctorController::class,'getDoctors'])->name('get-doctors');
Route::post('search', [SearchController::class,'search'])->name('search');
