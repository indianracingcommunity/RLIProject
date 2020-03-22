@extends('layouts.app')
@section('content')
@auth
<h1 class="text-center my-5">
        {{$user->name}}    
    </h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
                <div class="card card-default">
                        <div class="card-header">
                        <b>Details</b>
                        </div>
                         <img src="{{$user->avatar}}" id="av" alt="" width="90" style="margin-left:85%; position:absolute; margin-top:10%">
                         
                         <br>
                         
                         
                        
                        
                         
                   
                   
                   
                   
                         <div class="card-body" >

    
                  <p class="font-weight-bold"> User Name:  {{$user->name}} </p>
                  <p class="font-weight-bold">  Discord:  {{$user->name}}#{{$user->discord_discrim}} </p>
                  <p class="font-weight-bold">  Team:  {{$user->team}} </p>
                  <p class="font-weight-bold">  TeamMate:  {{$user->teammate}} </p>
                  <p class="font-weight-bold"> Steam Link:<a href="{{$user->steam_id}}">{{$user->steam_id}} </p>
                    
               {{--   <p class="font-weight-bold">  User Number:   {{$user->drivernumber}}</p>
                  <p class="font-weight-bold">  User Team:  {{$user->team}} </p>  --}}
                 
                 
                        </div>
                        
                   
                
        </div>
        <a href="edit/{{$user->id}}/" class="btn btn-info">Edit User</a>
        <a href="#" class="btn btn-default my-3"><img src="{{url('/img/discord2.png')}}" width="30" /> </a>
        <a href="{{$user->steam_id}}" class="btn btn-default my-3"><img src="{{url('/img/steam.png')}}" width="30" /> </a>
        <a href="/delete/{{$user->id}}/" class="btn btn-danger my-3">Delete User </a>


 {{--    @if($driver->retired==false)
    <a href="/driver-retire/{{$user->id}}" class="btn btn-danger my-3">Retire</a>
         @else
         <a href="/driver-active/{{$driver->id}}" class="btn btn-success my-3">Mark As Active</a>  
         @endif


    <a href="#" class="btn btn-default my-3"><img src="{{url('/img/discord2.png')}}" width="30" /> </a>
        <a href="{{"https://steamcommunity.com/profiles/".$driver->steamid}}" class="btn btn-default my-3"><img src="{{url('/img/steam.png')}}" width="30" /> </a>
     
    </div>
    @endauth
    @guest 
              --}}   
             
                   
            @endguest
    @endsection