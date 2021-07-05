@extends('layouts.app')
@section('content')
    

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Season: {{$report['race']['season']['name']}}</div>
              {{-- {{dd($report)}} --}}
                <div class="card-body">
                  <h1 class="text-center my-5"> Details</h1>
              
                <p>Reported: {{$report['reported_against']['name']}}</p>
                  <br>
                <p>Session: {{$report['race']['circuit']['name']}}</p>
                <br>
                <p>Lap: {{$report['lap']}}</p>
                <br>
                <p>Explanation: {{$report['explanation']}}</p>
                <br>
                <p>Proof:<a href="{{$report['proof']}}">{{ $report['proof'] }}</a></p>

        
                    
            


                </div>
            </div>
        </div>
    </div>
</div>


@endsection