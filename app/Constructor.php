<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Constructor extends Model
{
    static public function getTeams() {
        $team_list = Constructor::select('id', 'name')->get();
        return json_decode(json_encode($team_list), true);
    }
}
