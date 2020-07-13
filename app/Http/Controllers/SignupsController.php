<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Season;
use App\Circuit;
use App\Constructor;
use App\Driver;
use App\Signup;
use Storage;
use Auth;
class SignupsController extends Controller 
{
    public function view()
    {
      $signups = Signup::where('user_id',Auth::user()->id)->get()->toArray();
    
      $allseason = Season::all();
      $seasons = array();
      
      foreach($allseason as $i => $particular_season) {
        $status = $particular_season->status;
        if($status - (int)$status > 0)
          array_push($seasons, $particular_season);
      }
      
      return view('signup.home')
      ->with('seasons', $seasons)
      ->with('signup',$signups);
    }

    public function store(Request $request)
    {
        $data = request()->all();
      //  dd($data); 
        if(isset($data['evidencet1']) & isset($data['evidencet2']) & isset($data['evidencet3'])  )
           {
             if($data['evidencet1'] != NULL & $data['evidencet2'] != NULL & $data['evidencet3'] != NULL)
              $evidence1 = $data['evidencet1']->store('timetrials');
              $evidence2 = $data['evidencet2']->store('timetrials');
              $evidence3 = $data['evidencet3']->store('timetrials');
           }
           if($data['attendance']=="YES")
           {
             $attendance = 1;
           }
           else 
           {
             $attendance = 0;
           }
           $prefrence = $data['pref1'].','.$data['pref2'].','.$data['pref3'];

           if(isset($data['assists']))
           {
            $assists = serialize($data['assists']);
           }
           else
           {
             $assists = '' ;
           }
          
          

          
           //dd($assists);
        $signup = new Signup();
        $signup->user_id = Auth::user()->id;
        $signup->season = $data['seas'];
        $signup->speedtest = $data['speedtest'];
        $signup->timetrial1 = $data['t1'];
        $signup->timetrial2 = $data['t2'];
        $signup->timetrial3 = $data['t3'];
        $signup->ttevidence1 = $evidence1;
        $signup->ttevidence2 = $evidence2;
        $signup->ttevidence3 = $evidence3;
        $signup->carprefrence = $prefrence;
        $signup->attendance = $attendance;
        $signup->assists = $assists;
        $signup->drivernumber = $data['drivernumber'];
        $signup->save();
        return redirect('/home');
    }

    public function update(Signup $signup)
    {
       $data = request()->all();

     // dd($signup);
       if($signup->user_id==Auth::user()->id)
       {
        if($data['attendance']=="YES")
        {
          $attendance = 1;
        }
        else 
        {
          $attendance = 0;
        }
        if(isset($data['assists']))
           {
            $assists = serialize($data['assists']);
           }
           else
           {
             $assists = '' ;
           }
        $prefrence = $data['pref1'].','.$data['pref2'].','.$data['pref3'];
        $signup->season = $data['seas'];
        $signup->speedtest = $data['speedtest'];
        $signup->timetrial1 = $data['t1'];
        $signup->timetrial2 = $data['t2'];
        $signup->timetrial3 = $data['t3'];
        $signup->attendance = $attendance;
        $signup->carprefrence = $prefrence;
        $signup->assists = $assists;
        $signup->drivernumber = $data['drivernumber'];

        if(isset($data['evidencet1']))
        {
          $evidence1 = $data['evidencet1']->store('timetrials');
          Storage::delete($signup->ttevidence1); 
          $signup->ttevidence1 = $evidence1;         
        }


        if(isset($data['evidencet2']))
        {
          $evidence1 = $data['evidencet2']->store('timetrials');
          Storage::delete($signup->ttevidence2);
          $signup->ttevidence2 = $evidence1;
  
        }

        if(isset($data['evidencet3']))
        {
          $evidence1 = $data['evidencet3']->store('timetrials');
          Storage::delete($signup->ttevidence3); 
          $signup->ttevidence3 = $evidence1;
          
          
          
        }

          $signup->save();
          session()->flash('success',"Signup Updated");
          return redirect('/signup');
       }
       else
       {
            return redirect('/');
       }
    }

   public function viewsignups()
   {
     $data =  Signup::all()->load('user','season')->toArray();
    // dd($data);
     return view('admin.signups')
     ->with('data',$data);
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

    
      $season = Season::where('status','>',0)->get();
     
      
      $tracks = Circuit::select('*')->get();
      $constructor = Constructor::select('*')->get();
      $driver = Driver::select('id','name')->get();
      
      return view('standings.upload')
      ->with('data',$data)
      ->with('season',$season)
      ->with('tracks',$tracks)
      ->with('constructor',$constructor)
      ->with('driver',$driver);

    }



}
