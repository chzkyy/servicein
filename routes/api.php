<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * /------------------------------------------------------------------
 * | API Routes
 * /------------------------------------------------------------------
 * |
 * | Route untuk get api ke google maps
 * |
 */
Route::post('getMatrix', 'App\Http\Controllers\GetAPI_Controller@getMatrix');
Route::get('searchPlace', 'App\Http\Controllers\GetAPI_Controller@searchPlace');
Route::post('getLocation', 'App\Http\Controllers\GetAPI_Controller@getLocation');
Route::get('maps', 'App\Http\Controllers\GetAPI_Controller@MapsJs');

