@extends('layouts.app')
@section('content')
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
                     <form action="save/{{$user->id}}" method="POST">
                        @csrf
                    User Name: <input type="text" name="name" value="{{$user->name}}" class="form-control-sm">
                    <br><br>
                    DiscordDiscrim: <input type="text" class="form-control-sm" name="discord_discrim" value="{{$user->discord_discrim}}">
                    <br><br>
                     Team: <select class="form-control-sm" name="team" value="{{$user->team}}">
                        <option></option>
                        <option value="Mercedes">Mercedes</option>
                        <option value="Ferrari">Ferrari</option>
                        <option value="Red Bull">Red Bull</option>
                        <option value="Renault">Renault</option>
                        <option value="Haas">Haas</option>
                        <option value="McLaren">McLaren</option>
                        <option value="Racing Point">Racing Point</option>
                        <option value="Toro Rosso">Toro Rosso</option>
                        <option value="Alfa Romeo">Alfa Romeo</option>
                        <option value="Williams">Williams</option>
                    </select>
                    <br><br>
                    Steam: <input type="text" name="steam_id" value="{{$user->steam_id}}" class="form-control-sm">
                    <br><br>
                   Custom Avatar(Must be a valid image link): <input type="text" name="avatar" value="{{$user->avatar}}" class="form-control-sm">
                    <br><br>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </form>




           

    
@endsection