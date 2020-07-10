@extends('layouts.app')
@section('content')
<div class="container">
@if (Auth::user()->steam_id == NULL)
 <div class="font-semibold text-orange-800 bg-orange-200 rounded-md p-8">
     Welcome to <strong>Indian Racing Comunity!</strong> Your account is created but not yet <strong>verified</strong>. To verify your Account please please Sign in with your <strong>Steam</strong> account
 </div>
@endif

<div class="flex  my-8 ">
    <div class="flex flex-shrink-0">
        <div>
            <img src="{{Auth::user()->avatar}}" class="rounded-md " alt="">
        </div>
        <div class="my-2">
            <div class="flex">
                <div class=" font-semibold text-gray-800 mx-4 text-4xl font-bold">{{Auth::user()->name}}</div>
            </div>
            <div class="flex">
                <div class="text-xs font-semibold text-gray-600 ml-4 mr-3 mt-1">TEAM</div>
                <div class=" font-semibold text-gray-800 font-bold text-base">{{Auth::user()->team}}</div>
            </div>
            <div class="flex">
                <div class="text-xs font-semibold text-gray-600 ml-4 mr-3 mt-1">TEAMMATE</div>
                <div class=" font-semibold text-gray-800 font-bold text-base">{{Auth::user()->teammate}}</div>
            </div>
        </div>
    </div>
    <div class="ml-8 leading-none ">
        <div class="font-semibold text-gray-700 mb-4">
            <i class="fas fa-trophy mr-1"></i> Trophies
        </div>
        <div class="flex flex-wrap">
            <div class=" flex-col text-center mr-2">
                <div class="text-5xl text-indigo-700">👑</div>
                <div class="font-semibold mt-2 p-2 bg-indigo-700 rounded-md text-white">Tier 1</div>
            </div>
            <div class=" flex-col text-center mr-2">
                <div class="text-5xl text-indigo-700">⛔</div>
                <div class="font-semibold mt-2 p-2 bg-red-600 rounded-md text-white">Penalty King</div>
            </div>
            <div class=" flex-col text-center mr-2">
                <div class="text-5xl text-indigo-700">🛺</div>
                <div class="font-semibold mt-2 p-2 bg-blue-600 rounded-md text-white">Season 1</div>
            </div>
            <div class=" flex-col text-center mr-2">
                <div class="text-5xl text-indigo-700">🚜</div>
                <div class="font-semibold mt-2 p-2 bg-blue-600 rounded-md text-white">Season 2</div>
            </div>

        </div>
    </div>
