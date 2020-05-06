<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    static public function fetch() {
        $seasons = Season::all()->orderBy('updated_at', 'desc')->get();
        return $seasons;
    }

    protected $fillable = [
        'game', 'season', 'tier', 'year'
    ];
}
