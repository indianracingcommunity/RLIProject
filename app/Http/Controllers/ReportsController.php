<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use Auth;

class ReportsController extends Controller
{
    public function view()
    {
        return view('user.createreport');
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
