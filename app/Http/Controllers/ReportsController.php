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
            $userid = Driver::where('id', $data['driver'][$i])->get()->load('user')->toArray();
            Discord::publishMessage($this->reportMessage(Auth::user()->discord_id, $userid[0]['user']['discord_id'], $data), $race['season']['report_channel']);
        }

        // Redirect to View all Reports page
        session()->flash('success', "Report Submitted Successfully");
        return redirect('/');
    }

    public function publishReports()
    {
        //Requires Season
        $racelist = Race::where('season_id', request()->season)->pluck('id')->toArray();

        if(count($racelist) == 0)
            return abort(404);          //Actually should post 400 Error

        //Taking in season instead of Race, in case of Backlog
        $reports = Report::wherein('race_id', $racelist)
                         ->where('resolved', 2)
                         ->orderBy('race_id', 'asc')
                         ->orderBy('lap', 'asc')
                         ->get()
                         ->load(['reporting_driver.user', 'reported_against.user', 'race.season']);

        $prev_race_id = -1;
        for($i = 0; $i < count($reports); $i++)
        {
            //Apply Verdict
                //Find Result
                //Update Result status
                //Update Result Time (many conditions)

            //Update Resolved to 3
            $reports[$i]->resolved = 3;
            $reports[$i]->save();

            //Publish Splitter Message
            if($prev_race_id != $reports[$i]->race->id)
            {
                $splitter_message = " **-----------------------------**\n       Round " . $reports[$i]->race->round . " Reports\n **-----------------------------**";
                Discord::publishMessage($splitter_message, $season->verdict_channel);
            }

            //Publish Verdict Message
            Discord::publishMessage($this->verdictMessage($reports[$i]), $season->verdict_channel);

            $prev_race_id = $reports[$i]->race_id;
        }

        //Season reportable = 0
        $season = Season::where('id', request()->season)->firstOrFail();
        $season->reportable = 0;
        $season->save();
    }

    private function reportMessage($idfor, $idagainst, $data)
    {
        $message = "1. Reporting Driver: <@". $idfor ."> \n2. Against: <@";
        $message .= $idagainst . "> \n3. ";

        //Lap
        if($report->lap == -1)
            $message .= "In Quali";
        else if($report->lap == 0)
            $message .= "Formation Lap";
        else
            $message .= "Lap " . $data['lap'];

        $message .= "\n4. Explanation: " . $data['explained'];
        $message .= "\n5. Prood: " . $data['proof'];
        $message .= "\n-----------------------------";

        return $message;
    }

    //Assume loaded reporting_driver, reported_against, race.season
    private function verdictMessage(Report $report)
    {
        //Driver
        $message = "1. Driver: <@" . $report->reporting_driver->user->id . "> \n2. ";

        //Lap
        if($report->lap == -1)
            $message .= "In Quali";
        else if($report->lap == 0)
            $message .= "Formation Lap";
        else
            $message .= "Lap " . $report->lap;

        $message .= "\n3. Verdict: **";

        //Verdict Time
        if($report->verdict_time == 0 && $report->verdict_pp == 0)
            $message .= "NFA";
        if($report->verdict_time > 0)
            $message .= $report->verdict_time . " seconds Time Penalty ";
        else if($report->verdict_time < 0)
            $message .= $report->verdict_time . " seconds Removed";

        //Verdict PP
        if($report->verdict_time != 0 && $report->verdict_pp != 0)
            $message .= " + ";
        if($report->verdict_pp != 0)
        {
            $penalties = round((abs($report->verdict_pp) - (int)abs($report->verdict_pp)) * 10, 2);

            //Penalty Points
            if((int)$penalties != 0)
                $message .= (int)$penalties . " Penalty Points";

            //Warning
            if((int)$penalties != 0 && $penalties != (int)$penalties)
                $message .= " + Warning";
            else if($penalties != (int)$penalties)
                $message .= "Warning";
        }

        $message .= "**\n4. Evidence: " . $report->proof;

        //Explanation
        if($report->verdict_message != null)
            $message .= "\n5. Explanation: " . $report->verdict_message;

        return $message;
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

        //Update Posted Message

        session()->flash('success', "Report updated successfully");
        return redirect('/');
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

        //Delete Posted Message

        session()->flash('success', "Report deleted successfully");
        return redirect('/');
    }
}
