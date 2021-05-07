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

class ReportsController extends Controller
{
    public function view()
    {
        $seasons = Season::where('status', '<', 2)->get()->toArray();   // Get all active seasons
        $report_races = array();  
        foreach($seasons as $i)
        {
            if($i['report_races'] != NULL)
            {
                $arr = explode(',', $i['report_races']);
                for($j = 0; $j < count($arr); $j++)
                {
                    array_push($report_races,$arr[$j]);                 // Array of report_races id's from all seasons
                }
            }
        }

        $races = Race::wherein('id', $report_races)
                        ->get()->load(['circuit','season'])->toArray();

        return view('user.createreport')->with('data', $races);
    }

    public function driversdata($race)
    {
        $result = Result::where('race_id',$race)->get()->load('driver')->toArray();
        $drivers = array();
        for($i=0; $i<count($result); $i++)
        {
            array_push($drivers,$result[$i]['driver']);
        }
          
        return response()->json($drivers);
    }

    public function create()
    {
        $data = request()->all();
        // array_push($data['driver'],'1');       Uncomment this line to test reports with multiple drivers being reported | Will remove this after frontend is done
        for($i = 0; $i < count($data['driver']); $i++)
        {
            $report = new Report();
            $report -> race_id = $data['race'];
            $report -> reporting_driver = Auth::user()->id;
            $report -> reported_against = $data['driver'][$i];
            $report -> lap = $data['lap'];
            $report -> explanation = $data['explained'];
            $report -> proof = $data['proof'];
            $report->save();
        }
        
        // Redirect to View all Reports page
        session()->flash('success',"Report Submitted Successfully");
        return redirect('/home/report/list');
    }

    public function listDriverReports()
    {
        //Search for driver, if not, respond "Need to get a license first child"
        $driver = Driver::where('user_id', Auth::user()->id)->firstOrFail();
        $reports = Report::where('reporting_driver', $driver['id'])
                         ->orwhere('reported_against', $driver['id'])
                         ->orderBy('created_at', 'desc')
                         ->get()
                         ->load(['reporting_driver', 'reported_against', 'race.season', 'race.circuit']);

        return view('user.viewreports')->with('reports', $reports);
    }

    public function category(Report $report)
    {
        
        $report = Report::where('rid', '=', Auth::user()->id)->get();
        return view('user.viewreports', compact('report'));
    }

    public function details(Report $report)
    {
        return view('user.reportdetails')->with('report',$report);
    }
}
