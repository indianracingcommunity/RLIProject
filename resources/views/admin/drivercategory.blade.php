@extends('layouts.app')
@section('content')
@auth
<h1 class="text-center my-5">View Drivers </h1>
<div class="row justify-content-center">
    <div class="col-md-8">
            <div class="card default">
                    
                 <div class="card-body">

                    
                 
                <a href="/active-drivers" type="button" class="btn btn-primary" style="width:500px">View Active Drivers</a><br>


                <br> <a href="/retired-drivers" class="btn btn-dark" style="width:500px">View Reserve Drivers</a>
                

                @endauth
                @guest 
            
                <div class="card-header body">
                    You need to be an admin to View this page 
                </div>
            
            @endguest
                @endsection

