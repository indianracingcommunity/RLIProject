<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;
use App\Discord;
use Auth;
use Illuminate\Support\Facades\Schema;
use DB;
class PermissionManager

{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,...$roles) {
        if(Auth::user() &&  Auth::user()->isadmin == 1) {
            return $next($request);
        }
        else{  
        for($i=0;$i<count($roles);$i++) {
            if(Schema::hasColumn('roles',$roles[$i])!=true) {
                session()->flash('error','Route Permission error! Please contact an administrator.');
                return redirect('/'); 
            }   
        }
        
        for($i=0;$i<count($roles);$i++) {
            $getRole = Role::select('role_id')
            ->where($roles[$i], '1')
            ->pluck('role_id')->toArray();
            $check = PermissionManager::checkRole($getRole); 
            if($check == "Verified") {
                return $next($request);
            }
        }  
        session()->flash('error','You cannot view this page!');
            return redirect('/');       
     
            
    }
}



    public function checkRole($roles){
        $discord = new Discord();
        $userArray = $discord->getMemberRoles(Auth::user()->discord_id);
        for($i=0;$i<count($roles);$i++){
            if(in_array($roles[$i],$userArray)){
                return "Verified";
            }
        }
        return "Unverified";
    }
    
}


