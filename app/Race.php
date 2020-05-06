<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = [
        'circuit_id', 'season_id', 'round'
    ];
}
