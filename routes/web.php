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

use thiagoalessio\TesseractOCR\TesseractOCR;



Route::get('/', 'WebsiteController@loadhomepage');
Route::get('joinus', 'WebsiteController@loadjoinus');
Route::get('teamsanddrivers', 'WebsiteController@loadteamsanddrivers');
Route::get('standings', 'WebsiteController@loadstandings');
Route::get('aboutus', 'WebsiteController@loadaboutus');
Route::get('login', 'WebsiteController@loadlogin');

function two_tone(Intervention\Image\Image $img) {
    $thres = 86;
    for($i = 0; $i < $img->width(); $i++) {
        for($j = 0; $j < $img->height(); $j++) {
            $colorA = $img->pickColor($i, $j);
            if($colorA[0] > $thres && $colorA[1] > $thres && $colorA[2] > $thres) {
            //if($color != 4287993237) {
                $img->pixel('#000000', $i, $j);
            }
            else {
                $img->pixel('#ffffff', $i, $j);
            }
            //$output->writeln("<info>" . ($i + 1) . ", " . ($j+1) . ": " . $color . "</info>");
        }
    }

    return $img;
}

function race_prep(String $src) {
    $output = new Symfony\Component\Console\Output\ConsoleOutput();

    //Name
    $img = Image::make($src)
                ->resize(1920, 1080)
                ->crop(1000, 90, 90, 215)
                ->save('img/race_results/Name.png');

    //Standings
    $img = Image::make($src)
         ->resize(1920, 1080)
         ->crop(1290, 570, 530, 360)
         ->save('img/race_results/Standings.png');

    $img = Image::make('img/race_results/Standings.png')
         ->crop(150, 33, 150, 7)
         ->save('img/race_results/SD.png');

//$img->crop(1, 10, 5, 9);
//$img->save('img/race_results/SDI.png');
//    two_tone($img);
//  $img->save('img/race_results/SDI.png');


    $row_width = 40.2142;
    //Position
    for($i = 0; $i < 14; $i++) {
        $pos = Image::make('img/race_results/Standings.png');
        $pos->crop(50, 33, 3, 7 + (int)($i * $row_width));
        two_tone($pos);
        $pos->save('img/race_results/pos_' . ($i + 1) . '.png');
        $output->writeln('<info>img/race_results/pos_' . ($i + 1) . '.png<info>');
    }

    //Driver
    for($i = 0; $i < 14; $i++) {
        $driver = Image::make('img/race_results/Standings.png');
        $driver->crop(150, 33, 150, 7 + (int)($i * $row_width));
        two_tone($driver);
        $driver->save('img/race_results/driver_' . ($i + 1) . '.png');
        $output->writeln('<info>img/race_results/driver_' . ($i + 1) . '.png<info>');
    }

    //Team
    for($i = 0; $i < 14; $i++) {
        $team = Image::make('img/race_results/Standings.png');
        $team->crop(240, 33, 555, 7 + (int)($i * $row_width));
        two_tone($team);
        $team->save('img/race_results/team_' . ($i + 1) . '.png');
        $output->writeln('<info>img/race_results/team_' . ($i + 1) . '.png<info>');
    }

    //Grid
    for($i = 0; $i < 14; $i++) {
        $grid = Image::make('img/race_results/Standings.png');
        $grid->crop(50, 33, 821, 7 + (int)($i * $row_width));
        two_tone($grid);
        $grid->save('img/race_results/grid_' . ($i + 1) . '.png');
        $output->writeln('<info>img/race_results/grid_' . ($i + 1) . '.png<info>');
    }

    //Stops
    for($i = 0; $i < 14; $i++) {
        $stops = Image::make('img/race_results/Standings.png');
        $stops->crop(50, 33, 910, 7 + (int)($i * $row_width));
        two_tone($stops);
        $stops->save('img/race_results/stops_' . ($i + 1) . '.png');
        $output->writeln('<info>img/race_results/stops_' . ($i + 1) . '.png<info>');
    }

    //Fastest Lap
    for($i = 0; $i < 14; $i++) {
        $best = Image::make('img/race_results/Standings.png');
        $best->crop(150, 33, 1000, 7 + (int)($i * $row_width));
        two_tone($best);
        $best->save('img/race_results/best_' . ($i + 1) . '.png');
        $output->writeln('<info>img/race_results/best_' . ($i + 1) . '.png<info>');
    }

    //Finishing Time
    for($i = 0; $i < 14; $i++) {
        $time = Image::make('img/race_results/Standings.png');
        $time->crop(240, 33, 1175, 7 + (int)($i * $row_width));
        two_tone($time);
        $time->save('img/race_results/time_' . ($i + 1) . '.png');
        $output->writeln('<info>img/race_results/time_' . ($i + 1) . '.png<info>');
    }

    return 0;
}

