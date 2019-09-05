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
   public function store()
   {
       $data= request()->all();
       $driver= new Driver();
       $driver->name = $data['name'];
       $driver->steamid=$data['steamid'];
       $driver->discord=$data['discord'];
       $driver->drivernumber=$data['drivernumber'];
       $driver->team=$data['team'];
       $driver->save();
       return redirect('/home');
       
   }

   public function view(){
         
         return view('admin.view')->with('driver',Driver::all());
       
   }

   public function viewdetails(Driver $driver){
       return view('admin.viewdetails')->with('driver',$driver);
     

   }

}
