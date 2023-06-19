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
 * | Route super admin
 * /------------------------------------------------------------------
 * |
 * | Route untuk super admin
 * |
 */

Route::group(['prefix' => 'super-admin'], function () {
    Route::get('/', 'App\Http\Controllers\SuperAdminController@index')
        ->name('dashboard-super-admin')
        ->middleware(['auth', 'verified', 'super_admin']);

    Route::get('/getDataMerchant', 'App\Http\Controllers\SuperAdminController@getDataMerchant')
        ->name('get-data-merchant')
        ->middleware(['auth', 'verified', 'super_admin']);

    Route::post('/deleteMerchant', 'App\Http\Controllers\SuperAdminController@deleteAccount')
        ->name('delete-merchant')
        ->middleware(['auth', 'verified', 'super_admin']);

    Route::post('/suspendMerchant', 'App\Http\Controllers\SuperAdminController@suspendAccount')
        ->name('suspend-merchant')
        ->middleware(['auth', 'verified', 'super_admin']);

    Route::get('/viewbill/{id}', 'App\Http\Controllers\SuperAdminController@viewBIll')
        ->name('viewBill-merchant')
        ->middleware(['auth', 'verified', 'super_admin']);

    Route::get('/sendbill/{id}', 'App\Http\Controllers\SuperAdminController@sendBill')
        ->name('sendBill-merchant')
        ->middleware(['auth', 'verified', 'super_admin']);

    Route::post('/getListTransaction', 'App\Http\Controllers\SuperAdminController@getListTransaction')
        ->name('getListTransaction-admin')
        ->middleware(['auth', 'verified', 'super_admin']);

    Route::post('/createbill', 'App\Http\Controllers\SuperAdminController@createBill')
        ->name('createBill-merchant')
        ->middleware(['auth', 'verified', 'super_admin']);

    Route::post('/approve', 'App\Http\Controllers\SuperAdminController@approved')
        ->name('approve-merchant')
        ->middleware(['auth', 'verified', 'super_admin']);

    Route::post('/decline', 'App\Http\Controllers\SuperAdminController@decline')
        ->name('decline-merchant')
        ->middleware(['auth', 'verified', 'super_admin']);
});


/**
 * /------------------------------------------------------------------
 * | Route User
 * /------------------------------------------------------------------
 * |
 * | Route untuk user
 * |
 */
Route::get('/search', 'App\Http\Controllers\SearchController@searchMerchant')
    ->name('search-merchant');

Route::get('/', 'App\Http\Controllers\HomeController@index')
    ->name('home');


Route::get('/admin', 'App\Http\Controllers\TransactionController@show_transaction_merchant')
    ->name('dashboard-merchant')
    ->middleware(['auth', 'verified', 'merchant']);



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
 * | Route review
 * /------------------------------------------------------------------
 * |
 * | Route untuk review
 * |
 */


Route::group(['prefix' => 'review'], function() {
    Route::post('/add', 'App\Http\Controllers\ReviewController@addReview')
        ->name('add-review')
        ->middleware(['auth', 'verified']);

    Route::post('/add-image', 'App\Http\Controllers\ReviewController@addImage')
        ->name('add-image')
        ->middleware(['auth', 'verified']);
});




/**
 * /------------------------------------------------------------------
 * | Route notification
 * /------------------------------------------------------------------
 * |
 * | Route untuk notification
 * |
 */


Route::group(['prefix' => 'notification'], function () {
    Route::get('/', 'App\Http\Controllers\NotificationController@index')
        ->name('notification')
        ->middleware(['auth', 'verified']);

    Route::get('/get', 'App\Http\Controllers\NotificationController@getNotification')
        ->name('get-notification')
        ->middleware(['auth', 'verified']);

    Route::post('/read', 'App\Http\Controllers\NotificationController@readNotification')
        ->name('read-notification')
        ->middleware(['auth', 'verified']);

});


/**
  * /------------------------------------------------------------------
  * | Group chat
  * /------------------------------------------------------------------
  */

