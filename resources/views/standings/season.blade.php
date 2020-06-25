@extends('layouts.app')
<style>
tr:nth-child(even) td {
  background-color: #EDF2F7;
  margin:5px;
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

    @if($season['season'] - (int)$season['season'] < 0.75)
    <div class="bg-gray-100 rounded-md px-4 py-2 my-4 leading-none">
      <div class="text-sm font-semibold my-2 leading-none">
        Constructor Standings
      </div>
      <table>
        <thead>
        <tr>
          <th class="rounded-md bg-gray-300 border-2 border-white">Teams</th>
          <th  class="rounded-md bg-gray-300 border-2 border-white">Points</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0 ; $i < $ccount; $i++)
          <tr class="cursor-pointer">
            <td class="font-semibold rounded-lg border border-white">
            {{$cres[$i]['name']}}
            </td>
            <td class="font-semibold rounded-lg border border-white">
            {{$cres[$i]['points']}}
            </td>
          </tr>
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
    <div class="w-3/4 mx-5">
      <div class="flex mb-6 justify-center">
      @for ($i = 0, $k = 0; $i < $count && $k < 3; $i++, $k++)
       @php
        if((abs($res[$i]['status']) >= 10 && abs($res[$i]['status']) < 20) || $res[$i]['team']['name'] == 'Reserve')
        {
            $k--;
            continue;
        }
       @endphp

       @if($k == 0)
         <div class="card1 mr-8 text-white px-4 py-8 rounded-md hover:shadow-lg w-full text-center">
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
         <div class="card2 mr-8 text-white px-4 py-8 rounded-md hover:shadow-lg w-full text-center">
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
         <div class="card3 mr-8 text-white px-4 py-8 rounded-md hover:shadow-lg w-full text-center">
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
         </div>
       @endif
      @endfor
      </div>

      <div class="text-s font-semibold">
      Drivers' Standings
      </div>
      <table class="table">
        <thead>
          <tr>
            <th class="rounded-md bg-gray-300 border-2 border-white">Position</th>
            <th class="rounded-md bg-gray-300 border-2 border-white">Driver</th>
            @if($season['season'] - (int)$season['season'] < 0.75)
            <th class="rounded-md bg-gray-300 border-2 border-white">Team</th>
            @endif
            <th class="rounded-md bg-gray-300 border-2 border-white">Points</th>
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
            <tr class="cursor-pointer">
              @if ($res[$i]['user'] == Auth::id())
              <td class="font-semibold rounded border border-white text-white" style="background-color:#2f4353">{{$k+1}}</td>
              @else
              <td class="font-semibold rounded-lg border border-white">{{$k+1}}</td>
              @endif
              @if ($res[$i]['user'] == Auth::id())
                <td class="font-bold rounded border border-white text-white" style="background-color:#2f4353">{{$res[$i]['name']}}</td>
              @else
              <td class="font-semibold rounded-lg border border-white">{{$res[$i]['name']}}</td>
              @endif
            
              @if($season['season'] - (int)$season['season'] < 0.75)
                @if ($res[$i]['user'] == Auth::id())
                <td class="font-semibold rounded border border-white text-white" style="background-color:#2f4353">
                    {{$res[$i]['team']['name']}}
                </td>
                @else
                <td class="font-semibold rounded-lg border border-white">
                    {{$res[$i]['team']['name']}}
                </td>
                @endif
              @endif
              @if ($res[$i]['user'] == Auth::id())
              <td class="font-semibold rounded border border-white text-white" style="background-color:#2f4353">{{$res[$i]['points']}}</td>
              @else
              <td class="font-semibold rounded-lg border border-white">{{$res[$i]['points']}}</td>
              @endif
            </tr> 
          @endfor
        </tbody>
      </table>

    @if ($reservecount != 0)
      <div class="font-semibold mt-8">
      Reserves` Standings
      </div>
      <table class="table">
        <thead>
          <tr>
            <th class="rounded-md bg-gray-300 border-2 border-white">Position</th>
            <th class="rounded-md bg-gray-300 border-2 border-white">Driver</th>
            @if($season['season'] - (int)$season['season'] < 0.75)
            <th class="rounded-md bg-gray-300 border-2 border-white">Last Team Represented</th>
            @endif
            <th class="rounded-md bg-gray-300 border-2 border-white">Points</th>
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
              <td class="font-semibold rounded-lg border border-white">{{$k+1}}</td>
              <td class="font-semibold rounded-lg border border-white">{{$res[$i]['name']}}</td>
              @if($season['season'] - (int)$season['season'] < 0.75)
              <td class="font-semibold rounded-lg border border-white">
                <span>
                  {{$res[$i]['team']['name']}}
                </span>
              </td>
              @endif
              <td class="font-semibold rounded-lg border border-white">{{$res[$i]['points']}}</td>
            </tr> 
          @endfor
        </tbody>
      </table>
   </div>
  </div>
  @endif
  
  
@endsection


        

     