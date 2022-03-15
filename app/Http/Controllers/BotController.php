<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Driver;
use Illuminate\Support\Facades\Schema;

class BotController extends Controller
{
    public function fetchdetails($query, $discord_id)
    {
        // Check if the column requested exists in the DB or no
        $doesItExist = Schema::hasColumn('users', $query);

        // Columns API is not allowed to access
        $list = ['email','remember_token','location','mothertongue'];

        if (in_array($query, $list)) {
            return response()->json(['message' => 'Forbidden']);
        }
        if ($doesItExist) {
            $data = User::where('discord_id', '=', $discord_id)->first($query);
            return response()->json(['data' => $data[$query]]);
        } else {
            return response()->json(['message' => 'Invalid parameters']);
        }
    }

    public function fetchDriverId($discord_id)
    {
        // Fetch data from the DB
        $data = User::select('id')->where('discord_id', $discord_id)->get()->load('driver')->toArray();
        if (empty($data)) {  // If array is empty return an error response
            return response()->json(['error' => 'Driver ID not found']);
        } else {
            return response()->json(['data' => $data[0]['driver']]);
        }
    }

    public function fetchDrivers()
    {
        $data = Driver::select("id", "user_id")->get()->load('user:id,discord_id,name')->toArray();
        return response()->json($data);
    }
}
