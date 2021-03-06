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

Auth::routes([
    'register' => false
]);

Route::get('/add-location', 'LocationController@index' )->name('add-location');
Route::post('/add-location', 'LocationController@store' );

Route::group(['prefix' => 'category'], function () {
    Route::get('/all', 'CategoryController@getCategories');
});

Route::group(['prefix' => 'locations'], function () {
    Route::get('/all', 'LocationController@getLocations');
    Route::get('/markers', 'LocationController@markers');
});

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard/', 'DashboardController@index');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'is.admin']],function () {
    Route::get('/', 'AdminController@index');
    Route::get('/locations', 'AdminController@locations');
    Route::get('/categories', 'AdminController@categories');
    Route::get('/services', 'AdminController@services');
});

