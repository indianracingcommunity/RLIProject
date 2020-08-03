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
        $seasons = Season::where('status', '<', 2)->get();
        return view('accupload')->with('seasons', $seasons);
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
        $race = request()->file('race');
        $quali = request()->file('quali');

        //$fileEndEnd = mb_convert_encoding($file, 'UTF-8', "UTF-16LE");
        //$file8 = mb_convert_encoding($file16, 'utf-8');
        $race_content = file_get_contents($race);
        $quali_content = file_get_contents($quali);

        $jq = json_decode($quali_content, true);
        $json = json_decode($race_content, true);

        $round = (int)request()->round;
        $season = Season::find(request()->season);

        $sp_circuit = Circuit::getTrackByGame($json['trackName'], $season['series']);
        if($sp_circuit == null) return response()->json([]);

        $track = array(
            'circuit_id' => $sp_circuit['id'],
            'official' => $sp_circuit['official'],
            'display' => $sp_circuit['name'],
            "season_id" => $season['id'],
            "round" => $round
        );

        $qualiPosition = array();
        foreach($jq['sessionResult']['leaderBoardLines'] as $k => $driver)
            $qualiPosition[$driver['car']['carId']] = $k + 1;

        $totalLaps = 0;
        $results = array();
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

            $grid = 0;
            $status = 0;
            $total_time = "";
            $bestLap = "";
            $team_ind = array_search($driver['car']['carModel'], array_column($season['constructors'], "game"));

            //Grid Position
            if(array_key_exists($driver['car']['carId'], $qualiPosition))
                $grid = $qualiPosition[$driver['car']['carId']];

            //Fastest Lap
            if($json['sessionResult']['bestlap'] == $driver['timing']['bestLap'] && $k < 10)
                $status = 1;

            //Total Time
            if($totalLaps == $driver['timing']['lapCount'])
                $total_time = $this->convertMillisToStandard($driver['timing']['totalTime']);
            else if($driver['timing']['lastLap'] == 2147483647)
            {
                $status = -2;
                $total_time = "DNF";
            }
            else
            {
                $total_time = "+" . ($totalLaps - $driver['timing']['lapCount']) . " Lap";
                if($totalLaps - $driver['timing']['lapCount'] > 1)
                    $total_time .= "s";
            }

            if($driver['timing']['bestLap'] == 2147483647)
                $bestLap = "-";
            else
                $bestLap = $this->convertMillisToStandard($driver['timing']['bestLap']);

            //Push to Results
            array_push($results, array(
                "position" => $k + 1,
                "driver" => $dr['name'],
                "driver_id" => $dr['id'],
                "matched_driver" => $dr['name'],
                "team" => $season['constructors'][$team_ind]['name'],
                "constructor_id" => $season['constructors'][$team_ind]['id'],
                "matched_team" => $season['constructors'][$team_ind]['name'],
                "grid" => $grid,
                "stops" => 0,
                "status" => $status,
                "fastestlaptime" => $bestLap,
                "time" => $total_time
            ));
        }

        return response()->json(["track" => $track, "results" => $results]);
    }
}
