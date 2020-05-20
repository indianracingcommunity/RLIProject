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

    public function updatePosition(Request $request) {
        $request->validate([
            'newPos' => 'required|integer|gt:0',
            'driverid' => 'required|integer|gt:0',
            'raceid' => 'required|integer|gt:0'
        ]);

        $newPos = $request->newPos;
        $results = Result::where('race_id', $request->raceid)
                         ->orderBy('position')
                         ->get();

        if($request->newPos > count($results))
            return -1;

        $race_arr = json_decode($results, true);
        $driver_ind = array_search($request->driverid, array_column($race_arr, "driver_id"));
        if($driver_ind === false)
            return -1;

        $oldPos = $results[$driver_ind]['position'];

        if($request->has('status'))
            $results[$oldPos - 1]['status'] = $request->status;
        if($request->has('newTime'))
            $results[$oldPos - 1]['time'] = $request->newTime;

        $results[$oldPos - 1]['position'] = $newPos;
        //$results[$oldPos - 1]['time'] = $request->newTime;
        $results[$oldPos - 1]->save();
        if($newPos > $oldPos) {
            for($i = $oldPos; $i < $newPos; $i++) {
                $results[$i]['position'] = $results[$i]['position'] - 1;
                $results[$i]->save();
            }
        }
        elseif($newPos < $oldPos) {
            for($i = $newPos - 1; $i < $oldPos - 1; $i++) {
                $results[$i]['position'] = $results[$i]['position'] + 1;
                $results[$i]->save();
            }
        }

        return $results;
    }

    public function saveRaceResults(RaceResults $request) {
        //Race Storing
        $track = new Race($request->validated()['track']);
        $race = $track->insertRace();

        //Result Storing
        $results = $request->validated()['results'];
        foreach($results as $k => $res) {
            Driver::selfLearn($res['driver'], $res['driver_id']);

            $res['race_id'] = $race['id'];
            $result = new Result($res);
            $result->storeResult();
            $results[$k] = $result;
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
                         ->get()
                         ->load('driver','race.circuit', 'constructor:id,name')
                         ->toArray();

        foreach($results as $i => $res) {
            $pos = $res['position'];
            if($pos > 10 || $pos < 1)
                $pos = 11;

            if($res['status'] < 0)
                $results[$i]['points'] = 0;
            else {
                $results[$i]['points'] = self::POINTS[$pos - 1];
                if(((int)abs($results[$i]['status']) % 10) == 1) $results[$i]['points'] += 1;
            }
        }
        //dd($results);
        $count = count($results);
        return view('standings.race')
        ->with('results',$results)
        ->with('count',$count);
    }
}
