@extends('layouts.app')
@section('content')
<div class="container">
    <h2>IRC Standings</h2>
    <p>Standings for Season : </p>            
    <table class="table">
      <thead>
        <tr>
          <th>Firstname</th>
          <th>Points</th>
        </tr>
    </thead>
@for ($i = 0 ; $i < $count; $i++)
<tbody>
    <tr>
      <td>{{$res[$i]['name']}}</td>
      <td>{{$res[$i]['points']}}</td>
    </tr> 



    

@endfor
</tbody>
</table>
</div>
  
@endsection


        

     