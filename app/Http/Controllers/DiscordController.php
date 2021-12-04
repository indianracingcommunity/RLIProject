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
    protected $psRole;
    protected $xboxRole;
    protected $memberRole;
    protected $applicantRole;

    public function __construct()
    {
        $this->psRole = (int)config('services.discord.ps_role');
        $this->xboxRole = (int)config('services.discord.xbox_role');
        $this->memberRole = (int)config('services.discord.member_role');
        $this->applicantRole = (int)config('services.discord.applicant_role');
    }

    public function applyRoles()
    {
        $discord = new Discord();
        $series_all = Series::all();
        $user = User::find(Auth::user()->id);

        $psSet = false;
        $xboxSet = false;

        $roles = array();
        $discord_roles = $discord->getMemberRoles($user->discord_id);
        if(isset($user->mothertongue))
        {
            $roles['member'] = $this->memberRole;
            if(isset($user->games) && $user->games != "")
            {
                $user->games = unserialize($user->games);
                $user->platform = unserialize($user->platform);

                // For PC Game Roles
                foreach($series_all as $series)
                {
                    if(isset($series->discord_role) && in_array("PC", $user->platform)
                            && isset($user->steam_id) && in_array($series->code, $user->games))
                        $roles[$series->code] = $series->discord_role;
                }

                if(isset($user->psn) && $user->psn != "" && in_array("PlayStation", $user->platform))
                {
                    $roles['ps4'] = $this->psRole;
                    $psSet = true;
                }
                if(isset($user->xbox) && $user->xbox != "" && in_array("Xbox", $user->platform))
                {
                    $roles['xbox'] = $this->xboxRole;
                    $xboxSet = true;
                }
            }

            if(!in_array($this->xboxRole, $discord_roles) && $xboxSet)
                $discord->sendMemberProfile("Xbox ID for <@$user->discord_id> : $user->xbox");
            if(!in_array($this->psRole, $discord_roles) && $psSet)
                $discord->sendMemberProfile("PSN ID for <@$user->discord_id> : $user->psn");

            return $discord->addroles($roles, $user->discord_id, $discord_roles);
        }
        return 0;
    }

   public function updateallusers()
    {
        $discord = new Discord();
        $test = $discord->updatedetails();
        return $test;
    }
}
