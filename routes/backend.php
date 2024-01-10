<?php

use App\Http\Controllers\Dashboard\AbmulanceController;
use App\Http\Controllers\Dashboard\AmbulanceController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\InsuranceController;
use App\Http\Controllers\Dashboard\PatientController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\SingleServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
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

Route::get('dashboard_admin', [DashboardController::class, 'index']);


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {


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

            Route::resource('doctors', DoctorController::class);

            Route::post('update_password', [DoctorController::class, 'update_password'])->name('update_password');

            Route::post('update_status', [DoctorController::class, 'update_status'])->name('update_status');

            Route::resource('services', SingleServiceController::class);

            // ########### Routes livewire for add_group_services  ############
    

            Livewire::setUpdateRoute(function ($handle) {
                return Route::post('/custom/livewire/update', $handle);
            });


            Route::view('Add_GroupServices', 'livewire.GroupServices.include_create')->name('Add_GroupServices');


            Route::view('single_invoices', 'livewire.single_invoices.index')->name('single_invoices');




            Route::resource('insurance', InsuranceController::class);

            Route::resource('ambulances', AmbulanceController::class);

            Route::resource('patients', PatientController::class);


        });


        require __DIR__ . '/auth.php';

    }
);

