<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Schema;

class BotController extends Controller
{
    public function fetchdetails($query,$id)
    {
        // Check if the column requested exisits in the DB or no 
        $doesitexisit = Schema::hasColumn('users',$query);
        
        // Columns API is not allowed to access 
        $list =['email','remember_token','location','mothertongue']; 
 
        if(in_array($query,$list))
        { 
            return response()->json(['message'=>'Forbidden']);
        }
        if($doesitexisit)
        {
           $data = User::where('discord_id','=',$id)->first($query);
           return response()->json(['data'=>$data[$query]]);      
        }
        else
        {
           return response()->json(['message'=>'Invalid parameters']);
        }
    
    }

    public function fetchDriverId($id)
    {
        // Fetch data from the DB
        $data = User::select('id')->where('discord_id',$id)->get()->load('driver')->toArray();
        if(empty($data))  // If array is empty return an error response
        {
            return response()->json(['error'=>'Driver ID not found']);
        }
        else
        {
            return response()->json(['data'=>$data[0]['driver']]);
        }
        
    }

}
