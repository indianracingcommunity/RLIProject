@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
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
</div>




@endsection