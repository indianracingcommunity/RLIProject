@extends('layouts.app')

@section('content')

<div style="height:20px; width:100%; clear:both;"></div>
<div class="container mx-auto">
    <div class="w-1/3 mx-auto bg-gray-200 rounded-md p-8">
    <div class="px-3 bg-gray-800 mx-2 text-center text-white font-bold rounded-md hover:bg-gray-700 cursor-pointer flex items-center flex-shrink-0">
            <a href="/" class="flex ml-10 px-2 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700"><img src="/img/IRC_logo/logo_square.png" height="45" width="45"> <span class="p-3">Indian Racing Comunity</span> </a>
    </div>
    <div class="p-3 bg-red-200 text-center font-semibold rounded mx-2 my-4 text-red-700">
        @if(Session::has('error'))
            {{session('error')}}
        @else
            Acess Denied!
        @endif
    </div>
    <div class="p-3 bg-blue-200 text-center font-semibold rounded mx-2 my-4">
        You need to Login to access this content
    </div>
        <div class="px-4 flex mx-2 py-3 bg-indigo-600 text-white rounded font-semibold shadow-md cursor-pointer text-center hover:bg-indigo-700">
            <a href="/login/discord" class="w-full"><i class="fab fa-discord mr-4"></i></i>Login with Discord</a>
        </div>
    </div>
</div>

<div style="height:150px; width:100%; clear:both;"></div>
@endsection
