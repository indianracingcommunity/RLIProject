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
        else
            $res .= ".000";

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

    // Groups By Field
    // Example: Inputs -> ['season', 'signups', List of Seasons, List of All Signups, 'season']
    // Returns { season: {}, signups: [{}, {}, ...] }
    public function groupByField($fieldName, $listName, $idList, $ogList, $field, $id = "id")
    {
        $res = array();
        $sList = array();

        $prev = -1;
        $cur = 0;

        if(count($ogList) > 0)
            $prev = $ogList[0][$field];

        // Group by Field
        // Assumes ogList is sorted by field, so that it can be split by it in order
        foreach($ogList as $l)
        {
            $cur = $l[$field];

            if($prev != $cur)
            {
                $elId = array_search($prev, array_column($idList, $id));

                $el = array();
                $el[$fieldName] = $idList[$elId];
                $el[$listName] = $sList;
                array_push($res, $el);

                $sList = array();
            }

            array_push($sList, $l);
            $prev = $cur;
        }

        // Last element push
        $elId = array_search($cur, array_column($idList, $id));

        $el = array();
        $el[$fieldName] = $idList[$elId];
        $el[$listName] = $sList;

        array_push($res, $el);

        return $res;
    }
}
