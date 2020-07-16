<?php

namespace App\Http\Controllers;

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
}
