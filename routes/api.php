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

Route::get('orders', 'OrderController@index');
Route::post('orders', 'OrderController@store');
Route::patch('orders/{order}', 'OrderController@update');

Route::get('pizzas', 'PizzaController@index');
Route::get('pizzas/{pizza}', 'PizzaController@show');
Route::post('pizzas', 'PizzaController@store');
