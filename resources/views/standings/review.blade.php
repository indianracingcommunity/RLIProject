@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Review Standings data</div>
          
                
             
                <div class="card-body">
                  <h1 class="text-center my-5">  Review Race Result  </h1>
             
                
                  <h2 class="">Track</h3>
                    <form action="/test/save" method="POST">
                        @csrf
                    Circuit ID:  <input type="text" name="circuit_id" value="{{$json['track']['circuit_id'] }}" class="form-control">  
                  Official: <input type="text" name="official" value="{{$json['track']['official'] }}" class="form-control">
                  Display : <input type="text" name="display" value="{{$json['track']['display'] }}" class="form-control">
                  Season : <input type="text" name="display" value="" class="form-control">
                  Round : <input type="text" name="display" value="" class="form-control">
                <br>
                <br>

                @for ($i=0 ;  $i<5 ; $i++)
                    
                  
                    <h4>Driver :{{$i}} </h4>
             Position: <input type="text" name="position{{$i}}" class="form-control" value="{{$json['results'][$i]['position']}}">
         
          
             Driver ID:  <input type="text" name="driver_id{{$i}}" class="form-control" value="{{$json['results'][$i]['driver_id']}}">
          
           
              Driver:  <input type="text" name="driver{{$i}}" class="form-control" value="{{$json['results'][$i]['driver']}}"><br><br>
         
           
              Matched Driver :  <input type="text" name="matched_driver{{$i}}" class="form-control" value="{{$json['results'][$i]['matched_driver']}}"><br>
            
              Team:  <input type="hid" name="team{{$i}}" class="form-control" value="{{$json['results'][$i]['team']}}"><br><br>
              Constructor ID: <input type="hid" name="constructor_id{{$i}}" class="form-control" value="{{$json['results'][$i]['constructor_id']}}"><br><br>
              Matched Team:  <input type="hid" name="matched_team{{$i}}" class="form-control" value="{{$json['results'][$i]['matched_team']}}"><br><br>
              Grid: <input type="hid" name="grid{{$i}}" class="form-control" value="{{$json['results'][$i]['grid']}}"><br><br>
              Stops: <input type="hid" name="stops{{$i}}" class="form-control" value="{{$json['results'][$i]['stops']}}"><br><br>
              Fastest Lap: <input type="hid" name="fastestlaptime{{$i}}" class="form-control" value="{{$json['results'][$i]['fastestlaptime']}}"><br><br>
              Total time: <input type="hid" name="time{{$i}}" class="form-control" value="{{$json['results'][$i]['time']}}"><br><br>
           
              @endfor 

              <input type="submit" value="submit" id="submit" class="form-control col-md-8">
             
            </form>
        </div>        
        </div>           
    </div>
</div>
</div>

@endsection


