<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Driver extends Model
{
    use LogsActivity;
    protected static $logName = 'driver';  // Name for the log 
    protected static $logAttributes = ['*']; // Log All fields in the table
    protected static $recordEvents = ['updated','created']; // Log when a driver is Created or Updated
    protected static $logOnlyDirty = true; // Only log the fields that have been updated

    const delimiter = '~$~';
    static public function getAliases() {
        $alias_list = Driver::pluck('alias');

        foreach($alias_list as $i => $alias) {
            $arr = array();
            $arr = explode(self::delimiter, $alias);

            $alias_list[$i] = $arr;
        }

        return $alias_list;
    }

    static public function selfLearn(String $predicted, Int $id) {
        $driver = Driver::find($id);
        $driver->insertAlias($predicted);
        return 0;
    }

    static public function getNames() {
        $driver_list = Driver::select('id', 'name', 'alias')->get();
        foreach($driver_list as $i => $driver) {
            $arr = array();
            $arr = explode(self::delimiter, $driver['alias']);

            $driver_list[$i]['alias'] = $arr;
        }
        return json_decode(json_encode($driver_list), true);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function insertAlias(String $newAlias) {
        $aliases = explode(self::delimiter, $this->alias);
        if(!in_array($newAlias, $aliases)) {
            $this->alias = $this->alias . self::delimiter . $newAlias;
            $this->save();
            return 1;
        }
        return 0;
    }
    
    public function results()
    {
        return $this->hasMany('App\Result');
    }
}
