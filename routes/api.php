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


Route::middleware('auth:api')->get('/user', 'UserController@show');


Route::post('/create-order', 'TestController@createOrder');
Route::post('/manual-order-status-update', 'TestController@manualOrderStatusUpdate');
Route::post('/order-status', 'TestController@orderStatus');

Route::post('/sso-web-login', 'TestController@ssoWebLogin');
Route::post('/sso-sdk-login', 'TestController@ssoSDKLogin');
Route::post('/sso-verify-customer', 'TestController@verifyCustomer');