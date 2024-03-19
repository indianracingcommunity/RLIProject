@extends('layouts.app')
@section('content')
@php
    $platform = isset(Auth::user()->platform) ? unserialize(Auth::user()->platform) : NULL;
    $games = isset(Auth::user()->games) ? unserialize(Auth::user()->games) : NULL;
    $device = isset(Auth::user()->device) ? unserialize(Auth::user()->device) : NULL;
    if(isset(Auth::user()->location))
    {
        $data = Auth::user()->location;
        $arr = explode('~', $data);
        if(count($arr)>1){
            $city = $arr[0];
            $state = $arr[1];
        }else{
            $city = $arr[0];
            $state = '';
        }
    }
    else{
        $city = ""; $state="";
    }
@endphp

<style type="text/css">
    .errormsg{
        color: red;
        display: none;
    }
    .disabled{
        background: grey;
    }
    .disabled:hover {
        background-color: grey;
    }
    .steam {
        color: #ffffff;
        background-color: #1f3d7a;
    }
    .steam:hover {
        color: #ffffff;
        background-color: #1a202c;
    }
</style>

<div class="flex flex-col items-center xl:items-start justify-center gap-8 xl:gap-6 p-5 md:px-10 xl:px-14">
    <div class="flex flex-row items-start md:items-center justify-center gap-1 text-sm font-semibold text-orange-800 bg-orange-200 p-3 w-full rounded-md profileAlert" style="display:none">
        <i class="fa fa-exclamation-circle my-1 md:my-0" aria-hidden="true"></i>
        <p>Welcome to <strong>Indian Racing Community!</strong> Please complete your profile.</p>
    </div>

    @if(SESSION('savedProfile'))
    <div class="font-semibold text-center text-sm text-green-800 bg-blue-100 py-3 rounded-md w-full">
        <i class="fa fa-check-circle" aria-hidden="true"></i> {{session('savedProfile')}}
        @php Session::forget('savedProfile'); @endphp
    </div>
    @endif

    @if(SESSION('steamSuccess'))
    <div class="font-semibold text-center text-sm text-green-800 bg-blue-100 py-3 rounded-md w-full">
        <i class="fa fa-check-circle" aria-hidden="true"></i> {{session('steamSuccess')}}
        @php Session::forget('steamSuccess'); @endphp
    </div>
    @endif

    <!-- <div class="text-center md:text-left text-4xl xl:px-2 font-bold text-gray-900">User Profile</div> -->

    <div id="userDetails" class="flex flex-col lg:flex-row items-center xl:items-start justify-center p-4 rounded-md border gap-2 lg:gap-8 w-full">
        <div class="my-auto">
            <img src="{{Auth::user()->avatar}}" class="rounded-md w-24" alt="Profile picture">
        </div>

        <div class="flex flex-col items-center lg:items-start justify-center gap-1 xl:my-auto">
            <div class="font-bold text-gray-800 text-3xl tracking-tight break-all">{{Auth::user()->name}}</div>

            <div class="flex flex-row gap-2 mb-1">
                @if($platform != NULL)
                    @foreach ($platform as $value)
                        <div class="border-2 border-gray-800 rounded font-semibold px-2">
                            {{$value}}
                        </div>
                    @endforeach
                @endif
            </div>

        </div>

        <div class="hidden lg:flex border border-gray-600 h-8 my-auto"></div>
    </div>

    <div class="flex flex-col xl:flex-row gap-8 xl:gap-6 w-full">
        <div class="flex flex-col gap-5 xl:w-1/3">
            <div class="flex flex-col items-start justify-center bg-gray-800 rounded-md py-2 px-4">
                <div class="flex items-center justify-center gap-2 font-bold xl:text-lg text-white tracking-wide text-sm border-b pb-2 uppercase w-full">
                    <i class="fab fa-discord text-gray-100"></i>
                    user roles
                </div>
    
                <div class="flex flex-row gap-1 flex-wrap font-semibold text-sm pt-3 pb-1">
                    @if(is_array($roles))
                        @for ($i= 0; $i < count($roles); $i++)
                            @php
                                $color = str_pad($roles[$i]['color'], 6, "0", STR_PAD_LEFT);
                            @endphp
    
                            <div class="px-2 border rounded-full border-600 text-gray-300" style="border-color:#{{$color}};">
                                <i class="fas fa-circle mr-1 text-500" style="color:#{{$color}}"></i>
                                {{$roles[$i]['name']}} 
                            </div>
    
                        @endfor
                    @else
                        <!-- {{$roles}} -->
                    @endif
                </div>
            </div>
    
            @csrf
            @if (Auth::user()->steam_id == NULL)
            <form class="flex flex-col items-center justify-center px-4 py-2 rounded-md border border-red-600 gap-6" method="POST" @if ("{{Auth::user()->mothertongue}}" != "") action="setsteam/{{Auth::user()->id}}" @endif>
                    <span class="flex justify-center gap-2 font-semibold text-red-600 tracking-wide text-sm border-b border-red-600 pb-2 uppercase w-full">
                        steam profile link
                    </span>
    
                    <a class="py-2 flex flex-row items-center justify-center gap-2 rounded-md steam w-1/2" @if ("{{Auth::user()->mothertongue}}" != "") href="/login/steam" @endif> 
                        <i class="fab fa-steam"></i>
                        Link steam
                    </a>
                    
                    <ul class="flex flex-col items-start justify-center gap-2 list-disc list-inside">
                        <li class="text-sm font-bold text-gray-900">Mandatory for PC Users.</li>
        
                        <li class="text-sm font-semibold text-gray-700">Roles related to PC will be alloted only after your steam profile has been linked.</li>
        
                        @if (!isset(Auth::user()->mothertongue))
                            <li class="text-sm font-semibold text-red-600">Steam Account can only be linked after you complete your profile.</p>
                        @endif
                    </ul>
                @endif
            </form>
        </div>

        <form action="{{route('user.saveprofile', ['user' => Auth::user()->id])}}" method="POST" id="submitProfileForm" class="w-full">
            @csrf
            <div class="flex flex-col md:flex-row gap-5">
                <div class="md:w-1/2 flex flex-col items-center justify-start px-5 py-2 rounded-md border gap-6">
                    <div class="flex items-center justify-center gap-2 font-bold xl:text-lg text-gray-600 tracking-wide text-sm border-b pb-2 uppercase w-full">
                        <i class="far fa-edit"></i>
                        Personal details
                    </div>

                    <div class="flex flex-col items-center justify-center gap-2">
                        <label for="Nationality" class="font-semibold text-gray-800">
                            Are you an Indian?
                            <span class="text-red-600">●</span>
                        </label>

                        <div class="flex flex-row items-center justify-center gap-4">
                            <div class="flex flex-row items-center justify-center gap-1">
                                <input type="radio" id="Yes" name="Nationality" class="nationalityOption cursor-pointer" value="Yes" @if ("{{Auth::user()->mothertongue}}" != "") checked @endif>
                                <label for="male">Yes</label>
                            </div>

                            <div class="flex flex-row items-center justify-center gap-1">
                                <input type="radio" id="No" name="Nationality" class="nationalityOption cursor-pointer" value="No">
                                <label for="female">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-start justify-center gap-1 w-full">
                        <label for="MotherToungue" class="font-semibold text-gray-800">
                            What is your mother tongue?
                            <span class="text-red-600">●</span>
                        </label>
                        
                        <div class="flex flex-col items-start justify-center w-full">
                            <input maxlength="30" type="text" class="border text-gray-700 shadow-inner px-2 py-1 w-full mandatory rounded border-gray-700" placeholder="Hindi/Bengali/Tamil" name="mothertongue" value="{{Auth::user()->mothertongue}}">
    
                            <span class="errormsg errormsgMothTon text-sm px-1">Please enter your mother tongue.</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-1 w-full">
                        <label for="City" class="font-semibold text-gray-800">
                            City
                        </label>
                        
                        <div class="flex flex-col items-start justify-center w-full">
                            <input maxlength="30" type="text" name="city" class="border text-gray-700 shadow-inner px-2 py-1 w-full rounded border-gray-700  tildeNotValid" placeholder="Kolkata" value="{{$city}}">
    
                            <span class="errormsg errormsgCity text-sm px-1">Please enter your city.</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-1 w-full">
                        <label for="State" class="font-semibold text-gray-800">
                            State/Country
                            <span class="text-red-600">●</span>
                        </label>
                        
                        <div class="flex flex-col items-start justify-center w-full">
                            <input maxlength="30" type="text" name="state" class="border text-gray-700 shadow-inner px-2 py-1 w-full mandatory rounded border-gray-700 tildeNotValid" placeholder="West Bengal" value="{{$state}}">
    
                            <span class="errormsg errormsgState text-sm px-1">Please enter your state.</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-1 w-full">
                        <label for="State" class="font-semibold text-gray-800">
                            Which motorsports do you follow?
                            <span class="text-red-600">●</span>
                            <i class="fas fa-globe-americas text-gray-600"></i>
                        </label>
                        
                        <div class="flex flex-col items-start justify-center w-full">
                            <input maxlength="100" type="text" name="motorsport" class="border text-gray-700 shadow-inner px-2 py-1 w-full mandatory rounded border-gray-700" placeholder="F1/WEC/MotoGP" value="{{Auth::user()->motorsport}}">
    
                            <span class="errormsg errormsgMotersports text-sm px-1">Please enter required details.</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-1 w-full">
                        <label for="State" class="font-semibold text-gray-800">
                            Which driver do you support?
                            <span class="text-red-600">●</span>
                            <i class="fas fa-globe-americas text-gray-600"></i>
                        </label>
                        
                        <div class="flex flex-col items-start justify-center w-full">
                            <input maxlength="100" type="text" name="driversupport" class="border text-gray-700 shadow-inner px-2 py-1 w-full mandatory rounded border-gray-700" placeholder="Lando Norris" value="{{Auth::user()->driversupport}}">
    
                            <span class="errormsg errormsgDriver text-sm px-1">Please enter required details.</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-1 w-full">
                        <label for="State" class="font-semibold text-gray-800">
                            Where did you hear about IRC?
                            <span class="text-red-600">●</span>
                        </label>
                        
                        <div class="flex flex-col items-start justify-center w-full">
                            <input maxlength="100" type="text" name="source" class="border text-gray-700 shadow-inner px-2 py-1 w-full mandatory rounded border-gray-700" placeholder="Youtube/Twitter/Reddit/Discord" value="{{Auth::user()->source}}">
    
                            <span class="errormsg errormsgIrc text-sm px-1">Please enter required details.</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-1 w-full">
                        <label for="psn" class="font-semibold text-gray-800">
                            <i class="fab fa-playstation text-blue-700"></i>
                            PSN ID
                            <i class="fas fa-globe-americas text-gray-600"></i>
                            (Mandatory for PS users)
                        </label>
                        
                        <div class="flex flex-col items-start justify-center w-full">
                            <input maxlength="40" type="text" id="psInp" name="psn" class="border text-gray-700 shadow-inner px-2 py-1 w-full rounded border-gray-700 playstLink" placeholder="Username" value='@if(isset(Auth::user()->psn)) {{Auth::user()->psn}} @endif'>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-1 w-full">
                        <label for="xbox" class="font-semibold text-gray-800">
                            <i class="fab fa-xbox text-green-500"></i>
                            XBOX ID
                            <i class="fas fa-globe-americas text-gray-600"></i>
                            (Mandatory for XBOX users)
                        </label>
                        
                        <div class="flex flex-col items-start justify-center w-full">
                            <input maxlength="40" type="text" id="xboxIp" name="xbox" class="border text-gray-700 shadow-inner px-2 py-1 w-full rounded border-gray-700 xboxLink" placeholder="Username" value='@if(isset(Auth::user()->xbox)) {{Auth::user()->xbox}} @endif'>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-1 w-full">
                        <label for="youtube" class="font-semibold text-gray-800">
                            <i class="fab fa-youtube text-red-500"></i>
                            Youtube
                            <i class="fas fa-globe-americas text-gray-600"></i>
                        </label>
                        
                        <div class="flex flex-col items-start justify-center w-full">
                            <input type="text" name="youtube" placeholder="https://www.youtube.com/xyz" class="border text-gray-700 shadow-inner px-2 py-1 w-full rounded border-gray-700 youtubeLink" value='@if(isset(Auth::user()->youtube)) {{Auth::user()->youtube}} @endif'>
                            
                            <span class="errormsg text-sm px-1">Enter a valid link</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-1 w-full">
                        <label for="instagram" class="font-semibold text-gray-800">
                            <i class="fab fa-instagram text-pink-700"></i>
                            Instagram
                            <i class="fas fa-globe-americas text-gray-600"></i>
                        </label>

                        <div class="flex flex-col items-start justify-center w-full">
                            <input maxlength="100" type="text" name="instagram" placeholder="https://www.instagram.com/xyz" class="border text-gray-700 shadow-inner px-2 py-1 w-full rounded border-gray-700 instaLink" value='@if(isset(Auth::user()->instagram)) {{Auth::user()->instagram}} @endif'>

                            <span class="errormsg text-sm px-1">Enter a valid link</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-1 w-full">
                        <label for="twitch" class="font-semibold text-gray-800">
                            <i class="fab fa-twitch text-purple-700"></i>
                            Twitch
                            <i class="fas fa-globe-americas text-gray-600"></i>
                        </label>

                        <div class="flex flex-col items-start justify-center w-full">
                            <input maxlength="100" type="text" name="twitch" placeholder="https://www.twitch.tv/xyz" class="border text-gray-700 shadow-inner px-2 py-1 w-full rounded border-gray-700 twitchLink" value='@if(isset(Auth::user()->twitch)) {{Auth::user()->twitch}} @endif'>
                            
                            <span class="errormsg text-sm px-1">Enter a valid link</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-1 w-full">
                        <label for="twitter" class="font-semibold text-gray-800">
                            <i class="fab fa-twitter text-blue-500"></i>
                            Twitter
                            <i class="fas fa-globe-americas text-gray-600"></i>
                        </label>
                        
                        <div class="flex flex-col items-start justify-center w-full">
                            <input maxlength="100" type="text" name="twitter" placeholder="https://www.twitter.com/xyz" class="border text-gray-700 shadow-inner px-2 py-1 w-full rounded border-gray-700 twitterLink" value='@if(isset(Auth::user()->twitter)) {{Auth::user()->twitter}} @endif'>

                            <span class="errormsg text-sm px-1">Enter a valid link</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-1 pb-2 w-full">
                        <label for="reddit" class="font-semibold text-gray-800">
                            <i class="fab fa-reddit" style="color: #ff581a"></i>
                            Reddit
                            <i class="fas fa-globe-americas text-gray-600"></i>
                        </label>
                        
                        <div class="flex flex-col items-start justify-center w-full">
                            <input maxlength="100" type="text" name="reddit" placeholder="https://www.reddit.com/user/xyz" class="border text-gray-700 shadow-inner px-2 py-1 w-full rounded border-gray-700 redditLink" value='@if(isset(Auth::user()->reddit)) {{Auth::user()->reddit}} @endif'>
                            
                            <span class="errormsg text-sm px-1">Enter a valid link</span>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/2 flex flex-col items-center justify-start px-5 py-2 pb-4 rounded-md border gap-4 mb-auto">
                    <div class="flex items-center justify-center gap-2 font-bold xl:text-lg text-gray-600 tracking-wide text-sm border-b pb-2 uppercase w-full">
                        <i class="fas fa-gamepad"></i>
                        gamer profile
                    </div>

                    <label class="flex flex-row gap-1 items-center justify-center cursor-pointer">
                        <input type="checkbox" class="cursor-pointer" required id="playgameid" name="playgame" value="playsgame" @if ($games != NULL) checked @endif>

                        <span for="games" class="flex flex-row items-center justify-center gap-1 font-semibold text-gray-800">
                            I play racing games
                            <span class="text-red-600">●</span>
                        </span>
                    </label>

                    <div id="restfieldsid" class="flex flex-col gap-10 mt-6">
                        <div class="flex flex-col items-center justify-center gap-3 w-full text-center">
                            <label for="games" class="font-semibold text-gray-800">
                                Which games do you Play?
                                <span class="text-red-600">●</span>
                                <i class="fas fa-globe-americas text-gray-600"></i>
                            </label>
                            
                            <div class="flex flex-col items-center justify-center w-full gap-2">
                                <div class="flex flex-row items-center justify-center flex-wrap gap-3">
                                    @foreach($series as $gameList)
                                        <label class="flex flex-row items-center justify-center gap-1 px-2 py-1 rounded bg-gray-200 cursor-pointer">
                                            <input class="gameList cursor-pointer" type="checkbox" id="gameid" name="game[]" value="{{$gameList->code}}" @if($games!=NULL) @if (in_array($gameList->code, $games)) checked @endif @endif>
                                            
                                            <span for="games">{{$gameList->name}}</span>
                                        </label>
                                    @endforeach
                                </div>
                                
                                <span class="errormsg errormsgGame text-sm text-center">Please select atleast 1 game</span>
                            </div>
                        </div>

                        <div class="flex flex-col items-center justify-center gap-3 w-full text-center">
                            <label for="games" class="font-semibold text-gray-800">
                                Which platform do you play on?
                                <span class="text-red-600">●</span>
                                <i class="fas fa-globe-americas text-gray-600"></i>
                            </label>

                            <div class="flex flex-col items-center justify-center w-full gap-2">
                                <div class="flex flex-row items-center justify-center flex-wrap gap-3">
                                    <label class="flex flex-row items-center justify-center gap-1 px-2 py-1 rounded bg-gray-200 cursor-pointer">
                                        <input class="platformList cursor-pointer" type="checkbox" id="vehicle1" name="platform[]" value="PC" @if($platform!=NULL) @if (in_array("PC", $platform)) checked @endif @endif>

                                        <span for="games">PC</span>
                                    </label>

                                    <label class="flex flex-row items-center justify-center gap-1 px-2 py-1 rounded bg-gray-200 cursor-pointer">
                                        <input class="platformList cursor-pointer" type="checkbox" id="vehicle1" name="platform[]" value="PlayStation" @if($platform!=NULL) @if (in_array("PlayStation", $platform)) checked @endif @endif>
                                        
                                        <span for="games">PlayStation</span>
                                    </label>

                                    <label class="flex flex-row items-center justify-center gap-1 px-2 py-1 rounded bg-gray-200 cursor-pointer">
                                        <input class="platformList cursor-pointer" type="checkbox" id="vehicle1" name="platform[]" value="Xbox" @if($platform!=NULL) @if (in_array("Xbox", $platform)) checked @endif @endif>

                                        <span for="games">Xbox</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-center justify-center gap-3 w-full text-center">
                            <label for="games" class="font-semibold text-gray-800">
                                What device do you use to play games?
                                <span class="text-red-600">●</span>
                                <i class="fas fa-globe-americas text-gray-600"></i>
                            </label>

                            <div class="flex flex-col items-center justify-center w-full gap-2">
                                <div class="flex flex-row items-center justify-center flex-wrap gap-3">
                                    <label class="flex flex-row items-center justify-center gap-1 px-2 py-1 rounded bg-gray-200 cursor-pointer">
                                        <input class="deviceList cursor-pointer" type="checkbox" id="vehicle1" name="device[]" value="Keyboard/Mouse" @if($device!=NULL) @if (in_array("Keyboard/Mouse", $device)) checked @endif @endif>

                                        <span for="games">Keyboard/Mouse</span>
                                    </label>

                                    <label class="flex flex-row items-center justify-center gap-1 px-2 py-1 rounded bg-gray-200 cursor-pointer">
                                        <input class="deviceList cursor-pointer" type="checkbox" id="vehicle1" name="device[]" value="Controller" @if($device!=NULL) @if (in_array("Controller", $device)) checked @endif @endif>

                                        <span for="games">Controller</span>
                                    </label>

                                    <label class="flex flex-row items-center justify-center gap-1 px-2 py-1 rounded bg-gray-200 cursor-pointer">
                                        <input class="deviceList cursor-pointer" type="checkbox" id="vehicle1" name="device[]" value="Wheel" @if($device!=NULL)  @if (in_array("Wheel", $device)) checked @endif @endif>

                                        <span for="games">Wheel</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-start justify-center gap-1 w-full">
                            <label for="State" class="font-semibold text-gray-800">
                                What is your device name?
                                <span class="text-red-600">●</span>
                                <i class="fas fa-globe-americas text-gray-600"></i>
                            </label>

                            <div class="flex flex-col items-start justify-center w-full">
                                <input maxlength="100" type="text" name="devicename" id="deviceName" class="border text-gray-700 shadow-inner px-2 py-1 w-full rounded border-gray-700" placeholder="Fanatec/T300/G29/XBOX controller" value="{{Auth::user()->devicename}}">

                                <span class="errormsg errormsgDeviceName text-sm px-1">Please enter device details.</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-start justify-center gap-8 mt-4 w-full">
                        <div class="flex flex-col items-start justify-center gap-1">
                            <div class="font-semibold text-gray-700 text-center">
                                <span class="text-red-600 mx-1">●</span>
                                Mandatory Fields
                            </div>
    
                            <div class="font-semibold text-gray-700 text-center">
                                <i class="fas fa-globe-americas text-gray-600"></i>
                                Publicly visible fields
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-center justify-center gap-2 pt-4">
                        <button type="button" id="enabledbuttonid" class="bg-purple-500 rounded text-white font-semibold px-8 py-2 hover:bg-purple-800" style="display: block;">Submit</button>

                        <span class="errormsg errormsgSubmit text-sm">You need to be an Indian to fill this Form.</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center bg-black bg-opacity-50 hidden fixed inset-0 justify-center items-start w-screen" id="overlay">
                <div class="bg-gray-200 rounded-md w-3/4 sm:w-auto py-2 px-3 shadow-xl md:mb-48">
                    <div class="flex justify-between items-center border-b border-gray-400">
                        <h4 class="p-2 text-lg md:text-xl lg:text-2xl font-bold">One final step...</h4>
                        <svg id="cross" class=" w-6 h-7 cursor-pointer hover:bg-gray-400 rounded-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="close-modal"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <div>
                        <p class="text-center text-red-600 text-md md:text-lg lg:text-xl font-bold pt-3 pb-1">Link your gaming accounts</p>
                    </div>
                    <div class="flex justify-center pt-3 pb-6 gap-6">
                        <button id="steamPopup" type="button" class="hidden py-2 bg-black rounded-md">
                            <a @if ("{{Auth::user()->mothertongue}}" != "") href="/login/steam" @endif> 
                                <i class="px-3 fab fa-steam fa-2x text-white" alt=""></i> 
                            </a>
                        </button>
                        <button id="xboxPopup" type="button" class="hidden py-2 bg-green-500 rounded-md">
                            <i class="px-3 fab fa-xbox fa-2x text-white"></i>
                        </button>
                        <button id="psPopup" type="button" class="hidden py-2 bg-blue-600 rounded-md">
                            <i class="px-3 fab fa-playstation fa-2x text-white"></i>
                        </button>
                    </div>
                    <div id="xboxPopupEntry" class="hidden content-center flex-col justify-center md:w-2/3 bg-green-500 rounded-md p-3 mx-auto">
                        <div>
                            <label for="xbox" class="text-white"><i class="fab fa-xbox mr-1 text-white shadow-xl"></i>XBOX ID</label>
                        </div>
                        <div class="flex flex-col items-center">
                            <input maxlength="40" type="text" id="xboxPopupInp" name="xbox" placeholder="Username" class="shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700 xboxLink" value="{{Auth::user()->xbox}}">
                            <button type="button" id="submitXboxPopup" class="text-sm flex items-center justify-center content-center w-1/4 mt-3 bg-white rounded text-green-500 font-semibold hover:bg-green-800 hover:text-white shadow-xl" style="display: block;">Submit</button>
                        </div>
                    </div>
                    <div id="psPopupEntry" class="hidden content-center flex-col justify-center md:w-2/3 bg-blue-600 rounded-md p-3 mx-auto">
                        <div>
                            <label for="psn" class="text-white"><i class="fab fa-playstation text-white mr-1 shadow-xl"></i></i>PSN ID</label>
                        </div>
                        <div class="flex flex-col items-center">
                            <input maxlength="40" type="text" id="psPopupInp" name="psn" placeholder="Username" class="shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700 playstLink" value="{{Auth::user()->psn}}">
                            <button type="button" id="submitPsPopup" class="text-sm flex items-center justify-center content-center w-1/4 mt-3 bg-white rounded text-blue-600 font-semibold hover:bg-blue-800 hover:text-white shadow-xl" style="display: block;">Submit</button>
                        </div>
                    </div>
                    <div id="errorPopup" class="hidden text-center text-red-600 text-sm lg:text-md font-semibold mt-1 mb-3">
                        <span class="mb-2">Please enter required details.</span>
                    </div>
                        <div id="marginDiv" class="hidden mb-6">
                    </div>
                    <div class="border-t border-gray-400 p-2">
                        <p class="text-sm font-bold">Why do I need to do this?</p>
                        <p class="text-sm text-gray-800">Discord roles related to platform will be alloted only after your gaming profiles have been linked.</p>
                    </div>
                </div>
            </div>
        </form>
    </div>    
