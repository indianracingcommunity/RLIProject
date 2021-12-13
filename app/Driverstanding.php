<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Driverstanding extends Model
{
    use LogsActivity;

    protected static $logName = 'driverstanding';   // Name for the log
    protected static $logAttributes = ['*'];        // Log All fields in the table
    protected static $logOnlyDirty = true;          // Only log the fields that have been updated
}
