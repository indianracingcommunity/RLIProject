<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebsiteController extends Controller
{
    public function loadhomepage(){
    	return view('welcome');
    }

    public function loadjoinus(){
    	return view('joinus');
    }

     public function loadteamsanddrivers(){
    	return view('teamsanddrivers');
    }

     public function loadstandings(){
    	return view('standings');
    }

     public function loadaboutus(){
    	return view('aboutus');
    }

     public function loadfaq(){
        return view('faq');
    }

     public function loadlogin(){
    	return view('login');
    }
}
