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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::get('/products', 'API\ProductController@index');
Route::post('/upload-file', 'API\ProductController@uploadFile');
Route::get('/products/{product}', 'API\ProductController@show');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/users','API\UserController@index');
    Route::get('users/{user}','API\UserController@show');
    Route::patch('users/{user}','API\UserController@update');
    Route::get('users/{user}/orders','API\UserController@showOrders');
    Route::patch('products/{product}/units/add','API\ProductController@updateUnits');
    Route::patch('orders/{order}/deliver','API\OrderController@deliverOrder');
    Route::resource('/orders', 'API\OrderController');
    Route::resource('/products', 'API\ProductController')->except(['index','show']);
});
