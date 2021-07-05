<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Output\ConsoleOutput;

use App\User;
use App\Driver;
use App\Season;
use App\Series;
use App\Circuit;

//ACC Result Parsing Controller Class
class AccController extends Controller
{
    private $output;
    public function __construct() {
        $this->output = new ConsoleOutput();
    }

    //View to Upload Race Results
    public function raceUpload() {
        $series = Series::where('code', 'acc')->firstOrFail();
        $seasons = Season::where([
            ['status', '<', 2],
            ['series', $series['id']]
        ])->get();

        return view('accupload')->with('seasons', $seasons);
    }

    public function file_get_contents_utf8($fn) {
        $content = file_get_contents($fn);
         return mb_convert_encoding($content, 'UTF-8',
             mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    }

    //TODO: Accept other encodings. Currently only supports UTF-8
    //ACC Result File are in UTF-16LE encoding
    public function parseJson(Request $request) {
        $race = request()->file('race');
        $quali = request()->file('quali');

        //1 for Multi-Session Single Driver
        //0 for Single Session
        $mode = request()->has('mode') ? request()->mode : 0;

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

        $totalLaps = 0;
        $results = array();
        if(count($json['sessionResult']['leaderBoardLines']) > 0)
            $totalLaps = $json['sessionResult']['leaderBoardLines'][0]['timing']['lapCount'];

        $track = array(
            'circuit_id' => $sp_circuit['id'],
            'official' => $sp_circuit['official'],
            'display' => $sp_circuit['name'],
            "season_id" => $season['id'],
            "distance" => $totalLaps / 10.0,
            "round" => $round
        );

        $qualiPosition = array();
        foreach($jq['sessionResult']['leaderBoardLines'] as $k => $driver)
        {
            //Multi Session, Single Driver Setup
            if($mode)
            {
                if(!array_key_exists($driver['currentDriver']['playerId'], $qualiPosition))
                    $qualiPosition[$driver['currentDriver']['playerId']] = $k + 1;
            }

            //Single Session, Multi Driver Setup
            else
            {
                $qualiPosition[$driver['car']['carId']] = $k + 1;
            }
        }

        foreach($json['sessionResult']['leaderBoardLines'] as $k => $driver)
        {
            $user = User::where('steam_id', substr($driver['currentDriver']['playerId'], 1))->first();
            $dr = Driver::where('user_id', $user['id'])->first();
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
            if($mode)
            {
                if(array_key_exists($driver['currentDriver']['playerId'], $qualiPosition))
                    $grid = $qualiPosition[$driver['currentDriver']['playerId']];
            }
            else
            {
                if(array_key_exists($driver['car']['carId'], $qualiPosition))
                    $grid = $qualiPosition[$driver['car']['carId']];
            }

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
