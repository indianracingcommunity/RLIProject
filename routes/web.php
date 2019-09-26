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

Route::get('/category','DriverController@category');


Route::get('/active-drivers','DriverController@active');

Route::get('/edit/{driver}','DriverController@edit');

Route::post('/update-data/{driver}','DriverController@update');

Route::get('/retired-drivers','DriverController@retired');

Route::get('/delete/{driver}','DriverController@delete');

Route::get('/driver-retire/{driver}','DriverController@retire');
Route::get('/driver-active/{driver}','DriverController@actived');

Route::get('/teams/{key}','DriverController@viewferrari');

Route::get('/api/{driver}','DriverController@api');

Route::get('/api/{driver}','DriverController@api');

Route::get('/report','DriverController@report');