Route::group(['prefix' => 'chat'], function() {
    Route::get('/getlistcust', 'App\Http\Controllers\ChatController@getlistCust')
        ->name('get-list-customer')
        ->middleware(['auth', 'verified', 'customer']);

    Route::get('/', 'App\Http\Controllers\ChatController@listChatCust')
        ->name('chat')
        ->middleware(['auth', 'verified', 'customer']);

    Route::get('/{id}', 'App\Http\Controllers\ChatController@viewChatCust')
        ->name('chat-merchant')
        ->middleware(['auth', 'verified', 'customer']);


    Route::post('/getMessage', 'App\Http\Controllers\ChatController@getMessageCust')
        ->name('getChatCust')
        ->middleware(['auth', 'verified', 'customer']);

    Route::post('/sendMessage', 'App\Http\Controllers\ChatController@sendMessage')
        ->name('sendMessageCust')
        ->middleware(['auth', 'verified']);

    Route::post('/read', 'App\Http\Controllers\ChatController@readMessage')
        ->name('readChat')
        ->middleware(['auth', 'verified']);
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

Route::post('/get-detail/merchant', 'App\Http\Controllers\DetailMerchantController@getDetail')
    ->name('get-detail-m')
    ->middleware(['auth','verified']);

Route::post('/merchant/confirm', 'App\Http\Controllers\TransactionController@getServiceConfirmation')
    ->name('sevice_confirmation')
    ->middleware(['auth','verified']);

    // send confirmation by merchant \/
Route::post('/service-confirm', 'App\Http\Controllers\TransactionController@sendServiceConfirmation')
    ->name('confirm-service')
    ->middleware(['auth', 'verified']);


/**
  * /------------------------------------------------------------------
  * | Group bookin => /booking/..
  * /------------------------------------------------------------------
  */


Route::group(['prefix' => 'booking'], function() {
    Route::get('/success', 'App\Http\Controllers\TransactionController@booking_success')
        ->name('success-booking')
        ->middleware(['auth','verified', 'customer']);

    Route::get('/{id}', 'App\Http\Controllers\TransactionController@index')
        ->name('create-booking')
        ->middleware(['auth','verified', 'customer']);

    Route::post('/list-time', 'App\Http\Controllers\TransactionController@list_time')
        ->name('get-time-booking')
        ->middleware(['auth','verified', 'customer']);

    Route::post('/booking/store', 'App\Http\Controllers\TransactionController@store')
        ->name('store-booking')
        ->middleware(['auth','verified', 'customer']);
});


/**
  * /------------------------------------------------------------------
  * | Group transaction => /transaction/..
  * /------------------------------------------------------------------
  */

Route::group(['prefix' => 'transaction'], function() {
    Route::get('/detail/{id}', 'App\Http\Controllers\TransactionController@detail_transaction')
        ->name('detail-transaction')
        ->middleware(['auth','verified', 'customer']);

    Route::get('/', 'App\Http\Controllers\TransactionController@show_transaction')
        ->name('show-transaction')
        ->middleware(['auth','verified', 'customer']);

    Route::get('/get', 'App\Http\Controllers\TransactionController@get_transaction')
        ->name('customer.transaction.list')
        ->middleware(['auth','verified','customer']);

    Route::get('/getmerchant', 'App\Http\Controllers\TransactionController@get_transaction_merchant')
        ->name('merchant.transaction.list')
        ->middleware(['auth','verified','merchant']);

    Route::get('/invoice/{id}', 'App\Http\Controllers\TransactionController@view_invoice_customer')
        ->name('view-invoice-customer')
        ->middleware(['auth', 'verified', 'customer']);

    Route::post('/cancle', 'App\Http\Controllers\TransactionController@cancle_booking')
        ->name('cancel-booking')
        ->middleware(['auth','verified', 'customer']);

    Route::post('/cancle', 'App\Http\Controllers\TransactionController@cancle_booking')
        ->name('cancel-booking')
        ->middleware(['auth','verified', 'customer']);

    Route::post('/complaint', 'App\Http\Controllers\TransactionController@complaint')
        ->name('complaint')
        ->middleware(['auth','verified', 'customer']);
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
    Route::get('/trasaction-detail/{id}', 'App\Http\Controllers\TransactionController@getTransactionDetailMerchant')
        ->name('detail-transaction-admin')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::get('/profile', 'App\Http\Controllers\MerchantController@merchant')
        ->name('profile.admin')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::get('/edit-profile', 'App\Http\Controllers\MerchantController@edit_merchant')
        ->name('edit.profile.admin')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/update-profile', 'App\Http\Controllers\MerchantController@update_merchant')
        ->name('update.profile.admin')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/update-avatar', 'App\Http\Controllers\MerchantController@update_avatar')
        ->name('update-avatar-admin')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/merchant-gallery', 'App\Http\Controllers\MerchantController@merchant_gallery')
        ->name('merchant-gallery')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/delete-gallery', 'App\Http\Controllers\MerchantController@delete_merchant_gallery')
        ->name('delete-merchant-gallery')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/transaction/update-status', 'App\Http\Controllers\TransactionController@updateStatus')
        ->name('update-status-transaction')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/transaction/done-complaint', 'App\Http\Controllers\TransactionController@complaintDone')
        ->name('update-complaint-transaction')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/transaction/sendconfirmation', 'App\Http\Controllers\TransactionController@send_confirm')
        ->name('send-confirmation')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::get('/invoice/create/{id}', 'App\Http\Controllers\TransactionController@create_invoice')
        ->name('create-invoice')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::get('/invoice/{id}', 'App\Http\Controllers\TransactionController@view_invoice')
        ->name('view-invoice')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/invoice/get', 'App\Http\Controllers\TransactionController@get_invoice')
        ->name('get-invoice')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/invoice/add', 'App\Http\Controllers\TransactionController@add_invoice')
        ->name('add-invoice')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/invoice/delete', 'App\Http\Controllers\TransactionController@delete_invoice')
        ->name('delete-invoice')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/invoice/update', 'App\Http\Controllers\TransactionController@update_invoice')
        ->name('update-invoice')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/invoice/send', 'App\Http\Controllers\TransactionController@sendInvoice')
        ->name('send-invoice')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::get('/chat', 'App\Http\Controllers\ChatController@listChatMerch')
        ->name('admin-chat')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::get('/chat-list', 'App\Http\Controllers\ChatController@getlist')
        ->name('admin-chat-list')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::get('/chat/{id}', 'App\Http\Controllers\ChatController@viewChatMerch')
        ->name('admin-room-chat')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/chat/get', 'App\Http\Controllers\ChatController@getMessageMerch')
        ->name('getAdminChat')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::post('/chat/send', 'App\Http\Controllers\ChatController@sendMessageMerch')
        ->name('sendAdminChat')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::get('/bills', 'App\Http\Controllers\SuperAdminController@viewMerchant')
        ->name('admin-bills')
        ->middleware(['auth', 'verified', 'merchant']);

    Route::get('/list-bills', 'App\Http\Controllers\SuperAdminController@getListBillsMerchant')
        ->name('admin-list-bills')
        ->middleware(['auth', 'verified', 'merchant']);
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
