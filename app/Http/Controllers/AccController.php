<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Image as Img;

use App\Http\Requests\RaceResults;

use App\User;
use App\Race;
use App\Result;
use App\Driver;
use App\Season;
use App\Series;
use App\Circuit;
use App\Constructor;

class AccController extends Controller
{
    private $output;
    public function __construct() {
        $this->output = new ConsoleOutput();
    }

    public function raceUpload() {
        return view('accupload');
    }
    public function qualiIndex() {
        return view('qualiimage');
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

        $res = array($index, $shortest);
        return $res;
    }

    protected function crude_flatten($array) {
        $res = array();
        for($i = 0; $i < count($array); $i++) {
            $ires = array();
            $ires['id'] = $array[$i]['id'];
            $ires['name'] = $array[$i]['name'];

            foreach($array[$i]['alias'] as $j => $alias) {
                $ires['alias'] = $alias;
                array_push($res, $ires);
            }
        }
        return $res;
    }

    public function race_name(String $src, Bool $pub=false) {
        $tess = new TesseractOCR();
        $tess->lang('eng')->psm(1);

        $imag = $this->getImage($src, "name");
        $tess->image($imag->dirname . '/' . $imag->basename);
        $tr = $tess->run();
        unlink($imag->dirname . '/' . $imag->basename);

        //Replace Series of '\n' with a single '$'
        $tri = preg_replace('/\n+/', '$', $tr);
        $track = explode("$", $tri);

        if(count($track) < 2)
            return response()->json($track);

        $circuits = Circuit::getOfficial();

        if($pub) {
            return array(
                'official' => $track[1],
                'display' => $track[0]
            );
        }

        $official = array_column($circuits, 'official');
        $index = $this->closest_match($track[1], $official);
        return array(
            'circuit_id' => $circuits[$index[0]]['id'],
            'official' => $track[1],
            'display' => $track[0]
        );
    }

    public function file_get_contents_utf8($fn) {
        $content = file_get_contents($fn);
         return mb_convert_encoding($content, 'UTF-8',
             mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    }

    public function parseJson(Request $request) {
        ini_set('max_execution_time', 300);
        $file = request()->file('photo');

        //$fileEndEnd = mb_convert_encoding($file, 'UTF-8', "UTF-16LE");
        //$file8 = mb_convert_encoding($file16, 'utf-8');
        $content = file_get_contents($file);
        $json = json_decode($content, true);

        $round = 1;
        $season = Season::find(10);

        $sp_circuit = Circuit::getTrackByGame($json['trackName'], $season['series']);
        if($sp_circuit == null) return response()->json([]);

        $track = array(
            "season_id" => $season['id'],
            'circuit_id' => $sp_circuit['id'],
            'official' => $sp_circuit['official'],
            'display' => $sp_circuit['name'],
            "round" => $round
        );

        $carLaps = array();
        foreach($json['laps'] as $k => $laps)
        {
            if(!array_key_exists($laps['carId'], $carLaps))
                $carLaps[$laps['carId']] = $laps['laptime'];
            else
                $carLaps[$laps['carId']] += $laps['laptime'];
        }

        $results = array();
        $totalLaps = 0;
        if(count($json['sessionResult']['leaderBoardLines']) > 0)
            $totalLaps = $json['sessionResult']['leaderBoardLines'][0]['timing']['lapCount'];

        foreach($json['sessionResult']['leaderBoardLines'] as $k => $driver)
        {
            $dr = User::where('steam_id', substr($driver['currentDriver']['playerId'], 1))
                        ->first();

            if($dr == null)
            {
                $dr['name'] = $driver['currentDriver']['shortName'];
                $dr['id'] = -1;
            }

            $status = 0;
            $team_ind = array_search($driver['car']['carModel'], array_column($season['constructors'], "game"));

            $total_time = "";
            if($totalLaps == $driver['timing']['lapCount'])
                $total_time = $this->convertMillisToStandard($driver['timing']['totalTime']);
            else if($driver['timing']['totalTime'] == 2147483647)
                $total_time = "DNF";
            else
                $total_time = "+" . ($totalLaps - $driver['timing']['lapCount']) . " Laps";

            array_push($results, array(
                "position" => $k + 1,
                "driver" => $dr['name'],
                "driver_id" => $dr['id'],
                "matched_driver" => $dr['name'],
                "team" => $season['constructors'][$team_ind]['name'],
                "constructor_id" => $season['constructors'][$team_ind]['id'],
                "matched_team" => $season['constructors'][$team_ind]['name'],
                "grid" => 0,
                "stops" => 0,
                "status" => $status,
                "fastestlaptime" => $this->convertMillisToStandard($driver['timing']['bestLap']),
                "time" => $total_time
            ));
        }

        return response()->json(["t" => $track, "r" => $results]);
    }
}
