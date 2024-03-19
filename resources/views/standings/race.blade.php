@extends('layouts.app')
<style>

/* .cf {
    font-family: 'Anton', sans-serif;
} */

.fast {
  background-color: red !important;
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
@media only screen and (max-width: 768px) {
  .teamCol {
      display: none;
  }
}
</style>
@section('content')
<div class="container mx-auto px-4 xl:p-0">
    <div class="flex flex-col-reverse xl:flex-row xl:gap-4">
    <div class="xl:w-1/4 w-full">
        <div class="hidden xl:block bg-white p-4 rounded-lg border mb-4">
            <div class="text-3xl text-purple-700 leading-none mb-2 cf font-bold">
                {{$results[0]['race']['circuit']['name']}}
            </div>
            <div class="text-purple-700 leading-none mb-6 cf font-semibold">
                {{$results[0]['race']['circuit']['official']}}
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
        <div class="flex flex-col md:flex-row xl:flex-col items-start justify-center gap-2 md:gap-4 xl:gap-2 w-full">
          @if ($prevRace != NULL)
          <a href="{{route('raceresults', ['code' => $code, 'tier' => $tier, 'season' => $season, 'round' => $prevRace->round])}}" class="w-full">
            <div class="w-full py-2 px-4 bg-white my-3 shadow-md rounded-md border-r-4 border-blue-600 cursor-pointer justify-between hover:shadow-none hover:bg-gray-200" id="prev-race">
              <!-- <div class="text-xs text-center font-bold text-gray-700">PREVIOUS RACE</div> -->

              <div class="flex items-center font-bold text-center justify-center gap-5">
                <div class="flex items-center">
                  <i class="fas fa-chevron-left text-xl text-gray-700"></i>
                </div>
                
                <div class="flex items-center break-words">
                  <div class="flex flex-col gap-1">
                    <div class="text-gray-800 cf">
                      {{$prevRace->circuit->name}}
                    </div>
                    <div class="text-xs text-gray-700 flex-wrap cf">
                      {{$prevRace->circuit->official}}
                    </div>
                  </div>
                </div>

                <img src="{{$prevRace->circuit->flag}}" alt="" class="w-16 border border-gray-800 rounded-md">
              </div>
            </div>
          </a>
          @endif
          @if ($nextRace != NULL)
          <a href="{{route('raceresults', ['code' => $code, 'tier' => $tier, 'season' => $season, 'round' => $nextRace->round])}}" class="w-full">
            <div class="w-full py-2 px-4 bg-white my-3 shadow-md rounded-md border-l-4 border-green-600 cursor-pointer justify-between hover:shadow-none hover:bg-gray-200" id="next-race">
              <!-- <div class="text-xs text-center font-semibold text-gray-700">NEXT RACE</div> -->

              <div class="flex items-center font-bold text-center justify-center gap-5">
                <img src="{{$nextRace->circuit->flag}}" alt="" class="w-16 border border-gray-800 rounded-md">
                
                <div class="flex items-center break-words">
                  <div class="flex flex-col gap-1">
                    <div class="text-gray-800 cf">
                      {{$nextRace->circuit->name}}
                    </div>
                    <div class="text-xs text-gray-700 flex-wrap cf">
                      {{$nextRace->circuit->official}}
                    </div>
                  </div>
                </div>

                <div class="flex items-center">
                  <i class="fas fa-chevron-right text-xl text-gray-700"></i>
                </div>
              </div>
            </div>
          </a>
          @endif
        </div>
  </div>
  <div class="xl:w-3/4 mb-4">
    <div class="xl:hidden bg-white p-4 rounded-lg border mb-4">
      <div class="text-3xl text-center text-purple-700 leading-none mb-2 cf font-bold">
          {{$results[0]['race']['circuit']['name']}}
      </div>
      <div class="text-purple-700 text-center leading-none mb-6 cf font-semibold">
          {{$results[0]['race']['circuit']['official']}}
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
  <div class="bg-white p-4 rounded-lg border">
    <div class="font-semibold my-1 leading-none uppercase tracking-widest border-b pb-2 flex justify-between font-semibold">
      <div>
        <a title='Jump to Race Results' href="{{route('allraces', ['code' => $code, 'tier' => $tier, 'season' => $season])}}" class="font-semibold cursor-pointer px-1 rounded inline-flex items-center ">
          <span class='bg-gray-200 hover:bg-gray-900 text-dark-500 hover:text-white rounded p-1'> <i class="fas fa-angle-left p-1"></i></i></span>
        </a>
        <span class='text-xs pt-2'>
          Race Results
        </span>
      </div>
      <div>
        <a title='Jump to Championship Standings' href="{{route('standings', ['code' => $code, 'tier' => $tier, 'season' => $season])}}" class="font-semibold cursor-pointer px-1 float-right rounded inline-flex items-center ">
            <span class='bg-yellow-200 hover:bg-gray-900 rounded p-1'> <i class='fas fa-trophy  p-1 text-yellow-500'></i></span>
        </a>
      </div>
    </div>
          <table class="w-full">
            <thead>
              <tr>
              @auth
                @can('admin|coordinator|steward')
                <th class="md:w-1/12 rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center w-1/12 confTable">D.ID</th>
                <th class="md:w-1/12 rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center w-1/12 confTable">C.ID</th>
                  
                @endcan
              @endauth    
                
                <th class="w-1/5 md:w-1/12 rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center w-1/12">Pos.</th>
                <th class="w-1/2 md:w-2/5 rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white">Driver</th>
                <th class="md:w-auto rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white teamCol">Team</th>
                <th class="w-1/4 md:w-1/6 rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 text-center border-white">Points</th>
              </tr>
          </thead>
      <tbody>
      @for ($i = 0; $i < $count; $i++)
        @if((int)$results[$i]['status'] % 10 == 1)
          <tr>
            @auth
              @can('admin|coordinator|steward')
              <td class="md:w-1/12 font-semibold rounded-lg border border-white bg-purple-200 text-purple-700 text-center tracking-widest confTable">{{$results[$i]['driver']['id']}}</td>
              <td class="md:w-1/12 font-semibold rounded-lg border border-white bg-purple-200 text-purple-700 text-center tracking-widest confTable">{{$results[$i]['constructor_id']}}</td>
                
              @endcan
              @endauth    
                
              <td class="w-1/5 md:w-1/12 pr-2 font-semibold rounded-lg border border-white bg-purple-200 text-purple-700 text-center tracking-widest">{{$i+1}}</td>
              <td class="w-1/2 md:w-2/5 pr-2 break-all font-bold rounded-lg border border-white bg-purple-200 text-purple-700" > <a class="popOverBtn hover:underline cursor-pointer" onmouseout="openPopoverOut(event,'popover-id_{{$results[$i]['driver']['id']}}')" onmouseover="openPopover(event,'popover-id_{{$results[$i]['driver']['id']}}')">{{$results[$i]['driver']['name']}}</a>
                <!-- <button class="popOverBtn float-right text-gray p-1 mr-2 font-bold uppercase text-sm rounded outline-none focus:outline-none ease-linear transition-all duration-150" type="button" ><i class="fas fa-info-circle"></i> -->
                <!-- </button> -->
                <div class="insidePopDiv hidden shadow-lg bg-gray-500 border-0 mb-3 block z-50 font-normal leading-normal text-sm max-w-xs text-left no-underline break-words rounded-lg border" id="popover-id_{{$results[$i]['driver']['id']}}">
                  <div>
                    <div class="bg-gray-800 rounded-t-lg text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                      Fastest Lap : {{$results[$i]['fastestlaptime']}}
                    </div>
                    <div class="bg-gray-700 text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                      Race Time : {{$results[$i]['time']}}
                    </div>
                    <div class="bg-gray-600 text-white rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                      Starting Position : {{$results[$i]['grid']}}
                    </div>
                    <!-- <div class="bg-gray-500 rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                      <a class='hover:underline text-black' href="{{route('user.profile', ['user' => $results[$i]['driver']['user_id']])}}"> <i class="fas fa-user pr-1"></i> Go to Profile</a>
                    </div> -->
                  </div>
                </div>
              </td>
              <td class="md:w-auto pr-2 break-words font-semibold rounded-lg border border-white bg-purple-200 text-purple-700 teamCol">{{$results[$i]['constructor']['name']}}</td>
              <td class="w-1/4 md:w-1/6 pr-2 break-all font-bold rounded-lg border border-white bg-purple-200 text-purple-700 text-center tracking-widest">{{$results[$i]['points']}}</td>
          </tr>
        @elseif($i % 2 != 0)
        <tr>
            @auth
            @can('admin|coordinator|steward')
              @if ($results[$i]['driver']['user_id'] == Auth::id())
                <td class="md:w-1/12 font-semibold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest confTable">{{$results[$i]['driver']['id']}}</td>
              @else
                <td class="md:w-1/12 font-semibold rounded-lg border border-white bg-gray-200 text-center tracking-widest confTable">{{$results[$i]['driver']['id']}}</td>
              @endif
              
              @if ($results[$i]['driver']['user_id'] == Auth::id())
                <td class="md:w-1/12 font-semibold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest confTable">{{$results[$i]['constructor_id']}}</td>
              @else
                <td class="md:w-1/12 font-semibold rounded-lg border border-white bg-gray-200 text-center tracking-widest confTable">{{$results[$i]['constructor_id']}}</td>
              @endif    
            @endcan
            @endauth    
            
            @if ($results[$i]['driver']['user_id'] == Auth::id())
              <td class="w-1/5 md:w-1/12 pr-2 font-semibold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest">{{$i+1}}</td>
            @else
              <td class="w-1/5 md:w-1/12 pr-2 font-semibold rounded-lg border border-white bg-gray-200 text-center tracking-widest">{{$i+1}}</td>
            @endif
            @if ($results[$i]['driver']['user_id'] == Auth::id())
             <td class="w-1/2 md:w-2/5 pr-2 break-all font-bold rounded-lg border border-white bg-gray-700 text-white" > <a class="popOverBtn hover:underline cursor-pointer" onmouseout="openPopoverOut(event,'popover-id_{{$results[$i]['driver']['id']}}')" onmouseover="openPopover(event,'popover-id_{{$results[$i]['driver']['id']}}')">{{$results[$i]['driver']['name']}}</a>
              <!-- <button class="popOverBtn float-right text-gray p-1 mr-2 font-bold uppercase text-sm rounded outline-none focus:outline-none ease-linear transition-all duration-150" type="button" ><i class="fas fa-info-circle"></i> -->
              <!-- </button> -->
              <div class="insidePopDiv hidden shadow-lg bg-gray-500 border-0 mb-3 block z-50 font-normal leading-normal text-sm max-w-xs text-left no-underline break-words rounded-lg border" id="popover-id_{{$results[$i]['driver']['id']}}">
                <div>
                  <div class="bg-gray-800 rounded-t-lg text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                    Fastest Lap : {{$results[$i]['fastestlaptime']}}
                  </div>
                  <div class="bg-gray-700 text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                    Race Time : {{$results[$i]['time']}}
                  </div>
                  <div class="bg-gray-600 text-white rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                    Starting Position : {{$results[$i]['grid']}}
                  </div>
                  <!-- <div class="bg-gray-500 rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                    <a class='hover:underline text-black' href="{{route('user.profile', ['user' => $results[$i]['driver']['user_id']])}}"> <i class="fas fa-user pr-1"></i> Go to Profile</a>
                  </div> -->
                </div>
              </div>
            </td>
            @else
             <td class="w-1/2 md:w-2/5 pr-2 break-all font-bold rounded-lg border border-white bg-gray-200" > <a class="popOverBtn hover:underline cursor-pointer" onmouseout="openPopoverOut(event,'popover-id_{{$results[$i]['driver']['id']}}')"  onmouseover="openPopover(event,'popover-id_{{$results[$i]['driver']['id']}}')">{{$results[$i]['driver']['name']}}</a> 
              <!-- <button class="popOverBtn float-right text-gray p-1 mr-2 font-bold uppercase text-sm rounded outline-none focus:outline-none ease-linear transition-all duration-150" type="button" ><i class="fas fa-info-circle"></i> -->
              <!-- </button> -->
              <div class="insidePopDiv hidden shadow-lg bg-gray-500 border-0 mb-3 block z-50 font-normal leading-normal text-sm max-w-xs text-left no-underline break-words rounded-lg border" id="popover-id_{{$results[$i]['driver']['id']}}">
                <div>
                  <div class="bg-gray-800 rounded-t-lg text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                    Fastest Lap : {{$results[$i]['fastestlaptime']}}
                  </div>
                  <div class="bg-gray-700 text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                    Race Time : {{$results[$i]['time']}}
                  </div>
                  <div class="bg-gray-600 text-white rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                    Starting Position : {{$results[$i]['grid']}}
                  </div>
                  <!-- <div class="bg-gray-500 rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                    <a class='hover:underline text-black' href="{{route('user.profile', ['user' => $results[$i]['driver']['user_id']])}}"> <i class="fas fa-user pr-1"></i> Go to Profile</a>
                  </div> -->
                </div>
              </div>
            </td>
            @endif
            @if ($results[$i]['driver']['user_id'] == Auth::id())
              <td class="md:w-auto pr-2 break-words font-semibold rounded-lg border border-white bg-gray-700 text-white teamCol">{{$results[$i]['constructor']['name']}}</td>
            @else
              <td class="md:w-auto pr-2 break-words font-semibold rounded-lg border border-white bg-gray-200 teamCol">{{$results[$i]['constructor']['name']}}</td>
            @endif
            @if ($results[$i]['driver']['user_id'] == Auth::id())
            <td class="w-1/4 md:w-1/6 pr-2 break-all font-bold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest">{{$results[$i]['points']}}</td>
            @else
              <td class="w-1/4 md:w-1/6 pr-2 break-all font-bold rounded-lg border border-white bg-gray-200 text-center tracking-widest">{{$results[$i]['points']}}</td>
            @endif
         </tr>
        @else
            <!-- <tr>
              <td class="font-semibold rounded-lg border border-white">{{$i+1}}</td>

              @if ($results[$i]['driver']['user_id'] == Auth::id())
              <td class="font-extrabold rounded-lg border border-white"><a class="hover:underline cursor-pointer">{{$results[$i]['driver']['name']}}</a></td>
              @else
              <td class="font-semibold rounded-lg border border-white"><a class="hover:underline cursor-pointer">{{$results[$i]['driver']['name']}}</a></td>
              @endif

              <td class="font-semibold rounded-lg border border-white">{{$results[$i]['constructor']['name']}}</td>
              <td class="font-semibold rounded-lg border border-white">{{$results[$i]['points']}}</td>
            </tr> -->
            <tr>
            @auth
              @can('admin|coordinator|steward')
                @if ($results[$i]['driver']['user_id'] == Auth::id())
                  <td class="md:w-1/12 font-semibold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest confTable">{{$results[$i]['driver']['id']}}</td>
                @else
                  <td class="md:w-1/12 font-semibold rounded-lg border border-white text-center tracking-widest confTable">{{$results[$i]['driver']['id']}}</td>
                @endif
                
                @if ($results[$i]['driver']['user_id'] == Auth::id())
                  <td class="md:w-1/12 font-semibold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest confTable">{{$results[$i]['constructor_id']}}</td>
                @else
                  <td class="md:w-1/12 font-semibold rounded-lg border border-white text-center tracking-widest confTable">{{$results[$i]['constructor_id']}}</td>
                @endif
              
              @endcan
            @endauth    
        
            @if ($results[$i]['driver']['user_id'] == Auth::id())
              <td class="w-1/5 md:w-1/12 pr-2 font-semibold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest">{{$i+1}}</td>
            @else
              <td class="w-1/5 md:w-1/12 pr-2 font-semibold rounded-lg border border-white text-center tracking-widest">{{$i+1}}</td>
            @endif
            @if ($results[$i]['driver']['user_id'] == Auth::id())
             <td class="w-1/2 md:w-2/5 pr-2 break-all font-bold rounded-lg border border-white bg-gray-700 text-white" > <a class="popOverBtn hover:underline cursor-pointer" onmouseout="openPopoverOut(event,'popover-id_{{$results[$i]['driver']['id']}}')" onmouseover="openPopover(event,'popover-id_{{$results[$i]['driver']['id']}}')">{{$results[$i]['driver']['name']}}</a>
              <!-- <button class="popOverBtn float-right text-gray p-1 mr-2 font-bold uppercase text-sm rounded outline-none focus:outline-none ease-linear transition-all duration-150" type="button" ><i class="fas fa-info-circle"></i> -->
              <!-- </button> -->
              <div class="insidePopDiv hidden shadow-lg bg-gray-500 border-0 mb-3 block z-50 font-normal leading-normal text-sm max-w-xs text-left no-underline break-words rounded-lg border" id="popover-id_{{$results[$i]['driver']['id']}}">
                <div>
                  <div class="bg-gray-800 rounded-t-lg text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                    Fastest Lap : {{$results[$i]['fastestlaptime']}}
                  </div>
                  <div class="bg-gray-700 text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                    Race Time : {{$results[$i]['time']}}
                  </div>
                  <div class="bg-gray-600 text-white rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                    Starting Position : {{$results[$i]['grid']}}
                  </div>
                  <!-- <div class="bg-gray-500 rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                    <a class='hover:underline text-black' href="{{route('user.profile', ['user' => $results[$i]['driver']['user_id']])}}"> <i class="fas fa-user pr-1"></i> Go to Profile</a>
                  </div> -->
                </div>
              </div>
            </td>
            @else
              <td class="w-1/2 md:w-2/5 pr-2 break-all font-bold rounded-lg border border-white" > <a class="popOverBtn hover:underline cursor-pointer" onmouseout="openPopoverOut(event,'popover-id_{{$results[$i]['driver']['id']}}')" onmouseover="openPopover(event,'popover-id_{{$results[$i]['driver']['id']}}')">{{$results[$i]['driver']['name']}}</a>
                <!-- <button class="popOverBtn float-right text-gray p-1 mr-2 font-bold uppercase text-sm rounded outline-none focus:outline-none ease-linear transition-all duration-150" type="button" ><i class="fas fa-info-circle"></i> -->
                <!-- </button> -->
                <div class="insidePopDiv hidden shadow-lg bg-gray-500 border-0 mb-3 block z-50 font-normal leading-normal text-sm max-w-xs text-left no-underline break-words rounded-lg border" id="popover-id_{{$results[$i]['driver']['id']}}">
                  <div>
                    <div class="bg-gray-800 rounded-t-lg text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                      Fastest Lap : {{$results[$i]['fastestlaptime']}}
                    </div>
                    <div class="bg-gray-700 text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                      Race Time : {{$results[$i]['time']}}
                    </div>
                    <div class="bg-gray-600 text-white rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                      Starting Position : {{$results[$i]['grid']}}
                    </div>
                    <!-- <div class="bg-gray-500 rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                      <a class='hover:underline text-black' href="{{route('user.profile', ['user' => $results[$i]['driver']['user_id']])}}"> <i class="fas fa-user pr-1"></i> Go to Profile</a>
                    </div> -->
                  </div>
                </div>
              </td>
            @endif
            @if ($results[$i]['driver']['user_id'] == Auth::id())
              <td class="md:w-auto pr-2 break-words font-semibold rounded-lg border border-white bg-gray-700 text-white teamCol">{{$results[$i]['constructor']['name']}}</td>
            @else
              <td class="md:w-auto pr-2 break-words font-semibold rounded-lg border border-white teamCol">{{$results[$i]['constructor']['name']}}</td>
            @endif
            @if ($results[$i]['driver']['user_id'] == Auth::id())
            <td class="w-1/4 md:w-1/6 pr-2 break-all font-bold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest">{{$results[$i]['points']}}</td>
            @else
              <td class="w-1/4 md:w-1/6 pr-2 break-all font-bold rounded-lg border border-white text-center tracking-widest">{{$results[$i]['points']}}</td>
            @endif
         </tr>
        @endif
      @endfor
      </tbody>
      </table>
      </div>
  </div>
  
</div>
<!-- Admin View -->
<div>
@auth
   @can('admin|coordinator|steward')
   <div class="border p-5 rounded-lg confTable">
      <div class="text-2xl font-bold text-center">Admin/Coordinator Information</div>
      <div class="flex flex-wrap gap-5">
        <div class="text-lg font-semibold">Race ID: {{$results[0]['race']['id']}}</div>
        <div class="text-lg font-semibold">Round: {{$results[0]['race']['round']}}</div>
        <div class="text-lg font-semibold">Season ID: {{$results[0]['race']['season_id']}}</div>
        @for ($i = 0; $i < $count; $i++)
        @if((int)$results[$i]['status'] % 10 == 1)
        <div class="text-lg font-semibold">Fastest Lap Time: {{$results[$i]['fastestlaptime']}}</div>
        @endif
        @endfor
        <div class="text-lg font-semibold">Circuit ID: {{$results[0]['race']['circuit_id']}}</div>
        
      </div>
   </div>
   @endcan
@endauth
</div>

@auth
   @can('admin|coordinator|steward')
    <script>
      $('body').keypress(function (e) { 
        if(e.keyCode == 72 || e.keyCode == 104){
          $('.confTable').toggle();
        }
      });
      $('.confTable').toggle();
    </script>
  @endcan
@endauth

@endsection