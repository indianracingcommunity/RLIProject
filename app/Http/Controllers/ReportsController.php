<?php

namespace App\Http\Controllers;

use App\Driver;
use Illuminate\Http\Request;
use App\Report;
use Auth;
use App\Season;
use App\Race;

class ReportsController extends Controller
{
    public function view()
    {
        $seasons = Season::where('status', '<', 2)->get()->toArray(); // Get all active seasons
        $report_races = array();  
        foreach($seasons as $i)
        {
            if($i['report_races']!=NULL)
            {
            $arr = explode(',', $i['report_races']);
            for($j=0; $j<count($arr); $j++)
            {
                array_push($report_races,$arr[$j]);        // Array of report_races id's from all seasons
            }
            
            }
        }

        $final = array();
        for($i=0;$i<count($report_races);$i++)
        {
           $races = Race::where('id','=',$report_races[$i])->get()->load(['circuit','season'])->toArray();
        //    dd($races);
           array_push($final,$races[0]);
            
        }
        // dd($final);
        return view('user.createreport')->with('data',$final);
    }

    public function driversdata($tier)
    {
        $drivers = Driver::where('tier',$tier)->get();
        
        return response()->json($drivers);
    }

    public function create()
    {
        $data = request()->all();
        $report = new Report();
        $report -> rid = Auth::user()->id; 
        $report -> reported_by = Auth::user()->name; 
        $report->against=$data['against'];
        $report->track=$data['track'];
     //   $report->inquali=$data['inquali'];
        $report->lap=$data['lap'];
        $report->explained=$data['explained'];
        $report->proof=$data['proof'];
        $report->save();
        return redirect('/home');


    }

    public function category(Report $report)
    {
        
            $report = Report::where('rid','=',Auth::user()->id)
            ->get();
        return view('user.viewreports', compact('report'));
        
    }

    public function details(Report $report)
    {
        return view('user.reportdetails')->with('report',$report);
    }
}
