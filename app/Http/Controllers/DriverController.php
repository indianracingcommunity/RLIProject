<?php

namespace App\Http\Controllers;

use App\Driver;
use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Constructor;
use App\Result;
use App\Series;

class DriverController extends StandingsController
{

  public function info(Request $request)
  {
    $number = $request->query('number');
    if($number === false)
      return response()->json([]);

    $code = $request->query('code');
    $tier = $request->query('tier');
    $season = $request->query('season');
    $series = Series::where("code", $code)->first();

    $driver = Driver::where('drivernumber', $number)
                    ->select('id', 'name', 'drivernumber', 'team')
                    ->first();
    $constructor = 5;

    if($driver == null || $series == null)
      return response()->json([]);

    $points = 0;
    $cpoints = 0;
    $dpoints = 0;
    $dpos = 0;
    $cpos = 0;

    $found = false;
    if(!($tier === null || $season === null))
    {
      $cs = $this->computeStandings($series['id'], $tier, $season);
      if($cs['code'] == 200)
      {
        $driver_ind = array_search($driver['id'], array_column($cs['drivers'], "id"));

        if($driver_ind !== false)
        {
          if((abs($cs['drivers'][$driver_ind]['status']) >= 10 && abs($cs['drivers'][$driver_ind]['status']) < 20))
            $constructor = Constructor::where('name', 'Reserve')->first();
          else
          {
            $constructor = $cs['drivers'][$driver_ind]['team'];
            $cons_ind = array_search($constructor['id'], array_column($cs['constructors'], "id"));

            $cpoints = $cs['constructors'][$cons_ind]['points'];
            $cpos = $cons_ind + 1;
          }

          $found = true;
          $dpoints = $cs['drivers'][$driver_ind]['points'];
          $dpos = $driver_ind + 1;
        }
      }
    }

    if(!$found)
      $constructor = Constructor::find($driver['team']);

    unset($driver['team']);
    unset($constructor['created_at']);
    unset($constructor['updated_at']);

    $driver['points'] = $dpoints;
    $driver['position'] = $dpos;
    $constructor['points'] = $cpoints;
    $constructor['position'] = $cpos;

    return response()->json([
      "driver" => $driver,
      "constructor" => $constructor
    ]);
  }

  public function index()
  {
    return view('admin.adminhome');
  }

  public function viewusers()
  {
    return view('admin.viewusers')->with('user',User::all());
  }
  public function viewdetails(User $user)
  {
    return view('admin.viewdetails')->with('user',$user);
  }

  public function viewedit(User $user)
  {
    return view('admin.edit')->with('user',$user);
  }
 
  public function saveedit(User $user)
  {
    $data = request()->all();
    $user->name = $data['name'];
    $user->discord_discrim = $data['discord_discrim'];
    $user->team = $data['team'];
    $user->steam_id = $data['steam_id'];
    $user->avatar = $data['avatar'];
    $user->save();
    return redirect()->back();
  }

  public function viewreports(Report $report)
  {
    return view('admin.reports')->with('report',Report::all());
  }

  public function reportdetails(Report $report)
  {
    return view('admin.reportdetails')->with('report', $report);
  }

  public function saveverdict(Report $report)
  {
    $data = request()->all();
    $report->verdict = $data['verdict'];
    $report->resolved = 1;
    $report->save();
    return redirect()->back();
  }

  public function allotuser(User $id)
  {
    $existing = Driver::where('user_id',$id->id)->get();
    //dd($exisiting);
    return view('admin.allot')
            ->with('user',$id)
            ->with('existing',$existing);
  }

  public function saveallotment()
  {
    $data = request()->all();
       //dd($data);
    $userinfo = User::select('*')
      ->where('id',$data['user_id'])
      ->get()->toArray();

    $driver = new Driver();
    $driver -> user_id = $data['user_id'];
    $driver -> name = $userinfo['0']['name'];
    $driver -> team = $data['tier'];
    $driver -> drivernumber = 5;
    $driver -> retired = 0;
    $driver -> alias = $userinfo['0']['name'];
    $driver->save();
    return redirect()->back();
  }
  
  public function driverdata()
  {
    $data = Driver::select('id','name','team')->get();
    return response()->json($data);
  }
}