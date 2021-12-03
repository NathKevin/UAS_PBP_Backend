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

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('delivery', 'Api\DeliveryController@index');
    Route::get('delivery/{id}', 'Api\DeliveryController@showAll');
    Route::get('delivery/update/{id}', 'Api\DeliveryController@showUpdate');
    Route::post('delivery', 'Api\DeliveryController@store');
    Route::put('delivery/{id}', 'Api\DeliveryController@update');
    Route::delete('delivery/{id}', 'Api\DeliveryController@destroy');
    //-------------------------------------------------------------------
    Route::get('pengantar', 'Api\PengantarController@index');
    Route::get('pengantar/{id}', 'Api\PengantarController@show');
    Route::post('pengantar', 'Api\PengantarController@store');
    Route::put('pengantar/{id}', 'Api\PengantarController@update');
    Route::delete('pengantar/{id}', 'Api\PengantarController@destroy');
    //-------------------------------------------------------------------
    Route::put('user/{id}', 'Api\AuthController@update');

});