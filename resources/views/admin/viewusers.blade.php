@extends('layouts.app')
@section('content')
@auth
<h1 class="text-center my-5"> All Users </h1>
<div class="row justify-content-center">
    <div class="col-md-8">
            <div class="card default">
                    
                 <div class="card-body">
                            @foreach($user as $user)
                           
                            <ul>
                            <li class="list-group-item">
                            <img src="{{$user->avatar}}" alt="" style="width:30px">
                              {{$user->name}}
                              
                            <a href="/home/admin/user/{{$user->id}}" class="btn btn-primary btn-sm float-right ml-2 ">View Details</a>
                            <a href="/home/admin/user-allot/{{$user->id}}" class="btn btn-warning btn-sm float-right ml-2 ">Allot Driver</a> 
                                
                            </li>
                            </ul>
                          
                            @endforeach
                            
                    </div>
                </div>
                @endauth     
                @endsection

