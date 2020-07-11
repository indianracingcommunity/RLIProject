<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Discord;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.adminhome');
    }

    public function viewprofile(User $user)
    {
        $discord = new Discord();
        $userroles = $discord->getroles($user->discord_id);
       // dd($userroles);
          return view('user.profiles')
          ->with('user',$user)
          ->with('roles',$userroles);
    }

    public function savedetails(Request $request,User $user)
    {
       // dd($request->request);
        $location = $request->city.", ".$request->state;
        if(isset($request->game))
        {
            $games = serialize($request->game);
            $user->games = $games;
         
        }
        if(isset($request->platform))
        {
            $platformdata = serialize($request->platform);
            $user->platform = $platformdata;
        
        }

        if(isset($request->device))
        {
            $devicedata = serialize($request->device);
            $user->device = $devicedata;
          
        }

        $user-> mothertongue = $request->mothertongue;
        $user-> location = $location;
        $user-> motorsport = $request->motorsport;
        $user-> driversupport = $request->driversupport;
        $user-> source = $request->source;
        $user->youtube = $request->youtube;
        $user->instagram = $request->instagram;
        $user->twitch = $request->twitch;
        $user->twitter = $request->twitter;
        $user->xbox = $request->xbox;
        $user->psn = $request->psn;
        $user->spotify = $request->spotify;
        $user->devicename = $request->devicename; 
        
       
        $user->save();
        return redirect('/user/profile');
    }

    
}
