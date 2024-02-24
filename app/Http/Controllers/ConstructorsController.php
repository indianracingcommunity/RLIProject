<?php

namespace App\Http\Controllers;

use App\Constructor;
use Illuminate\Http\Request;

class ConstructorsController extends Controller
{
    public function index(Request $request)
    {
        $constructors = Constructor::filter($request)
                                   ->selectable($request)
                                   ->get()->toArray();

        return response()->json($constructors);
    }
}
