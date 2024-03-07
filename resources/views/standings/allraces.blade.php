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
      padding-left: 10px;
   }
</style>
@section('content')
<div class="container mx-auto px-4 md:p-0">
   <div class="bg-white p-4 rounded-lg border mb-4 md:m-0 md:hidden block">
      <div class="font-bold text-gray-800 leading-none flex items-center">
         <div class="mr-4">
            <i class="fas fa-chess-king text-5xl text-purple-600"></i>
         </div>
         <div>
            <div class="text-3xl">
               {{$season['tiername']}}
            </div>
            <div class="text-2xl font-semibold text-gray-700 leading-none">
               Season {{(int)$season['season']}}
            </div>
         </div>
      </div>
   </div>

   <div class="flex flex-col-reverse md:flex-row md:gap-4">
      <div class="md:w-1/3 ">
         <div class="bg-white p-4 rounded-lg border mb-4 md:m-0 hidden md:block">
            <div class="font-bold text-gray-800 leading-none flex items-center">
               <div class="mr-4">
                  <i class="fas fa-chess-king text-5xl text-purple-600"></i>
               </div>
               <div>
                  <div class="text-3xl">
                     {{$season['tiername']}}
                  </div>
                  <div class="text-2xl font-semibold text-gray-700 leading-none">
                     Season {{(int)$season['season']}}
                  </div>
               </div>
            </div>
         </div>
         <div class="bg-white p-4 rounded-lg border mb-4 md:my-4">
            <div class="font-semibold my-2 leading-none uppercase tracking-widest text-xs border-b pb-4">
               Top 3 drivers
            </div>
            <table>
               <thead>
                  <tr>
                     <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white">Driver</th>
                     <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center">Points</th>
                  </tr>
               </thead>
               <tbody>
                  @for ($i = 0, $k = 0; $i < count($tdrivers) && $k < 3; $i++, $k++) @php if((abs($tdrivers[$i]['status'])>= 10 && abs($tdrivers[$i]['status']) < 20) || $tdrivers[$i]['team']['name']=='Reserve' ) { $k--; continue; } @endphp @if($k==0) <tr class="bg-gray-100">
                        <td class="font-semibold text-l rounded-lg border-2 border-white hover:underline cursor-pointer openDriver" data-driverLink="{{$tdrivers[$i]['user']}}">
                           <a href="#">{{$tdrivers[$i]['name']}}</a>
                        </td>
                        <td class="font-bold text-l rounded-lg border-2 border-white text-center tracking-widest py-2">
                           {{$tdrivers[$i]['points']}}
                        </td>
                        </tr>
                        @if($tdrivers[$i]['team']['car'] != null)
                        <tr class="bg-gray-300">
                           <td colspan="2" class="font-semibold rounded-lg border-2 border-white">
                              <img class="px-6 py-2 w-11/12" src="{{$tdrivers[$i]['team']['car']}}">
                           </td>
                        </tr>
                        @endif
                        @endif
                        @if($k == 1)
                        <tr class="bg-gray-100">
                           <td class="font-semibold text-l rounded-lg border-2 border-white hover:underline cursor-pointer openDriver" data-driverLink="{{$tdrivers[$i]['user']}}">
                              <a href="#">{{$tdrivers[$i]['name']}}</a>
                           </td>
                           <td class="font-bold text-l rounded-lg border-2 border-white text-center tracking-widest py-2">
                              {{$tdrivers[$i]['points']}}
                           </td>
                        </tr>
                        @if($tdrivers[$i]['team']['car'] != null)
                        <tr class="bg-gray-300">
                           <td colspan="2" class="font-semibold rounded-lg border-2 border-white">
                              <img class="px-6 py-2 w-11/12" src="{{$tdrivers[$i]['team']['car']}}">
                           </td>
                        </tr>
                        @endif
                        @endif
                        @if($k == 2)
                        <tr class="bg-gray-100">
                           <td class="font-semibold text-l rounded-lg border-2 border-white hover:underline cursor-pointer openDriver" data-driverLink="{{$tdrivers[$i]['user']}}">
                              <a href="#">{{$tdrivers[$i]['name']}}</a>
                           </td>
                           <td class="font-bold text-l rounded-lg border-2 border-white text-center tracking-widest py-2">
                              {{$tdrivers[$i]['points']}}
                           </td>
                        </tr>
                        @if($tdrivers[$i]['team']['car'] != null)
                        <tr class="bg-gray-300">
                           <td colspan="2" class="font-semibold rounded-lg border-2 border-white">
                              <img class="px-6 py-2 w-11/12" src="{{$tdrivers[$i]['team']['car']}}">
                           </td>
                        </tr>
                        @endif
                        @endif
                        @endfor
               </tbody>
            </table>
         </div>
         @if($season['season'] - (int)$season['season'] < 0.75) 
         <div class="bg-white p-4 rounded-lg border mb-4 md:my-4">
            <div class="font-semibold my-2 leading-none uppercase tracking-widest text-xs border-b pb-4">
               Top 3 Constructors
            </div>
            <table>
               <thead>
                  <tr>
                     <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white">Teams</th>
                     <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center">Points</th>
                  </tr>
               </thead>
               <tbody>
                  @for ($i = 0, $k = 0; $i < count($tconst) && $k < 3; $i++, $k++) @php if($tconst[$i]['team']['name']=='Reserve' ) { $k--; continue; } @endphp @if($k==0) <tr class="bg-gray-100">
                     <td class="font-semibold text-l rounded-lg border-2 border-white">
                        {{$tconst[$i]['name']}}
                     </td>
                     <td class="font-bold py-2 text-l rounded-lg border-2 border-white text-center tracking-widest">
                        {{$tconst[$i]['points']}}
                     </td>
                     </tr>
                     @if($tconst[$i]['team']['car'] != null)
                     <tr class="bg-gray-300">
                        <td colspan="2" class="font-semibold rounded-lg border-2 border-white">
                           <img class="px-6 py-2 w-11/12" src="{{$tconst[$i]['team']['car']}}">
                        </td>
                     </tr>
                     @endif
                     @endif
                     @if($k == 1)
                     <tr class="bg-gray-100">
                        <td class="font-semibold text-l rounded-lg border-2 border-white">
                           {{$tconst[$i]['name']}}
                        </td>
                        <td class="font-bold py-2 text-l rounded-lg border-2 border-white text-center tracking-widest">
                           {{$tconst[$i]['points']}}
                        </td>
                     </tr>
                     @if($tconst[$i]['team']['car'] != null)
                     <tr class="bg-gray-300">
                        <td colspan="2" class="font-semibold rounded-lg border-2 border-white">
                           <img class="px-6 py-2 w-11/12" src="{{$tconst[$i]['team']['car']}}">
                        </td>
                     </tr>
                     @endif
                     @endif
                     @if($k == 2)
                     <tr class="bg-gray-100">
                        <td class="font-semibold text-l rounded-lg border-2 border-white">
                           {{$tconst[$i]['name']}}
                        </td>
                        <td class="font-bold pt-2 text-l rounded-lg border-2 border-white text-center tracking-widest">
                           {{$tconst[$i]['points']}}
                        </td>
                     </tr>
                     @if($tconst[$i]['team']['car'] != null)
                     <tr class="bg-gray-300">
                        <td colspan="2" class="font-semibold rounded-lg border-2 border-white">
                           <img class="px-6 py-2 w-11/12" src="{{$tconst[$i]['team']['car']}}">
                        </td>
                     </tr>
                     @endif
                     @endif
                     @endfor
               </tbody>
            </table>
            </div>
            @endif
      
   </div>

   <div class="md:w-2/3">
      <div class="bg-white p-4 rounded-lg border leading-none overflow-y-auto mb-4">
         <div class="font-semibold my-1 leading-none uppercase tracking-widest border-b pb-2 flex justify-between font-semibold">
            <span class='text-xs pt-2'>
            All Races
            </span>
            <a title='Jump to Championship Standings' href="{{route('standings', ['code' => $code, 'tier' => $season['tier'], 'season' => $season['season']])}}" class="font-semibold cursor-pointer px-1 float-right rounded inline-flex items-center ">
               <span class='bg-yellow-200 hover:bg-gray-900 rounded p-1'> <i class='fas fa-trophy  p-1 text-yellow-500'></i></span>
            </a>
         </div>
         <table class="w-full">
            <thead>
               <tr>
                  <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center w-8">Rnd.</th>
                  <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white">Tracks</th>
                  <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center w-1/6">Actions</th>
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
                     <div class="py-2 flex items-center flex-shrink-0 gap-4">
                        <div class="text-center float-right">
                           <img src="{{$value->circuit->flag}}" class="w-12 mr-3 border rounded inline-block" alt="">
                        </div>
                        <div class="flex items-center flex-shrink-0">
                           <span class="hidden md:block">{{$value->circuit->name}}</span>
                           @php
                           $cname = substr($value->circuit->name,0,3)
                           @endphp
                           <span class="md:hidden block uppercase tracking-widest font-semibold">{{$cname}}</span>
                        </div>

                     </div>
                  </td>
                  <td>
                     <div class="text-center">
                        <a href="{{route('raceresults', ['code' => $code, 'tier' => $value->season->tier, 'season' => $value->season->season, 'round' => $value->round])}}" class="bg-gray-100 rounded text-gray-800 font-semibold p-2 hover:bg-indigo-100 hover:text-indigo-800"><i class="far fa-eye mr-2"></i>View</a>
                     </div>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
<!-- Admin View -->

@auth
   @can('admin|coordinator|steward')
   <div class="border p-5 confTable rounded-lg">
      <div class="text-2xl font-bold text-center">Admin/Coordinator Information</div>
      <div class="flex gap-5">
      <div class="text-lg font-semibold">Season ID: {{$season['id']}}</div>
      <div class="text-lg font-semibold">Tier: {{$season['tier']}}</div>
      <div class="text-lg font-semibold">Series: {{$season['series']}}</div>
      <div class="text-lg font-semibold">Status: {{$season['status']}}</div>
</div>
   </div>
   @endcan
@endauth

</div>
<script>
   $(document).ready(function() {
      $('.openDriver').click(function(e) {
         e.preventDefault();
         var linkId = $(this).attr('data-driverLink');
         window.open('/user/profile/view/' + linkId, '_blank');   //Need to replace with named route
      });
   });
   $('body').keypress(function (e) { 
      if(e.keyCode == 72 || e.keyCode == 104){
         $('.confTable').toggle();
      }
   });
   $('.confTable').toggle();
</script>
@endsection