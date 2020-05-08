@extends('layouts.app')
@section('content')
<div class="container">
    <h2>{{$results[0]['race']['circuit']['name']}} </h2>           
    <table class="table">
      <thead>
        <tr>
          <th>Driver</th>
          <th>Points</th>
        </tr>
    </thead>
@for ($i = 0 ; $i < $count; $i++)
<tbody>
    <tr>
      <td>{{$results[$i]['driver']['name']}}</td>
      <td>{{$results[$i]['points']}}</td>
    </tr> 



    

@endfor
</tbody>
</table>
</div>
  
@endsection


        

     