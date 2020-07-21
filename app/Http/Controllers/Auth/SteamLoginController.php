<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use kanalumaddela\LaravelSteamLogin\Http\Controllers\AbstractSteamLoginController;
use kanalumaddela\LaravelSteamLogin\SteamUser;
use App\Http\Controllers\DiscordController;
use App\Discord;

class SteamLoginController extends AbstractSteamLoginController
{
    /**
     * {@inheritdoc}
     */
    public function authenticated(Request $request, SteamUser $steamUser)
    {
        $useraccount = User::where('id', Auth::user()->id);
        $useraccount->update(["steam_id" => $steamUser->steamId]);
        
        $dis = new DiscordController();
        $dis->applyRoles();  
        // $discord = new Discord();
        // $discord->sendSteamProfile($steamUser->steamId);
        session()->flash('steamSuccess','Steam Profile Linked Successfully.');
        return redirect('/user/profile');
    }
}
