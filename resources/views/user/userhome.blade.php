@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Panel</div>
                @if (Auth::user()->steam_id==NULL)
                <h2>Before accessing your account please add your steam profile link here :<a href="/user/profile/{{Auth::user()->id}}">Profile</a></h2>
                 @endif
                @if (Auth::user()->steam_id!=NULL)


                <div class="card-body">
                  <h1 class="text-center my-5">  User Controls  </h1>


                 <a href="#" class="btn btn-primary btn float-left ml-1">View Standings</a>
                 <a href="#" class="btn btn-primary btn float-left ml-2">View Team Stats</a>
                 <a href="/home/report/create" class="btn btn-primary btn float-left ml-2">Create a report</a>
                 <a href="/home/report/category" class="btn btn-primary btn float-left ml-2">View all Reports</a>
                 <br><br><br>
                 @if (Auth::user()->isadmin==1)
                <p>You are an Admin! Visit the admin area Here:</p>
                 <a href="/home/admin" class="btn btn-success btn float-left ml-2">Admin Area</a>
                 @endif




                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection


