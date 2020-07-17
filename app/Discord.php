<?php

// Check if user is in IRC or not 
namespace App;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Log;

class Discord
{
    public static function check($userr)
    {
        $params =(['access_token' => $userr->accessTokenResponseBody['access_token'],]);

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
            for($i = 0; $i < count($final); $i++)
            {
               if($final[$i]['id'] == $irc)
               {
                   $check = 'True';
               }
            }
            return $check;
        }
    }

    public function getroles($id)
    {
        $params =(['token' => config('services.discord.bot')]);

        $curl = curl_init();
        $server = 533143665921622017;
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://discord.com/api/guilds/".$server."/roles",
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
            $final = json_decode($response, true);
            return $this->checkRoles($final, $id);
        }
    }

    public static function checkRoles($roles, $id)
    {
        $data = Discord::getMemberRoles($id);
        if($data != "Invalid")
        {
            $arr = array();

            $crole = 0;
            for($i = 0; $i < count($roles); $i++)
            {
                for($j = 0; $j < count($data); $j++)
                {
                    if($roles[$i]['id'] == $data[$j])
                    {
                        array_push($arr, ['name' => $roles[$i]['name'],
                                          'color' => dechex($roles[$i]['color'])]);
                        $crole++;
                    }
                }
            }
            return $arr;
        }
        else
        {
            return "Error Fetching Roles";
        }
    }

    public static function getMemberRoles($id)
    {
        $userdata = $id;
        $params =(['token' => config('services.discord.bot')]);

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
                "Authorization: Bot " . $params['token']
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
            if(isset($final['message']))
            {
                return "Invalid";
            }
            else
            {
              return $final['roles'];
            }
        }
    }

    public function removeApplicantRole($id, $applicantrole)
    {
        $params = (['token' => config('services.discord.bot')]);

        $curl = curl_init();
        $server = 533143665921622017; //irc
        curl_setopt_array($curl, array(
            CURLOPT_URL => "/".$server."/members/".$id."/roles/".$applicantrole,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
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
            if(isset($final['message']))
            {
                return "Invalid";
            }
            else
            {
              return $response;
            }
        }
    }

    public function addroles($roles, $id)
    {
        $params = (['token' => config('services.discord.bot')]);
        $applicantrole = 731215351416750130;

        $data = $this->getMemberRoles($id);
        if(in_array($applicantrole, $data))
        {
            $var =  $this->removeApplicantRole($id, $applicantrole);
            if($var == "Invalid")
            {
                return "Error Removing applicant role";
            }
        }
    
        if(!empty($roles))
        {
            foreach($roles as $value)
            {
                sleep(1);
                $curl = curl_init();
                $server = 533143665921622017; //irc 
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://discord.com/api/guilds/".$server."/members/".$id."/roles/".$value,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Content-Length: 0',
                "Authorization: Bot ".$params['token']
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
            }

            if ($err)
            {
                return $err;
            }
            else
            {
                $final = json_decode($response,true);
                return $response;

                if(isset($final['message']))
                {
                    return "Invalid";
                }
                else
                {
                    return $final;
                }
            }
        }
    }
}
?>