</div>
<div class="flex">
    <div>
        <div class="font-semibold text-gray-600 mb-4">
            <i class="far fa-user-circle mr-1"></i> User Details
        </div>
        <table>
            <tr>
                <td class="font-semibold text-gray-600">USERNAME</td>
                <td class=" font-bold text-gray-800 px-4 py-1">{{Auth::user()->name}}</td>
            </tr>
            <tr>
                <td class="font-semibold text-gray-600">EMAIL</td>
                <td class=" font-bold text-gray-800 px-4 py-1">{{Auth::user()->email}}</td>
            </tr>
            <tr>
                <td class="font-semibold text-gray-600">DISCORD</td>
                <td class=" font-bold text-gray-800 px-4 py-1">{{Auth::user()->name}}#{{Auth::user()->discord_discrim}}</td>
            </tr>
            <tr>
                <td class="font-semibold text-gray-600">STEAM</td>
                <td class=" font-bold text-gray-800 px-4 py-1"><a href= "{{Auth::user()->steam_id}}">{{Auth::user()->steam_id}} </a></td>
            </tr>
        </table>
        <div class="mt-8">
            <div class="font-semibold text-gray-600 mb-4">
                <i class="fas fa-users-cog mr-1"></i> User Roles
            </div>
            

            
            <div class="flex w-64 flex-wrap font-semibold text-sm">
               @if(is_array($roles))
              @for ($i= 0; $i < count($roles) ; $i++)
              @php
               $color = str_pad($roles[$i]['color'],6,"0",STR_PAD_LEFT);
              @endphp
            <div class="px-1 border rounded-full mr-1 mb-1 border-600 bg-gray-400" style="color:#{{$color}}; border-color:#{{$color}};"><i class="fas fa-circle mr-1 text-500" style="color:#{{$color}}"></i>{{$roles[$i]['name']}} </div>    
              @endfor
              @else
              {{$roles}}
              @endif
               
        
            </div>
        </div>
    </div>
    <div class="ml-12 pl-8 border-l">
        <div class="font-semibold text-gray-600 mb-4">
            <i class="fas fa-edit mr-1"></i> More Details
        </div>
        <form action="/user/profile/save/{{Auth::user()->id}}" method="POST">
            @csrf
            <div class="flex">
                <div class="">
                    <div class="mb-4">
                        <div>
                            <label for="Nationality" class="font-semibold text-gray-800">Are you an Indian?<span class="text-red-600 ml-2">●</span></label>
                        </div>
                        <div>
                            <input type="radio" id="Yes" name="Nationality" value="Yes" onclick="javascript:enablebutton()" @if ("{{Auth::user()->mothertongue}}" != "") checked @endif> 
                            <label for="male">Yes</label>
                            <input type="radio" id="No" name="Nationality" value="No" onclick="javascript:enablebutton()">
                            <label for="female">No</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="MotherToungue" class="font-semibold text-gray-800" ">What is your Mother Tongue?<span class="text-red-600 ml-2">●</span></label>
                        </div>
                        <input type="text" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="Hindi/Bengali/Tamil" name="mothertongue" value="{{Auth::user()->mothertongue}}" required>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="City" class="font-semibold text-gray-800">City<span class="text-red-600 ml-2">●</span></label>
                        </div>
                        @php
                        if(isset(Auth::user()->location))
                        {
                            $data = Auth::user()->location;
                            $city = preg_replace('/^([^,]*).*$/', '$1', $data);  
                            $state =   preg_replace('/^[^,]*,\s*/', '', $data);
                        }
                        else{$city = ""; $state="";}   
                        @endphp
                        
                        <input type="text" name="city" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="Kolkata" value = {{$city}} >
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="State" class="font-semibold text-gray-800">State<span class="text-red-600 ml-2">●</span></label>
                        </div>
                        <input type="text" name="state" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="West Bengal" value="{{$state}}">
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="State" class="font-semibold text-gray-800">Which motorsport do you follow?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                    <input type="text" name="motorsport" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="F1" value="{{Auth::user()->motorsport}}">
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="State" class="font-semibold text-gray-800">Which driver do you support?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                        <input type="text" name="driversupport" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="Lando Norris" value="{{Auth::user()->driversupport}}">
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="State" class="font-semibold text-gray-800">Where did you hear about IRC?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                        <input type="text" name="source" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="Discord, Youtube, etc." value="{{Auth::user()->source}}">
                    </div>
                </div>
                <div class="ml-8 w-1/2">
                        <?php
                          if(isset(Auth::user()->games))
                          {
                              $games = unserialize(Auth::user()->games);
                          }
                          else
                          {
                             $games = '';
                          }
                          
                        ?> 
                    <div class="mb-4">
                        <input type="checkbox" id="playgameid" name="playgame" value="playsgame" onchange="javascript:showfields()" @if ($games != "") checked @endif>
                        <label for="games"  class="font-semibold text-gray-800"> I play racing games or am interested in esports.<span class="text-red-600 ml-2">●</span></label>
                    </div>
                    <div id="restfieldsid" style="display : block;">
                        
                        
                        <div class="mb-4">
                            <label for="games" class="font-semibold text-gray-800">Which Games do you Play?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                            <div class="flex flex-wrap">
                                
                                <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                    <input type="checkbox" id="gameid" name="game[]" value="f1" @if (in_array("f1", $games)) checked @endif>
                                    <label for="games" class="mr-2">F1</label>
                                </span>
                                <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                    <input type="checkbox" id="gameid" name="game[]" value="Assetto Corsa" @if (in_array("Assetto Corsa", $games)) checked @endif>
                                    <label for="games" class="mr-2">Assetto Corsa</label>
                                </span>
                                <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                    <input type="checkbox" id="gameid" name="game[]" value="Asseto Corsa Compitizione" @if (in_array("Asseto Corsa Compitizione", $games)) checked @endif>
                                    <label for="games" class="mr-2">Asseto Corsa Compitizione</label>
                                </span>
                                <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                    <input type="checkbox" id="gameid" name="game[]" value="Grand Tourismo Sports" @if (in_array("Grand Tourismo Sports", $games)) checked @endif>
                                    <label for="games" class="mr-2">Grand Tourismo Sports</label>
                                </span>
                                <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                    <input type="checkbox" id="gameid" name="game[]" value="Dirt Rally" @if (in_array("Dirt Rally", $games)) checked @endif>
                                    <label for="games" class="mr-2">Dirt Rally</label>
                                </span>
                            </div>
                        </div>
                        <?php
                        if(isset(Auth::user()->platform))
                        {
                           $platform = unserialize(Auth::user()->platform);
                        }
                        else
                        {
                            $platfrom = '';
                        }  
                        ?>
                        <div class="mb-4">
                            <label for="games" class="font-semibold text-gray-800">Which platform do you play on?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                            <div class="flex flex-wrap">
                                <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                    <input type="checkbox" id="vehicle1" name="platform[]" value="PC" @if (in_array("PC", $platform)) checked @endif>
                                    <label for="games" class="mr-2">PC</label>
                                </span>
                                <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                    <input type="checkbox" id="vehicle1" name="platform[]" value="PlayStation" @if (in_array("PlayStation", $platform)) checked @endif>
                                    <label for="games" class="mr-2">PlayStation</label>
                                </span>
                                <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                    <input type="checkbox" id="vehicle1" name="platform[]" value="Xbox" @if (in_array("Xbox", $platform)) checked @endif>
                                    <label for="games" class="mr-2">XBox</label>
                                </span>
                            </div>
                        </div>
                        <div>
                            <label for="games" class="font-semibold text-gray-800">What Controler do you use to play Games?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                            <div>
                                <?php 
                                  if(isset(Auth::user()->device))
                                  {
                                      $device = unserialize(Auth::user()->device);
                                  }
                                  else
                                  {
                                      $device = '';
                                  }
                                ?>
                            <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                    <input type="checkbox" id="vehicle1" name="device[]" value="Keyboard/Mouse" @if (in_array("Keyboard/Mouse", $device)) checked @endif>
                                    <label for="games" class="mr-2">Keyboard/Mouse</label>
                                </span>
                                <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                    <input type="checkbox" id="vehicle1" name="device[]" value="Controller" @if (in_array("Controller", $device)) checked @endif>
                                    <label for="games" class="mr-2">Controller</label>
                                </span>
                                <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                    <input type="checkbox" id="vehicle1" name="device[]" value="Wheel" @if (in_array("Wheel", $device)) checked @endif>
                                    <label for="games" class="mr-2">Wheel</label>
                                </span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div>
                                <label for="State" class="font-semibold text-gray-800">Device name of controller or wheel<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                            </div>
                            <input type="text" name="devicename" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="T300, xbox controller, g29, Red Legend, etc." value="{{Auth::user()->devicename}}">
                        </div>
                    </div>
                </div>
                
            </div>
            <div>
                    <div class="font-semibold text-gray-700 mb-4">
                        <div>
                            <span class="text-red-600 mr-2">●</span>Mandatory Fields
                        </div>
                        <div>
                            <i class="fas fa-globe-americas text-gray-600 mr-2"></i>Publicly visible fields
                        </div>
                    </div>
                <button id="enabledbuttonid" class="bg-blue-500 rounded text-white font-semibold px-8 py-2 hover:bg-blue-800" style="display: block;">Submit</button>
                <button disabled id="disabledbuttonid" class="bg-blue-500 text-white font-semibold px-8 py-2 rounded opacity-50 cursor-not-allowed" style="display: none;">Submit</button>
            </div>
        </form>
    </div>
