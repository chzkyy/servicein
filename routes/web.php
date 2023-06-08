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

/**
  * /------------------------------------------------------------------
  * | Group Profile => /Profile/..
  * /------------------------------------------------------------------
  */
Route::group(['prefix' => 'profile'], function() {
    Route::get('/', 'App\Http\Controllers\CustomerController@profile')
        ->name('profile')
        ->middleware(['auth', 'verified']);

    Route::get('/edit', 'App\Http\Controllers\CustomerController@edit_profile')
        ->name('edit.profile')
        ->middleware(['auth', 'verified']);

    Route::post('/update', 'App\Http\Controllers\CustomerController@update_profile')
        ->name('update.profile')
        ->middleware(['auth', 'verified']);

    Route::post('/avatar/update', 'App\Http\Controllers\CustomerController@update_avatar')
        ->name('update-avatar')
        ->middleware(['auth', 'verified']);
});


/**
  * /------------------------------------------------------------------
  * | Group Device => /device/..
  * /------------------------------------------------------------------
  */


Route::group(['prefix' => 'device'], function() {
    Route::get('/', 'App\Http\Controllers\DeviceController@show')
        ->name('list-device')
        ->middleware(['auth', 'verified']);

    Route::get('/list', 'App\Http\Controllers\DeviceController@getDevice')
        ->name('get-list-device')
        ->middleware(['auth', 'verified']);

    Route::post('/add', 'App\Http\Controllers\DeviceController@store')
        ->name('add-device')
        ->middleware(['auth','verified']);

    Route::put('/remove/{id}', 'App\Http\Controllers\DeviceController@destroy')
        ->name('delete-device')
        ->middleware(['auth','verified']);

    Route::post('/update', 'App\Http\Controllers\DeviceController@update')
        ->name('edit-device')
        ->middleware(['auth','verified']);
});


/**
  * /------------------------------------------------------------------
  * | for detail merchant information
  * /------------------------------------------------------------------
  */
Route::get('/detail-merchant/{id}', 'App\Http\Controllers\DetailMerchantController@index')
    ->name('detail-merchant')
    ->middleware(['auth','verified']);


/**
  * /------------------------------------------------------------------
  * | Group bookin => /booking/..
  * /------------------------------------------------------------------
  */
Route::group(['prefix' => 'booking'], function() {
    Route::get('/{id}', 'App\Http\Controllers\TransactionController@index')
        ->name('create-booking')
        ->middleware(['auth','verified']);

    Route::get('/success', 'App\Http\Controllers\TransactionController@booking_success')
        ->name('success-booking')
        ->middleware(['auth','verified']);

    Route::get('/list-time', 'App\Http\Controllers\TransactionController@list_time')
        ->name('get-time-booking')
        ->middleware(['auth','verified']);

    Route::post('/booking/store', 'App\Http\Controllers\TransactionController@store')
        ->name('store-booking')
        ->middleware(['auth','verified']);
});


/**
 * /------------------------------------------------------------------
 * | Route admin toko
 * /------------------------------------------------------------------
 * |
 * | Route untuk Admin Toko
 * |
 */

Route::group(['prefix' => 'admin'], function() {
    Route::get('/profile', 'App\Http\Controllers\MerchantController@merchant')
        ->name('profile.admin')
        ->middleware(['auth', 'verified']);

    Route::get('/edit-profile', 'App\Http\Controllers\MerchantController@edit_merchant')
        ->name('edit.profile.admin')
        ->middleware(['auth', 'verified']);

    Route::post('/update-profile', 'App\Http\Controllers\MerchantController@update_merchant')
        ->name('update.profile.admin')
        ->middleware(['auth', 'verified']);

    Route::post('/update-avatar', 'App\Http\Controllers\MerchantController@update_avatar')
        ->name('update-avatar-admin')
        ->middleware(['auth', 'verified']);

    Route::post('/merchant_gallery', 'App\Http\Controllers\MerchantController@merchant_gallery')
        ->name('merchant-gallery')
        ->middleware(['auth', 'verified']);

    Route::POST('/delete_gallery', 'App\Http\Controllers\MerchantController@delete_merchant_gallery')
        ->name('delete-merchant-gallery')
        ->middleware(['auth', 'verified']);
});


/**
 * /------------------------------------------------------------------
 * | Route privacy policy
 * /------------------------------------------------------------------
 * |
 * | Route untuk privacy policy, terms and conditions dan lain-lain
 * |
 */

Route::get('/privacy-policy', 'App\Http\Controllers\PolicyController@PrivacyPolicy')
    ->name('privacy-policy');
