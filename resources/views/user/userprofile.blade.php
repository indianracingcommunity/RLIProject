@extends('layouts.app')
@auth
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Panel</div>

                <div class="card-body">
                  <h1 class="text-center my-5">  User Profile  </h1>

                <img src="{{$user->avatar}}" class="rounded mx-auto d-block" alt="" style="align:center">

                <p>  Username: {{$user->name}} </p>
                 <p> Email : {{$user->email}}</p>
                <p>Discord : {{$user->name}}#{{$user->discord_discrim}}</p>
                @if ($user->steamid=NULL)
                <form method="POST" action="setsteam/{{$user->id}}">
                    @csrf
                    Steam Profile Link : <input type="text" name="steamid">
                    <input type="submit" value="Set Your Steamlink" class="btn btn-primary">
                </form>
                @else
            <p>Steam :<a href="{{$user->steam_id}}">{{$user->steam_id}}</a></p>
    
                @endif

                </div>
            </div>
            <br>
            <form action="steam/reset/{{$user->id}}" method="POST">
        <input type="resetlink" value="Remove Steam Link" class="btn btn-danger"> 
        </form>
        </div>
    </div>
</div>



@endauth
@endsection