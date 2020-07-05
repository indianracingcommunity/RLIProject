<?php

// Check if user is in IRC or not 
namespace App;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
class Discord
{

    public static function check($userr)
    {
          
        $params =([
            'access_token' =>$userr->accessTokenResponseBody['access_token'],
             ]);

             $curl = curl_init();

             curl_setopt_array($curl, array(
             CURLOPT_URL => "https://discord.com/api/users/@me/guilds",
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_ENCODING => "",
             CURLOPT_MAXREDIRS => 10,
             CURLOPT_TIMEOUT => 30,
             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
             CURLOPT_CUSTOMREQUEST => "GET",
             CURLOPT_HTTPHEADER => array(
                 'Content-Type: application/json',
                 "Authorization: Bearer ".$params['access_token']
             ),
     ));

     $response = curl_exec($curl);
     $err = curl_error($curl);

     curl_close($curl);

     if ($err) 
            {
                return $err;
            } 
            else
            {
                $final = json_decode($response,true);
                $irc = 533143665921622017;
                $check = 'False';
                for($i = 0; $i < count($final) ; $i++)
                {
                   if($final[$i]['id']==$irc)
                   {
                       $check = 'True';
                   }
                }
                
                  return $check;
            }


    }


    public function getroles()
    {
        $params =([
            'token' => config('services.discord.bot')
             ]);
      // dd($params);
        $curl = curl_init();
        $server = 533143665921622017;
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://discord.com/api/guilds/".$server,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            "Authorization: Bot ".$params['token']
        ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) 
                {
                    return $err;
                } 
                else
                {
                    $final = json_decode($response,true);
                   // dd($final);
                    return $this->checkRoles($final['roles']);
                }
    }

    public static function getMemberRoles()
    {
       
      
        $userdata = Auth::user()->discord_id;
        
        $params =([
            'token' => config('services.discord.bot')
             ]);
      // dd($params);
        $curl = curl_init();
        $server = 533143665921622017;
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://discord.com/api/guilds/".$server."/members/".$userdata,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            "Authorization: Bot ".$params['token']
        ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) 
                {
                    return $err;
                } 
                else
                {
                    $final = json_decode($response,true);
                   // dd($final);
                    if(isset($final['message']))
                    {
                    echo "Invalid Discord ID";
                    }
                    else
                    {
                      return $final['roles'];
                    }
                }

            
    }


    public static function checkRoles($roles)
    {
        $data = Discord::getMemberRoles();
        
        $arr = array();

        //$over=count($roles);
        $crole=0;
        for($i=0 ; $i < count($roles) ; $i++)
        {
            for($j=0 ; $j < count($data) ; $j++)
            {
               if($roles[$i]['id']==$data[$j])
                {
                    
                    array_push($arr,$roles[$i]['name']);
                    
                    
                    //echo $roles[$i]['name']; 
                     $crole++;
                }
               
                
            }
            
        }
       
        $serialize = serialize($arr);
        DB::table('users')
             ->where('id',Auth::user()->id)
             ->update(['discord_roles'=>$serialize]);
        
             return "Done";


    }


}






?>
