<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Output\ConsoleOutput;

use App\Http\Requests\RaceResults;
use Illuminate\Database\Eloquent\Builder;

use App\Race;
use App\Result;
use App\Driver;

class ResultsController extends Controller
{
    private $output;
    const POINTS = array(25, 18, 15, 12, 10, 8, 6, 4, 2, 1, 0);
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

    public function fetchRaceResults($tier, $season, $round) {
        $race = Race::whereHas('season',
            function (Builder $query) use ($tier, $season) {
                $query->where([
                    ['tier', $tier],
                    ['season', $season]
                ]);
            })
            ->where('round', $round)
            ->firstOrFail();

        $results = Result::where('race_id', $race['id'])
                         ->orderBy('position', 'asc')
                         ->get()->load('driver','race.circuit')->toArray();
     
        foreach($results as $i => $res) {
            $pos = $res['position'];
            if($pos > 10 || $pos < 1)
                $pos = 11;

            $results[$i]['points'] = self::POINTS[$pos - 1] + $res['fastestlap'];
        }
        //dd($results);
        $count = count($results);
        return view('standings.race')
        ->with('results',$results)
        ->with('count',$count);
    }
}
