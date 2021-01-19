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
Route::middleware(['auth:api','can:isAdmin'])->namespace('API')->group(function (){
    Route::apiResource('users','UserController');
    Route::get('search','UserController@search');
    Route::apiResource('governorates','GovernorateController');
    Route::apiResource('cities','CityController');
    Route::apiResource('product','ProductController');
    Route::apiResource('categories','CategoryController');
    Route::get('all-categories','CategoryController@categories');
    Route::apiResource('post','PostController');
    Route::post('comment','PostController@storeComment');
    Route::post('reply','PostController@storeReply');
    Route::get('reply','PostController@allReplies');
    Route::post('like','PostController@like');
    Route::post('logout','AuthController@logout');
});
//i must use php artisan passport:client --personal or php artisan passport:install to generate token every time i migrate
    Route::apiResource('orders','API\OrdersController');
    Route::post('login','API\AuthController@login');
    Route::post('register','API\AuthController@register');
    Route::get('governor','API\GovernorateController@index2');
    Route::get('city','API\CityController@index2');
    Route::put('profile','API\UserController@updateProfile');
    Route::get('profile','API\UserController@profile');
