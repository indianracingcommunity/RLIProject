@extends('layouts.app')
<style>
.card1 {
background:linear-gradient(45deg,#f09819,#edde5d);
}
.card2 {
/* background:linear-gradient(45.34deg, #EA52F8 5.66%, #0066FF 94.35%); */
background-color: #2f4353;
background-image: linear-gradient(315deg, #d2ccc4 0%,#2f4353 74%);
}
.card3 {
/* background:linear-gradient(45deg, #191654, #43C6AC);
*/
background: #B79891;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #94716B, #B79891);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #94716B, #B79891); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
</style>
@section('content')
<div class="container mx-auto flex">
   <div class="w-1/3">
   <div class="bg-white p-4 rounded-lg shadow-lg">
       @if($season['season'] == (int)$season['season'])
       <div class="font-bold text-gray-800 leading-none flex items-center">
           <div class="mr-4">
               <i class="fas fa-chess-king text-5xl text-purple-600"></i>
           </div>
           <div>
               <div class="text-3xl">
                   Tier {{$season['tier']}}
               </div>
                <div class="text-2xl font-semibold text-gray-700 leading-none">
                    Season {{$season['season']}}
                </div>
           </div>
       </div>
       @else
       <div class="text-4xl font-bold text-gray-800 leading-none">
          <i class="fas fa-chess-king text-purple-600"></i> {{$season['name']}}
       </div>
       @endif
   </div>
      @if($season['season'] - (int)$season['season'] < 0.75)
      <div class="py-2 my-4 leading-none bg-white p-4 rounded-lg shadow-lg">
        <div class="font-semibold my-2 leading-none uppercase tracking-widest text-xs border-b pb-4 text-indigo-600">
        Constructors` Standings
        </div>
        <div>
            <table class="w-full">
                <thead>
                    <th class="font-bold tracking-widest bg-purple-400 py-1 border-4 border-white">
                        TEAMS
                    </th>
                    <th class="font-bold tracking-wider text-white bg-purple-800 py-1 border-4 border-white">
                        POINTS
                    </th>
                </thead>
                @for ($i = 0; $i < $ccount; $i++)
                    @php
                        if($cres[$i]['name'] == 'Reserve')
                            continue;
                    @endphp
                    <tr>
                        <td class="font-semibold flex-grow text-md p-2 border-4 border-white bg-gray-100 ">
                            {{$cres[$i]['name']}}
                        </td>
                        <td class="bg-white font-semibold text-purple-600 text-center tracking-widest flex-grow text-md ">
                            {{$cres[$i]['points']}}
                        </td>
                    </tr>
                @endfor
            </table>
        </div>
      </div>
      @endif
      @if($nextRace != null)
      <div class="border rounded-md p-3">
         <div class="text-xl font-semibold text-gray-600">
            Next Race
         </div>
         <div class="text-4xl font-semibold text-purple-700">
            {{$nextRace['name']}}
         </div>
         <div class="mb-4">
            <img src="{{$nextRace['display']}}" alt="">
         </div>
         <div class="flex justify-between font-semibold">
            <div>
               Circuit Length
            </div>
            <div class="text-lg text-blue-700">
               {{$nextRace['track_length']}}
            </div>
         </div>
         <div class="flex justify-between font-semibold">
            <div>
               Number of laps
            </div>
            <div class="text-lg text-blue-700">
               {{$nextRace['laps']}}
            </div>
         </div>
      </div>
      @endif
   </div>
   <div class="w-3/4 ml-4">
      <div class="flex justify-center">
        @for ($i = 0, $k = 0; $i < $count && $k < 3; $i++, $k++)
         @php
            if((abs($res[$i]['status']) >= 10 && abs($res[$i]['status']) < 20) || $res[$i]['team']['name'] == 'Reserve')
            {
               $k--;
               continue;
            }
         @endphp
         @if($k == 0)
         <!-- <div class="card1 mx-2 text-white px-4 py-8 rounded-md hover:shadow-lg w-full text-center">
            <div class="text-4xl font-bold">
               1st
            </div>
            @if($season['season'] - (int)$season['season'] < 0.75)
            <div class="font-semibold">
               {{$res[$i]['team']['name']}}
            </div>
            @endif
            <div class="font-semibold text-xl">
               {{$res[$i]['name']}}
            </div>
         </div>
         @elseif($k == 1)
         <div class="card2 mx-2 text-white px-4 py-8 rounded-md hover:shadow-lg w-full text-center">
            <div class="text-4xl font-bold">
               2nd
            </div>
            @if($season['season'] - (int)$season['season'] < 0.75)
            <div class="font-semibold">
               {{$res[$i]['team']['name']}}
            </div>
            @endif
            <div class="font-semibold text-xl">
               {{$res[$i]['name']}}
            </div>
         </div>
         @elseif($k == 2)
         <div class="card3 ml-2 text-white px-4 py-8 rounded-md hover:shadow-lg w-full text-center">
            <div class="text-4xl font-bold">
               3rd
            </div>
            @if($season['season'] - (int)$season['season'] < 0.75)
            <div class="font-semibold">
               {{$res[$i]['team']['name']}}
            </div>
            @endif
            <div class="font-semibold text-xl">
               {{$res[$i]['name']}}
            </div>
         </div> -->
         @endif
         @endfor
      </div>
      <div class="bg-white rounded-lg shadow-lg p-4">
        <div class="font-semibold my-2 leading-none uppercase tracking-widest text-xs border-b pb-4 text-red-600">
            DRIVERS` STANDINGS
        </div>
          <table class="w-full">
             <thead>
                <tr>
                   <th class="font-bold tracking-widest bg-purple-400 py-1 border-4 border-white">POSITION</th>
                   <th class="font-bold tracking-widest bg-purple-800 text-white py-1 border-4 border-white">DRIVER</th>
                   @if($season['season'] - (int)$season['season'] < 0.75)
                   <th class="font-bold tracking-widest bg-purple-400 py-1 border-4 border-white">TEAM</th>
                   @endif
                   <th class="font-bold tracking-widest bg-purple-800 text-white py-1 border-4 border-white">POINTS</th>
                </tr>
             </thead>
             <tbody>
                @for ($i = 0, $k = 0; $i < $count; $i++, $k++)
                @php
                   if((abs($res[$i]['status']) >= 10 && abs($res[$i]['status']) < 20) || $res[$i]['team']['name'] == 'Reserve')
                   {
                      $k--;
                      continue;
                   }
                @endphp
                <tr>
                   @if ($res[$i]['user'] == Auth::id())
                   <td class="font-semibold flex-grow text-md p-2 border-4 border-white bg-green-200 text-center tracking-widest">{{$k+1}}</td>
                   @else
                   <td class="font-semibold flex-grow text-md p-2 border-4 border-white bg-gray-100 text-center tracking-widest">{{$k+1}}</td>
                   @endif
                   @if ($res[$i]['user'] == Auth::id())
                   <td class="font-semibold flex-grow text-md p-2 border-4 border-white bg-green-200 hover:underline cursor-pointer openDriver" data-driverLink="{{$res[$i]['user']}}" <a class="hover:underline" href="#">{{$res[$i]['name']}}</a></td>
                   @else
                   <td class="font-semibold flex-grow text-md p-2 border-4 border-white hover:underline cursor-pointer openDriver" data-driverLink="{{$res[$i]['user']}}"><a class="hover:underline" href="#">{{$res[$i]['name']}}</a></td>
                   @endif
                   @if($season['season'] - (int)$season['season'] < 0.75)
                   @if ($res[$i]['user'] == Auth::id())
                   <td class="font-semibold flex-grow text-md p-2 border-4 border-white bg-green-200">
                      {{$res[$i]['team']['name']}}
                   </td>
                   @else
                   <td class="font-semibold flex-grow text-md p-2 border-4 border-white bg-gray-100 ">
                      {{$res[$i]['team']['name']}}
                   </td>
                   @endif
                   @endif
                   @if ($res[$i]['user'] == Auth::id())
                   <td class="font-semibold flex-grow text-md p-2 border-4 border-white bg-green-200 text-purple-600 text-center tracking-widest" >{{$res[$i]['points']}}</td>
                   @else
                   <td class="font-semibold flex-grow text-md p-2 border-4 border-white text-purple-600 text-center tracking-widest">{{$res[$i]['points']}}</td>
                   @endif
                </tr>
                @endfor
             </tbody>
          </table>

      </div>
      @if ($reservecount != 0)
      <div class="shadow-lg rounded-lg p-4 bg-white mt-4">
      <div class="font-semibold my-2 leading-none uppercase tracking-widest text-xs border-b pb-4 text-gray-600">
         Reserves` Standings
      </div>
      <table class="w-full">
         <thead>
            <tr>
               <th class="font-bold tracking-widest bg-purple-400 py-1 border-4 border-white">POSITION</th>
               <th class="font-bold tracking-widest bg-purple-800 text-white py-1 border-4 border-white">DRIVER</th>
               @if($season['season'] - (int)$season['season'] < 0.75)
               <th class="font-bold tracking-widest bg-purple-400 py-1 border-4 border-white">TEAM</th>
               @endif
               <th class="font-bold tracking-widest bg-purple-800 text-white py-1 border-4 border-white">POINTS</th>
            </tr>
         </thead>
         <tbody>
            @for ($i = 0, $k = 0; $i < $count; $i++, $k++)
            @php
               if(!((abs($res[$i]['status']) >= 10 && abs($res[$i]['status']) < 20) || $res[$i]['team']['name'] == 'Reserve'))
               {
                  $k--;
                  continue;
               }
            @endphp
            <tr class="cursor-pointer">
               <td class="font-semibold rounded-lg border border-white" @if ($res[$i]['user'] == Auth::id()) style="background-color:#2f4353; color:white;" @endif>
                  {{$k+1}}
               </td>
               <td class="font-semibold rounded-lg border border-white" @if ($res[$i]['user'] == Auth::id()) style="background-color:#2f4353; color:white;" @endif>
                  <a class="hover:underline" href="/user/profile/view/{{$res[$i]['user']}}">{{$res[$i]['name']}}</a>
               </td>
               @if($season['season'] - (int)$season['season'] < 0.75)
               <td class="font-semibold rounded-lg border border-white" @if ($res[$i]['user'] == Auth::id()) style="background-color:#2f4353; color:white;" @endif>
                  <span>
                     {{$res[$i]['team']['name']}}
                  </span>
               </td>
               @endif
               <td class="font-semibold rounded-lg border border-white" @if ($res[$i]['user'] == Auth::id()) style="background-color:#2f4353; color:white;" @endif>
                  {{$res[$i]['points']}}
               </td>
            </tr>
            @endfor
         </tbody>
      </table>

      </div>
   </div>
</div>
@endif
<script>
   $( document ).ready(function() {
      $('.openDriver').click(function (e) {
         e.preventDefault();
         var linkId = $(this).attr('data-driverLink');
         console.log(linkId);
         window.open('/user/profile/view/'+linkId, '_blank');
      });
   });
</script>
@endsection
