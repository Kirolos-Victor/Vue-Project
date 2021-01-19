<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
//home
Auth::routes();
Route::middleware('can:isAdmin')->group(function(){
    Route::get('/admin', 'HomeController@admin');
});
Route::get('/home', 'HomeController@index');
Route::get('/products','HomeController@allProducts');
Route::get('/products/{product}','HomeController@product');
Route::get('/totalQty','CartController@totalQty');
Route::get('/cart','CartController@cart');
Route::get('/cart/{product}','CartController@addToCart');
Route::put('/cart/{product}','CartController@updateQuantity');
Route::delete('/cart/{product}','CartController@destroy');
Route::get('/payment','CartController@payment')->middleware('auth');
Route::post('/charge','CartController@charge');
Route::get('/order','CartController@myOrders');
Route::get('/posts', 'HomeController@post');
Route::post('/user_photo', 'HomeController@user_photo');
Route::get('/chat', 'ChatController@index');
Route::post('/chat/send', 'ChatController@send');
Route::post('/chat/session', 'ChatController@chatSession');
Route::post('/chat/history', 'ChatController@getOldMessage');
Route::get('todo',function (){
    return view('front.todo');
})->name('todo');
Route::middleware(['auth'])->group(function () {
    Route::get('notifications','NotificationsController@index');
    Route::put('notifications','NotificationsController@unReadNotify');
    Route::post('notifications','NotificationsController@readNotify');
    //استبيان
    Route::resource('questionnaire','QuestionnaireController');
    Route::get('questionnaire/{questionnaire}/questions','QuestionsController@index');
    Route::post('questionnaire/{questionnaire}/questions','QuestionsController@store');
    Route::get('questionnaire/edit/{question}','QuestionsController@edit');
    Route::delete('questionnaire/{question}/questions','QuestionsController@destroy');

    Route::get('survey/{questionnaire}-{slug}','SurveyController@show');
    Route::post('survey/{questionnaire}-{slug}','SurveyController@store');
    Route::get('survey/{questionnaire}/answers','SurveyController@answer');


});

//testing
//Route::get('/check',function (){
//   return session('chat');
//});

// must end with this path to use vue router with out errors
Route::get('{path}', 'HomeController@admin')->where('path','([A-z]+)?');


//preg_match + WE NEED TO LEARN JOIN IN  MYSQL
//google logging
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

//Route::pattern('path','([A-z\d-\/_.]+)?');
