<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
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
}
