<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    const cdelim = ',';
    static public function fetch() {
        $seasons = Season::all()->orderBy('updated_at', 'desc')->get();
        return $seasons;
    }

    protected $fillable = [
        'game', 'season', 'tier', 'year'
    ];

    public function races()
    {
        return $this->hasMany('App\Race');
    }

    public function series()
    {
        return $this->belongsTo('App\Series');
    }

    public function getConstructorsAttribute($string)
    {
        $cars = array_map('intval', explode(self::cdelim, $string));
        $lm = Constructor::whereIn('id', $cars)->get()->toArray();

        return $lm;
    }
    public function getTttracksAttribute($string)
    {
        $circuits = array_map('intval', explode(self::cdelim, $string));
        $lm = Circuit::whereIn('id', $circuits)->get()->toArray();

        return $lm;
    }

    public function signups()
    {
        return $this->hasMany('App\Signup');
    }
}
