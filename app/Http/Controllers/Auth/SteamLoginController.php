<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use kanalumaddela\LaravelSteamLogin\Http\Controllers\AbstractSteamLoginController;
use kanalumaddela\LaravelSteamLogin\SteamUser;

class SteamLoginController extends AbstractSteamLoginController
{
    /**
     * {@inheritdoc}
     */
    public function authenticated(Request $request, SteamUser $steamUser)
    {
       // dd($steamUser); 
        $useraccount = User::where('id',Auth::user()->id);
        $useraccount->update([
                           
                       "steam_id" => $steamUser->steamId

                            ]);
        
        session()->flash('steamSuccess','Steam Profile Linked Successfully.');

        return redirect('/user/profile');                    
        
    }
}
