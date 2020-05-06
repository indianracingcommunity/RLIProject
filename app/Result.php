<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'constructor_id', 'driver_id', 'race_id', 'grid', 'points', 'fastestlaptime', 'position', 'tyres', 'stops', 'time'
    ];
}
