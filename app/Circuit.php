<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Circuit extends Model
{
    use LogsActivity;

    protected static $logName = 'circuit';  // Name for the log 
    protected static $logAttributes = ['*']; // Log All fields in the table
    protected static $recordEvents = ['updated']; // Only log updated events
    protected static $logOnlyDirty = true; // Only log the fields that have been updated

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