Route::get('raceprep', function()
{
/*    //Name
    $img = Image::make('img/RRRussia.png')
                ->resize(1920, 1080)
                ->crop(1000, 90, 90, 215)
                ->save('img/race_results/Name.png');

    //Standings
    $img = Image::make('img/RRSuzuka.png')
                ->resize(1920, 1080)
                ->crop(1290, 570, 530, 360)
                ->save('img/race_results/Standings.png');

    $img = Image::make('img/race_results/Standings.png')
                ->crop(150, 33, 150, 7)
                ->save('img/race_results/SD.png');

    //$img->crop(1, 10, 5, 9);
    //$img->save('img/race_results/SDI.png');
//    two_tone($img);
  //  $img->save('img/race_results/SDI.png');


    $row_width = 40.2142;
    //Position
    for($i = 0; $i < 14; $i++) {
        $pos = Image::make('img/race_results/Standings.png');
        $pos->crop(50, 33, 3, 7 + (int)($i * $row_width));
        two_tone($pos);
        $pos->save('img/race_results/pos_' . ($i + 1) . '.png');
    }

    //Driver
    for($i = 0; $i < 14; $i++) {
        $driver = Image::make('img/race_results/Standings.png');
        $driver->crop(150, 33, 150, 7 + (int)($i * $row_width));
        two_tone($driver);
        $driver->save('img/race_results/driver_' . ($i + 1) . '.png');
    }

    //Team
    for($i = 0; $i < 14; $i++) {
        $team = Image::make('img/race_results/Standings.png');
        $team->crop(240, 33, 555, 7 + (int)($i * $row_width));
        two_tone($team);
        $team->save('img/race_results/team_' . ($i + 1) . '.png');
    }

    //Grid
    for($i = 0; $i < 14; $i++) {
        $grid = Image::make('img/race_results/Standings.png');
        $grid->crop(50, 33, 821, 7 + (int)($i * $row_width));
        two_tone($grid);
        $grid->save('img/race_results/grid_' . ($i + 1) . '.png');
    }

    //Stops
    for($i = 0; $i < 14; $i++) {
        $stops = Image::make('img/race_results/Standings.png');
        $stops->crop(50, 33, 910, 7 + (int)($i * $row_width));
        two_tone($stops);
        $stops->save('img/race_results/stops_' . ($i + 1) . '.png');
    }

    //Fastest Lap
    for($i = 0; $i < 14; $i++) {
        $best = Image::make('img/race_results/Standings.png');
        $best->crop(150, 33, 1000, 7 + (int)($i * $row_width));
        two_tone($best);
        $best->save('img/race_results/best_' . ($i + 1) . '.png');
    }

    //Finishing Time
    for($i = 0; $i < 14; $i++) {
        $time = Image::make('img/race_results/Standings.png');
        $time->crop(240, 33, 1175, 7 + (int)($i * $row_width));
        two_tone($time);
        $time->save('img/race_results/time_' . ($i + 1) . '.png');
    }

    /*  Race Name
    ->crop(1000, 90, 90, 215);
    $img->save('img/RRSuzukaName.png');
    */

    /*  Race Standings
    ->crop(1290, 570, 530, 360);
    $img->save('img/RRSuzukaResults.png');
    */

    //race_prep('img/RRRussia.png');

    //echo ("Henlo");
    $olid = new TesseractOCR();
    $olid->lang('eng');
    $olid->userWords('drivers.txt');
    $output = new Symfony\Component\Console\Output\ConsoleOutput();

    $olid->image('img/race_results/Name.png');
    $tr = $olid->run();

    $output->writeln("<info>" . $tr . "</info>");

    for($i = 3; $i < 14; $i++) {
        $output->writeln("<info>Driver " . ($i + 1) . " : " . "</info>");

        $olid->image('img/race_results/pos_' . ($i + 1) . '.png');
        $tr = $olid->run();

        $output->writeln("<info>" . $tr . "</info>");

        $olid->image('img/race_results/driver_' . ($i + 1) . '.png');
        $tr = $olid->run();

        $output->writeln("<info>" . $tr . "</info>");

        $olid->image('img/race_results/team_' . ($i + 1) . '.png');
        $tr = $olid->run();

        $output->writeln("<info>" . $tr . "</info>");

        $olid->image('img/race_results/grid_' . ($i + 1) . '.png');
        $tr = $olid->run();

        $output->writeln("<info>" . $tr . "</info>");

        $olid->image('img/race_results/stops_' . ($i + 1) . '.png');
        $tr = $olid->run();

        $output->writeln("<info>" . $tr . "</info>");

        $olid->image('img/race_results/best_' . ($i + 1) . '.png');
        $tr = $olid->run();

        $output->writeln("<info>" . $tr . "</info>");

        $olid->image('img/race_results/time_' . ($i + 1) . '.png');
        $tr = $olid->run();

        $output->writeln("<info>" . $tr . "</info>");
    }

    $olid->image('img/race_results/Standings.png');
    return $olid->response('png');
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