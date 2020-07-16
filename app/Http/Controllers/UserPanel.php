<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Discord;
use App\Series;

class UserPanel extends Controller
{
    public function index()
    {
        $user_id=Auth::user()->id;
        return view('user.userhome', compact('user_id'));
    }

    public function viewprofile()
    {
        $id = Auth::user()->discord_id;
        $series = Series::all();
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
