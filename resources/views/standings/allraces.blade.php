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
<div class="container mx-auto w-5/6">
   <div class="flex">
      <div class="w-1/4">
         @if($season['season'] == (int)$season['season'])
         <div class="text-4xl font-bold text-gray-800 leading-none">
            <i class="fas fa-chess-king text-purple-600"></i> Tier {{$season['tier']}}
         </div>
         <div class="text-2xl font-semibold text-gray-700 leading-none">
            Season {{$season['season']}}
         </div>
         @else
         <div class="text-4xl font-bold text-gray-800 leading-none">
            <i class="fas fa-chess-king text-purple-600"></i> {{$season['name']}}
         </div>
         @endif
         <div class="bg-indigo-100 font-semibold p-3 rounded-md my-2">
            Welcome to the Results Page of this Season.
         </div>
      </div>
      <div class="w-5/6 mx-4">
         <h2 class="text-3xl font-semibold ml-20">All Races </h2>
         <table class="w-5/6 mx-auto">
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
                        {{$value->round}}
                     </div>
                  </td>
                  <td class="rounded-md border-2 border-white font-semibold flex justify-between">
                     <div class="py-2 flex items-center flex-shrink-0">
                        <div class="flex items-center flex-shrink-0">
                           {{$value->circuit->name}}
                        </div class="flex items-center flex-shrink-0">
                        
                     </div>
                     <div>
                        <a href="/{{$code}}/{{$value->season->tier}}/{{$value->season->season}}/race/{{$value->round}}" class="float-right bg-gray-100 rounded text-gray-800 font-semibold p-2 hover:bg-indigo-100 hover:text-indigo-800">View Results</a>
                        <img src="{{$value->circuit->flag}}" class="w-12 mr-8 border rounded float-right" alt="">
                     </div>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection
