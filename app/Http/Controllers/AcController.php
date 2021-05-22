<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Output\ConsoleOutput;

use App\Driver;
use App\Season;
use App\Series;
use App\Circuit;
use App\Constructor;

class AcController extends ImageController
{
    private $output;
    public function __construct() {
        $this->output = new ConsoleOutput();
    }

    //View for CSV Upload
    public function raceUpload() {
        $series = Series::where('code', 'ac')->firstOrFail();
        $seasons = Season::where([
            ['status', '<', 2],
            ['series', $series['id']]
        ])->get();

        return view('acupload')->with('seasons', $seasons);
    }

    //Currently the CSV is generated from an SQLite Query
    //The Query HAS to be run on a Unix system

    //TODO: Handle Windows Line Ending format
    //TODO: Validate File Format and Columns
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
            $rcsv[$j][5] = (int)$rcsv[$j][5]; //Grid, Track, Laps

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
            "distance" => $rcsv[0][7] / 10.0,
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
            if($driver[0] > 1000) {
                $status = -2;
                $driver[0] -= 1000;
            }
            else if($k == $minid) {
                $status = 1;
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
                "grid" => ($driver[5] > 1000) ? $driver[5] - 1000 : $driver[5],
                "stops" => 0,
                "status" => $status,
                "fastestlaptime" => $fastestLapTime,
                "time" => $totalTime
            ));
        }

        return response()->json(["track" => $track, "results" => $results]);
    }
}
