<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Constructor extends Model
{
    use LogsActivity;

    protected static $logName = 'constructor';  // Name for the log 
    protected static $logAttributes = ['*']; // Log All fields in the table
    protected static $recordEvents = ['updated']; // Only log updated events
    protected static $logOnlyDirty = true; // Only log the fields that have been updated

    static public function getTeams() {
        $team_list = Constructor::select('id', 'name')->get();
        return json_decode(json_encode($team_list), true);
    }

    public function results()
    {
        return $this->hasMany('App\Result');
    }
}
