<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Driver;

class SteamController extends Controller
{
    public function check()
    {
        //Get all Users from DB
        $query = Driver::select('*')
                ->get()->load('user');

        $count = count($query);
        $key = config('steam-login.api_key');
        //dd($key);

        for($i = 0; $i < $count; $i++)
        {
            $str = $this->querySteam('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$key.'&steamids='.$query[$i]['user']['steam_id']);
 
            if($str['response']['players'] == NULL)
                echo "Invalid Steam ID";
            else
            {
                $checkalias = $str['response']['players']['0']['personaname'];
                echo "<br>".$checkalias." Driver id ".$query[$i]['id']."<br>";
                $query[$i]->insertAlias($checkalias);
            }
        }
    }

    protected function querySteam(String $query)
    {
        $connect = curl_init();
        curl_setopt($connect, CURLOPT_URL, $query);
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, true);

        $str = curl_exec($connect);  

        curl_close ($connect);
        return json_decode($str, true);
    }
}
