<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    static public function getAliases() {
        $alias_list = Driver::pluck('alias');

        foreach($alias_list as $i => $alias) {
            $arr = array();
            $arr = explode("~$~", $alias);

            $alias_list[$i] = $arr;
        }

        return $alias_list;
    }

    static public function getNames() {
        $name_list = Driver::select('id', 'name')->get();
        return json_decode(json_encode($name_list), true);
    }
}
