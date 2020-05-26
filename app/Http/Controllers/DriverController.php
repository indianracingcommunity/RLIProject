<?php

namespace App\Http\Controllers;

use App\Driver;
use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Constructor;
use App\Result;

class DriverController extends StandingsController
{

  public function info(Request $request)
  {
    $number = $request->query('number');
    if($number === false)
      return response()->json([]);

    $tier = $request->query('tier');
    $season = $request->query('season');

    $driver = Driver::where('drivernumber', $number)
                    ->select('id', 'name', 'drivernumber', 'team')
                    ->first();
    $constructor = 5;

    if($driver == null)
      return response()->json([]);

    $points = 0;
    $cpoints = 0;
    $dpoints = 0;
    $dpos = 0;
    $cpos = 0;

    $found = false;
    if(!($tier === null || $season === null))
    {
      $cs = $this->computeStandings($tier, $season);
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
    return view('admin.reportdetails')->with('report',$report);
  }

  public function saveverdict(Report $report)

  {
    $data=request()->all();
    $report->verdict=$data['verdict'];
    $report->resolved=1;
    $report->save();
    return redirect()->back();

  }

  public function allotuser(User $id)
  {
    return view('admin.allot')
    ->with('user',$id)
    ->with('team',Constructor::all());
  }

  public function saveallotment()
  {
    $data = request()->all();
       
    $userinfo = User::select('*')
      ->where('id',$data['user_id'])
      ->get()->toArray();

    // dd($userinfo);

    $driver = new Driver();
    $driver -> user_id = $data['user_id'];
    $driver -> name = $userinfo['0']['name'];
    $driver -> team = $data['constructor'];
    $driver -> drivernumber = 5;
    $driver -> retired = 0;
    $driver -> alias = $userinfo['0']['name'];
    $driver->save();
    return redirect()->back();
  }






















    
// Unused Functions, Only Kept for refrences 


   public function viewferrari(Driver $driver,$key)
   {
      

    $driver = Driver::where('team' ,'=', $key )
            ->get();
    return view('driverview.teamview',compact('driver'));
   }

   public function api(Driver $driver){

       $profile=$driver->steamid;     
        $str=file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=A858C6BCA92BE79C5483EF2029AD8F66&steamids='.$profile);
       $json = json_decode($str,true);
        $avatarurl=$json['response']['players']['0']['avatarfull'];
      //  echo $avatarurl;
        $driver->avatar=$avatarurl;
        $driver->save();
        return redirect('/drivers/'.$driver->id);
        
   }
   public function apidiscord(Driver $driver){

    $opts = array(
      'http'=>array(
        'method'=>"GET",
        'header'=>
                  "Authorization: Bot NjI1Mjg5MTY5NDUwNjk2NzA0.XZYYKQ.zrl8ET3alByITkxZYAsOGiUCadU \r\n"
      )
    );
    
    $context = stream_context_create($opts);
    
    // Open the file using the HTTP headers set above
    $uid=$driver->discord;
    $file = file_get_contents('https://discordapp.com/api/users/'.$uid, false, $context);

    $json = json_decode($file,true);
    $avatarhash=$json['avatar'];
    $userid=$json['id'];
    $result= 'https://cdn.discordapp.com/avatars/'.$userid.'/'.$avatarhash;
   $driver->avatar=$result;
   $driver->save();
   return redirect('/drivers/'.$driver->id);

  


  
}
}