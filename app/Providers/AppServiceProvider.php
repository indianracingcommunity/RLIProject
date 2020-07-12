<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Session;
use App\Season;
use App\Series;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {         
        $all_seasons = Season::where('status', '>=', 1)
                    ->orderBy('series', 'asc')
                    ->orderBy('tier', 'asc')
                    ->orderBy('season', 'desc')
                    ->get()
                    ->toArray();

        $prev = -1;
        $prev = 0;
        $seasons = array();
        for($i = 0; $i < count($all_seasons); $i++)
        {
            $series = array();
            while($i < count($all_seasons) && $all_seasons[$i]['series'] == $all_seasons[$prev]['series'])
            {
                if($all_seasons[$i]['season'] == (int)$all_seasons[$i]['season'])
                    array_push($series, $all_seasons[$i]);
                $i++;
            }

            $prev = $i;
            $i--;
            if(count($series) > 0)
                array_push($seasons, $series);
        }

        $res = array();
        for($i = 0; $i < count($seasons); $i++)
        {
            $tier = array();
            $prev = 0;
            for($j = 0; $j < count($seasons[$i]); $j++)
            {
                $seq = array();
                while($j < count($seasons[$i]) && $seasons[$i][$j]['tier'] == $seasons[$i][$prev]['tier'])
                {
                    array_push($seq, $seasons[$i][$j]);
                    $j++;
                }

                $prev = $j;
                $j--;
                array_push($tier, $seq);
            }

            $series_n = Series::find($tier[0][0]['series']);
            array_push($res, array("name" => $series_n, "tier" => $tier));
        }

        session(['topBarSeasons' => $res]);
    }
}
