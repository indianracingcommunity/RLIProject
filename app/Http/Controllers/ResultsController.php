<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Output\ConsoleOutput;

use App\Http\Requests\RaceResults;

use App\Race;
use App\Result;
use App\Driver;

class ResultsController extends Controller
{
    private $output;
    public function __construct() {
        $this->output = new ConsoleOutput();
    }

    public function saveRaceResults(RaceResults $request) {
        //Race Storing
        $track = new Race($request->validated()['track']);
        $race = $track->insertRace();

        //Result Storing
        $results = $request->validated()['results'];
        foreach($results as $res) {
            Driver::selfLearn($res['driver'], $res['driver_id']);

            $res['race_id'] = $race['id'];
            $result = new Result($res);
            $result->storeResult();
        }

        return response()->json([
            "race" => $race,
            "result" => $results
        ]);
    }
}
