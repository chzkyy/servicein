<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', function () {
    return view('index');
})->name('index');

Route::get('/test', 'App\Http\Controllers\MerchantController@index');

/**
 * /------------------------------------------------------------------
 * | Route User
 * /------------------------------------------------------------------
 * |
 * | Route untuk user
 * |
 */

Route::get('/', 'App\Http\Controllers\HomeController@index')
    ->name('home');

/**
 * /------------------------------------------------------------------
 * | Route Auth
 * /------------------------------------------------------------------
 * |
 * | Route untuk Authentication
 * |
 */
Auth::routes();

// Route::post('/register-admin', 'App\Http\Controllers\Auth\RegisterController@AdminRegister')
//     ->name('admin.register')
//     ->middleware(['guest']);

Route::get('/change-password', 'App\Http\Controllers\Auth\ForgotPasswordController@ChangePassword')
    ->name('change-password');

Route::post('/change', 'App\Http\Controllers\Auth\ForgotPasswordController@updatePassword')
    ->name('password.change');

Route::get('/reset-password/success', 'App\Http\Controllers\Auth\ForgotPasswordController@success')
    ->name('reset-success');

Route::get('/verify/success', 'App\Http\Controllers\Auth\VerificationController@success')
    ->name('verify-success');

Route::get('/choose', 'App\Http\Controllers\Auth\ChooseRoleController@chooseRole')
    ->name('choose.role');

Route::post('/storeRole', 'App\Http\Controllers\Auth\ChooseRoleController@storeRole')
    ->name('store.role');

Route::group(['prefix' => 'login'], function () {
    Route::get('google', 'App\Http\Controllers\Auth\AuthGoogleController@redirect')
        ->name('redirect')
        ->middleware(['guest']);

    Route::get('google/callback', 'App\Http\Controllers\Auth\AuthGoogleController@callback')
        ->name('callback')
        ->middleware(['guest']);
});


/**
 * /------------------------------------------------------------------
 * | Route email verification
 * /------------------------------------------------------------------
 * |
 * | Route untuk email verification
 * |
 */
Route::group(['prefix' => 'email'], function() {
    Route::post('/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

    Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return redirect('/verify/success');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::get('/verify', function () {
        return view('auth.verify');
    })->middleware('auth')->name('verification.notice');
});


/**
 * /------------------------------------------------------------------
 * | Route customer
 * /------------------------------------------------------------------
 * |
 * | Route untuk customer
 * |
 */

Route::get('/profile', 'App\Http\Controllers\CustomerController@profile')
    ->name('profile')
    ->middleware(['auth', 'verified']);


Route::get('/edit-profile', 'App\Http\Controllers\CustomerController@edit_profile')
    ->name('edit.profile')
    ->middleware(['auth', 'verified']);

Route::post('/update-profile', 'App\Http\Controllers\CustomerController@update_profile')
    ->name('update.profile')
    ->middleware(['auth', 'verified']);

Route::post('/update-avatar', 'App\Http\Controllers\CustomerController@update_avatar')
    ->name('update.avatar')
    ->middleware(['auth', 'verified']);
