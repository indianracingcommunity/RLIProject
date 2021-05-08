<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Race;
use App\Season;
use App\Report;
use App\Driver;
use App\Result;
use App\Discord;

class ReportsController extends Controller
{
    public function reportDriver()
    {
        //Check whether a Driver
        $dr = Driver::where('user_id', Auth::user()->id)->first();
        if($dr == null)
        {   
            session()->flash('error', "Need to get a license first child, Please contact a coordinator");
            return redirect('/');
        }

        //Return All Active Seasons which is Reportable
        $seasons = Season::where('status', '<', 2)
                         ->where('reportable', true)
                         ->whereNotNull('report_window')
                         ->get()->toArray();

        //Return Seasons with Report Windows still open
        $seasonlist = array();
        for($k = 0; $k < count($seasons); $k++)
        {
            if(time() > strtotime($seasons[$k]['report_window']))
                continue;

            array_push($seasonlist, $seasons[$k]['id']);
        }

        //Get Max Round of Seasons, i.e. Latest Races
        $race_ids = Race::wherein('season_id', $seasonlist)
                        ->selectRaw('max(round) as round, season_id')
                        ->groupBy('season_id')
                        ->get()->toArray();

        //Get Latest Races
        $races = [];
        if(count($race_ids) > 0)
        {
            //[round AND season_id] OR [round AND season_id] OR ...
            $races = Race::where(function($query) use ($race_ids) {
                for($j = 0; $j < count($race_ids); $j++)
                {
                    $query->orWhere(function($orq) use ($j, $race_ids) {
                        $orq->where('round', $race_ids[$j]['round'])
                            ->where('season_id', $race_ids[$j]['season_id']);
                    });
                }
            });

            $races = $races->get()->load(['circuit','season'])->toArray();
        }

        return view('user.createreport')->with('data', $races);
    }

    public function driversdata($race)
    {
        $result = Result::where('race_id', $race)
                        ->get()->load('driver')
                        ->pluck('driver')->toArray();

        return response()->json($result);
    }

    public function create()
    {
        $data = request()->all();
        $dr = Driver::where('user_id', Auth::user()->id)->firstOrFail();
        $race = Race::where('id', $data['race'])->firstOrFail()->load('season')->toArray();

        // array_push($data['driver'],'1');       Uncomment this line to test reports with multiple drivers being reported | Will remove this after frontend is done
        for($i = 0; $i < count($data['driver']); $i++)
        {
            $report = new Report();
            $report -> race_id = $data['race'];
            $report -> reporting_driver = $dr->id;
            $report -> reported_against = $data['driver'][$i];
            $report -> lap = $data['lap'];
            $report -> explanation = $data['explained'];
            $report -> proof = $data['proof'];
            $report->save();

            //Publish Message in Season's Report Channel
            $userid = Driver::where('id',$data['driver'][$i])->get()->load('user')->toArray();
            $message = "1. <@".$userid[0]['user']['discord_id']."> \n 2. ".$data['lap']."\n 3. ".$data['explained']."\n 4. ".$data['proof'];
            Discord::publishMessage($message, $race['season']['report_channel']); 
        }

        // Redirect to View all Reports page
        session()->flash('success', "Report Submitted Successfully");
        return redirect('/');
    }

    public function update()   // Check this function once the frontend page is done
    {
        $report = Report::findOrFail(request()->report)
                        ->load(['reporting_driver', 'race.season']);

        $rA = $report->toArray();

        //Checks for Update:
        //1. Check if Reporting Driver is the Authenticated User
        //2. Check if Report is already Resolved/Published by Stewards
        //3. Check if Report Update is in Reporting Window
        if($rA['reporting_driver']['user_id'] != Auth::user()->id || $rA['resolved'] > 0 ||
           !($rA['race']['season']['reportable'] && $rA['race']['season']['report_window'] != null
            && time() < strtotime($rA['race']['season']['report_window'])))
        {
            session()->flash('error', "You are not allowed to Update this report");
            return redirect('/');
        }

        $data = request()->all();
        $report -> reported_against = $data['driver'];
        $report -> lap = $data['lap'];
        $report -> explanation = $data['explained'];
        $report -> proof = $data['proof'];
        $report->save();
    }

    public function listDriverReports()
    {
        //Search for driver, if not, respond "Need to get a license first child"
        $driver = Driver::where('user_id', Auth::user()->id)->firstOrFail();
        $reports = Report::where('reporting_driver', $driver['id'])
                         ->orWhere('reported_against', $driver['id'])
                         ->orderBy('created_at', 'desc')
                         ->get()
                         ->load(['reporting_driver', 'reported_against', 'race.season', 'race.circuit']);

        return view('user.viewreports')->with('reports', $reports);
    }

    public function details()
    {
        $report = Report::findOrFail(request()->report)
                        ->load(['reporting_driver', 'reported_against', 'race.season', 'race.circuit'])->toArray();

        if(!($report['reporting_driver']['user_id'] == Auth::user()->id || $report['reported_against']['user_id'] == Auth::user()->id))
        {
            session()->flash('error', "You are not allowed to view this report");
            return redirect('/home/report/list');
        }

        return view('user.reportdetails')->with('report', $report);
    }

    public function delete()
    {
        $report = Report::findOrFail(request()->report)
                        ->load(['reporting_driver', 'reported_against']);

        //Checks for Update:
        //1. Check if Reporting Driver is the Authenticated User
        //2. Check if Report is already Resolved/Published by Stewards
        //3. Check if Report Update is in Reporting Window
        if($rA['reporting_driver']['user_id'] != Auth::user()->id || $rA['resolved'] > 0 ||
           !($rA['race']['season']['reportable'] && $rA['race']['season']['report_window'] != null
            && time() < strtotime($rA['race']['season']['report_window'])))
        {
            session()->flash('error', "You are not allowed to delete this report");
            return redirect('/');
        }

        $report->delete();
        session()->flash('success', "Report deleted successfully");
        return redirect('/');
    }
}
