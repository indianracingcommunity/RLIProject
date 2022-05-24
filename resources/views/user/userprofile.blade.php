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

<div class="container">
<div class="font-semibold text-center text-orange-800 bg-orange-200 rounded-md p-6 profileAlert" style="display: none;">
    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Welcome to <strong>Indian Racing Community!</strong> Please complete your <strong>Profile.</strong>
</div>
@if(SESSION('savedProfile'))
<div class="font-semibold text-center text-green-800 bg-blue-100 rounded-md p-6" >
    <i class="fa fa-check-circle" aria-hidden="true"></i> {{session('savedProfile')}}
    @php Session::forget('savedProfile'); @endphp
</div>
@endif
@if(SESSION('steamSuccess'))
<div class="font-semibold text-center text-green-800 bg-blue-100 rounded-md p-6" >
    <i class="fa fa-check-circle" aria-hidden="true"></i> {{session('steamSuccess')}}
    @php Session::forget('steamSuccess'); @endphp
</div>
@endif

<style type="text/css">
    .errormsg{
        color: red;
        display: none;
    }
    .disabled{
        background: grey;
    }
</style>

<div class="text-4xl font-bold tracking-wide md:mb-2 p-4 md:p-0">User Profile</div>
<div class="flex md:flex-row flex-col px-4 md:p-0">
    <div class="flex bg-white rounded-lg p-4 items-center border">
        <div>
            <img src="{{Auth::user()->avatar}}" class="rounded-md " alt="">
        </div>
        <div>
            <div class=" font-bold text-gray-800 mx-4 text-3xl tracking-tight">{{Auth::user()->name}}</div>
            <div class="flex mb-1 mx-4">
                @if($platform != NULL)
                    @foreach ($platform as $value)
                        <div class="border-2 border-black rounded font-semibold px-1 mr-1">
                            {{$value}}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- <div class="ml-8 leading-none ">
        <div class="font-semibold text-gray-700 mb-4">
            <i class="fas fa-trophy mr-1"></i> Trophies
        </div>
        <div class="flex flex-wrap">
            <div class=" flex-col text-center mr-2">
                <div class="text-5xl text-indigo-700">👑</div>
                <div class="font-semibold mt-2 p-2 bg-indigo-700 rounded-md text-white">Tier 1</div>
            </div>
            <div class=" flex-col text-center mr-2">
                <div class="text-5xl text-indigo-700">⛔</div>
                <div class="font-semibold mt-2 p-2 bg-red-600 rounded-md text-white">Penalty King</div>
            </div>
            <div class=" flex-col text-center mr-2">
                <div class="text-5xl text-indigo-700">🛺</div>
                <div class="font-semibold mt-2 p-2 bg-blue-600 rounded-md text-white">Season 1</div>
            </div>
            <div class=" flex-col text-center mr-2">
                <div class="text-5xl text-indigo-700">🚜</div>
                <div class="font-semibold mt-2 p-2 bg-blue-600 rounded-md text-white">Season 2</div>
            </div>
        </div>
    </div> -->
