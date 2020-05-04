<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Driver;
use App\Result;

class StandingsController extends Controller
{
      public function fetchDrivers()
      {
          $query = Driver::all();
          return $query;
      }

      public function fetchCircuit()
      {
          $query = Circuit::all();
          return $query;
      }

      public function storeResults(Request $request)
      {
            $result = new Result();
            $result->race_id = $request['race_id'];
            $result->constructor_id = $request['constructor_id'];
            $result->driver_id = $request['driver_id'];
            $result->grid = $request['grid'];
            $result->points = $request['points'];
            $result->fastestlap = $request['fastestlap'];
            $result->fastestlaptime = $request['fastestlaptime'];
            $result->tyres = $request['tyres'];
            $result->position = $request['position'];
            $result->save();

            return redirect('/');
      }
}
