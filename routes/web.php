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

Route::get('raceprep', function()
{
    //Name
    $img = Image::make('img/RRSuzuka.png')
                ->resize(1920, 1080)
                ->crop(1000, 90, 90, 215)
                ->save('img/race_results/Name.png');

    //Standings
    $img = Image::make('img/RRSuzuka.png')
                ->resize(1920, 1080)
                ->crop(1290, 570, 530, 360)
                ->save('img/race_results/Standings.png');

    $row_width = 40.2142;
    //Position
    for($i = 0; $i < 14; $i++) {
        $pos = Image::make('img/race_results/Standings.png');
        $pos->crop(50, 33, 3, 7 + (int)($i * $row_width));
        $pos->save('img/race_results/pos_' . ($i + 1) . '.png');
    }

    //Driver
    for($i = 0; $i < 14; $i++) {
        $driver = Image::make('img/race_results/Standings.png');
        $driver->crop(150, 33, 150, 7 + (int)($i * $row_width));
        $driver->save('img/race_results/driver_' . ($i + 1) . '.png');
    }

    //Team
    for($i = 0; $i < 14; $i++) {
        $team = Image::make('img/race_results/Standings.png');
        $team->crop(240, 33, 555, 7 + (int)($i * $row_width));
        $team->save('img/race_results/team_' . ($i + 1) . '.png');
    }

    //Grid
    for($i = 0; $i < 14; $i++) {
        $team = Image::make('img/race_results/Standings.png');
        $team->crop(50, 33, 821, 7 + (int)($i * $row_width));
        $team->save('img/race_results/grid_' . ($i + 1) . '.png');
    }

    //Stops
    for($i = 0; $i < 14; $i++) {
        $team = Image::make('img/race_results/Standings.png');
        $team->crop(50, 33, 910, 7 + (int)($i * $row_width));
        $team->save('img/race_results/stops_' . ($i + 1) . '.png');
    }

    //Fastest Lap
    for($i = 0; $i < 14; $i++) {
        $team = Image::make('img/race_results/Standings.png');
        $team->crop(150, 33, 1000, 7 + (int)($i * $row_width));
        $team->save('img/race_results/best' . ($i + 1) . '.png');
    }

    //Finishing Time
    for($i = 0; $i < 14; $i++) {
        $team = Image::make('img/race_results/Standings.png');
        $team->crop(240, 33, 1175, 7 + (int)($i * $row_width));
        $team->save('img/race_results/time_' . ($i + 1) . '.png');
    }

    /*  Race Name
    ->crop(1000, 90, 90, 215);
    $img->save('img/RRSuzukaName.png');
    */

    /*  Race Standings
    ->crop(1290, 570, 530, 360);
    $img->save('img/RRSuzukaResults.png');
    */


    return $img->response('png');
});

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