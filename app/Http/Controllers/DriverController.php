<?php

namespace App\Http\Controllers;

use App\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function create()

 {
      return view('admin.create');
 }

 // Function to store data 
   public function store()
   {
       $data= request()->all();
       $driver= new Driver();
       $driver->name = $data['name'];
       $driver->steamid=$data['steamid'];
       $driver->discord=$data['discord'];
       $driver->drivernumber=$data['drivernumber'];
       $driver->team=$data['team'];
       $driver->teammate=$data['teammate'];
       $driver->retired=false;
       $driver->save();
       return redirect('/home');
       
   }
  // Function to View all data
   public function view(){
         
         return view('admin.view')->with('driver',Driver::all());
       
   }

   public function viewdetails(Driver $driver){
       return view('admin.viewdetails')->with('driver',$driver);
     

   }
  // Function showing the categories Active and Retired
   public function category()
   {
       return view('admin.drivercategory');
   }
// Only Showing active drivers
   public function active()
   {
    return view('admin.activedrivers')->with('driver',Driver::all());
   }

   public function retired()
   {
    return view('admin.retireddrivers')->with('driver',Driver::all());
   }

   public function edit(Driver $driver){

        return view('admin.edit')->with('driver',$driver);
   }

   public function update(Driver $driver)
   {
     $data = request()->all();
    $driver->name=$data['name'];
    $driver->steamid=$data['steamid'];
    $driver->discord=$data['discord'];
    $driver->drivernumber=$data['drivernumber'];
    $driver->teammate=$data['teammate'];
    $driver->team=$data['team'];

    $driver->save();
     return redirect('/drivers/'.$driver->id);
         

   }


   public function delete(Driver $driver)
   {
      $driver->delete();
      return redirect('/home');
   }

   public function retire(Driver $driver)
   {
      $driver->retired=true;
      $driver->team="";
      $driver->teammate="";
      $driver->save();
      return redirect('/home');
   }

   public function actived(Driver $driver)
   {
      $driver->retired=false;
      $driver->save();
      return redirect('/home');
   }
   

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
        return redirect('/active-drivers');
        
   }
     public function report()
     {
         return view('report');
     }

}
