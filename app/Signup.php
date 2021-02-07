<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signup extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function season()
    {
        return $this->belongsTo('App\Season', 'season');
    }
    
}
