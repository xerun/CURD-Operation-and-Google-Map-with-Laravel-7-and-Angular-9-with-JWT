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
Route::middleware('auth:api')->get('/labs', 'LabController@index', function (Request $request) {
    return $request->labs();
});
Route::middleware('auth:api')->get('/labs/{id}', 'LabController@show', function (Request $request) {
    return $request->labs();
});
Route::middleware('auth:api')->post('/labs', 'LabController@store', function (Request $request) {
    return $request->labs();
});
Route::middleware('auth:api')->put('/labs/{id}', 'LabController@update', function (Request $request) {
    return $request->labs();
});
Route::middleware('auth:api')->delete('/labs/{id}', 'LabController@delete', function (Request $request) {
    return $request->labs();
});

Route::middleware('auth:api')->get('/locations', 'LocationController@index', function (Request $request) {
    return $request->locations();
});
Route::middleware('auth:api')->get('/locations/{id}', 'LocationController@show', function (Request $request) {
    return $request->locations();
});
Route::middleware('auth:api')->post('/locations', 'LocationController@store', function (Request $request) {
    return $request->locations();
});
Route::middleware('auth:api')->put('/locations/{id}', 'LocationController@update', function (Request $request) {
    return $request->locations();
});
Route::middleware('auth:api')->delete('/locations/{id}', 'LocationController@delete', function (Request $request) {
    return $request->locations();
});

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
