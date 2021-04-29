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

// Public Routes
Route::get('/', 'WebsiteController@loadhomepage');
Route::get('joinus', 'WebsiteController@loadjoinus');
Route::get('teamsanddrivers', 'WebsiteController@loadteamsanddrivers');
//Route::get('standings', 'WebsiteController@loadstandings');
Route::get('aboutus', 'WebsiteController@loadaboutus');
Route::get('ourteam', 'WebsiteController@loadourteam');
Route::get('faq', 'WebsiteController@loadfaq');
Route::get('f1leaguerules', 'WebsiteController@f1leaguerules');
Route::get('f1XBOXleaguerules', 'WebsiteController@f1XBOXleaguerules');
Route::get('accleaguerules', 'WebsiteController@accleaguerules');
Route::get('login', 'WebsiteController@loadlogin');

/* Exposing Image Manipulation API for Public
Route::get('/public/image/race', 'ImageController@pubRace');
Route::get('/public/image/quali', 'ImageController@pubQuali');
*/

//Farewell Routes
//To be moved to api.php
Route::put('/impel', 'WebsiteController@impelS');
Route::delete('/impel', 'WebsiteController@impelA');

Route::get('/recotap', 'WebsiteController@recotapB');
Route::post('/recotap', 'WebsiteController@recotapG');
//

//League Result Data
Route::get('/{code}/{tier}/{season}/standings', 'StandingsController@fetchStandings')                         //Standings
->where(['tier' => '^[-+]?\d*\.?\d*$', 'season' => '^[-+]?\d*\.?\d*$']);
Route::get('/{code}/{tier}/{season}/races', 'StandingsController@fetchRaces')                                 //All Races
->where(['tier' => '^[-+]?\d*\.?\d*$', 'season' => '^[-+]?\d*\.?\d*$']);
Route::get('/{code}/{tier}/{season}/race/{round}', 'ResultsController@fetchRaceResults')                      //Race Results
->where(['tier' => '^[-+]?\d*\.?\d*$', 'season' => '^[-+]?\d*\.?\d*$', 'round' => '^[-+]?\d*\.?\d*$']);

//User Authenticated Routes
Auth::routes();
Route::group(['middleware' => 'auth'], function () {

     //User Profile Routes
     Route::get('/user/profile/', 'UserPanel@viewprofile')->name('home');
     Route::post('/user/profile/save/{user}','HomeController@savedetails');
     Route::group(['middleware' => 'profile'], function () {
          Route::post('/user/profile/setsteam/{user}','UserPanel@SetSteam');
          SteamLogin::routes(['controller' => SteamLoginController::class]);

          //Driver Report Routes
          Route::get('/home/report/create','ReportsController@view');
          Route::post('/home/report/submit','ReportsController@create');
          Route::get('/home/report/category','ReportsController@category');
          Route::get('/home/view/report/{report}/details','ReportsController@details');

          //Signup Routes
          Route::get('/signup','SignupsController@view')->middleware('signup');
          Route::post('/signup/store','SignupsController@store');
          Route::post('/signup/update/{signup}','SignupsController@update');

          //Profile Routes
          Route::get('/user/profile/view/{user}','HomeController@viewprofile');     
     });
});

//REST APIs
//To be moved to api.php
Route::group(['middleware' => 'auth:api'], function () {
     //Fetch Driver & Constructor Details - Telemetry API
     Route::get('/drivers/data','DriverController@driverdata');

     //Fetch User Info - Discord Bot
     Route::get('/api/users/details/{query}/{id}','BotController@fetchdetails');

     //Upload Race Results
     Route::post('/results/race', 'ResultsController@saveRaceResults');
});

// Routes Handling the Discord Login
Route::get('login/discord', 'Auth\LoginController@redirectToProvider')->name('auth');
Route::get('login/discord/callback', 'Auth\LoginController@handleProviderCallback')->name('callback');

//Admin Panel
Route::group(['middleware' => 'allowed:admin,coordinator'], function () {
     Route::get('/home/admin', 'DriverController@index')->name('adminhome');
     Route::get('/home/admin/users','DriverController@viewusers'); 
     Route::get('/home/admin/user/{user}','DriverController@viewdetails'); 
     Route::get('/home/admin/user/edit/{user}','DriverController@viewedit');
     Route::post('/home/admin/user/edit/save/{user}','DriverController@saveedit');
     Route::get('/result/upload','SignupsController@temp');
});

//League Sign Up
Route::group(['middleware' => 'allowed:admin,signup'], function () {
     Route::get('/home/admin/view-signups','SignupsController@viewsignups');
});

//Stewards Reports
Route::group(['middleware' => 'allowed:admin,steward'], function () {
     Route::get('/home/admin/report','DriverController@viewreports');
     Route::get('home/admin/report/{report}/details','DriverController@reportdetails');
     Route::post('/home/admin/verdict/{report}/save','DriverController@saveverdict');
     Route::put('/position', 'ResultsController@updatePosition');
});

//Driver Allotment
Route::group(['middleware' => 'allowed:admin,coordinator'], function () {
     Route::get('/home/admin/user-allot/{id}','DriverController@allotuser');
     Route::post('/home/admin/user-allot/submit','DriverController@saveallotment');
});

//League Results Parsing
Route::group(['middleware' => 'allowed:admin,coordinator', 'prefix'=>'parse'], function () {
     //F1 Results
     Route::get('/f1/quali', 'ImageController@qualiIndex');
     Route::get('/f1/race', 'ImageController@raceIndex');
     Route::post('/f1/race', 'ImageController@ocrRace');
     
     //ACC Results
     Route::get('/acc/upload', 'AccController@raceUpload');
     Route::post('/acc/upload', 'AccController@parseJson');
     
     //AC Results
     Route::get('/ac/upload', 'AcController@raceUpload');
     Route::post('/ac/upload', 'AcController@parseCsv');
});