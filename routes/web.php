<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/add-location', 'LocationController@index' )->name('add-location');
Route::post('/add-location', 'LocationController@store' );

Route::group(['prefix' => 'category'], function () {
    Route::get('/all', 'CategoryController@getCategories');
});

Route::group(['prefix' => 'locations'], function () {
    Route::get('/all', 'LocationController@getLocations');
});
