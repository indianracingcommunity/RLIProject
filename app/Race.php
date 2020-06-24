<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    public function insertRace() {
        $race = Race::where([
            ['circuit_id', '=', $this->circuit_id],
            ['season_id', '=', $this->season_id],
            ['round', '=', $this->round]
        ])->first();

        if($race)
            return $race;
        else {
            $this->save();
            return $this;
        }
    }

    protected $fillable = [
        'circuit_id', 'season_id', 'round', 'distance'
    ];

    public function season()
    {
        return $this->belongsTo('App\Season');
    }

    public function circuit()
    {
        return $this->belongsTo('App\Circuit');
    }

    public function results()
    {
        return $this->hasMany('App\Result');
    }
}
