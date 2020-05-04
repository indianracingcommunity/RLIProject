<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Symfony\Component\Console\Output\ConsoleOutput;
use Intervention\Image\Image as Img;

use App\Driver;
use App\Circuit;
use App\Constructor;

class ImageController extends Controller
{
    private $output;
    private $olid;
    public function __construct() {
        $this->output = new ConsoleOutput();

        $this->olid = new TesseractOCR();
        $this->olid->lang('eng')
                   ->psm(7);
    }

    protected function thicken(Img $img) {
        $black_arr = array();
        for($i = 0; $i < $img->width(); $i++) {
            for($j = 0; $j < $img->height(); $j++) {
                $colorA = $img->pickColor($i, $j, 'hex');
                if($colorA == '#000000') {
                    array_push($black_arr, array($i, $j));
                }
            }
        }

        $s = count($black_arr);
        for($k = 0; $k < $s; $k++) {
            $img->pixel('#000000', $black_arr[$k][0]-1, $black_arr[$k][1]-1);
            $img->pixel('#000000', $black_arr[$k][0], $black_arr[$k][1]-1);
            $img->pixel('#000000', $black_arr[$k][0]+1, $black_arr[$k][1]-1);
            $img->pixel('#000000', $black_arr[$k][0]-1, $black_arr[$k][1]);
            $img->pixel('#000000', $black_arr[$k][0]+1, $black_arr[$k][1]);
            $img->pixel('#000000', $black_arr[$k][0]-1, $black_arr[$k][1]+1);
            $img->pixel('#000000', $black_arr[$k][0], $black_arr[$k][1]+1);
            $img->pixel('#000000', $black_arr[$k][0]+1, $black_arr[$k][1]+1);
        }
        return 0;
    }
    protected function two_tone(Img $img) {
        $thres = 86;
        $white = 0;
        $black = 0;
        for($i = 0; $i < $img->width(); $i++) {
            for($j = 0; $j < $img->height(); $j++) {
                $colorA = $img->pickColor($i, $j);
                if($colorA[0] > $thres && $colorA[1] > $thres && $colorA[2] > $thres) {
                //if($color != 4287993237) {
                    $img->pixel('#000000', $i, $j);
                    $black++;
                }
                else {
                    $img->pixel('#ffffff', $i, $j);
                    $white++;
                }
            }
        }
    
        if($black > $white)
            $img->invert();

        //$this->thicken($img);
        return $img;
    }

    protected function race_prep(String $src) {    
        //Name
        $img = Image::make($src)
                    ->resize(1920, 1080)
                    ->crop(1000, 90, 90, 215);

        $this->two_tone($img);
        $img->save('img/race_results/Name.png');
    
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
        //    $this->two_tone($img);
        //  $img->save('img/race_results/SDI.png');
    
    
        $row_width = 40.2142;
        //Position
        for($i = 0; $i < 14; $i++) {
            $pos = Image::make('img/race_results/Standings.png');
            $pos->crop(50, 33, 10, 7 + (int)($i * $row_width));
            $this->two_tone($pos);
            $pos->save('img/race_results/pos_' . ($i + 1) . '.png');
            $this->output->writeln('<info>img/race_results/pos_' . ($i + 1) . '.png<info>');
        }
    
        //Driver
        for($i = 0; $i < 14; $i++) {
            $driver = Image::make('img/race_results/Standings.png');
            $driver->crop(150, 33, 150, 7 + (int)($i * $row_width));
            $this->two_tone($driver);
            $driver->save('img/race_results/driver_' . ($i + 1) . '.png');
            $this->output->writeln('<info>img/race_results/driver_' . ($i + 1) . '.png<info>');
        }
    
        //Team
        for($i = 0; $i < 14; $i++) {
            $team = Image::make('img/race_results/Standings.png');
            $team->crop(240, 33, 555, 7 + (int)($i * $row_width));
            $this->two_tone($team);
            $team->save('img/race_results/team_' . ($i + 1) . '.png');
            $this->output->writeln('<info>img/race_results/team_' . ($i + 1) . '.png<info>');
        }
    
        //Grid
        for($i = 0; $i < 14; $i++) {
            $grid = Image::make('img/race_results/Standings.png');
            $grid->crop(50, 33, 821, 7 + (int)($i * $row_width));
            $this->two_tone($grid);
            $grid->save('img/race_results/grid_' . ($i + 1) . '.png');
            $this->output->writeln('<info>img/race_results/grid_' . ($i + 1) . '.png<info>');
        }
    
        //Stops
        for($i = 0; $i < 14; $i++) {
            $stops = Image::make('img/race_results/Standings.png');
            $stops->crop(50, 33, 910, 7 + (int)($i * $row_width));
            $this->two_tone($stops);
            $stops->save('img/race_results/stops_' . ($i + 1) . '.png');
            $this->output->writeln('<info>img/race_results/stops_' . ($i + 1) . '.png<info>');
        }
    
        //Fastest Lap
        for($i = 0; $i < 14; $i++) {
            $best = Image::make('img/race_results/Standings.png');
            $best->crop(150, 33, 1000, 7 + (int)($i * $row_width));
            $this->two_tone($best);
            $best->save('img/race_results/best_' . ($i + 1) . '.png');
            $this->output->writeln('<info>img/race_results/best_' . ($i + 1) . '.png<info>');
        }
    
        //Finishing Time
        for($i = 0; $i < 14; $i++) {
            $time = Image::make('img/race_results/Standings.png');
            $time->crop(140, 33, 1140, 7 + (int)($i * $row_width));
            $this->two_tone($time);
            $time->save('img/race_results/time_' . ($i + 1) . '.png');
            $this->output->writeln('<info>img/race_results/time_' . ($i + 1) . '.png<info>');
        }
    
        return 0;
    }

