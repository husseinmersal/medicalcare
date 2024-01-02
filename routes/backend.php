<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 


        // ########### Dashboard User ############

        Route::get('/dashboard/user', function () {
            return view('Dashboard.user.dashboard');
        })->middleware(['auth:web'])->name('dashboard.user');
        

        // ########### Dashboard Admin ############

        
        Route::get('/dashboard/admin', function () {
            return view('Dashboard.admin.dashboard');
        })->middleware(['auth:admin'])->name('dashboard.admin');
        



        // ########### Routes Authenticated With Admin  ############

        
     Route::middleware(['auth:admin'])->group(function () {
        Route::resource('sections', SectionController::class);
     });


        require __DIR__.'/auth.php';
        
    });

