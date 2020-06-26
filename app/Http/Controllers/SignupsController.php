<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Season;

class SignupsController extends Controller 
{
    public function view()
    {
      $allseason = Season::all();
      $seasons = array();

      foreach($allseason as $i => $particular_season) {
        $status = $particular_season->status;
        if($status - (int)$status > 0)
          array_push($seasons, $particular_season);
      }

      return view('signup.home')->with('seasons', $seasons);
    }

    public function store()
    {
        $data = request()->all();
        $sigunup = new Signup();
        $signup->user_id = Auth::user()->id;
        $signup->speedtest = $data['speedtest'];
        $signup->timetrial1 = $data['timetrial1'];
        $signup->timetrial2 = $data['timetrial2'];
        $signup->timetrial3 = $data['timetrial3'];
        $signup->ttevidence1 = $data['ttevidence1'];
        $signup->ttevidence2 = $data['ttevidence2'];
        $signup->ttevidence3 = $data['ttevidence3'];
        $signup->carprefrence = $data['carprefrence'];
        $signup->attendance = $data['attendance'];
        $signup->save();
        return redirect('/home');
    }

    public function test(Request $request)
    {
       dd($request->request);
    }


    public function temp()
    {
      $data = '{
        "track": {
          "circuit_id": 13,
          "season_id": 7,
          "round": 9
        },
        "results": [{
          "position": 1,
          "driver": "MaranelloBaby",
          "driver_id": 2,
          "constructor_id": 18,
          "grid": 0,
          "stops": 0,
          "fastestlaptime": "-",
          "time": "-"
        }, {
          "position": 2,
          "driver": "kapilace6",
          "driver_id": 3,
          "constructor_id": 16,
          "grid": 0,
          "stops": 0,
          "fastestlaptime": "-",
          "time": "-"
        }, {
          "position": 4,
          "driver": "gnan20",
          "driver_id": 40,
          "constructor_id": 21,
          "grid": 0,
          "stops": 0,
          "fastestlaptime": "-",
          "time": "DNF",
          "status": -2
        }, {
          "position": 7,
          "driver": "Blacksheep",
          "driver_id": 19,
          "constructor_id": 21,
          "grid": 0,
          "stops": 0,
          "fastestlaptime": "-",
          "time": "DNF",
          "status": -2
        }, {
          "position": 3,
          "driver": "SpeedLust",
          "driver_id": 4,
          "constructor_id": 18,
          "grid": 0,
          "stops": 0,
          "fastestlaptime": "-",
          "time": "-"
        }, {
          "position": 6,
          "driver": "vagary",
          "driver_id": 30,
          "constructor_id": 14,
          "grid": 0,
          "stops": 0,
          "fastestlaptime": "-",
          "time": "DNF",
          "status": -2
        }, {
          "position": 5,
          "driver": "Streeter",
          "driver_id": 7,
          "constructor_id": 23,
          "grid": 0,
          "stops": 0,
          "fastestlaptime": "-",
          "time": "DNF",
          "status": -2
        }]
      }
    ';
    
      return view('standings.upload')->with('data',$data);

    }



}
