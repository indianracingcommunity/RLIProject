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
                        <div class="card-body">
                  <p class="font-weight-bold"> Driver Name:</p>   {{$driver->name}}
                  <p class="font-weight-bold">  Driver Number: </p>  {{$driver->drivernumber}}
                  <p class="font-weight-bold">  Driver Team: </p>  {{$driver->team}}
                        
                        </div>
                   
                
        </div>
        <a href="/driver{{$driver->id}}/edit" class="btn btn-info">Edit</a>
        <a href="/driver/{{$driver->id}}/delete" class="btn btn-danger my-3">Delete </a>
        <a href="#" class="btn btn-default my-3"><img src="{{url('/img/discord2.png')}}" width="30" /> </a>
        <a href="#" class="btn btn-default my-3"><img src="{{url('/img/steam.png')}}" width="30" /> </a>
     
    </div>
    @endauth
    @guest 
            
                <div class="card-header body">
                    You need to be an admin to View this page 
                </div>
            
            @endguest
    @endsection