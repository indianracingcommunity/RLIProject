@extends('layouts.app')
    @section('content')
    @php
    $platform = isset($user->platform) && $user->platform != '' ? unserialize($user->platform) : NULL;
    $games = isset($user->games) && $user->games != '' ? unserialize($user->games) : NULL;
    $userGames = [];
    if($games != NULL){
    foreach($series as $gameList){
    if(in_array($gameList->code, $games)){
    array_push($userGames,$gameList->name);
    }
    }
    }
    $device = isset($user->device) && $user->device != '' ? unserialize($user->device) : NULL;
    @endphp
    <div class="flex flex-col items-center justify-center gap-8 xl:gap-6 p-5 md:px-10 xl:px-14">
        <div class="flex flex-col lg:flex-row items-center justify-center p-4 rounded-md border gap-2 lg:gap-8 w-full">
            <div class="my-auto">
                <img src="{{$user->avatar}}" class="rounded-md w-24" alt="Profile picture">
            </div>

            <div class="flex flex-col items-center lg:items-start justify-center gap-1 xl:my-auto">
                <div class="font-bold text-gray-800 text-3xl tracking-tight break-all">{{$user->name}}</div>

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
                
            <div class="flex flex-row items-center text-white mt-2 lg:mt-0 gap-3">
                <p class="hidden lg:flex capitalize font-semibold text-gray-600 tracking-wide text-sm">socials:</p>

                @if ($user->steam_id != NULL)
                    <a href="https://steamcommunity.com/profiles/{{$user->steam_id}}" target="_blank">
                        <i style='background:#1f3d7a' class='fab fa-steam text-xl p-2 rounded-md'></i> 
                    </a>
                @endif

                @if ($user->youtube != NULL)
                <a href="{{$user->youtube}}" target="_blank">
                    <i style='background:#FF0000' class='fab fa-youtube text-xl p-2 rounded-md'></i>
                </a>
                @endif

                @if ($user->twitch != NULL)
                <a href="{{$user->twitch}}" target="_blank">
                    <i style='background:#6441a5' class='fab fa-twitch text-xl p-2 rounded-md bg-blue-800'></i> 
                </a>
                @endif

                @if ($user->twitter != NULL)
                <a href="{{$user->twitter}}" target="_blank">
                    <i style='background:#1DA1F2' class='fab fa-twitter text-xl     p-2 rounded-md bg-blue-500'></i> 
                </a>
                @endif

                @if ($user->instagram != NULL)
                <a href="{{$user->instagram}}" target="_blank">
                    <i style='background:#E1306C' class="fab fa-instagram text-xl   p-2 rounded-md bg-pink-600"></i>
                </a>
                @endif
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 xl:gap-6 w-full">
            <div class="lg:w-3/5 flex flex-col items-center xl:items-start justify-start px-8 py-2 rounded-md border gap-3">
                <div class="flex items-center justify-center gap-2 font-semibold text-gray-600 tracking-wide text-sm border-b pb-2 uppercase w-full">
                    <i class="far fa-edit"></i>
                    user details
                </div>

                <table>
                    <tr>
                        <td class="flex justify-start font-semibold text-gray-600 uppercase">username</td>
                        <td class="font-bold text-gray-800 pl-4 pb-1 break-all">{{$user->name}}</td>
                    </tr>

                    <tr>
                        <td class="flex justify-start font-semibold text-gray-600 uppercase">discord</td>
                        @php
                            $discordFullUsername = $user->name;
                            if ($user->discord_discrim != "0") {
                                $discordFullUsername .= "#" . $user->discord_discrim;
                            }
                        @endphp
                        <td class="font-bold text-gray-800 pl-4 pb-1 break-all">{{ $discordFullUsername }}</td>
                    </tr>

                    @if ($user->psn != NULL)
                    <tr>
                        <td class="flex justify-start font-semibold text-gray-600 uppercase">psn</td>
                        <td class="font-bold text-gray-800 pl-4 pb-1 break-all">{{$user->psn}}</td>
                    </tr>
                    @endif

                    @if ($user->xbox != NULL)
                    <tr>
                        <td class="flex justify-start font-semibold text-gray-600 uppercase">xbox</td>
                        <td class="font-bold text-gray-800 pl-4 pb-1 break-all">{{$user->xbox}}</td>
                    </tr>
                    @endif

                    @if ($user->motorsport != NULL)
                    <tr>
                        <td class="flex justify-start font-semibold text-gray-600 uppercase">motorsports</td>
                        <td class="font-bold text-gray-800 pl-4 pb-1 break-words">{{$user->motorsport}}</td>
                    </tr>
                    @endif

                    @if ($user->driversupport != NULL)
                    <tr>
                        <td class="flex justify-start font-semibold text-gray-600 uppercase">drivers</td>
                        <td class="font-bold text-gray-800 pl-4 pb-1 break-words">{{$user->driversupport}}</td>
                    </tr>
                    @endif

                    @if ($user->device != NULL)
                    <tr>
                        <td class="flex justify-start font-semibold text-gray-600 uppercase">devices</td>
                        <td class="font-bold text-gray-800 pl-4 pb-1 break-words">{{$user->devicename}}</td>
                    </tr>
                    @endif

                    @if ($games != NULL)
                    <tr>
                        <td class="flex justify-start font-semibold text-gray-600 uppercase">games</td>
                        <td class="font-bold text-gray-800 pl-4 pb-1 break-words">
                            @for($i=0;$i<count($userGames);$i++) {{$userGames[$i]}}@if($i<count($userGames)-1), @endif @endfor
                        </td>
                    </tr>
                    @endif
                </table>
            </div>

            <div class="lg:w-2/5 flex flex-col items-start justify-start bg-gray-800 rounded-md py-2 px-4">
                <div class="flex items-center justify-center gap-2 font-semibold text-white tracking-wide text-sm border-b pb-2 uppercase w-full">
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
        </div>
    </div>
    @endsection