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
@php 
Log::info(print_r($tdrivers,true));
@endphp
@section('content')
<div class="container mx-auto w-11/12">
   <div class="flex">
      <div class="w-2/6">
         @if($season['season'] == (int)$season['season'])
         <div class="text-4xl font-bold text-gray-800 leading-tight">
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
         {{-- <div class="bg-indigo-100 font-semibold p-3 rounded-md my-2">
            Welcome to the Results Page of this Season.
         </div> --}}
         <div class="bg-purple-100 mt-2">
            <div class="text-2xl text-purple-700  rounded-md bg-purple-200 text-center p-4 leading-none cf font-bold">
               Top 3 Drivers
            </div>
            @for ($i = 0, $k = 0; $i < count($tdrivers) && $k < 3; $i++, $k++)
            @php
            if((abs($tdrivers[$i]['status']) >= 10 && abs($tdrivers[$i]['status']) < 20) || $tdrivers[$i]['team']['name'] == 'Reserve')
            {
            $k--;
            continue;
            }
            @endphp
            @if($k == 0)
            <div class="border hover:shadow-lg shadow-md text-center bg-yellow-300 rounded-md leading-none">
               <div class="text-2xl font-bold p-4">
                  1st : {{$tdrivers[$i]['name']}}
               </div>
               <div class="flex justify-center p-2">
                  <img class="h-10" src="https://www.f1gamesetup.com/img/teams/2019/mclaren-2019.png">
               </div>
            </div>
            @endif
            @if($k == 1)
            <div class="border hover:shadow-lg shadow-md mt-2 text-center bg-gray-200 rounded-md leading-none">
               <div class="text-2xl font-bold p-4">
                  2nd : {{$tdrivers[$i]['name']}}
               </div>
               <div class="flex justify-center p-2">
                  <img class="h-10" src="https://www.f1gamesetup.com/img/teams/2019/mclaren-2019.png">
               </div>
            </div>
            @endif
            @if($k == 2)
            <div class="border hover:shadow-lg shadow-md mt-2 text-center bg-orange-200 rounded-md leading-none">
               <div class="text-2xl font-bold p-4">
                  3rd : {{$tdrivers[$i]['name']}}
               </div>
               <div class="flex justify-center p-2">
                  <img class="h-10" src="https://www.f1gamesetup.com/img/teams/2019/mclaren-2019.png">
               </div>
            </div>
            @endif
            @endfor
         </div>
         <div class="bg-purple-100 ">
            <div class="text-2xl text-purple-700 text-center rounded-md bg-purple-200 text-center p-4 mt-3 leading-none cf font-bold">
               Top 3 Constructors
            </div>
            <div class="border hover:shadow-lg shadow-md  text-center bg-yellow-300 rounded-md leading-none">
               <div class="flex justify-center p-2">
                  <img class="h-10" src="https://www.f1gamesetup.com/img/teams/2019/mclaren-2019.png">
               </div>
            </div>
            <div class="border hover:shadow-lg shadow-md mt-2 text-center bg-gray-200 rounded-md leading-none">
               <div class="flex justify-center p-2">
                  <img class="h-10" src="https://www.f1gamesetup.com/img/teams/2019/mclaren-2019.png">
               </div>
            </div>
            <div class="border hover:shadow-lg shadow-md mt-2 text-center bg-orange-200 rounded-md leading-none">
               <div class="flex justify-center p-2">
                  <img class="h-10" src="https://www.f1gamesetup.com/img/teams/2019/mclaren-2019.png">
               </div>
            </div>
         </div>
      </div>
      <div class="w-5/6">
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
