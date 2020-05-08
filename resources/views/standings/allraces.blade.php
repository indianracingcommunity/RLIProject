@extends('layouts.app')
@section('content')
<div class="container">
    <h2>All Races </h2>           
    <table class="table">
      <thead>
        <tr>
          <th>Track</th>
        </tr>
    </thead>
@foreach($races as $value)
<tbody>
    <tr>
    <td>{{$value->circuit->name}}   
    <a href="/{{$value->season->tier}}/{{$value->season->season}}/race/{{$value->id}}" class="float-right btn btn-primary">View Results</a>
    </td>
      
    </tr> 



    

@endforeach
</tbody>
</table>
</div>
  
@endsection


        

     