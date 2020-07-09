@extends('layouts.app')
@section('content')
<div class="flex  my-8 ">
    <div class="flex flex-shrink-0">
        <div>
            <img src="{{$user->avatar}}" class="rounded-md " alt="">
        </div>
        <div class="my-2">
            <div class="flex">
                <div class=" font-semibold text-gray-800 mx-4 text-4xl font-bold">{{$user->name}}</div>
            </div>
            <div class="flex">
                <div class="text-xs font-semibold text-gray-600 ml-4 mr-3 mt-1">TEAM</div>
                <div class=" font-semibold text-gray-800 font-bold text-base">{{$user->team}}</div>
            </div>
            <div class="flex">
                <div class="text-xs font-semibold text-gray-600 ml-4 mr-3 mt-1">TEAMMATE</div>
                <div class=" font-semibold text-gray-800 font-bold text-base">{{$user->teammate}}</div>
            </div>
        </div>
    </div>
    <div class="ml-24 leading-none ">
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
    </div>
</div>
@php
$platform = unserialize($user->platform);
$games = unserialize($user->games);
$device = unserialize($user->device);
@endphp
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
            <tr>
                <td class="font-semibold text-gray-600">STEAM</div>
                <td class=" font-bold text-gray-800 px-4 py-1"><a href= "https://steamcommunity.com/profiles/{{$user->steam_id}}">{{$user->steam_id}} </a></td>
            </tr>
            <tr>
                <td class="font-semibold text-gray-600">PLATFORM</div>  
                @for ($i =0 ; $i <count($platform); $i++)
                <td class=" font-bold text-gray-800 px-4 py-1">{{$platform[$i]}}</td> 
                @endfor
                             
                
            </tr>
            <tr>
                <td class="font-semibold text-gray-600">MOTOSPORTS FOLLOWED</div>
                <td class=" font-bold text-gray-800 px-4 py-1">F1, MotoGP, Indy Truck</td>
            </tr>
            <tr>
                <td class="font-semibold text-gray-600">DRIVER SUPPORTED</div>
                <td class=" font-bold text-gray-800 px-4 py-1">Lance Stroll</td>
            </tr>
            <tr>
                <td class="font-semibold text-gray-600">DEVICE USED</div>
                <td class=" font-bold text-gray-800 px-4 py-1">XBOX Controller</td>
            </tr>
        </table>
    </div>
    <div class="ml-24 pl-4">
        <div class="font-semibold text-gray-700 mb-4">
            <i class="fas fa-users-cog mr-1"></i> User Roles
        </div>
        <div class="flex w-64 flex-wrap font-semibold text-sm">

            @for ($i= 0; $i < count($roles) ; $i++)
            @php
             $color = str_pad($roles[$i]['color'],6,"0",STR_PAD_LEFT);
            @endphp
           <div class="px-1 border rounded-full mr-1 mb-1 border-600 bg-gray-400" style="color:#{{$color}}; border-color:#{{$color}};"><i class="fas fa-circle mr-1 text-500" style="color:#{{$color}}"></i>{{$roles[$i]['name']}} </div>    

            @endfor
        </div>
    </div>
</div>
@endsection