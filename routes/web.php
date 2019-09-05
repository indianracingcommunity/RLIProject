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




Route::get('/', 'WebsiteController@loadhomepage');
Route::get('joinus', 'WebsiteController@loadjoinus');
Route::get('teamsanddrivers', 'WebsiteController@loadteamsanddrivers');
Route::get('standings', 'WebsiteController@loadstandings');
Route::get('aboutus', 'WebsiteController@loadaboutus');
Route::get('login', 'WebsiteController@loadlogin');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/add-driver','DriverController@create');

Route::post('/store-data','DriverController@store');

Route::get('/drivers','DriverController@view'); 

Route::get('/drivers/{driver}','DriverController@viewdetails'); 
