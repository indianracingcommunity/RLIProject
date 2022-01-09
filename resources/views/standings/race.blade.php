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
</style>
@section('content')
<div class="container mx-auto px-4 md:p-0">
    <div class="flex flex-col-reverse md:flex-row md:gap-4">
    <div class="md:w-1/4 w-full">
        <div class="bg-white p-4 rounded-lg border mb-4">
            <div class="text-3xl text-purple-700 leading-none mb-2 cf font-bold">
                {{$results[0]['race']['circuit']['name']}}
            </div>
            <div class="text-purple-700 leading-none mb-4 cf font-semibold">
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
        @if ($prevRace != NULL)
        <a href="{{route('raceresults', ['code' => $code, 'tier' => $tier, 'season' => $season, 'round' => $prevRace->round])}}">
          <div class="py-2 px-2 bg-white my-3 shadow-md rounded-md border-r-4 border-blue-600 cursor-pointer justify-between hover:shadow-none hover:bg-gray-200" id="prev-race">
            <div class="text-xs text-center font-semibold text-gray-700">PREVIOUS RACE</div>
            <div class="flex items-center flex-shrink-0 font-semibold justify-between">
                <div class="flex items-center">
                        <i class="fas fa-chevron-left text-xl text-gray-700"></i>
                </div>
                <div class="flex items-center font-bold flex-shrink-0">
                    <div class="">
                        <div class="text-gray-800 cf">
                            {{$prevRace->circuit->name}}
                        </div>
                        <div class="text-xs text-gray-700 flex-wrap cf" style="width: 171px;">
                            {{$prevRace->circuit->official}}
                        </div>
                    </div>
                    <img src="{{$prevRace->circuit->flag}}" alt="" class=" w-16 border">
                </div>
            </div>
          </div>
        </a>
        @endif
        @if ($nextRace != NULL)
        <a href="{{route('raceresults', ['code' => $code, 'tier' => $tier, 'season' => $season, 'round' => $nextRace->round])}}">
          <div class="py-2 px-2 bg-white my-3 shadow-md rounded-md border-l-4 border-green-600 cursor-pointer justify-between hover:shadow-none hover:bg-gray-200" id="next-race">
            <div class="text-xs text-center font-semibold text-gray-700">NEXT RACE</div>
            <div class="flex items-center flex-shrink-0 font-bold justify-between">
                <div class="flex items-center flex-shrink-0">
                    <img src="{{$nextRace->circuit->flag}}" alt="" class="mr-3 w-16 border">
                    <div class="">
                        <div class="text-gray-800 cf ">
                            {{$nextRace->circuit->name}}
                        </div>
                        <div class="text-xs text-gray-700 cf" style="width: 171px;">
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
  <div class="md:w-3/4 mb-4 md:m-">
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
              @view('admin,coordinator')
              <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center w-1/12 confTable">D.ID</th>
              <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center w-1/12 confTable">C.ID</th>
                
              @endview
              @endauth    
                
                <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white text-center w-1/12">Pos.</th>
                <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white">Driver</th>
                <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 border-white md:block hidden">Team</th>
                <th class="rounded-lg bg-gray-800 tracking-widest text-gray-100 border-2 text-center border-white">Points</th>
              </tr>
          </thead>
      <tbody>
      @for ($i = 0; $i < $count; $i++)
        @if((int)$results[$i]['status'] % 10 == 1)
          <tr>
            @auth
              @view('admin,coordinator')
              <td class="font-semibold rounded-lg border border-white bg-purple-200 text-purple-700 text-center tracking-widest confTable">{{$results[$i]['driver']['id']}}</td>
              <td class="font-semibold rounded-lg border border-white bg-purple-200 text-purple-700 text-center tracking-widest confTable">{{$results[$i]['constructor_id']}}</td>
                
              @endview
              @endauth    
                
              <td class="font-semibold rounded-lg border border-white bg-purple-200 text-purple-700 text-center tracking-widest">{{$i+1}}</td>
              <td class="font-bold rounded-lg border border-white bg-purple-200 text-purple-700" ><a class="popOverBtn hover:underline cursor-pointer" onmouseover="openPopover(event,'popover-id_{{$results[$i]['driver']['id']}}')">{{$results[$i]['driver']['name']}}</a>
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
                    <div class="bg-gray-600 text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                      Starting Position : {{$results[$i]['grid']}}
                    </div>
                    <div class="bg-gray-500 rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                      <a class='hover:underline text-black' href="{{route('user.profile', ['user' => $results[$i]['driver']['user_id']])}}"> <i class="fas fa-user pr-1"></i> Go to Profile</a>
                    </div>
                  </div>
                </div>
              </td>
              <td class="font-semibold rounded-lg border border-white bg-purple-200 text-purple-700 md:block hidden">{{$results[$i]['constructor']['name']}}</td>
              <td class="font-bold rounded-lg border border-white bg-purple-200 text-purple-700 text-center tracking-widest">{{$results[$i]['points']}}</td>
          </tr>
        @elseif($i % 2 != 0)
        <tr>
            @auth
            @view('admin,coordinator')
              @if ($results[$i]['driver']['user_id'] == Auth::id())
                <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest confTable">{{$results[$i]['driver']['id']}}</td>
              @else
                <td class="font-semibold rounded-lg border border-white bg-gray-200 text-center tracking-widest confTable">{{$results[$i]['driver']['id']}}</td>
              @endif
              
              @if ($results[$i]['driver']['user_id'] == Auth::id())
                <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest confTable">{{$results[$i]['constructor_id']}}</td>
              @else
                <td class="font-semibold rounded-lg border border-white bg-gray-200 text-center tracking-widest confTable">{{$results[$i]['constructor_id']}}</td>
              @endif    
            @endview
            @endauth    
            
            @if ($results[$i]['driver']['user_id'] == Auth::id())
              <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest">{{$i+1}}</td>
            @else
              <td class="font-semibold rounded-lg border border-white bg-gray-200 text-center tracking-widest">{{$i+1}}</td>
            @endif
            @if ($results[$i]['driver']['user_id'] == Auth::id())
             <td class="font-bold rounded-lg border border-white bg-gray-700 text-white" ><a class="popOverBtn hover:underline cursor-pointer" onmouseover="openPopover(event,'popover-id_{{$results[$i]['driver']['id']}}')">{{$results[$i]['driver']['name']}}</a>
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
                  <div class="bg-gray-600 text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                    Starting Position : {{$results[$i]['grid']}}
                  </div>
                  <div class="bg-gray-500 rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                    <a class='hover:underline text-black' href="{{route('user.profile', ['user' => $results[$i]['driver']['user_id']])}}"> <i class="fas fa-user pr-1"></i> Go to Profile</a>
                  </div>
                </div>
              </div>
            </td>
            @else
             <td class="font-bold rounded-lg border border-white bg-gray-200" ><a class="popOverBtn hover:underline cursor-pointer" onmouseover="openPopover(event,'popover-id_{{$results[$i]['driver']['id']}}')">{{$results[$i]['driver']['name']}}</a> 
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
                  <div class="bg-gray-600 text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                    Starting Position : {{$results[$i]['grid']}}
                  </div>
                  <div class="bg-gray-500 rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                    <a class='hover:underline text-black' href="{{route('user.profile', ['user' => $results[$i]['driver']['user_id']])}}"> <i class="fas fa-user pr-1"></i> Go to Profile</a>
                  </div>
                </div>
              </div>
            </td>
            @endif
            @if ($results[$i]['driver']['user_id'] == Auth::id())
              <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white md:block hidden">{{$results[$i]['constructor']['name']}}</td>
            @else
              <td class="font-semibold rounded-lg border border-white bg-gray-200 md:block hidden">{{$results[$i]['constructor']['name']}}</td>
            @endif
            @if ($results[$i]['driver']['user_id'] == Auth::id())
            <td class="font-bold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest">{{$results[$i]['points']}}</td>
            @else
              <td class="font-bold rounded-lg border border-white bg-gray-200 text-center tracking-widest">{{$results[$i]['points']}}</td>
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
            @view('admin,coordinator')
            @if ($results[$i]['driver']['user_id'] == Auth::id())
              <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest confTable">{{$results[$i]['driver']['id']}}</td>
            @else
              <td class="font-semibold rounded-lg border border-white text-center tracking-widest confTable">{{$results[$i]['driver']['id']}}</td>
            @endif
            
            @if ($results[$i]['driver']['user_id'] == Auth::id())
              <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest confTable">{{$results[$i]['constructor_id']}}</td>
            @else
              <td class="font-semibold rounded-lg border border-white text-center tracking-widest confTable">{{$results[$i]['constructor_id']}}</td>
            @endif
            
              @endview
              @endauth    
        
            @if ($results[$i]['driver']['user_id'] == Auth::id())
              <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest">{{$i+1}}</td>
            @else
              <td class="font-semibold rounded-lg border border-white text-center tracking-widest">{{$i+1}}</td>
            @endif
            @if ($results[$i]['driver']['user_id'] == Auth::id())
             <td class="font-bold rounded-lg border border-white bg-gray-700 text-white" ><a class="popOverBtn hover:underline cursor-pointer" onmouseover="openPopover(event,'popover-id_{{$results[$i]['driver']['id']}}')">{{$results[$i]['driver']['name']}}</a>
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
                  <div class="bg-gray-600 text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                    Starting Position : {{$results[$i]['grid']}}
                  </div>
                  <div class="bg-gray-500 rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                    <a class='hover:underline text-black' href="{{route('user.profile', ['user' => $results[$i]['driver']['user_id']])}}"> <i class="fas fa-user pr-1"></i> Go to Profile</a>
                  </div>
                </div>
              </div>
            </td>
            @else
              <td class="font-bold rounded-lg border border-white" ><a class="popOverBtn hover:underline cursor-pointer" onmouseover="openPopover(event,'popover-id_{{$results[$i]['driver']['id']}}')">{{$results[$i]['driver']['name']}}</a>
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
                    <div class="bg-gray-600 text-white font-semibold p-3 mb-0 border-b border-solid border-white">
                      Starting Position : {{$results[$i]['grid']}}
                    </div>
                    <div class="bg-gray-500 rounded-b-lg font-semibold p-3 mb-0 border-b border-solid border-white">
                      <a class='hover:underline text-black' href="{{route('user.profile', ['user' => $results[$i]['driver']['user_id']])}}"> <i class="fas fa-user pr-1"></i> Go to Profile</a>
                    </div>
                  </div>
                </div>
              </td>
            @endif
            @if ($results[$i]['driver']['user_id'] == Auth::id())
              <td class="font-semibold rounded-lg border border-white bg-gray-700 text-white md:block hidden">{{$results[$i]['constructor']['name']}}</td>
            @else
              <td class="font-semibold rounded-lg border border-white md:block hidden">{{$results[$i]['constructor']['name']}}</td>
            @endif
            @if ($results[$i]['driver']['user_id'] == Auth::id())
            <td class="font-bold rounded-lg border border-white bg-gray-700 text-white text-center tracking-widest">{{$results[$i]['points']}}</td>
            @else
              <td class="font-bold rounded-lg border border-white text-center tracking-widest">{{$results[$i]['points']}}</td>
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
   @view('admin,coordinator')
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
   @endview
@endauth
</div>

@auth
   @view('admin,coordinator')
    <script>
      $('body').keypress(function (e) { 
        if(e.keyCode == 72 || e.keyCode == 104){
          $('.confTable').toggle();
        }
      });
      $('.confTable').toggle();
    </script>
  @endview
@endauth

@endsection
