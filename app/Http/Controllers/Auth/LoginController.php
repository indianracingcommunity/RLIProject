<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Socialite;
use App\User;

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
    protected $redirectTo = '/home';

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
         $authUser = $this->findOrCreateUser($userr);
         Auth::login($authUser, true);

         return view('home');
     }

     private function findOrCreateUser($userr){
       $userAccount = User::where('discord_id', $userr->id)->first();
       if($userAccount)
       {
         //  dd($userr->user['discriminator']);
           // dd($userr);
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

}
