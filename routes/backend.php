<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('dashboard_admin',[DashboardController::class,'index']);


Route::get('/dashboard/patient', function () {
    return view('Dashboard.patient.dashboard');
})->middleware(['auth'])->name('dashboard.patient');




require __DIR__.'/auth.php';