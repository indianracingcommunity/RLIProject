<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function convertMillisToStandard($time)
    {
        $mtime = (int)$time;
        $seconds = round($mtime / 1000.0, 3);
        $minutes = (int)($seconds / 60);
        $seconds = round($seconds - $minutes * 60, 3);

        $res = "";
        if($minutes > 0)
            $res .= (string)$minutes . ":";
        if($seconds < 10)
            $res .= "0";

        $res .= (string)$seconds;
        $tr = explode(".", $res);
        if(count($tr) > 1)
        {
            $decimal = $tr[1];
            if(strlen($decimal) != 3)
            {
                for($i = 3; $i > strlen($decimal); --$i)
                    $res .= "0";
            }
        }

        return $res;
    }

    public function sgnp($n) {
        return ($n >= 0) - ($n < 0);
    }

    public function convertStandardtoMillis($time)
    {
        $seg_time = explode(":", $time);
        $min = 0;
        $sec = 0;
        if(count($seg_time) > 0)
            $min = (int)$seg_time[0];
        if(count($seg_time) > 0)
            $sec = (float)$seg_time[1];
        else
            $sec = (float)$seg_time[0];

        $res = $min * 60 + $sec;
        return ceil($res * 1000);
    }
}
