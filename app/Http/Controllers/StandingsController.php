<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Driver;
use App\Result;
use App\Season;
use App\Race;
use App\Circuit;

class StandingsController extends Controller
{
    const POINTS = array(25, 18, 15, 12, 10, 8, 6, 4, 2, 1, 0);
    public function fetchDrivers()
    {
        $query = Driver::all();
        return $query;
    }

    public function fetchCircuit()
    {
        $query = Circuit::all();
        return $query;
    }

    public function fetchRaces($tier, $season) {
        $season = Season::where([
            ['tier', $tier],
            ['season', $season]
        ])->firstOrFail();

        $races = Race::where('season_id', $season['id'])
                     ->orderBy('round', 'asc')
                     ->get()->load('season','circuit');

                       //whereHas('season', function (Builder $query) use ($tier, $season) {
                       //     $query->where([
                       //         ['tier', $tier],
                       //         ['season', $season]
                       //     ]);
                       //})
                       //->orderBy('round', 'asc')
                       //->get()->load('season','circuit');

       //dd($races);
       return view('standings.allraces')->with('races',$races);
    }

    public function fetchStandings($tier, $season) {
        $season = Season::where([
            ['tier', $tier],
            ['season', $season]
        ])->firstOrFail();

        $races = Race::where('season_id', $season['id'])
                     ->pluck("id");

        $results = Result::whereIn('race_id', $races)
                         ->orderBy('driver_id')
                         ->orderBy('position')
                         ->get()->load('driver:id,name')->toArray();

        if(!count($results))
            return 0;

        $prev = $results[0]['driver_id'];
        $res = array(array(
            "id" => $results[0]['driver_id'],
            "name" => $results[0]['driver']['name'],
            "start" => 0
        ));

        $points = 0;
        foreach($results as $k => $driver) {
            if($prev != $driver['driver_id']) {
                $cur = array(
                    "id" => $driver['driver_id'],
                    "name" => $driver['driver']['name'],
                    "start" => $k
                );

                $res[count($res) - 1]['points'] = $points;
                $res[count($res) - 1]['end'] = $k;
                $points = 0;
                array_push($res, $cur);
            }

            $prev = $driver['driver_id'];
            $pos = $driver['position'];
            if($pos > 10 || $pos < 1)
                $pos = 11;

            $points += self::POINTS[$pos - 1] + $driver['fastestlap'];
        }
        $res[count($res) - 1]['points'] = $points;
        $res[count($res) - 1]['end'] = count($results);

        usort($res, function($a, $b) use ($results) {
            if ($a['points'] < $b['points'])
                return 1;
            elseif ($a['points'] > $b['points'])
                return -1;

            //Equal Points
            for($j = 0; $j < min($a['end'] - $a['start'], $b['end'] - $b['start']); $j++) {
                if($results[$j + $a['start']]['position'] > $results[$j + $b['start']]['position'])
                    return 1;
                if($results[$j + $a['start']]['position'] < $results[$j + $b['start']]['position'])
                    return -1;
            }

            if(($a['end'] - $a['start']) < ($b['end'] - $b['start']))
                return 1;
            return 0;
        });

        $nextRace = $this->nextRace($season['id']);
        $count = count($res);

        return view('standings.season')
               ->with('res', $res)
               ->with('count', $count)
               ->with('nextRace', $nextRace);
    }

    protected function nextRace($seasonid) {
        //$season = Season::where([
        //    ['tier', $tier],
        //    ['season', $season]
        //])->firstOrFail();

        $round = Race::has('results')
                      ->where('season_id', $seasonid)
                      ->max('round');

        $nextRace = Race::where([
                        ['season_id', $seasonid],
                        ['round', ($round + 1)]
                    ])->first();

        if($nextRace) {
            $circuit = Circuit::find($nextRace['circuit_id']);
            return $circuit;
        }
        return $nextRace;
    }

    public function storeResults(Request $request)
    {
        $result = new Result();
        $result->race_id = $request['race_id'];
        $result->constructor_id = $request['constructor_id'];
        $result->driver_id = $request['driver_id'];
        $result->grid = $request['grid'];
        $result->points = $request['points'];
        $result->fastestlap = $request['fastestlap'];
        $result->fastestlaptime = $request['fastestlaptime'];
        $result->tyres = $request['tyres'];
        $result->position = $request['position'];
        $result->save();

        return redirect('/');
    }
}
