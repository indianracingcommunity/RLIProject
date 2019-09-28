@extends('layouts.app')
@section('content')
@auth
<h1 class="text-center my-5">
        {{$driver->name}}    
    </h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
                <div class="card card-default">
                        <div class="card-header">
                        <b> Details</b>
                        </div>
                         <img src="{{$driver->avatar}}" id="av" alt="" width="90" style="margin-left:85%; position:absolute; margin-top:10%">
                         <a href="/api/{{$driver->id}}">     <label for="av" style="margin-left:84%; position:absolute; margin-top:20%">Steam Avatar</label>    </a>
                         <br>
                         <img src="{{$driver->avatar}}" id="av" alt="" width="90" style="margin-left:85%; position:absolute; margin-top:10%">
                         <a href="/discordapi/{{$driver->id}}">     <label for="av" style="margin-left:84%; position:absolute; margin-top:20%">Discord Avatar</label>    </a>
                    <div class="card-body" >

    
                  <p class="font-weight-bold"> Driver Name:</p>   {{$driver->name}}
                  <p class="font-weight-bold">  Driver Number: </p>  {{$driver->drivernumber}}
                  <p class="font-weight-bold">  Driver Team: </p>  {{$driver->team}}
                  <p class="font-weight-bold">  Driver Team Mate: </p>  {{$driver->teammate}}
                  @if($driver->retired==false)
                  <p class="font-weight-bold">  Retired: No </p>
                  @else  
                  <p class="font-weight-bold">  Reserve: Yes </p>
                  @endif
                 
                        </div>
                        
                   
                
        </div>
        <a href="/edit/{{$driver->id}}/" class="btn btn-info">Edit</a>
        <a href="/delete/{{$driver->id}}/" class="btn btn-danger my-3">Delete </a>



        @if($driver->retired==false)
    <a href="/driver-retire/{{$driver->id}}" class="btn btn-danger my-3">Retire</a>
         @else
         <a href="/driver-active/{{$driver->id}}" class="btn btn-success my-3">Mark As Active</a>  
         @endif


    <a href="#" class="btn btn-default my-3"><img src="{{url('/img/discord2.png')}}" width="30" /> </a>
        <a href="{{"https://steamcommunity.com/profiles/".$driver->steamid}}" class="btn btn-default my-3"><img src="{{url('/img/steam.png')}}" width="30" /> </a>
     
    </div>
    @endauth
    @guest 
            
                <div class="card-header body">
                    You need to be an admin to View this page 
                </div>
                   
            @endguest
    @endsection