<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Encryption\Encrypter;
use Illuminate\Contracts\Encryption\DecryptException;

class WebsiteController extends Controller
{
    public function loadhomepage()
    {
        return view('welcome')->with('irc_guild', config('services.discord.irc_guild'));
    }

    public function impel(Request $request)
    {
        $safeword = $request->query('safe_word');
        if($safeword === null)
          return response()->json(["errorMessage" => "Pass the safe_word in the Query Params"]);

        $safeword = str_replace("_", "", strtolower($safeword));
        $safeword = str_replace("-", "", strtolower($safeword));
        $safeword = str_replace(" ", "", strtolower($safeword));

        // /return response()->json(['c' => $safeword]);
        $cipher = "AES-256-CBC"; //or AES-128-CBC if you prefer

        $key = hash_hmac("md2", $safeword, "post");
        //Create two encrypters using different keys for each
        $encrypterFrom = new Encrypter($key, $cipher);
        $encrypterTo = new Encrypter($key, $cipher);

        try {
            $encryptedFromString = $encrypterFrom->encryptString("{\"a1\": \"Hey\"}");
            $decryptedFromString = $encrypterTo->decryptString($encryptedFromString);
            $resp = json_decode($decryptedFromString);
            return response()->json($resp);
        }
        catch (DecryptException $e) {
            return response()->json(["errorMessage" => "Incorrect Key"]);
        }
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

    public function f1leaguerules()
    {
        return view('f1leaguerules');
    }
    
    public function f1XBOXleaguerules()
    {
        return view('f1XBOXleaguerules');
    }
    
    public function accleaguerules()
    {
        return view('accleaguerules');
    }
    
    public function loadlogin()
    {
    	return view('login');
    }
}
