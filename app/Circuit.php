<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    static public function getOfficial() {
        $official_list = Circuit::select('id', 'official')->get();
        return json_decode(json_encode($official_list), true);
    }
}
