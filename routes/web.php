<?php

use Illuminate\Support\Facades\Route;
//use bSecure\LaravelSDK\bSecure;


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

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/demo/{name}', function($sName) {
//    $oGreetr = new bSecure();
//    return $oGreetr->home($sName);
//});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('cart','HomeController@cart');
Route::post('create-order','HomeController@createOrder');