</div>
<div class="flex flex-col md:flex-row mt-2 md:mt-6 p-4 md:p-0">
    <div>
        <div class="bg-white rounded-lg border p-4">
            <div class="font-semibold text-gray-600 mb-4 tracking-wide text-sm border-b pb-2">
                <i class="far fa-user-circle mr-1"></i> USER DETAILS
            </div>
            <table>
                <tr>
                    <td class="font-semibold text-gray-600">USERNAME</td>
                    <td class=" font-bold text-gray-800 px-4 py-1">{{Auth::user()->name}}</td>
                </tr>
                <tr>
                    <td class="font-semibold text-gray-600">EMAIL</td>
                    <td class=" font-bold text-gray-800 px-4 py-1 whitespace-pre-wrap">{{Auth::user()->email}}</td>
                </tr>
                <tr>
                    <td class="font-semibold text-gray-600">DISCORD</td>
                    <td class=" font-bold text-gray-800 px-4 py-1">{{Auth::user()->name}}#{{Auth::user()->discord_discrim}}</td>
                </tr>
            </table>
        </div>
        <div class="pl-4 bg-gray-800 rounded-lg p-4 my-6 border">
            <div class="font-semibold text-gray-100 mb-4 border-b border-gray-600 pb-2">
                <i class="fab fa-discord mr-1 text-gray-100"></i> User Roles
            </div>
            <div class="flex w-64 flex-wrap font-semibold text-sm">
                @if(is_array($roles))
                    @for ($i= 0; $i < count($roles); $i++)
                        @php
                            $color = str_pad($roles[$i]['color'], 6, "0", STR_PAD_LEFT);
                        @endphp
                        <div class="px-2 border rounded-full mr-1 mb-1 border-600 text-gray-300" style="border-color:#{{$color}};"><i class="fas fa-circle mr-1 text-500" style="color:#{{$color}}"></i>{{$roles[$i]['name']}} </div>
                    @endfor
                @else
                    <!-- {{$roles}} -->
                @endif
            </div>
        </div>
        @if (Auth::user()->steam_id == NULL)
        <hr>
        @endif
        <div class="mt-2">
            <form method="POST" @if ("{{Auth::user()->mothertongue}}" != "") action="setsteam/{{Auth::user()->id}}" @endif>
                @csrf
                @if (Auth::user()->steam_id == NULL)
                    <span class=" font-semibold text-gray-600 mt-1">STEAM PROFILE LINK</span>
                    <button type="button" class="flex py-2 mt-1 mb-2 bg-black rounded-lg">
                        <a @if ("{{Auth::user()->mothertongue}}" != "") href="/login/steam" @endif> 
                            <i class="px-3 fab fa-steam fa-3x text-white" alt=""></i> 
                        </a>
                    </button>
                    <span class="text-black-600 pt-2 mr-2">●</span><span class=" font-semibold text-gray-700 leading-none"><strong>Mandatory for PC Users.</strong></span></br>
                    <span class="text-black-600 pt-2 mr-2">●</span><span class=" font-semibold text-gray-700 leading-none">Roles related to PC will be alloted only after your steam profile has been linked.</span></br>
                    @if (!isset(Auth::user()->mothertongue))
                        <span class="text-red-600 mr-2">●</span><span class=" font-semibold text-red-700 leading-none">Steam Account can only be linked after you complete your profile.</span>
                    @endif
                @endif
            </form>
        </div>
    
    </div>
    
    <div class="md:mx-4 mx-auto w-full">
        <form action="{{route('user.saveprofile', ['user' => Auth::user()->id])}}" method="POST" id="submitProfileForm">
            @csrf
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 w-auto flex-grow-0 md:px-4 bg-white rounded-lg border p-4">
                    <div class="font-semibold text-gray-600 pb-2 mb-4 text-sm tracking-wide border-b">
                        <i class="fas fa-edit mr-1"></i> MORE DETAILS
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="Nationality" class="font-semibold text-gray-800">Are you an Indian?<span class="text-red-600 ml-2">●</span></label>
                        </div>
                        <div>
                            <input type="radio" id="Yes" name="Nationality" class="nationalityOption" value="Yes" @if ("{{Auth::user()->mothertongue}}" != "") checked @endif>
                            <label for="male">Yes</label>
                            <input type="radio" id="No" name="Nationality" class="nationalityOption" value="No">
                            <label for="female">No</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="MotherToungue" class="font-semibold text-gray-800">What is your Mother Tongue?<span class="text-red-600 ml-2">●</span></label>
                        </div>
                        <input maxlength="30" type="text" class="border shadow-inner px-2 py-1 mt-1 w-full mandatory rounded border-gray-700" placeholder="Hindi/Bengali/Tamil" name="mothertongue" value="{{Auth::user()->mothertongue}}">
                        <span class="errormsg errormsgMothTon">Please enter your Mother Tongue.</span>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="City" class="font-semibold text-gray-800">City</label>
                        </div>
                        <input maxlength="30" type="text" name="city" class="border shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700 tildeNotValid" placeholder="Kolkata" value="{{$city}}" >
                        <span class="errormsg errormsgCity">Please enter your City.</span>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="State" class="font-semibold text-gray-800">State/Country<span class="text-red-600 ml-2">●</span></label>
                        </div>
                        <input maxlength="30" type="text" name="state" class="border shadow-inner mandatory px-2 py-1 mt-1 w-full rounded border-gray-700 tildeNotValid" placeholder="West Bengal" value="{{$state}}">
                        <span class="errormsg errormsgState">Please enter your State.</span>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="State" class="font-semibold text-gray-800">Which motorsport do you follow?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                        <input maxlength="100" type="text" name="motorsport" class="border mandatory shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="F1" value="{{Auth::user()->motorsport}}">
                        <span class="errormsg errormsgMotersports">Please enter required details.</span>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="State" class="font-semibold text-gray-800">Which driver do you support?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                        <input maxlength="100" type="text" name="driversupport" class="border mandatory shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="Lando Norris" value="{{Auth::user()->driversupport}}">
                        <span class="errormsg errormsgDriver">Please enter required details.</span>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="State" class="font-semibold text-gray-800">Where did you hear about IRC?<span class="text-red-600 ml-2">●</span></label>
                        </div>
                        <input maxlength="100" type="text" name="source" class="border shadow-inner mandatory px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="Discord, Youtube, etc." value="{{Auth::user()->source}}">
                        <span class="errormsg errormsgIrc">Please enter required details.</span>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="psn" class="font-semibold text-gray-800"><i class="fab fa-playstation text-blue-700 mr-1"></i></i>PSN ID<i class="fas fa-globe-americas text-gray-600 ml-2"></i> (Mandatory for PS Users)</label>
                        </div>
                        <input maxlength="40" type="text" id="psInp" name="psn" placeholder="Username" class="border shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700 playstLink" value='@if(isset(Auth::user()->psn)) {{Auth::user()->psn}} @endif'>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="xbox" class="font-semibold text-gray-800"><i class="fab fa-xbox mr-1 text-green-500"></i>Xbox ID<i class="fas fa-globe-americas text-gray-600 ml-2"></i> (Mandatory for Xbox Users)</label>
                        </div>
                        <input maxlength="40" type="text" id="xboxInp" name="xbox" placeholder="Username" class="border shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700 xboxLink" value='@if(isset(Auth::user()->xbox)) {{Auth::user()->xbox}} @endif'>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="youtube" class="font-semibold text-gray-800"><i class="fab fa-youtube text-red-500 mr-1"></i>Youtube<i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                        <input type="text" name="youtube" placeholder="https://www.youtube.com/xyz" class="border shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700 youtubeLink" value='@if(isset(Auth::user()->youtube)) {{Auth::user()->youtube}} @endif'>
                        <span class="errormsg">Enter a valid link</span>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="instagram" class="font-semibold text-gray-800"><i class="fab fa-instagram text-indigo-500 mr-1"></i>Instagram<i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                        <input maxlength="100" type="text" name="instagram" placeholder="https://www.instagram.com/xyz" class="border shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700 instaLink" value='@if(isset(Auth::user()->instagram)) {{Auth::user()->instagram}} @endif'>
                        <span class="errormsg">Enter a valid link</span>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="twitch" class="font-semibold text-gray-800"><i class="fab fa-twitch text-purple-700 mr-1"></i>Twitch<i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                        <input maxlength="100" type="text" name="twitch" placeholder="https://www.twitch.tv/xyz" class="border shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700 twitchLink" value='@if(isset(Auth::user()->twitch)) {{Auth::user()->twitch}} @endif'>
                        <span class="errormsg">Enter a valid link</span>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="twitter" class="font-semibold text-gray-800"><i class="fab fa-twitter text-blue-500 mr-1"></i>Twitter<i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                        <input maxlength="100" type="text" name="twitter" placeholder="https://www.twitter.com/xyz" class="border shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700 twitterLink" value='@if(isset(Auth::user()->twitter)) {{Auth::user()->twitter}} @endif'>
                        <span class="errormsg">Enter a valid link</span>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="reddit" class="font-semibold text-gray-800"><i class="fab fa-reddit mr-1" style="color: #ff581a"></i>Reddit<i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                        <input maxlength="100" type="text" name="reddit" placeholder="https://www.reddit.com/user/xyz" class="border shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700 redditLink" value='@if(isset(Auth::user()->reddit)) {{Auth::user()->reddit}} @endif'>
                        <span class="errormsg">Enter a valid link</span>
                    </div>
                </div>
                <div class="md:w-1/2 w-auto mt-6 md:ml-4 md:mt-0">
                    <div class="bg-white p-4 rounded-lg border">
                        <label class="mb-4 cursor-pointer">
                            <input type="checkbox" required id="playgameid" name="playgame" value="playsgame" @if ($games != NULL) checked @endif>
                            <span for="games" class="font-semibold text-gray-800"> I play racing games.<span class="text-red-600 ml-2">●</span></span>
                        </label>
                        <div id="restfieldsid" class="mt-10" style="display : block;">
                            <div class="mb-4">
                                <label for="games" class="font-semibold text-gray-800">Which Games do you Play?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                                <div class="flex flex-wrap">
                                    @foreach($series as $gameList)
                                    <label class="rounded bg-gray-200 px-2 py-1 my-1 mr-2 cursor-pointer">
                                        <input class="gameList" type="checkbox" id="gameid" name="game[]" value="{{$gameList->code}}" @if($games!=NULL) @if (in_array($gameList->code, $games)) checked @endif @endif>
                                        <span for="games" class="mr-2">{{$gameList->name}}</span>
                                    </label>
                                    @endforeach
                                </div>
                                <span class="errormsg errormsgGame">Please select atleast 1.</span>
                            </div>
                            <div class="mb-4">
                                <label for="games" class="font-semibold text-gray-800">Which platform do you play on?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                                <div class="flex flex-wrap">
                                    <label class="rounded bg-gray-200 px-2 py-1 my-1 mr-2 cursor-pointer">
                                        <input class="platformList" type="checkbox" id="vehicle1" name="platform[]" value="PC" @if($platform!=NULL) @if (in_array("PC", $platform)) checked @endif @endif>
                                        <span for="games" class="mr-2">PC</span>
                                    </label>
                                    <label class="rounded bg-gray-200 px-2 py-1 my-1 mr-2 cursor-pointer">
                                        <input class="platformList" type="checkbox" id="vehicle1" name="platform[]" value="PlayStation" @if($platform!=NULL) @if (in_array("PlayStation", $platform)) checked @endif @endif>
                                        <span for="games" class="mr-2">PlayStation</span>
                                    </label>
                                    <label class="rounded bg-gray-200 px-2 py-1 my-1 mr-2 cursor-pointer">
                                        <input class="platformList" type="checkbox" id="vehicle1" name="platform[]" value="Xbox" @if($platform!=NULL) @if (in_array("Xbox", $platform)) checked @endif @endif>
                                        <span for="games" class="mr-2">Xbox</span>
                                    </label>
                                </div>
                                <span class="errormsg errormsgPlatform">Please select atleast 1.</span>
                            </div>
                            <div>
                                <label for="games" class="font-semibold text-gray-800">What Device do you use to play Games?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                                <div class="flex flex-wrap">
                                    <label class="rounded bg-gray-200 px-2 py-1 my-1 mr-2 cursor-pointer">
                                        <input class="deviceList" type="checkbox" id="vehicle1" name="device[]" value="Keyboard/Mouse" @if($device!=NULL) @if (in_array("Keyboard/Mouse", $device)) checked @endif @endif>
                                        <span for="games" class="mr-2">Keyboard/Mouse</span>
                                    </label>
                                    <label class="rounded bg-gray-200 px-2 py-1 my-1 mr-2 cursor-pointer">
                                        <input class="deviceList" type="checkbox" id="vehicle1" name="device[]" value="Controller" @if($device!=NULL) @if (in_array("Controller", $device)) checked @endif @endif>
                                        <span for="games" class="mr-2">Controller</span>
                                    </label>
                                    <label class="rounded bg-gray-200 px-2 py-1 my-1 mr-2 cursor-pointer">
                                        <input class="deviceList" type="checkbox" id="vehicle1" name="device[]" value="Wheel" @if($device!=NULL)  @if (in_array("Wheel", $device)) checked @endif @endif>
                                        <span for="games" class="mr-2">Wheel</span>
                                    </label>
                                </div>
                                <span class="errormsg errormsgDevice">Please select atleast 1.</span>
                            </div>
                            <div class="mt-4">
                                <div>
                                    <label for="State" class="font-semibold text-gray-800">What is your device name?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                                </div>
                                <input maxlength="100" type="text" name="devicename" id="deviceName" class="border shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="T300, xbox controller, g29, Red Legend, etc." value="{{Auth::user()->devicename}}">
                                <span class="errormsg errormsgDeviceName">Please enter device details.</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 border mt-6">
                        <div class="font-semibold text-gray-700">
                            <div>
                                <span class="text-red-600 mr-2">●</span>Mandatory Fields
                            </div>
                            <div>
                                <i class="fas fa-globe-americas text-gray-600 mr-2"></i>Publicly visible fields
                            </div>
                        </div>
                        <button type="button" id="enabledbuttonid" class="bg-blue-500 rounded mt-4 text-white font-semibold px-8 py-2 hover:bg-blue-800" style="display: block;">Submit</button>
                        <span class="errormsg errormsgSubmit">You need to be an Indian to fill this Form.</span>
                    </div>
                </div>
            </div>
            <!-- Popup/Dialog Box html/css code starts here -->
            <div class="bg-black bg-opacity-50 fixed inset-0 hidden justify-center items-start w-screen" id="overlay">
                <div class="bg-gray-200 rounded-lg w-3/4 sm:w-auto py-2 px-3 shadow-xl md:mt-48">
                    <div class="flex justify-between items-center border-b border-gray-400">
                        <h4 class="p-2 text-lg md:text-xl lg:text-2xl font-bold">One final step...</h4>
                        <svg id="cross" class=" w-6 h-7 cursor-pointer hover:bg-gray-400 rounded-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="close-modal"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <div>
                        <p class="text-center text-red-600 text-md md:text-lg lg:text-xl font-bold pt-3 pb-1">Link your gaming accounts</p>
                    </div>
                    <div class="flex justify-center pt-3 pb-6 gap-6">
                        <button id="steamPopup" type="button" class="hidden py-2 bg-black rounded-lg">
                            <a @if ("{{Auth::user()->mothertongue}}" != "") href="/login/steam" @endif> 
                                <i class="px-3 fab fa-steam fa-2x text-white" alt=""></i> 
                            </a>
                        </button>
                        <button id="xboxPopup" type="button" class="hidden py-2 bg-green-500 rounded-lg">
                            <i class="px-3 fab fa-xbox fa-2x text-white"></i>
                        </button>
                        <button id="psPopup" type="button" class="hidden py-2 bg-blue-600 rounded-lg">
                            <i class="px-3 fab fa-playstation fa-2x text-white"></i>
                        </button>
                    </div>
                    <div id="xboxPopupEntry" class="hidden content-center flex-col justify-center md:w-2/3 bg-green-500 rounded-lg p-3 mx-auto">
                        <div>
                            <label for="xbox" class="text-white"><i class="fab fa-xbox mr-1 text-white shadow-xl"></i>XBOX ID</label>
                        </div>
                        <div class="flex flex-col items-center">
                            <input maxlength="40" type="text" id="xboxPopupInp" name="xbox" placeholder="Username" class="shadow-inner px-2 py-1 mt-1 w-full rounded border-gray-700 xboxLink" value="{{Auth::user()->xbox}}">
                            <!-- <span class="mt-3 px-2 errormsg bg-white rounded-md">Please enter required details.</span> -->
                            <button type="button" id="submitXboxPopup" class="text-sm flex items-center justify-center content-center w-1/4 mt-3 bg-white rounded text-green-500 font-semibold hover:bg-green-800 hover:text-white shadow-xl" style="display: block;">Submit</button>
                        </div>
                    </div>
                    <div id="psPopupEntry" class="hidden content-center flex-col justify-center md:w-2/3 bg-blue-600 rounded-lg p-3 mx-auto">
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
            <!-- Popup/Dialog Box html/css code ends here -->
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
    });
</script>
@endsection
