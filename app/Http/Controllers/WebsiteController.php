<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class WebsiteController extends Controller
{
    public function loadhomepage()
    {
        return view('welcome')->with('irc_guild', config('services.discord.irc_guild'));
    }

    public function loadjoinus()
    {
        return view('joinus')->with('irc_guild', config('services.discord.irc_guild'));
    }

    public function loadteamsanddrivers()
    {
        return view('teamsanddrivers');
    }

    public function loadstandings()
    {
    	return view('standings');
    }

    public function loadaboutus()
    {
        return view('aboutus')->with('irc_guild', config('services.discord.irc_guild'));
    }

    public function loadourteam()
    {
        $var = User::select('id','name','avatar')
                  ->where('role_id', 3)
                  ->get()->toArray();

        $fieldsTeams = array();
        for ($i = 0; $i < count($var); $i++)
        {
            # code...
            $id = $var[$i]['id'];
            $fieldsTeams[$id] = $var[$i];
        }
        return view('ourteam',compact('fieldsTeams'));
    }

    public function loadfaq()
    {
        return view('faq');
    }

    public function loadlogin()
    {
    	return view('login');
    }
}
