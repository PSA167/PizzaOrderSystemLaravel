<?php

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

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::group(['prefix' => 'category', 'namespace' => 'API', 'middleware' => 'auth:sanctum'], function () {
    Route::get('list', 'ApiController@categoryList'); // List
    Route::post('create', 'ApiController@categoryCreate'); // Create
    Route::post('details', 'ApiController@categoryDetails'); // Details
    Route::get('delete/{id}', 'ApiController@categoryDelete'); // Delete
    Route::post('update', 'ApiController@categoryUpdate'); // Update
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('logout', 'AuthController@logout');
});
