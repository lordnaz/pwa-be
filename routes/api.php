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

Route::group([
	'middleware' => 'api',
	'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function($router){
    Route::post('login', 'AuthController@login');
});

Route::group([
	'middleware' => 'api',
	'namespace' => 'App\Http\Controllers'
], function($router){
    Route::post('category', 'ProductController@category');
    Route::post('countries', 'ProductController@countries');
    Route::post('product_owners', 'ProductController@product_owners');
    Route::post('get_products', 'ProductController@get_products');
    Route::post('get_otp', 'OtpController@get_otp');
    // Route::get('get_token', 'OtpController@get_token');
    Route::post('validate_otp', 'OtpController@validate_otp');
    Route::post('pay_status', 'OtpController@pay_status');
    Route::post('resend_otp', 'OtpController@resend_otp');
});