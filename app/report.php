<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Report extends Model
{
    use LogsActivity;

    protected static $logName = 'report';  // Name for the log 
    protected static $logAttributes = ['*']; // Log All fields in the table
    protected static $recordEvents = ['updated']; // Only log updated events
    protected static $logOnlyDirty = true; // Only log the fields that have been updated

    protected $fillable = [
         'against', 'track','inquali','lap','explained','proof'
    ];

}
