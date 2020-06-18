<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignupsController extends Controller 
{
    public function view()
    {
      return view('signup.home');
    }

    public function store()
    {
        $data = request()->all();
        $sigunup = new Signup();
        $signup->user_id = Auth::user()->id;
        $signup->speedtest = $data['speedtest'];
        $signup->timetrial1 = $data['timetrial1'];
        $signup->timetrial2 = $data['timetrial2'];
        $signup->timetrial3 = $data['timetrial3'];
        $signup->ttevidence1 = $data['ttevidence1'];
        $signup->ttevidence2 = $data['ttevidence2'];
        $signup->ttevidence3 = $data['ttevidence3'];
        $signup->carprefrence = $data['carprefrence'];
        $signup->attendance = $data['attendance'];
        $signup->save();
        return redirect('/home');
    }

    public function test(Request $request)
    {
       dd($request);
    }



}