</div>
<div>
    <form method="POST" action="setsteam/{{Auth::user()->id}}">
        @csrf
        <br><br>

        @if (Auth::user()->steam_id == NULL)
         <span class="text-xs font-semibold text-gray-600 mt-1">STEAM PROFILE LINK</span>
         <span class="text-red-600 mr-4">●</span>
         <a href="/login/steam"> <img src="{{url('/img/steam.png')}}" alt=""> </a>
         <span class="text-red-600 mr-2">●</span><span class="text-xs font-semibold text-gray-700">To verify your account please Sign in with your Steam account</span>
        @endif
    </form>
</div>
<script>
    var games = <?php echo json_encode($games); ?>;
    var platform = <?php echo json_encode($platform); ?>;
    var device = <?php echo json_encode($device); ?>;
    console.log(games);
    document.getElementById('restfieldsid').style.display = "none";

    showfields = function(){
        if(document.getElementById('playgameid').checked){
            document.getElementById('restfieldsid').style.display = "block";
        }
        else{
            document.getElementById('restfieldsid').style.display = "none";
        }
    }
    enablebutton = function(){
        if(document.getElementById('No').checked){
            document.getElementById('disabledbuttonid').style.display = "block";
            document.getElementById('enabledbuttonid').style.display = "none";
        }
        else{
            document.getElementById('disabledbuttonid').style.display = "none";
            document.getElementById('enabledbuttonid').style.display = "block";
        }
    }
    showfields();
    enablebutton();
</script>

@endsection