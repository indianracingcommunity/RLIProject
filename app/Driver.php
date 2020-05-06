<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    const delimiter = "~$~";
    static public function getAliases() {
        $alias_list = Driver::pluck('alias');

        foreach($alias_list as $i => $alias) {
            $arr = array();
            $arr = explode(delimiter, $alias);

            $alias_list[$i] = $arr;
        }

        return $alias_list;
    }

    static public function getNames() {
        $name_list = Driver::select('id', 'name', 'alias')->get();
        return json_decode(json_encode($name_list), true);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function insertAlias(String $newAlias) {
        $aliases = explode(delimiter, $this->alias);
        if(!in_array($newAlias, $aliases)) {
            $this->alias = $this->alias . delimiter . $newAlias;
            $this->save();
        }
        return 0;
    }
}
