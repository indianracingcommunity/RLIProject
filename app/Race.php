<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    public function insertRace() {
        $race = Race::where([
            ['circuit_id', '=', $this->circuit_id],
            ['season_id', '=', $this->season_id]
        ])->first();

        if($race)
            return $race;
        else {
            $this->save();
            return $this;
        }
    }

    protected $fillable = [
        'circuit_id', 'season_id', 'round'
    ];
}
