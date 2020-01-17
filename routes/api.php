<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['api']], function () {
    Route::post('auth/login', 'ApiController@login');
    Route::post('auth/register', 'ApiController@register');

    Route::group(['middleware' => 'jwt.check'], function () {
        Route::get('user', 'ApiController@getAuthUser');
        Route::post('upload', 'ApiController@sendToPublicDrirectory');
        Route::post('delete', 'ApiController@deleteLW');
        Route::post('list', 'ApiController@listUserLW');
        Route::post('unlist', 'ApiController@unlistUserLW');
        Route::post('report', 'ApiController@reportLW');
    });
});