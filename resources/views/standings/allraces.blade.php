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

   <div class="block sm:block md:block lg:flex xl:flex justify-center w-full">
      
      <div class="block pt-5 justify-center items-center w-full sm:w-full md:w-full lg:w-1/6 xl:w-1/6 px-1 sm:px-1 md:px-1 lg:px-4 xl:px-4">
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
         <div class="bg-indigo-100 font-semibold p-3 rounded-md my-2">
            Welcome to the Results Page of this Season.
         </div>
      </div>
      <div class="w-full sm:w-full md:w-full lg:w-2/5 xl:w-2/5 pt-5 px-1 sm:px-1 md:px-1 lg:px-10 xl:px-10">
         <h2 class="text-3xl font-semibold">All Races </h2>
         <table class="w-full">
            <thead>
               <tr>
                  <th class="bg-gray-300 border rounded-md text-center border-2 border-white">Round</th>
                  <th class="bg-gray-300 border rounded-md border-2 border-white">Tracks</th>
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
                  <td class="rounded-md border-2 border-white font-semibold flex justify-between items-center">
                     <div class="py-2 w-2/6 truncate flex items-center flex-shrink-0">
                           {{$value->circuit->name}}
                     </div>
                     <div class="flex items-center">
                        <img src="{{$value->circuit->flag}}" class="w-12 mr-2 sm:mx-2 md:mx-2 lg:mr-8 xl:mr-8 border rounded float-right" alt="">
                        <a href="/{{$code}}/{{$value->season->tier}}/{{$value->season->season}}/race/{{$value->round}}" class="float-right bg-gray-100 rounded text-gray-800 font-semibold p-2 hover:bg-indigo-100 hover:text-indigo-800">View Results</a>
                        
                     </div>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>

@endsection
