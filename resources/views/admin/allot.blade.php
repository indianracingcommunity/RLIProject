@extends('layouts.app')
@section('content')

<div class="w-1/3 mx-auto">
    <div class="text-2xl font-semibold text-gray-700">
    Allot Driver / User Profile
    </div>
    <div class="flex my-4 py-2">
        <div>
            <img src="{{$user->avatar}}" class="rounded" alt="">
        </div>
        <div class="flex flex-col justify-between ml-4">
            <div>
                <div class="text-xl font-bold text-gray-700 uppercase">{{$user->name}}</div>
                <div class="font-bold text-gray-700">{{$user->email}}</div>
            </div>
            <div class="flex flex-col-reverse">
                <div class="font-bold text-gray-700 text-xl flex flex-row-reverse">
                    #{{$user->discord_discrim}}
                </div>
                <div>
                    <a href="https://steamcommunity.com/profiles/{{$user->steam_id}}" target="_blank">
                        <span class="px-2 pt-3 rounded cursor-pointer hover:bg-blue-700 pb-2 bg-blue-800">
                            <i class="fab fa-steam text-2xl text-white"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" action="/home/admin/user-allot/submit">
                @csrf
                <input type="hidden" value="{{$user->id}}" name="user_id">
                <span class="font-bold text-gray-700 ">Team</span>
                <select name="tier" id="tier" class="border p-1 mx-2">
                    <option value="1">Tier 1</option>
                    <option value="2">Tier 2</option>
                    <option value="3">Reserve/Challenger</option>
                </select>
                @if (count($exisiting)==0)
                <button type="submit" class="ml-6 bg-blue-600 hover:bg-blue-700 text-white py-1 px-8 rounded font-semibold">Submit</button>
                @else

                <!-- @endif -->

                @if (count($exisiting) > 1 )
                <div class="bg-red-200 rounded text-red-800 p-4 mb-3 font-semibold">
                 Duplicate Drivers in DB detected please check the database before proceeding !
                </div>

                @endif



                </div>

            </div>

        </form>
</div>


<!-- <div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Profile</div>

                <div class="card-body">
                  <h1 class="text-center my-5">  Allot Driver </h1>

           <img src="{{$user->avatar}}" class="rounded mx-auto d-block" alt="">

                <p>  Username: {{$user->name}} </p>
                 <p> Email : {{$user->email}}</p>
                <p>Discord : {{$user->name}}#{{$user->discord_discrim}}</p>
                Steam : <a href= "{{$user->steam_id}}">{{$user->steam_id}} </a>
                <br><br>
                <form method="POST" action="/home/admin/user-allot/submit">
                    @csrf
                <input type="hidden" value="{{$user->id}}" name="user_id">
                    Team: <select name="tier" id="tier">

                    <option value="1">Tier 1</option>
                    <option value="2">Tier 2</option>
                    <option value="3">Reserve/Challenger</option>
                    </select>

                <br>
                <br>
                @if (count($exisiting)==0)
                <input type="submit" class="btn btn-warning">
                @else

                @endif

                @if (count($exisiting) > 1 )
              <div class="bg-red-200 rounded text-red-800 p-4 mb-3 font-semibold">
                 Duplicate Drivers in DB detected please check the database before proceeding !
                </div>

                @endif



                </div>

            </div>
            <br>

        </form>
        </div>
    </div>
</div> -->




@endsection
