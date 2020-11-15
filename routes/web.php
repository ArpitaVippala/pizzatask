<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great! 
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', 'user\UserController@login')->name('Login');
Route::post('loginUser', 'user\UserController@loginUser');
Route::get('products', 'admin\AdminController@allproducts')->name('Products');
Route::post('addToCart', 'admin\AdminController@addToCart');
Route::get('/gotoCart', 'admin\AdminController@gotoCart');
Route::post('createOrder', 'admin\AdminController@createOrder');
Route::get('/placeOrder', 'admin\AdminController@placeOrder')->name('PlaceOrder');
Route::get('/orders', 'admin\AdminController@orders');
Route::post('plusToCart', 'admin\AdminController@plusToCart');
Route::post('minusToCart', 'admin\AdminController@minusToCart');
Route::post('getOrderProducts', 'admin\AdminController@getOrderProducts');
Route::post('changeCurrency', 'admin\AdminController@changeCurrency');
Route::get('logout', 'admin\AdminController@logout');