<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use bSecure\UniveralCheckout\Controllers\Orders\CreateOrderController;
use bSecure\UniveralCheckout\Controllers\Orders\OrderStatusUpdateController;
use bSecure\UniveralCheckout\Controllers\Orders\IOPNController;
use bSecure\UniveralCheckout\Controllers\SSO\VerifyClientController;
use bSecure\UniveralCheckout\Controllers\SSO\CustomerVerification;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('create-order', function(Request $request) {
    $requestData = $request->all();
    $order = new CreateOrderController();
    return $order->create($requestData);
});

Route::post('manual-order-status-update', function(Request $request) {
    $requestData = $request->all();
    $order = new OrderStatusUpdateController();
    return $order->updateStatus($requestData);
});

Route::post('order-status', function(Request $request) {
    $requestData = $request->all();
    $customer = new IOPNController();
    return $customer->orderStatus($requestData);
});


Route::post('sso-login', function(Request $request) {
    $requestData = $request->all();
    $client = new VerifyClientController();
    return $client->verifyClient($requestData);
});


Route::post('sso-verify-customer', function(Request $request) {
    $requestData = $request->all();
    $customer = new CustomerVerification();
    return $customer->verifyCustomer($requestData);
});