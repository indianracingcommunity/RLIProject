@extends('layouts.app')
<style>
   tr:nth-child(even) td {
      background-color: #edf2f7;
   }

   table {
      width: 100%
   }

   th {
      padding: 10px;
      text-align: left;
   }

   tr:hover,
   td:hover {
      background-color: #e2e8f0;
   }

   td {
      padding-left: 10px;
      padding-top: 5px;
      padding-bottom: 5px;
   }

   .card1 {
      background: linear-gradient(45deg, #f09819, #edde5d);
   }

   .card2 {
      /* background:linear-gradient(45.34deg, #EA52F8 5.66%, #0066FF 94.35%); */
      background-color: #2f4353;
      background-image: linear-gradient(315deg, #d2ccc4 0%, #2f4353 74%);
   }

   .card3 {
      /* background:linear-gradient(45deg, #191654, #43C6AC);
*/
      background: #B79891;
      /* fallback for old browsers */
      background: -webkit-linear-gradient(to right, #94716B, #B79891);
      /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to right, #94716B, #B79891);
      /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
   }
</style>
@section('content')

<div class="container mx-auto px-4 md:p-0">
   <div class="pb-6 md:mb-4 leading-none md:p-0 flex items-center justify-between">
      <div class="text-4xl font-bold">
         Championship Standings
      </div>
      <!-- <div class="text-sm  px-4 py-2 rounded-md flex items-center font-semibold text-white bg-purple-600 hover:bg-purple-500 cursor-pointer">
         Race Results <i class="fas fa-external-link-alt ml-1"></i>
      </div> -->
   </div>
   <div class="flex flex-col md:flex-row">
      <div class="bg-white p-4 rounded-lg border md:w-1/3 mb-4 md:m-0">
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
      <div class="md:ml-4 md:w-2/3 flex justify-between flex-col md:flex-row md:gap-4">
         @for ($i = 0, $k = 0; $i < $count && $k < 3; $i++, $k++) @php if((abs($res[$i]['status'])>= 10 && abs($res[$i]['status']) < 20) || $res[$i]['team']['name']=='Reserve' ) { $k--; continue; } @endphp @if($k==0) <div class="bg-white p-4 rounded-lg border md:w-1/3 mb-4 md:m-0">
               <div class="font-bold text-gray-800 leading-none flex items-center">
                  <div class="mr-4">
                     <i class="fas fa-award text-5xl" style="color: gold;"></i>
                  </div>
                  <div>
                     <div class="text-xl">
                        {{$res[$i]['name']}}
                     </div>
                     <div class="text font-semibold text-gray-700 leading-none">
                        {{$res[$i]['team']['name']}}
                     </div>
                  </div>
               </div>
      </div>
      @elseif($k == 1)
      <div class="bg-white p-4 rounded-lg border md:w-1/3 mb-4 md:m-0">
         <div class="font-bold text-gray-800 leading-none flex items-center">
            <div class="mr-4">
               <i class="fas fa-award text-5xl" style="color: silver;"></i>
            </div>
            <div>
               <div class="text-xl">
                  {{$res[$i]['name']}}
               </div>
               <div class="text font-semibold text-gray-700 leading-none">
                  {{$res[$i]['team']['name']}}
               </div>
            </div>
         </div>
      </div>
      @elseif($k == 2)
      <div class="bg-white p-4 rounded-lg border md:w-1/3 mb-4 md:m-0">
         <div class="font-bold text-gray-800 leading-none flex items-center">
            <div class="mr-4">
               <i class="fas fa-award text-5xl" style="color: #b08d57;"></i>
            </div>
            <div>
               <div class="text-xl">
                  {{$res[$i]['name']}}
               </div>
               <div class="text font-semibold text-gray-700 leading-none">
                  {{$res[$i]['team']['name']}}
               </div>
            </div>
         </div>
      </div>
      @endif
      @endfor

   </div>
</div>

<div class="flex flex-col-reverse md:flex-row">
   <div class="md:w-1/3">
      @if($season['season'] - (int)$season['season'] < 0.75) <div class="my-4 leading-none bg-white p-4 rounded-lg border">
         <div class="font-semibold my-2 leading-none uppercase tracking-widest text-xs border-b pb-4">
            Constructors` Standings
         </div>
         <table>
            <thead>
               <tr>
                  <th class="border-2 rounded-lg bg-gray-800 tracking-widest text-gray-100 border-white">Teams</th>
                  <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center">Points</th>
               </tr>
            </thead>
            <tbody>
               @for ($i = 0; $i < $ccount; $i++) @php if($cres[$i]['name']=='Reserve' ) continue; @endphp <tr class="">
                  <td class="font-semibold rounded-lg border border-white">
                     {{$cres[$i]['name']}}
                  </td>
                  <td class="font-bold rounded-lg border tracking-widest border-white text-center">
                     {{$cres[$i]['points']}}
                  </td>
                  </tr>
                  @endfor
            </tbody>
         </table>
   </div>
   @endif

   @if(count($flaps)>0)
   <div class="bg-white p-4 rounded-lg border leading-none">
      <div class="font-semibold my-2 leading-none uppercase tracking-widest text-xs border-b pb-4 text-purple-700">
         Fastest Laps
      </div>
      <table>
         <thead>
            <tr>
               <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white">Driver</th>
               <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center">Fastest Laps</th>
            </tr>
         </thead>
         <tbody>
            @for ($i = 0; $i < count($flaps); $i++) @if($flaps !=0 && $flaps !='0' ) <tr class="">
               <td class="font-semibold rounded-lg border border-white">
                  {{$flaps[$i]['name']}}
               </td>
               <td class="font-semibold text-center rounded-lg border border-white">
                  {{$flaps[$i]['flaps']}}
               </td>
               </tr>
               @endif
               @endfor
         </tbody>
      </table>
   </div>
   @endif

   @if(count($penalties)>0)
   <div class="bg-white p-4 rounded-lg border mt-4 leading-none">
      <div class="font-semibold my-2 leading-none uppercase tracking-widest text-xs border-b pb-4 text-orange-500">
         Driver Penalties
      </div>
      <table>
         <thead>
            <tr>
               <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white">Driver</th>
               <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 text-center border-white">Penalty/Warning</th>
            </tr>
         </thead>
         <tbody>
            @for ($i = 0; $i < count($penalties); $i++) @php $penalty=$penalties[$i]['penalties']; $warnings=0; if(floor( $penalty ) !=$penalties[$i]['penalties']){ $warnings=1; } @endphp @if($penalty !=0 && $penalty !='0' ) <tr class="">
               <td class="font-semibold rounded-lg border border-white">
                  {{$penalties[$i]['name']}}
               </td>
               <td class="font-semibold text-center rounded-lg border border-white">
                  @if (floor( $penalty ) != 0)
                  {{floor( $penalty )}}
                  @endif

                  @if ($warnings != 0)
                  @if (floor( $penalty ) != 0)
                  +
                  @endif
                  Warning
                  @endif
               </td>
               </tr>
               @endif
               @endfor
         </tbody>
      </table>
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

<div class="md:w-2/3 md:ml-4 md:mt-4">
   <div class="bg-white p-4 rounded-lg border">
      <div class="font-semibold my-2 leading-none uppercase tracking-widest text-xs border-b pb-4">
         Drivers' Standings
      </div>
      <div class="overflow-y-auto pb-4">
         <table>
            <thead>
               <tr>
                  <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center">Pos.</th>
                  <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white">Driver</th>
                  @if($season['season'] - (int)$season['season'] < 0.75) <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white md:block hidden">Team</th>
                     @endif
                     <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 text-center border-white">Points</th>
               </tr>
            </thead>
            <tbody>
               @for ($i = 0, $k = 0; $i < $count; $i++, $k++) @php if((abs($res[$i]['status'])>= 10 && abs($res[$i]['status']) < 20) || $res[$i]['team']['name']=='Reserve' ) { $k--; continue; } @endphp <tr>
                     @if ($res[$i]['user'] == Auth::id())
                     <td class="font-semibold rounded border border-white text-white text-center tracking-widest" style="background-color:#2f4353">{{$k+1}}</td>
                     @else
                     <td class="font-semibold rounded-lg border border-white text-center tracking-widest">{{$k+1}}</td>
                     @endif
                     @if ($res[$i]['user'] == Auth::id())
                     <td class="font-bold rounded border border-white text-white hover:underline cursor-pointer openDriver" data-driverLink="{{$res[$i]['user']}}" style="background-color:#2f4353"><a class="hover:underline" href="#">{{$res[$i]['name']}}</a></td>
                     @else
                     <td class="font-bold tracking-wide rounded-lg border border-white hover:underline cursor-pointer openDriver" data-driverLink="{{$res[$i]['user']}}"><a class="hover:underline" href="#">{{$res[$i]['name']}}</a></td>
                     @endif
                     @if($season['season'] - (int)$season['season'] < 0.75) @if ($res[$i]['user']==Auth::id()) <td class="font-semibold rounded border border-white text-white hidden md:block" style="background-color:#2f4353">
                        {{$res[$i]['team']['name']}}
                        </td>
                        @else
                        <td class="font-semibold rounded-lg border border-white hidden md:block">
                           {{$res[$i]['team']['name']}}
                        </td>
                        @endif
                        @endif
                        @if ($res[$i]['user'] == Auth::id())
                        <td class="font-bold rounded border border-white text-white text-center tracking-widest" style="background-color:#2f4353">{{$res[$i]['points']}}</td>
                        @else
                        <td class="font-bold rounded-lg border border-white text-center tracking-widest">{{$res[$i]['points']}}</td>
                        @endif
                        </tr>
                        @endfor
            </tbody>
         </table>
      </div>
   </div>
   @if ($reservecount != 0)
   <div class="p-4 border rounded-lg bg-white my-4 overflow-y-auto">
      <div class="font-semibold my-2 leading-none uppercase tracking-widest text-xs border-b pb-4">
         Reserves` Standings
      </div>
      <div class="overflow-y-auto pb-4">
         <table>
            <thead>
               <tr>
                  <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center">Pos.</th>
                  <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white">Driver</th>
                  @if($season['season'] - (int)$season['season'] < 0.75) <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white hidden md:block">Team</th>
                     @endif
                     <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center">Points</th>
               </tr>
            </thead>
            <tbody>
               @for ($i = 0, $k = 0; $i < $count; $i++, $k++) @php if(!((abs($res[$i]['status'])>= 10 && abs($res[$i]['status']) < 20) || $res[$i]['team']['name']=='Reserve' )) { $k--; continue; } @endphp <tr class="cursor-pointer">
                     <td class="font-semibold rounded-lg border border-white text-center tracking-widest" @if ($res[$i]['user']==Auth::id()) style="background-color:#2f4353; color:white;" @endif>
                        {{$k+1}}
                     </td>
                     <td class="font-bold rounded-lg border border-white tracking-wide" @if ($res[$i]['user']==Auth::id()) style="background-color:#2f4353; color:white;" @endif>
                        <a class="hover:underline" href="{{route('user.profile', ['user' => $res[$i]['user']])}}">{{$res[$i]['name']}}</a>
                     </td>
                     @if($season['season'] - (int)$season['season'] < 0.75) <td class="font-semibold rounded-lg border border-white md:block hidden" @if ($res[$i]['user']==Auth::id()) style="background-color:#2f4353; color:white;" @endif>
                        <span>
                           {{$res[$i]['team']['name']}}
                        </span>
                        </td>
                        @endif
                        <td class="font-bold rounded-lg border border-white text-center tracking-widest" @if ($res[$i]['user']==Auth::id()) style="background-color:#2f4353; color:white;" @endif>
                           {{$res[$i]['points']}}
                        </td>
                        </tr>
                        @endfor
            </tbody>
         </table>
      </div>
   </div>
   @endif
</div>
</div>


<!-- Admin View -->

@auth
   @view('admin,coordinator')
   <div class="border p-5 mt-2 confTable rounded-lg">
      <div class="text-2xl font-bold text-center">Admin/Coordinator Information</div>
      <div class="flex gap-5">
      <div class="text-lg font-semibold">Season ID: {{$season['id']}}</div>
      <div class="text-lg font-semibold">Tier: {{$season['tier']}}</div>
      <div class="text-lg font-semibold">Series: {{$season['series']}}</div>
      <div class="text-lg font-semibold">Status: {{$season['status']}}</div>
</div>
   </div>
   @endview
@endauth
<script>
   $(document).ready(function() {
      $('.openDriver').click(function(e) {
         e.preventDefault();
         var linkId = $(this).attr('data-driverLink');
         console.log(linkId);
         window.open('/user/profile/view/' + linkId, '_blank');
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