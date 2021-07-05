@extends('layouts.app')
@auth
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Panel</div>

                <div class="card-body">
                  <h1 class="text-center my-5">  Admin Controls  </h1>
             

                 <a href="{{route('coordinator.driverlist')}}" class="btn btn-primary btn float-left ml-2">View/Allot Drivers</a>
                 <a href="#" class="btn btn-primary btn float-left ml-2">Update Standings</a>
                 <a href="{{route('steward.list')}}" class="btn btn-primary btn float-left ml-2">View All Reports</a>
                 <br><br><br>
                 <p>User Panel:</p>
                 <a href="{{route('home')}}" class="btn btn-primary btn float-left ml-2">Back to User panel</a>


                </div>
            </div>
        </div>
    </div>
</div>
@endauth

@endsection
