@extends('layouts.app')
@section('content')
    

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Report Against:{{$report->against}}</div>

                <div class="card-body">
                  <h1 class="text-center my-5"> Details </h1>
              
                <p>Reported: {{$report->against}}</p>
                  <br>
                <p>Track: {{$report->track}}</p>
                <br>
                <p>Lap: {{$report->lap}}</p>
                <br>
                <p>Explanation: {{$report->explained}}</p>
                <br>
                <p>Proof:<a href="{{$report->proof}}">{{$report->proof}}</a></p>

                  @if ($report->resolved==0)
                Status:<p>Being Reviewed By stewards</p>
                      @else
                      <p>Resolved</p>
                  @endif  

                  
            


                </div>
            </div>
        </div>
    </div>
</div>


@endsection