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
    // create a new user
    Route::post('register', 'Auth\RegisterController@create');

    // log in as a user
    Route::post('login', 'Auth\LoginController@login');
    
    Route::group(['middleware' => 'jwt.auth'], function (){
        // get info about the current user
        Route::get('user', 'Auth\LoginController@user');

        // log out current user
        Route::post('logout', 'Auth\LoginController@logout');
    });

    Route::group(['middleware' => 'jwt.refresh'], function (){
        // refresh the user
      Route::get('refresh', 'Auth\LoginController@refresh');
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
