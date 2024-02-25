<?php

namespace App;

use App\Traits\Queryable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Driver extends Model
{
    use Queryable;
    use LogsActivity;

    protected static $logName = 'driver';  // Name for the log
    protected static $logAttributes = ['*']; // Log All fields in the table // Log when a driver is Created or Updated
    protected static $logOnlyDirty = true; // Only log the fields that have been updated

    private const DELIMITER = '~$~';
    public static function getAliases()
    {
        $alias_list = Driver::pluck('alias');

        foreach ($alias_list as $i => $alias) {
            $arr = array();
            $arr = explode(self::DELIMITER, $alias);

            $alias_list[$i] = $arr;
        }

        return $alias_list;
    }

    public static function selfLearn(string $predicted, int $id)
    {
        $driver = Driver::find($id);
        $driver->insertAlias($predicted);
        return 0;
    }

    public static function getNames()
    {
        $driver_list = Driver::select('id', 'name', 'alias')->get();
        foreach ($driver_list as $i => $driver) {
            $arr = array();
            $arr = explode(self::DELIMITER, $driver['alias']);

            $driver_list[$i]['alias'] = $arr;
        }
        return json_decode(json_encode($driver_list), true);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function insertAlias(string $newAlias)
    {
        $aliases = explode(self::DELIMITER, $this->alias);
        if (!in_array($newAlias, $aliases)) {
            $this->alias = $this->alias . self::DELIMITER . $newAlias;
            $this->save();
            return 1;
        }
        return 0;
    }

    public function getAliasAttribute($aliasString)
    {
        return explode(self::DELIMITER, $aliasString);
    }

    public function results()
    {
        return $this->hasMany('App\Result');
    }
}
