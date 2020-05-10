@extends('layouts.app')
<style>
table {
  width: 100%
}
th {
  padding: 10px;
  text-align: left;
}

td {
  padding-left:10px;
}
</style>
@section('content')
<div class="container mx-auto w-2/3 flex">
  <div class="1/3">
    Tier 1
  </div>
  <div class="2/3">
      <h2 class="text-3xl font-semibold">All Races </h2>           
      <table class="table">
        <thead>
          <tr>
            <th class="bg-gray-300 rounded-md">Tracks</th>
          </tr>
      </thead>
      <tbody>
  @foreach($races as $value)
      <tr>
      <td class="rounded-md border-2 border-white font-semibold flex justify-between">
      <div class="py-2">
        {{$value->circuit->name}}
      </div>   
      <a href="/{{$value->season->tier}}/{{$value->season->season}}/race/{{$value->id}}" class="float-right bg-blue-600 rounded text-white font-semibold p-2 hover:bg-blue-700">View Results</a>
      </td>
      </tr> 
  @endforeach
  </tbody>
  </table>

  </div>
</div>
  
@endsection


        

     