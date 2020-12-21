<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    public function races()
    {
        return $this->hasOne('App\Race');
    }
}
