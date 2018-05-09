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

/*
| Auth routes
*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => 'jwt.auth'], function (){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });

    Route::group(['middleware' => 'jwt.refresh'], function (){
      Route::get('refresh', 'AuthController@refresh');
    });
});

/*
| Model routes
*/
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('locations', 'LocationsController@index');
    Route::post('locations', 'LocationsController@create');
    Route::get('locations/{id}', 'LocationsController@show');
    Route::delete('locations/{id}', 'LocationsController@delete');
});
