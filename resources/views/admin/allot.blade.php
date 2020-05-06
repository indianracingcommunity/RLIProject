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
                    Team: <select name="constructor" id="constructor">
                        @foreach($team as $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                    
                <br>
                <br>
                <input type="submit" class="btn btn-warning">
                </div>
              
            </div>
            <br>
             
        </form>
        </div>
    </div>
</div>




@endsection