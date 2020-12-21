<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    public function seasons()
    {
        return $this->hasOne('App\Season');
    }
}