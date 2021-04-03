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

class AcController extends Controller
{
    private $output;
    public function __construct() {
        $this->output = new ConsoleOutput();
    }

    public function raceUpload() {
        $series = Series::where('code', 'ac')->firstOrFail();
        $seasons = Season::where([
            ['status', '<', 2],
            ['series', $series['id']]
        ])->get();

        return view('acupload')->with('seasons', $seasons);
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

    public function parseCsv(Request $request) {
        $race = request()->file('race');
        $rcsvlines = file_get_contents($race);

        $rcsv = str_getcsv($rcsvlines, "\n");
        if(count($rcsv) == 0) return response()->json([]);

        $minid = 0;
        $mintime = PHP_INT_MAX;
        for($j = 0; $j < count($rcsv); $j++) {
            $l = str_replace("\"", "", $rcsv[$j]);
            $rcsv[$j] = explode(",", $l);

            $rcsv[$j][0] = (int)$rcsv[$j][0]; //Finishing Position, Name, Car
            $rcsv[$j][3] = (int)$rcsv[$j][3]; //Fastest Lap
            $rcsv[$j][4] = (int)$rcsv[$j][4]; //Total Time
            $rcsv[$j][5] = (int)$rcsv[$j][5]; //Grid, Track

            //check which driver has fastest lap
            if($rcsv[$j][5] < $mintime) {
                $minid = $j;
                $mintime = $rcsv[$j][5];
            }
        }

        $round = (int)request()->round;
        $season = Season::find(request()->season);
        $sp_circuit = Circuit::getTrackByGame($rcsv[0][6], $season['series']);
        if($sp_circuit == null) return response()->json([]);

        $track = array(
            'circuit_id' => $sp_circuit['id'],
            'official' => $sp_circuit['official'],
            'display' => $sp_circuit['name'],
            "season_id" => $season['id'],
            "round" => $round
        );

        $results = array();
        //Check for Fastest Time, get ID

        foreach($rcsv as $k => $driver)
        {
            //Search for Closest Matching Driver
            $drList = Driver::getNames();
            $drName = array_column($drList, 'name');

            $index = $this->closest_match($driver[1], $drName);
            $flat_drivers = $this->crude_flatten((array)$drList);

            $matched_driverid = $drList[$index[0]]['id'];
            $matched_drivername = $drList[$index[0]]['name'];

            if($index[1] != 0) {
                $fname = array_column($flat_drivers, 'alias');
                $findex = $this->closest_match($driver[1], $fname);

                if($findex[1] < $index[1]) {
                    $matched_driverid = $flat_drivers[$findex[0]]['id'];
                    $matched_drivername = $flat_drivers[$findex[0]]['alias'];
                }
            }

            //Search Car
            $status = 0;
            $car = Constructor::where('game', $driver[2])->first();
            if($car == null) $car = array("id" => -1, "name" => "NA");

            //if position > 1000, position -= 1000;
            //if minid (fastest lap), $status = 1;
            if($k == $minid) {
                $status = 1;
            }
            else if($driver[0] > 1000) {
                $status = -2;
                $driver[0] -= 1000;
            }

            //Convert Times to Standard Format
            $fastestLapTime = $this->convertMillisToStandard($driver[3]);
            if($fastestLapTime == "00") $fastestLapTime = "-";

            $totalTime = $this->convertMillisToStandard($driver[4]);
            if($totalTime == "00") $totalTime = "DNF";

            //Push to Results
            array_push($results, array(
                "position" => $driver[0],
                "driver" => $driver[1],
                "driver_id" => $matched_driverid,
                "matched_driver" => $matched_drivername,
                "team" => $car['name'],
                "constructor_id" => $car['id'],
                "matched_team" => $car['name'],
                "grid" => $driver[5],
                "stops" => 0,
                "status" => $status,
                "fastestlaptime" => $fastestLapTime,
                "time" => $totalTime
            ));
        }

        return response()->json(["track" => $track, "results" => $results]);
    }
}
