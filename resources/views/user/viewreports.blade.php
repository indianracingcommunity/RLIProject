@extends('layouts.app')
@section('content')
    

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">View Reports</div>

                <div class="card-body">
                  <h1 class="text-center my-5"> All Reports  </h1>

                  @foreach($report as $report)
                           
                  <ul>
                  <li class="list-group-item">
                  
             Report Against: {{$report->against}}
                    
                  <a href="/home/view/report/{{$report->id}}/details" class="btn btn-primary btn-sm float-right ml-2 ">View Details</a>

                  
                      
                  </li>
                  </ul>
                
                  @endforeach

            
         



                </div>
            </div>
        </div>
    </div>
</div>


@endsection