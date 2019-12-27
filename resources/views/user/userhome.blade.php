@extends('layouts.app')
@auth
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Panel</div>

                <div class="card-body">
                  <h1 class="text-center my-5">  User Controls  </h1>
             
            
                 <a href="/" class="btn btn-primary btn float-left ml-1">View Standings</a>
                 <a href="/" class="btn btn-primary btn float-left ml-2">View Team Stats</a>
                 <a href="/" class="btn btn-primary btn float-left ml-2">Create a report</a>
              <a href="/user/profile/{{$user_id}}">View My Profile</a>
             



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endauth
@guest 
            
<div class="card-header body">
    You need to be an admin to View this page 
</div>

@endguest