    public function closest_match($input, $dic) {

        // no shortest distance found, yet
        $shortest = -1;
        $index = 0;

        // loop through words to find the closest
        foreach ($dic as $i => $word) {

            // calculate the distance between the input word,
            // and the current word
            $lev = levenshtein($input, $word);

            // check for an exact match
            if ($lev == 0) {

                // closest word is this one (exact match)
                //$closest = $word;
                $index = $i;
                $shortest = 0;

                // break out of the loop; we've found an exact match
                break;
            }

            // if this distance is less than the next found shortest
            // distance, OR if a next shortest word has not yet been found
            if ($lev <= $shortest || $shortest < 0) {
                // set the closest match, and shortest distance
                //$closest  = $word;
                $index = $i;
                $shortest = $lev;
            }
        }
        return $index;
    }
    
    public function raceprep() {
        //$this->race_prep('img/RRSuzuka.png');
    
        /*$this->olid->image('img/race_results/Name.png');
        $this->olid->psm(1);
        $tr = $this->olid->run();
        $this->output->writeln("<info>" . $tr . "</info>");

        $this->olid->psm(7);*/

        $drivers = Driver::getNames();
        $constructors = Constructor::getTeams();

        //$kar = levenshtein($input, $word);
        $results = array();
        for($i = 0; $i < 14; $i++) {
            $row = array();
            $this->output->writeln("<info>Driver " . ($i + 1) . " : " . "</info>");
    
            //Position
            $this->olid->image('img/race_results/pos_' . ($i + 1) . '.png');
            $tr = $this->olid->run();
            $row["pos"] = (int)$tr;
            $this->output->writeln("<info>" . $tr . "</info>");
    
            //Driver
            $this->olid->image('img/race_results/driver_' . ($i + 1) . '.png');
            $tr = $this->olid->run();
            $row["driver"] = $tr;
            $this->output->writeln("<info>" . $tr . "</info>");

            $name = array_column($drivers, 'name');
            $index = $this->closest_match($tr, $name);
            $row["driver_id"] = $drivers[$index]['id'];
            $row["matched_driver"] = $drivers[$index]['name'];
    
            //Team
            $this->olid->image('img/race_results/team_' . ($i + 1) . '.png');
            $tr = $this->olid->run();
            $row["team"] = $tr;
            $this->output->writeln("<info>" . $tr . "</info>");

            $name = array_column($constructors, 'name');
            $index = $this->closest_match($tr, $name);
            $row["constructor_id"] = $constructors[$index]['id'];
            $row["matched_team"] = $constructors[$index]['name'];

            //Grid
            $this->olid->image('img/race_results/grid_' . ($i + 1) . '.png');
            $tr = $this->olid->run();
            $row["grid"] = (int)$tr;
            $this->output->writeln("<info>" . $tr . "</info>");

            //Stops
            $this->olid->image('img/race_results/stops_' . ($i + 1) . '.png');
            $tr = $this->olid->run();
            $row["stops"] = (int)$tr;
            $this->output->writeln("<info>" . $tr . "</info>");

            //Best
            $this->olid->image('img/race_results/best_' . ($i + 1) . '.png');
            $tr = $this->olid->run();
            $row["best"] = $tr;
            $this->output->writeln("<info>" . $tr . "</info>");

            //Time
            $this->olid->image('img/race_results/time_' . ($i + 1) . '.png');
            $tr = $this->olid->run();
            $row["time"] = $tr;
            $this->output->writeln("<info>" . $tr . "</info>");

            array_push($results, $row);
        }
    
        $this->olid->image('img/race_results/Standings.png');
        return response()->json($results); //$this->olid->response('png');
    }

    public function race_name() {
        $this->race_prep('img/RRSuzuka.png');
    
        $this->olid->image('img/race_results/Name.png');
        $this->olid->psm(1);
        $tr = $this->olid->run();
        $this->olid->psm(7);

        //Replace Series of '\n' with a single '$'
        $tri = preg_replace('/\n+/', '$', $tr);
        $track = explode("$", $tri);

        if(count($track) < 2)
            return response()->json($track);

        $circuits = Circuit::getOfficial();

        $official = array_column($circuits, 'official');
        $index = $this->closest_match($track[1], $official);
        return response()->json([
            'id' => $circuits[$index]['id'],
            'official' => $track[1],
            'display' => $track[0]]);
    }
}
