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

//Store & Auth routes
Route::get('/','StoreController@home');
Route::get('/admin','StoreController@dashboard')->middleware('auth');
Route::get('/admin/refill','StoreController@showRefill')->middleware('auth');
Route::get('/product/notAvailable','StoreController@admindisabled')->middleware('auth');
Route::get('/search', 'StoreController@search')->name('search');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Products
Route::get('/product', 'ProductsController@index');
Route::get('/product/create', 'ProductsController@create'); //mostra il form per la creazione
Route::post('/product/create', 'ProductsController@store'); //gestisce i dati inviati col form
Route::get('/product/{product}', 'ProductsController@show')->name('ShowProduct');
Route::get('/product/{product}/edit', 'ProductsController@edit')->name('EditProduct');
Route::patch('/product/{product}', 'ProductsController@update');
Route::delete('/product/{product}', 'ProductsController@destroy');

//Categories
Route::get('/category/{category}', 'CategoryController@show')->name('CategoryPage');
Route::get('/category/{category}/notAvailable', 'CategoryController@showNotAvailable')->name('CategoryNotAvailablePage');

//Orders
Route::get('/orders', 'OrdersController@index')->middleware('auth')->name('OrdersPage');
Route::post('/orders', 'OrdersController@store')->middleware('auth');

//Cart
Route::get('/cart', 'CartController@index')->middleware('auth')->name('CartPage');
Route::post('/cart', 'CartController@store')->middleware('auth');
Route::delete('/cart/{cart}', 'CartController@destroy')->middleware('auth');
Route::patch('/cart/{cart}', 'CartController@update')->middleware('auth');

//Reviews
Route::resource('/review', 'ReviewController')->middleware('auth');
