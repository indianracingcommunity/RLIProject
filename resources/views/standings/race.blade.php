@extends('layouts.app')
<style>
tr:nth-child(even) td {
  /* background-color: #EDF2F7; */
}
.fast {
  backgroun-color: red !important;
}
table {
  width: 110%
}
th {
  padding: 10px;
  text-align: left;
}
td {
  padding-left:10px;
  padding-top:5px;
  padding-bottom: 5px;
}
</style>
@section('content')
<div class="container w-5/6 mx-auto">
  <div class="flex">
    <div class="w-1/4"> 
    <div class="border rounded-md p-3">
    <div class="text-4xl font-semibold text-purple-700 leading-none mb-4">
    {{$results[0]['race']['circuit']['name']}}
    </div>
    <div class="mb-4">
      <img src="{{$results[0]['race']['circuit']['display']}}" alt="">
    </div>
    <div class="flex justify-between font-semibold">
      <div>
        Circuit Length
      </div>
      <div class="text-lg text-blue-700">
       {{$results[0]['race']['circuit']['track_length']}}
      </div>
    </div>
    <div class="flex justify-between font-semibold">
      <div>
        Number of Laps
      </div>
      <div class="text-lg text-blue-700">
       {{$results[0]['race']['circuit']['laps']}}
      </div>
    </div>
    </div>
  </div>
  <div class="w-3/4 mx-4">
  <div class="font-semibold">
    Race Results
  </div>
      <table class="table">
        <thead>
          <tr>
            <th class="rounded-md bg-gray-300 border-2 border-white w-8">Position</th>
            <th class="rounded-md bg-gray-300 border-2 border-white">Driver</th>
            <th class="rounded-md bg-gray-300 border-2 border-white">Team</th>
            <th class="rounded-md bg-gray-300 border-2 border-white">Points</th>
          </tr>
      </thead>
  <tbody>
  @for ($i = 0; $i < $count; $i++)
    @if((int)$results[$i]['status'] % 10 == 1)
      <tr>
        <td class="font-bold rounded-lg border border-white bg-purple-200 text-purple-700 fast">{{$i+1}}</td>
        <td class="font-bold rounded-lg border border-white bg-purple-200 text-purple-700"><a class="hover:underline" href="/user/profile/view/{{$results[$i]['driver']['user_id']}}">{{$results[$i]['driver']['name']}}</a></td>
        <td class="font-bold rounded-lg border border-white bg-purple-200 text-purple-700">{{$results[$i]['constructor']['name']}}</td>
        <td class="font-bold rounded-lg border border-white bg-purple-200 text-purple-700">{{$results[$i]['points']}}</td>
      </tr>
    @elseif($i % 2 != 0)
     <tr>
        @if ($results[$i]['driver']['user_id'] == Auth::id())
          <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white">{{$i+1}}</td>
        @else
          <td class="font-semibold rounded-lg border border-white bg-gray-200">{{$i+1}}</td>
        @endif
        @if ($results[$i]['driver']['user_id'] == Auth::id())
         <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white"><a class="hover:underline" href="/user/profile/view/{{$results[$i]['driver']['user_id']}}">{{$results[$i]['driver']['name']}}</a></td>
        @else 
         <td class="font-semibold rounded-lg border border-white bg-gray-200"><a class="hover:underline" href="/user/profile/view/{{$results[$i]['driver']['user_id']}}">{{$results[$i]['driver']['name']}}</a></td>
        @endif
        @if ($results[$i]['driver']['user_id'] == Auth::id())
          <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white">{{$results[$i]['constructor']['name']}}</td>
        @else
          <td class="font-semibold rounded-lg border border-white bg-gray-200">{{$results[$i]['constructor']['name']}}</td>
        @endif
        @if ($results[$i]['driver']['user_id'] == Auth::id())
        <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white">{{$results[$i]['points']}}</td>
        @else
          <td class="font-semibold rounded-lg border border-white bg-gray-200">{{$results[$i]['points']}}</td>
        @endif
     </tr>
    @else
        <!-- <tr>
          <td class="font-semibold rounded-lg border border-white">{{$i+1}}</td>
          
          @if ($results[$i]['driver']['user_id'] == Auth::id())
          <td class="font-extrabold rounded-lg border border-white"><a class="hover:underline" href="/user/profile/view/{{$results[$i]['driver']['user_id']}}">{{$results[$i]['driver']['name']}}</a></td>
          @else 
          <td class="font-semibold rounded-lg border border-white"><a class="hover:underline" href="/user/profile/view/{{$results[$i]['driver']['user_id']}}">{{$results[$i]['driver']['name']}}</a></td>
          @endif
          
          <td class="font-semibold rounded-lg border border-white">{{$results[$i]['constructor']['name']}}</td>
          <td class="font-semibold rounded-lg border border-white">{{$results[$i]['points']}}</td>
        </tr> -->
        <tr>
        @if ($results[$i]['driver']['user_id'] == Auth::id())
          <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white">{{$i+1}}</td>
        @else
          <td class="font-semibold rounded-lg border border-white">{{$i+1}}</td>
        @endif
        @if ($results[$i]['driver']['user_id'] == Auth::id())
         <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white"><a class="hover:underline" href="/user/profile/view/{{$results[$i]['driver']['user_id']}}">{{$results[$i]['driver']['name']}}</a></td>
        @else 
         <td class="font-semibold rounded-lg border border-white"><a class="hover:underline" href="/user/profile/view/{{$results[$i]['driver']['user_id']}}">{{$results[$i]['driver']['name']}}</a></td>
        @endif
        @if ($results[$i]['driver']['user_id'] == Auth::id())
          <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white">{{$results[$i]['constructor']['name']}}</td>
        @else
          <td class="font-semibold rounded-lg border border-white">{{$results[$i]['constructor']['name']}}</td>
        @endif
        @if ($results[$i]['driver']['user_id'] == Auth::id())
        <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white">{{$results[$i]['points']}}</td>
        @else
          <td class="font-semibold rounded-lg border border-white">{{$results[$i]['points']}}</td>
        @endif
     </tr>
    @endif
  @endfor
  </tbody>
  </table>
  </div>          
</div>
  
@endsection


        

     
