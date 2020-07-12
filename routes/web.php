<?php
use App\Http\Controllers\Auth\SteamLoginController;
use kanalumaddela\LaravelSteamLogin\Facades\SteamLogin;

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

Route::get('/test','ImageController@testing');
Route::post('/test/save','ImageController@testsave');

Route::get('/fetch/drivers', 'StandingsController@fetchDrivers');
Route::get('/fetch/circuit', 'StandingsController@fetchCircuit');
Route::get('/store-results', 'StandingsController@fetchCircuit');

Route::get('/steam/check', 'SteamController@check');
Route::get('/driver', 'DriverController@info');

Route::get('/{tier}/{season}/standings', 'StandingsController@fetchStandings')
->where(['tier' => '^[-+]?\d*\.?\d*$', 'season' => '^[-+]?\d*\.?\d*$']);
Route::get('/{tier}/{season}/races', 'StandingsController@fetchRaces')
->where(['tier' => '^[-+]?\d*\.?\d*$', 'season' => '^[-+]?\d*\.?\d*$']);
Route::get('/{tier}/{season}/race/{round}', 'ResultsController@fetchRaceResults')
->where(['tier' => '^[-+]?\d*\.?\d*$', 'season' => '^[-+]?\d*\.?\d*$', 'round' => '^[-+]?\d*\.?\d*$']);

Route::put('/position', 'ResultsController@updatePosition');
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
Route::post('/home/admin/user-allot/submit','DriverController@saveallotment');

Route::get('/image/quali', 'ImageController@qualiIndex');
//Route::post('/image/quali', 'ImageController@ocrQuali');

Route::get('/image/race', 'ImageController@raceIndex');
Route::post('/image/race', 'ImageController@ocrRace');
//Discord 
Route::get('/discord/fetchroles','DiscordController@getServerRoles');
Route::get('/discord/fetchroles/users','DiscordController@getMemberRoles');

});


// MiddleWare For Userlogin
Route::group(['middleware' => 'auth'], function () {
     Route::get('/user/profile/', 'UserPanel@viewprofile')->name('home');
     Route::post('/user/profile/setsteam/{user}','UserPanel@SetSteam');
     SteamLogin::routes(['controller' => SteamLoginController::class]);

     Route::get('/home', 'UserPanel@index')->name('home');
     
     //Report Routes
     Route::get('/home/report/create','ReportsController@view');
     Route::post('/home/report/submit','ReportsController@create');
     Route::get('/home/report/category','ReportsController@category');
     Route::get('/home/view/report/{report}/details','ReportsController@details');

     //Signup Routes
     Route::get('/signup','SignupsController@view');
     Route::post('/signup/store','SignupsController@store');
     Route::post('/signup/update/{signup}','SignupsController@update');
     Route::get('/upload','SignupsController@temp');

     //Profile Routes
     Route::get('/user/profile/view/{user}','HomeController@viewprofile');
     Route::post('/user/profile/save/{user}','HomeController@savedetails');
});

Route::get('/teams/{key}','DriverController@viewferrari');
Route::get('/api/{driver}','DriverController@api');
Route::get('/discordapi/{driver}','DriverController@apidiscord');

// Routes Handling the Discord Login
Route::get('login/discord', 'Auth\LoginController@redirectToProvider')->name('auth');
Route::get('login/discord/callback', 'Auth\LoginController@handleProviderCallback')->name('callback');
