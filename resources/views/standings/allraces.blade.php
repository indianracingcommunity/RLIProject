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
<div class="container mx-auto w-2/3">
<div class="flex">
  <div class="w-1/4">
    <div class="text-4xl font-bold text-gray-800">
      <i class="fas fa-chess-king text-purple-600"></i> Tier 1
    </div>
    <div class="text-2xl font-semibold text-gray-700">
      Season 4
    </div>
    <div class="bg-indigo-100 font-semibold p-3 rounded-md my-2">
      This is the All races page here you can select any race and get details about that particular race
    </div>
  </div>
  <div class="w-3/4 mx-4">
      <h2 class="text-3xl font-semibold">All Races </h2>           
      <table>
        <thead>
          <tr>
            <th class="bg-gray-300 rounded-md w-24 text-center border-2 border-white">Round</th>
            <th class="bg-gray-300 rounded-md border-2 border-white">Tracks</th>
          </tr>
      </thead>
      <tbody>
  @foreach($races as $ie=>$value)
      <tr>
      <td class="rounded-md border-2 border-white font-semibold">
        <div class="py-2 text-center">
        {{$ie+1}}
        </div>
      </td>
      <td class="rounded-md border-2 border-white font-semibold flex justify-between">
      <div class="py-2">
        {{$value->circuit->name}}
      </div> 
      </tf>  
      <a href="/{{$value->season->tier}}/{{$value->season->season}}/race/{{$value->id}}" class="float-right bg-gray-100 rounded text-gray-800 font-semibold p-2 hover:bg-indigo-100 hover:text-indigo-800">View Results</a>
      </td>
      </tr> 
  @endforeach
  </tbody>
  </table>

  </div>
</div>
</div>
  
@endsection


        

     