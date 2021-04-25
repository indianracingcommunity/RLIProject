<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Series;
use App\Discord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPanel extends Controller
{
    /*
    public function index()
    {
        $user_id = Auth::user()->id;
        return view('user.userhome', compact('user_id'));
    }
    */

    public function viewprofile()
    {
        $id = Auth::user()->discord_id;
        $series = Series::where('profile', true)->get();
        $discord = new Discord();
        $userroles = $discord->getroles($id);

        return view('user.userprofile')
                ->with('roles', $userroles)
                ->with('series', $series);
    }

    public function SetSteam(user $user)
    {
        $data = request()->all();
        $user->steam_id = $data['steamid'];
        $user->save();
        return redirect('/user/profile/' . $user->id);
    }

    public function ResetSteamLink(user $user)
    {
        $user->update(['steam_id' => NULL]);
        $user->save();
    }
}
