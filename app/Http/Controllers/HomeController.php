<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Discord;
use App\Series;
use Illuminate\Support\Facades\Log;
use Auth;

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

        $series = Series::all();
        return view('user.profiles')
          ->with('user', $user)
          ->with('roles', $userroles)
          ->with('series', $series);
    }

    public function savedetails(Request $request,User $user)
    {
        $id = Auth::user()->discord_id;

        // Dank code for auto roles
        $roles = array();
        if(isset($request->mothertongue))
        {
            $roles['member'] = 598061461511602191;
            if(isset($request->game))
            {
                if(in_array("f1", $request->game) && in_array("PC", $request->platform))
                {
                    $roles['pc'] = 687344291265118224;
                }
                if(in_array("acc", $request->game))
                {
                    $roles['acc'] = 728830210874540082;
                }
                if(in_array("ac", $request->game))
                {
                    $roles['ac'] = 643354584747868172;
                }
            
                if(in_array("PlayStation", $request->platform))
                {
                   $roles['ps4'] = 724495481241206795;
                }
                if(in_array("Xbox", $request->platform))
                {
                   $roles['xbox'] = 728827128443043902;
                }
            }

            $discord = new Discord();
            $var = $discord->addroles($roles,$id);
        }

      
        // Save query
        $location = $request->city."~".$request->state;
        if(isset($request->game))
        {
            $games = serialize($request->game);
            $user->games = $games;
        }
        else
        {
            $user->games = '';
        }

        if(isset($request->platform))
        {
            $platformdata = serialize($request->platform);
            $user->platform = $platformdata;        
        }
        else
        {
            $user->platform = '';
        }

        if(isset($request->device))
        {
            $devicedata = serialize($request->device);
            $user->device = $devicedata; 
        }
        else
        {
            $user->device = '';
        }

        $user->mothertongue = trim($request->mothertongue);
        $user->location = $location;
        $user->motorsport = trim($request->motorsport);
        $user->driversupport = trim($request->driversupport);
        $user->source = trim($request->source);
        $user->youtube = $request->youtube;
        $user->instagram = $request->instagram;
        $user->twitch = $request->twitch;
        $user->twitter = $request->twitter;
        $user->xbox = $request->xbox;
        $user->psn = $request->psn;
        $user->spotify = $request->spotify;
        $user->devicename = trim($request->devicename); 
        $user->save();

        session()->flash('savedProfile','Details saved successfully.');
        return redirect('/user/profile');
    }
}