</div>

<script>
    var games = <?php echo json_encode($games); ?>;
    var platform = <?php echo json_encode($platform); ?>;
    var device = <?php echo json_encode($device); ?>;
    var accounts = <?php echo json_encode($accounts); ?>;
    $( document ).ready(function() {
        $('#restfieldsid').hide();
        $('.tildeNotValid').keydown(function(event) {
            var keyCode = (event.which) ? event.which : event.keyCode;
            if(keyCode == 192){
                return false;
            }
        });
        $('.youtubeLink').change(function(event) {
            $(this).siblings(".errormsg").hide();
            var linkCheck = new RegExp(/^https:\/\/www[.]youtube[.]com\/.+/);
            var linkValid = linkCheck.test($(this).val());
            if(linkValid == false){
                $(this).val('');
                $(this).siblings(".errormsg").show('slow/400/fast', function() {});
            }
        });
        $('.redditLink').change(function(event) {
            $(this).siblings(".errormsg").hide();
            var linkCheck = new RegExp(/^https:\/\/www[.]reddit[.]com\/.+/);
            var linkValid = linkCheck.test($(this).val());
            if(linkValid == false){
                $(this).val('');
                $(this).siblings(".errormsg").show('slow/400/fast', function() {});
            }
        });
        $('.instaLink').change(function(event) {
            $(this).siblings(".errormsg").hide();
            var linkCheck = new RegExp(/^https:\/\/www[.]instagram[.]com\/.+/);
            var linkValid = linkCheck.test($(this).val());
            if(linkValid == false){
                $(this).val('');
                $(this).siblings(".errormsg").show('slow/400/fast', function() {});
            }
        });
        $('.twitterLink').change(function(event) {
            $(this).siblings(".errormsg").hide();
            var linkCheck = new RegExp(/^https:\/\/twitter[.]com\/.+/);
            var linkValid = linkCheck.test($(this).val());
            if(linkValid == false){
                $(this).val('');
                $(this).siblings(".errormsg").show('slow/400/fast', function() {});
            }
        });
        $('.twitchLink').change(function(event) {
            $(this).siblings(".errormsg").hide();
            var linkCheck = new RegExp(/^https:\/\/www[.]twitch[.]tv\/.+/);
            var linkValid = linkCheck.test($(this).val());
            if(linkValid == false){
                $(this).val('');
                $(this).siblings(".errormsg").show('slow/400/fast', function() {});
            }
        });
        $('#deviceName').change(function(event) {
            $(this).val($.trim($(this).val()));
        });
        $('.nationalityOption').change(function(event) {
            $('.errormsgSubmit').hide();
            $('#enabledbuttonid').removeAttr('disabled');
            $('#enabledbuttonid').removeClass('disabled');
            if($('#No').is(':checked')){
                $('.errormsgSubmit').show();
                $('#enabledbuttonid').addClass('disabled');
                $('#enabledbuttonid').attr('disabled', 'disabled');
            }
        });
        $('#playgameid').change(function(event) {
            if( $(this).is(':checked') ){
                $('#restfieldsid').show('slow/400/fast', function() {});
                $('#deviceName').addClass('mandatory');
            }else{
                $('.gameList').removeAttr('checked');
                $('.platformList').removeAttr('checked');
                $('.deviceList').removeAttr('checked');
                $('#deviceName').val('');
                $('#restfieldsid').hide('slow/400/fast', function() {});
                $('#deviceName').removeClass('mandatory');
            }
        });
        $('.nationalityOption').trigger('change');
        $('#playgameid').trigger('change');
        $('.mandatory').each(function(index, el) {
            if( $(this).val() == '' ){
                $('.profileAlert').show('slow/400/fast', function() {});
            }
        });
        $('#enabledbuttonid').click(function(event) {
            $('.errormsg').hide();
            var dontSubmit = false;
            $('.mandatory').each(function(index, el) {
                if( $(this).val() == '' ){
                    $(this).siblings(".errormsg").show('slow/400/fast', function() {});
                    dontSubmit = true;
                    // return false;
                }
            });
            if(dontSubmit == false){
                if( $('#playgameid').is(':checked') ){
                    var gameList = false;
                    var platformList = false;
                    var deviceList = false;
                    $('.gameList').each(function(index, el) {
                        if($(this).is(':checked')){
                            gameList = true;
                        }
                    });
                    $('.platformList').each(function(index, el) {
                        if($(this).is(':checked')){
                            platformList = true;
                        }
                    });
                    $('.deviceList').each(function(index, el) {
                        if($(this).is(':checked')){
                            deviceList = true;
                        }
                    });
                    setTimeout(function()
                    {
                        if(gameList == false){
                            $('.errormsgGame').show();
                            return false;
                        }
                        if(platformList == false){
                            $('.errormsgPlatform').show();
                            return false;
                        }
                        if(deviceList == false){
                            $('.errormsgDevice').show();
                            return false;
                        }
                        if(gameList == true && platformList == true && deviceList == true){
                            $('#submitProfileForm').submit();
                        }
                    }, 500);
                }else{
                    $('#submitProfileForm').submit();
                }
            }
        });
        
        // popup script
        var popupIndex = 0;
        var accountDetails = [
                    {
                        classId: '#xboxPopup',
                        submitBtn: '#submitXboxPopup',
                        entryPopup: '#xboxPopupEntry',
                        formInp: '#xboxInp',
                        popupInp: '#xboxPopupInp',
                    },
                    {
                        classId: '#psPopup',
                        submitBtn: '#submitPsPopup',
                        entryPopup: '#psPopupEntry',
                        formInp: '#psInp',
                        popupInp: '#psPopupInp',
                    },
                    {
                        classId: '#steamPopup',
                        submitBtn: null,
                        entryPopup: null,
                        formInp: null,
                        popupInp: null,
                    }
                ];

        for(let i = 0; i < accountDetails.length; i++){
            popupOpen(i, accountDetails);
            openPopupFields(i, accountDetails);
            popupSubmit(i, accountDetails);
            copyTextFields(i, accountDetails);
        }
        
        // closes popup on button click on cross
        $('#cross').click(function(event) {
            $('#overlay').removeClass('flex');
            $('#overlay').addClass('hidden');
        });
        
        // opens popup as per accounts value
        function popupOpen(i, accountDetails) {
            if(accounts != -1 && (accounts & (1 << i)))  {
                $('#overlay').removeClass('hidden');
                $('#overlay').addClass('flex');
                $(accountDetails[i].classId).toggleClass('hidden');
            }
        }

        // opens popup entry field as per button press
        function openPopupFields(i, accountDetails) {
            $(accountDetails[i].classId).click(function(event){
                $('#errorPopup').hide('500');
                if(popupIndex == i + 1){
                    $(accountDetails[i].entryPopup).removeClass('isOpen');
                    $(accountDetails[i].entryPopup).hide('500');
                    $('#marginDiv').addClass('hidden');
                    popupIndex = 0;
                } else {
                    if(popupIndex){
                        $(accountDetails[popupIndex - 1].entryPopup).removeClass('isOpen');
                        $(accountDetails[popupIndex - 1].entryPopup).hide('500');
                        $('#marginDiv').addClass('hidden');
                    }
                    if(accountDetails[i].entryPopup != null) {
                        $(accountDetails[i].entryPopup).addClass('isOpen');
                        $(accountDetails[i].entryPopup).show('500');
                        $('#marginDiv').removeClass('hidden');
                    }
                    popupIndex = i + 1;
                }
            });
        }

        // submits details entered in the popup
        function popupSubmit(i, accountDetails) {
            $(accountDetails[i].submitBtn).click(function(event) {
                $('#errorPopup').hide('500');
                if($(accountDetails[i].popupInp).val() == ''){
                    $('#marginDiv').addClass('hidden');
                    $("#errorPopup").show('slow/400/fast', function() {});
                } else {
                    $('#marginDiv').removeClass('hidden');
                    $('#submitProfileForm').submit();
                }
            });
        }
        
        // copies text fields in the form to the popup
        function copyTextFields(i, accountDetails) {
            for(let i = 0; i < accountDetails.length; i++){
                $(accountDetails[i].formInp).on('input', function () {
                    $(accountDetails[i].popupInp).val($(accountDetails[i].formInp).val());
                });
            }
        }

        let rowsPerCol = 3;
        let name = <?php echo json_encode(Auth::user()->name); ?>;
        let discordDiscrim = <?php echo json_encode(Auth::user()->discord_discrim); ?>;

        let userInfo = {
            email: <?php echo json_encode(Auth::user()->email); ?>,
            discord: displayDiscordName(name, discordDiscrim),
            psn: <?php echo json_encode(Auth::user()->psn); ?>,
            xbox: <?php echo json_encode(Auth::user()->xbox); ?>
        }

        let noOfCols = Math.ceil(Object.keys(userInfo).length / rowsPerCol);

        displayMobileUserDetails(userInfo);
        displayDesktopUserDetails(userInfo, noOfCols, rowsPerCol);
        
        function displayMobileUserDetails(userInfo) {
            let startIndex = 0;
            let endIndex = Object.keys(userInfo).length - 1;

            let tableContentStr = populateCol(userInfo, startIndex, endIndex);
    
            $('#userDetails').append(`<table class="xl:hidden mt-3 lg:mt-0 xl:mb-auto">${tableContentStr}</table>`);
        }

        function displayDesktopUserDetails(userInfo, noOfCols, rowsPerCol) {
            for(let i = 0; i < noOfCols; i++) {
                let lastRowIndex = Object.keys(userInfo).length - 1;
                let colLastRowIndex = rowsPerCol * (i + 1) - 1;
    
                let startIndex = rowsPerCol * i;
                let endIndex = colLastRowIndex > lastRowIndex ? lastRowIndex : colLastRowIndex;
    
                let tableContentStr = populateCol(userInfo, startIndex, endIndex);
        
                $('#userDetails').append(`<table class="hidden xl:block xl:mb-auto">${tableContentStr}</table>`);
            }
        }

        function displayDiscordName(name, discrim) {
            let displayName = name;

            if(discrim != "0") {
                displayName += `#${discrim}`;
            }

            return displayName;
        }

        function populateCol(userInfo, startIdx, endIdx) {
            let rowsString = '';

            for(let i = startIdx; i <= endIdx; i++) {
                let keyName = Object.keys(userInfo)[i];
                let keyValue = Object.values(userInfo)[i];

                if(keyValue !== null) {
                    rowsString += `
                    <tr>
                        <td class="font-semibold text-gray-600 uppercase">${keyName}</td>
                        <td class="font-bold text-gray-800 pl-4 py-1 break-all">${keyValue}</td>
                    </tr>
                    `
                }
            }

            return rowsString;
        }
    });
</script>
@endsection