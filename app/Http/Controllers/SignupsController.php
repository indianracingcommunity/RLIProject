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



}
