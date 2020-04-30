<?php

namespace App\Http\Controllers;

use App\Driver;
use Illuminate\Http\Request;
use App\User;
use App\Report;

class DriverController extends Controller
{


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
    $user->name=$data['name'];
    $user->discord_discrim=$data['discord_discrim'];
    $user->team=$data['team'];
    $user->steam_id=$data['steam_id'];
    $user->avatar=$data['avatar'];
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