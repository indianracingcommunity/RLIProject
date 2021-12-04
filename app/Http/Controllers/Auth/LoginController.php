<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Socialite;
use App\User;
use App\Discord;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

// Discord Oauth
    public function redirectToProvider()
    {
        return Socialite::driver('discord')->scopes(['identify', 'email', 'guilds', 'connections'])->redirect();
    }
    
     public function handleProviderCallback()
     {
         $userr = Socialite::driver('discord')->user();
        // dd($userr);
         $authUser = $this->findOrCreateUser($userr);
         if($authUser=='false')
         { 
          session()->flash('error','Please join the IRC Discord Server before signing up on the site');
          return redirect('/login');
         }
         else
         {
         Auth::login($authUser, true);
         }

         return redirect()->route('user.home');
     }

     private function findOrCreateUser($userr)
     {
       $discord = new Discord();
       $check = $discord->check($userr);

       if($check == "True")
       {
       $userAccount = User::where('discord_id', $userr->id)->first();
       if($userAccount)
        {
         //  dd($userr->user['discriminator']);
            
           $userAccount->update([
            'name' => $userr->name,
            'avatar' => $userr->avatar,
            'discord_discrim' => $userr->user['discriminator'],
            'discord_id' => $userr->id,
            'email' => $userr->email,
            'password' => null,
           ]);
         return $userAccount;
       }
       
       $newUser = User::create([
        'name' => $userr->name,
        'avatar' => $userr->avatar,
        'discord_discrim' => $userr->user['discriminator'],
        'discord_id' => $userr->id,
        'email' => $userr->email,
        'password' => null,
       ]);
       return $newUser;
     }
     else
     {
       return 'false';
     }
    }
    

}
