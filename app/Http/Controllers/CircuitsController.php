<?php

namespace App\Http\Controllers;

use App\Circuit;
use Illuminate\Http\Request;

class CircuitsController extends Controller
{
    public function index(Request $request)
    {
        $circuits = Circuit::filter($request)
                           ->selectable($request)
                           ->get()->toArray();

        return response()->json($circuits);
    }
}
