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

        $discord_id = Auth::user()->discord_id;
        $steamid = $steamUser->steamId;
        $message = "Steam profile for <@$discord_id> : https://steamcommunity.com/profiles/$steamid";
        Discord::sendMemberProfile($message);

        session()->flash('steamSuccess','Steam Profile Linked Successfully.');
        return redirect('/user/profile');
    }
}
