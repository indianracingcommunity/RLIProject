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

/* Exposing Image Manipulation API for Public
Route::get('/public/image/race', 'ImageController@pubRace');
Route::get('/public/image/quali', 'ImageController@pubQuali');
*/

Route::get('/fetch/drivers', 'StandingsController@fetchDrivers');
Route::get('/fetch/circuit', 'StandingsController@fetchCircuit');
Route::get('/store-results', 'StandingsController@fetchCircuit');

Route::get('/steam/check', 'SteamController@check');

Route::get('/{tier}/{season}/standings', 'StandingsController@fetchRaces')
->where(['tier' => '[0-9]+', 'season' => '[0-9]+']);
Route::get('/{tier}/{season}/standings/{round}', 'StandingsController@fetchStandings')
->where(['tier' => '[0-9]+', 'season' => '[0-9]+', 'season' => '[0-9]+']);

Route::post('/results/race', 'ResultsController@saveRaceResults');
//Route::post('/results/quali', 'ResultsController@saveQualiResults');

Auth::routes();

// All Admin panel Routes

Route::group(['middleware' => 'IsAdmin'], function () {
Route::get('/home/admin', 'DriverController@index')->name('adminhome');
Route::get('/home/admin/users','DriverController@viewusers'); 
Route::get('/home/admin/user/{user}','DriverController@viewdetails'); 
Route::get('/home/admin/user/edit/{user}','DriverController@viewedit');
Route::post('/home/admin/user/edit/save/{user}','DriverController@saveedit');

Route::get('/home/admin/report','DriverController@viewreports');
Route::get('home/admin/report/{report}/details','DriverController@reportdetails');
Route::post('/home/admin/verdict/{report}/save','DriverController@saveverdict');

Route::get('/home/admin/user-allot/{id}','DriverController@allotuser');
Route::POST('/home/admin/user-allot/submit','DriverController@saveallotment');

Route::get('/image/quali', 'ImageController@qualiIndex');
//Route::post('/image/quali', 'ImageController@ocrQuali');

Route::get('/image/race', 'ImageController@raceIndex');
Route::post('/image/race', 'ImageController@ocrRace');
});
// MiddleWare For Userlogin
Route::group(['middleware' => 'auth'], function () {
Route::get('/home', 'UserPanel@index')->name('home');
Route::get('/user/profile/{user}', 'UserPanel@viewprofile')->name('home');
Route::post('/user/profile/setsteam/{user}','UserPanel@SetSteam');
//Report Routes
Route::get('/home/report/create','ReportsController@view');
Route::post('/home/report/submit','ReportsController@create');
Route::get('/home/report/category','ReportsController@category');
Route::get('/home/view/report/{report}/details','ReportsController@details');


});





Route::get('/teams/{key}','DriverController@viewferrari');

Route::get('/api/{driver}','DriverController@api');
Route::get('/discordapi/{driver}','DriverController@apidiscord');


// Routes Handling the Discord Login
Route::get('login/discord', 'Auth\LoginController@redirectToProvider')->name('auth');
Route::get('login/discord/callback', 'Auth\LoginController@handleProviderCallback')->name('callback');