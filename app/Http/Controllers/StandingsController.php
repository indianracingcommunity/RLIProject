<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Driver;
use App\Result;
use App\Season;
use App\Race;

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
        return $races;
    }

    public function fetchStandings($tier, $season) {
        $season = Season::where([
            ['tier', $tier],
            ['season', $season]
        ])->firstOrFail();
        
        $races = Race::where('season_id', $season['id'])
                     ->pluck("id");

        $results = Result::whereIn('race_id', $races)
                         ->distinct('driver_id')
                         ->orderBy('driver_id')
                         ->get()->load('driver:id,name')->toArray();

        foreach($results as $k => $driver) {
            $positions = Result::whereIn('race_id', $races)
                            ->where('driver_id', $driver['driver']['id'])
                            ->pluck('position');

            $points = 0;
            foreach($positions as $position) {
                $pos = $position;
                if($pos > 10 || $pos < 1)
                    $pos = 11;

                $points += self::POINTS[$pos - 1];
            }
            $results[$k]['points'] = $points;
        }

        usort($results, function($a, $b) {
            if ($a['points'] == $b['points']) return 0;
            return ($a['points'] < $b['points']) ? 1 : -1;
        });

        return $results;
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
