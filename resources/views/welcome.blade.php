@extends('layout')


@section('body')
<div class="jumbotron container">
    
    <div class=" p-5  text-center">
        <h1 class="display-2 text-primary">Welcome to RLI - "Racing League Of India"</h1>
    </div><hr>

    <div class="card-columns">
        <div class="card m-4 bg-info" style="width:600px" >
            <div class="card-body text-center">
                <h2 class="display-4">Latest Race Results  Belgium GP</h2>
                <h5 class="card-text"><strong>Race Winner : theKC66</strong></h5>
                <h6 class="card-text">2nd Place : Freeman</h6>
                <p class="card-text">3rd Place : kapilace6</p>
                <a href="standings" class="btn btn-dark">Go to Standings</a>
            </div>
        </div>
        
 
    </div><hr>
</div>
@endsection
