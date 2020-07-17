<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Series;
use App\Discord;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;

class DiscordController extends Controller
{
    public function getServerRoles()
    {
        $discord = new Discord();
        $userroles = $discord->getroles();
    }

    public function applyRoles()
    {
        $series_all = Series::all()->toArray();
        $user = User::find(Auth::user()->id);

        $roles = array();
        if(isset($user->mothertongue))
        {
            $roles['member'] = 598061461511602191;
            if(isset($user->game))
            {
                $user->game = unserialize($user->game);
                $user->platform = unserialize($user->platform);

                //For PC Game Roles
                foreach($series_all as $series)
                {
                    if(isset($series->discord_role) && in_array("PC", $user->platform)
                            && isset($user->steam_id) && in_array($series->code, $user->game))
                    {
                        if($user->game[$series->code])
                            $roles[$series->code] = $series->discord_role;
                    }
                }

                if(isset($user->psn) && in_array("PlayStation", $user->platform))
                   $roles['ps4'] = 724495481241206795;
                if(isset($user->xbox) && in_array("Xbox", $user->platform))
                   $roles['xbox'] = 728827128443043902;
            }

            $discord = new Discord();
            return $discord->addroles($roles, $user->discord_id);
        }
        return 0;
    }
}
