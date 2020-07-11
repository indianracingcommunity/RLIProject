@extends('layouts.app')
@section('content')
@php
$platform = unserialize($user->platform);
$games = unserialize($user->games);
$device = unserialize($user->device);
@endphp
<div class="flex  my-8 ">
    <div class="flex flex-shrink-0">
        <div>
            <img src="{{$user->avatar}}" class="rounded-md " alt="">
        </div>
        <div class="">
            <div class="flex">
                <div class=" font-semibold text-gray-800 mx-4 text-4xl font-bold">{{$user->name}}</div>
            </div>
            <div class="flex mb-1 mx-4">
                @if($platform != NULL)
                    @foreach ($platform as $value)
                        <div class="border-2 border-black rounded font-semibold px-1 mr-1">
                            {{$value}}
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="flex mx-4 my-2">
                @if ($user->steam_id != NULL)
                <a href="https://steamcommunity.com/profiles/{{$user->steam_id}}" target="_blank">
                    <i class="fab fa-steam text-blue-700 text-3xl mr-2"></i>
                </a>
                @endif
                @if ($user->youtube != NULL)
                <a href="{{$user->youtube}}" target="_blank">
                    <i class="fab fa-youtube text-red-600 text-3xl mr-2"></i>
                </a>
                @endif
                @if ($user->twitch != NULL)
                <a href="{{$user->twitch}}" target="_blank">
                    <i class="fab fa-twitch text-purple-700 text-3xl mr-2"></i>
                </a>
                @endif
                @if ($user->twitter != NULL)
                <a href="{{$user->twitter}}" target="_blank">
                    <i class="fab fa-twitter text-blue-600 text-3xl mr-2"></i>
                </a>
                @endif
                @if ($user->instagram != NULL)
                <a href="{{$user->instagram}}" target="_blank">
                    <i class="fab fa-instagram text-purple-500 text-3xl"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
        <!-- <div class="ml-24 leading-none ">
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
<div class="flex">
    <div>
        <div class="font-semibold text-gray-700 mb-4">
            <i class="far fa-user-circle mr-1"></i> User Details
        </div>
        <table>
            <tr>
                <td class="font-semibold text-gray-600">USERNAME</td>
                <td class=" font-bold text-gray-800 px-4 py-1">{{$user->name}}</td>
            </tr>

            <tr>
                <td class="font-semibold text-gray-600">DISCORD</td>
                <td class=" font-bold text-gray-800 px-4 py-1">{{$user->name}}#{{$user->discord_discrim}}</td>
            </tr>
            @if ($user->psn != NULL)
            <tr>
                <td class="font-semibold text-gray-600">PSN ID</td>
                <td class=" font-bold text-gray-800 px-4 py-1">{{$user->psn}}</td>
            </tr>
            @endif
            @if ($user->xbox != NULL)
            <tr>
                <td class="font-semibold text-gray-600">XBox ID</td>
                <td class=" font-bold text-gray-800 px-4 py-1">{{$user->xbox}}</td>
            </tr>
            @endif
            @if ($user->motorsport != NULL)
            <tr>
                <td class="font-semibold text-gray-600">MOTOSPORTS FOLLOWED</div>
                <td class=" font-bold text-gray-800 px-4 py-1">{{$user->motorsport}}</td>
            </tr>
            @endif
            @if ($user->driversupport != NULL)
            <tr>
                <td class="font-semibold text-gray-600">DRIVER SUPPORTED</div>
                <td class=" font-bold text-gray-800 px-4 py-1">{{$user->driversupport}}</td>
            </tr>
            @endif
            @if ($user->devicename != NULL)
            <tr>
                <td class="font-semibold text-gray-600">DEVICE USED</div>
                <td class=" font-bold text-gray-800 px-4 py-1">{{$user->devicename}}</td>
            </tr>
            @endif
        </table>
    </div>
    <div class="ml-24 pl-4 bg-gray-800 rounded-md p-4 inline-block">
        <div class="font-semibold text-gray-100 mb-4 border-b border-gray-600 pb-2">
            <i class="fab fa-discord mr-1 text-gray-100"></i> User Roles
        </div>
        <div class="flex w-64 flex-wrap font-semibold text-sm">
            @if(is_array($roles))
            @for ($i= 0; $i < count($roles) ; $i++)
            @php
             $color = str_pad($roles[$i]['color'],6,"0",STR_PAD_LEFT);
            @endphp
           <div class="px-1 border rounded-full mr-1 mb-1 border-600 text-gray-300" style="border-color:#{{$color}};"><i class="fas fa-circle mr-1 text-500" style="color:#{{$color}}"></i>{{$roles[$i]['name']}} </div>

            @endfor
            @else
            {{$roles}}
            @endif
        </div>
    </div>
</div>
@endsection
