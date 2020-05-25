@extends('layouts.app')
@section('content')
<div class="container">
<div class="font-semibold text-orange-800 bg-orange-200 rounded-md p-8">
    Welcome to <strong>Indian Racing Comunity!</strong> Your account is created but not yet <strong>verified</strong>. To verify your Account please add your <strong>Steam ID</strong> on the given field
</div>
<div class="flex my-8">
    <div>
        <img src="{{$user->avatar}}" class="rounded-md " alt="">
    </div>
    <div class="py-3">
        <div class="flex">
            <div class="text-xs font-semibold text-gray-600 mx-4 mt-1">USERNAME</div>
            <div class=" font-semibold text-gray-900">{{$user->name}}</div>
        </div>
        <div class="flex">
            <div class="text-xs font-semibold text-gray-600 ml-4 mr-3 mt-1">EMAIL</div>
            <div class=" font-semibold text-gray-900 ml-8">{{$user->email}}</div>
        </div>
        <div class="flex">
            <div class="text-xs font-semibold text-gray-600 ml-4 mr-6 mt-1">DISCORD</div>
            <div class=" font-semibold text-gray-900 ml-1">{{$user->name}}#{{$user->discord_discrim}}</div>
        </div>
        <div class="flex">
            <div class="text-xs font-semibold text-gray-600 ml-4 mr-6 mt-1">STEAM</div>
            <div class=" font-semibold text-gray-900 ml-4"><a href= "{{$user->steam_id}}">{{$user->steam_id}} </a></div>
        </div>
    </div>
</div>
<div>
<form method="POST" action="setsteam/{{$user->id}}">
    @csrf
    <span class="text-xs font-semibold text-gray-600 mt-1">STEAM PROFILE LINK</span> <span class="text-red-600 mr-4">●</span>
    <input type="url" name="steamid" class="border rounded py-2 px-3" placeholder="https://steamcommunity.com/id/Freeman" style="width: 43%">
    <br><br>
    <input type="submit" value="Set Your Steamlink" class="bg-blue-600 py-2 rounded-md font-semibold cursor-pointer hover:bg-blue-700 focus:bg-blue-800 px-4 text-white">
    </div>
        <span class="text-red-600 mr-2">●</span><span class="text-xs font-semibold text-gray-700">To verify your account add your Steam profile link</span>
    <div>
</form>

@endsection