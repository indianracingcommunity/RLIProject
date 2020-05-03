<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Driver;

class StandingsController extends Controller
{
      public function fetchDrivers()
      {
          $query = Driver::all();
          return $query;
      }
}
