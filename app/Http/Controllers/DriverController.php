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

   public function delete(Driver $driver)
   {
      $driver->delete();
      return redirect('/home');
   }

   public function retire(Driver $driver)
   {
      $driver->retired=true;
      $driver->save();
      return redirect('/home');
   }

   public function actived(Driver $driver)
   {
      $driver->retired=false;
      $driver->save();
      return redirect('/home');
   }
   

   public function viewferrari(Driver $driver)
   {
      $driver = Driver::where('team' ,'=', 'Ferrari')
             ->get();
      return view('driverview.ferraridrivers',compact('driver'));
   }

}
