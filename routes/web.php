<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\jobListingController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAccountOwnership;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/jobs', [HomeController::class, 'jobs'])->name('home.jobs');
Route::get('/jobs/filter', [HomeController::class, 'jobsfilter'])->name('home.jobsfilter');
Route::get('/jobs/{name}', [HomeController::class, 'filterjob'])->name('home.filterjob');

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
Route::get('/jobsingle/{id}', [jobListingController::class, 'jobsingle'])->name('jobsingle');
Route::get('/joblist/apply/{id}', [jobListingController::class, 'jobapply'])->name('joblist.apply');

// Reset password
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Show form to reset password
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::group(
    ['middleware' => 'auth'],
    function () {

        Route::post('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::post('/send-meet-link/{applicationId}', [jobListingController::class, 'sendMeetLink'])->name('send.meet.link');
        Route::get('/category', [jobListingController::class, 'category'])->name('account.category');
        Route::get('/applied', [jobListingController::class, 'applied'])->name('account.applied');
        Route::delete('/applied/{id}', [jobListingController::class, 'appliedDelete'])->name('account.appliedDelete');
        Route::get('/joblist', [jobListingController::class, 'joblist'])->name('account.joblist');
        Route::get('/joblist/edit', [jobListingController::class, 'joblistEdit'])->name('joblist.edit');
        Route::delete('/joblist/delete/{id}', [jobListingController::class, 'joblistdlt'])->name('joblist.delete');
        Route::post('/joblist/update/{id}', [jobListingController::class, 'joblistUpdate'])->name('joblist.update');
        Route::get('/account/{id}', [AccountController::class, 'index'])->name('account')->middleware([CheckAccountOwnership::class]);
    }
);
