<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\jobListingController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAccountOwnership;
use App\Http\Middleware\RedirectIfAuthenticated;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/jobs', [HomeController::class, 'jobs'])->name('home.jobs');
Route::get('/jobs/filter', [HomeController::class, 'jobsfilter'])->name('home.jobsfilter');
Route::get('/jobs/{name}', [HomeController::class, 'singlejob'])->name('home.singlejob');

Route::get('/login', [AccountController::class, 'login'])->name('account.login')->middleware([RedirectIfAuthenticated::class]);
Route::post('/loginprocess', [AccountController::class, 'loginprocess'])->name('account.loginprocess');
Route::get('/register', [AccountController::class, 'register'])->name('account.register');
Route::get('/job-post', [AccountController::class, 'jobPost'])->name('account.jobPost');
Route::post('/storejob', [jobListingController::class, 'index'])->name('joblistings.store');
Route::post('/registerprocess', [AccountController::class, 'registerprocess'])->name('account.registerprocess');
Route::post('/categoryadd', [jobListingController::class, 'categoryadd'])->name('account.categoryadd');
Route::post('/uploadimage', [AccountController::class, 'uploadImage'])->name('account.uploadImage');
Route::post('/accountUpdate', [AccountController::class, 'accountUpdate'])->name('account.update');
Route::post('/passwordUpdate', [AccountController::class, 'passwordUpdate'])->name('account.passwordUpdate');



Route::group(
    ['middleware' => 'auth'],
    function () {

        Route::post('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::get('/category', [jobListingController::class, 'category'])->name('account.category');
        Route::get('/joblist', [jobListingController::class, 'joblist'])->name('account.joblist');
        Route::get('/account/{id}', [AccountController::class, 'index'])->name('account')->middleware([CheckAccountOwnership::class]);
    }
);
