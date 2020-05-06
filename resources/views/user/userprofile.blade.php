@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Panel</div>

                <div class="card-body">
                  <h1 class="text-center my-5">  User Profile  </h1>

           <img src="{{$user->avatar}}" class="rounded mx-auto d-block" alt="">

                <p>  Username: {{$user->name}} </p>
                 <p> Email : {{$user->email}}</p>
                <p>Discord : {{$user->name}}#{{$user->discord_discrim}}</p>
                <form method="POST" action="setsteam/{{$user->id}}">
                    @csrf
                    Steam Profile Link : <input type="url" name="steamid" placeholder="https://steamcommunity.com/id/Freeman" style="width: 50%">
                    <br><br>
                    <input type="submit" value="Set Your Steamlink" class="btn btn-primary">
                </form>
                <br>
                Steam : <a href= "{{$user->steam_id}}">{{$user->steam_id}} </a>
                </div>
            </div>
            <br>
             
        </form>
        </div>
    </div>
</div>




@endsection