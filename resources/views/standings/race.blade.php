@extends('layouts.app')
<style>
tr:nth-child(even) td {
  /* background-color: #EDF2F7; */
}
.fast {
  backgroun-color: red !important;
}
table {
  width: 100%
}
th {
  padding: 10px;
  text-align: left;
}
tr:hover, td:hover {background-color: #E2E8F0;}
td {
  padding-left:10px;
  padding-top:5px;
  padding-bottom: 5px;
}
</style>
@section('content')
<div class="container w-2/3 mx-auto">
  <div class="flex">
    <div class="w-1/4"> 
    <div class="border rounded-md p-3">
    <div class="text-4xl font-semibold text-purple-700">
    {{$results[0]['race']['circuit']['name']}}
    </div>
    <div class="mb-4">
      <img src="https://www.formula1.com/content/dam/fom-website/2018-redesign-assets/Circuit%20maps%2016x9/Australia_Circuit.png.transform/9col/image.png" alt="">
    </div>
    <div class="flex justify-between font-semibold">
      <div>
        Circuit Length
      </div>
      <div class="text-lg text-blue-700">
        5.303 km
      </div>
    </div>
    <div class="flex justify-between font-semibold">
      <div>
        Number of laps
      </div>
      <div class="text-lg text-blue-700">
       30
      </div>
    </div>
    </div>
  </div>
  <div class="w-3/4 mx-4">
  <div class="font-semibold">
    Drivers` Standing
  </div>
      <table class="table">
        <thead>
          <tr>
            <th class="rounded-md bg-gray-300 border-2 border-white w-8">Position</th>
            <th class="rounded-md bg-gray-300 border-2 border-white">Driver</th>
            <th class="rounded-md bg-gray-300 border-2 border-white">Points</th>
          </tr>
      </thead>
  <tbody>
  @for ($i = 0 ; $i < $count; $i++)
  @if($results[$i]['status'] == 1)
      <tr>
        <td class="font-bold rounded-lg border border-white bg-purple-200 text-purple-700 fast">{{$i+1}}</td>
        
        <td class="font-bold rounded-lg border border-white bg-purple-200 text-purple-700">{{$results[$i]['driver']['name']}}</td>
        
        <td class="font-bold rounded-lg border border-white bg-purple-200 text-purple-700">{{$results[$i]['points']}}</td>
      </tr> 
    @elseif($i%2 != 0)
    <tr>
        <td class="font-semibold rounded-lg border border-white bg-gray-200">{{$i+1}}</td>
        
        <td class="font-semibold rounded-lg border border-white bg-gray-200">{{$results[$i]['driver']['name']}}</td>
        
        <td class="font-semibold rounded-lg border border-white bg-gray-200">{{$results[$i]['points']}}</td>
      </tr> 
    @else
      <tr>
        <td class="font-semibold rounded-lg border border-white">{{$i+1}}</td>
        
        <td class="font-semibold rounded-lg border border-white">{{$results[$i]['driver']['name']}}</td>
        
        <td class="font-semibold rounded-lg border border-white">{{$results[$i]['points']}}</td>
      </tr> 
    @endif



      

  @endfor
  </tbody>
  </table>
  
  </div>          
</div>
  
@endsection


        

     