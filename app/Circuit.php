<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    static public function getOfficial() {
        $official_list = Circuit::select('id', 'official')->get();
        return json_decode(json_encode($official_list), true);
    }

    static public function getTrackByGame($game, $series) {
        $track = Circuit::where('game', $game)
                        ->where('series', $series)
                        ->first();

        return $track;
    }

    public function races()
    {
        return $this->hasMany('App\Race');
    }

    public function series()
    {
        return $this->belongsTo('App\Series');
    }
}
