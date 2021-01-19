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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/getProducts', "ProductController@all");
Route::get('/getCategoris',"CategoryController@all");
Route::post('/addProduct',"ProductController@create");
Route::get('/filterByCategory/{id}',"ProductController@filterByCategory");
