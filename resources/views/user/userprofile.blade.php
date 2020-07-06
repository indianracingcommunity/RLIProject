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
            <!-- <?php 
                $data = unserialize(Auth::user()->discord_roles)
            ?> -->

            
            <div class="flex w-64 flex-wrap font-semibold text-sm">
            <!-- @foreach($data as $value)
            <div class="px-1 border rounded-full mr-1 mb-1 border-orange-600"><i class="fas fa-circle mr-1 text-orange-500"></i>{{$value}}</div>
            
            @endforeach -->
                <div class="px-1 border rounded-full mr-1 mb-1 border-orange-600"><i class="fas fa-circle mr-1 text-orange-500"></i>Mclaren</div>
                <div class="px-1 border rounded-full mr-1 mb-1 border-green-600"><i class="fas fa-circle mr-1 text-green-500"></i>Tier-2</div>
                <div class="px-1 border rounded-full mr-1 mb-1 border-purple-500"><i class="fas fa-circle mr-1 text-purple-400"></i>IRC Team</div>
                <div class="px-1 border rounded-full mr-1 mb-1 border-indigo-800"><i class="fas fa-circle mr-1 text-indigo-700"></i>PS4</div>
                <div class="px-1 border rounded-full mr-1 mb-1 border-purple-800"><i class="fas fa-circle mr-1 text-purple-700"></i>PC</div>
                <div class="px-1 border rounded-full mr-1 mb-1 border-red-800"><i class="fas fa-circle mr-1 text-red-700"></i>Member</div>
                <div class="px-1 border rounded-full mr-1 mb-1 border-yellow-600"><i class="fas fa-circle mr-1 text-yellow-300"></i>Assetto Corsa</div>
            </div>
        </div>
    </div>
    <div class="ml-12 pl-8 border-l">
        <div class="font-semibold text-gray-600 mb-4">
            <i class="fas fa-edit mr-1"></i> More Details
        </div>
        <form action="">
            <div class="flex">
                <div class="w-1/2">
                    <div class="mb-4">
                        <div>
                            <label for="Nationality" class="font-semibold text-gray-800">Are you an Indian?<span class="text-red-600 ml-2">●</span></label>
                        </div>
                        <div>
                            <input type="radio" id="Yes" name="Nationality" value="Yes">
                            <label for="male">Yes</label>
                            <input type="radio" id="No" name="Nationality" value="No">
                            <label for="female">No</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="MotherToungue" class="font-semibold text-gray-800">What is your Mother Tounge?<span class="text-red-600 ml-2">●</span></label>
                        </div>
                        <input type="text" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="Hindi/Bengali/Tamil">
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="City" class="font-semibold text-gray-800">City<span class="text-red-600 ml-2">●</span></label>
                        </div>
                        <input type="text" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="Kolkata">
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="State" class="font-semibold text-gray-800">State<span class="text-red-600 ml-2">●</span></label>
                        </div>
                        <input type="text" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="West Bengal">
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="State" class="font-semibold text-gray-800">Which motorsport do you follow?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                        <input type="text" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="F1">
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="State" class="font-semibold text-gray-800">Which driver do you support?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                        <input type="text" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="Lando Norris">
                    </div>
                </div>
                <div class="ml-8">
                    
                    <div class="mb-4">
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="games" class="font-semibold text-gray-800"> I play racing games or am interested in esports.<span class="text-red-600 ml-2">●</span></label>
                    </div>
                    <div class="mb-4">
                        <div>
                            <label for="State" class="font-semibold text-gray-800">Where did you hear about IRC?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        </div>
                        <input type="text" class="border shadow-inline px-2 py-1 mt-1 w-full rounded border-gray-700" placeholder="Discord, Youtube, etc.">
                    </div>
                    <div class="mb-4">
                        <label for="games" class="font-semibold text-gray-800">Which Games do you Play?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        <div class="flex flex-wrap">
                            <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                <label for="games" class="mr-2">F1</label>
                            </span>
                            <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                <label for="games" class="mr-2">Assetto Corsa</label>
                            </span>
                            <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                <label for="games" class="mr-2">Asseto Corsa Compitizione</label>
                            </span>
                            <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                <label for="games" class="mr-2">Grand Tourismo Sports</label>
                            </span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="games" class="font-semibold text-gray-800">Which platform do you play on?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        <div class="flex flex-wrap">
                            <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                <label for="games" class="mr-2">PC</label>
                            </span>
                            <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                <label for="games" class="mr-2">PlayStation</label>
                            </span>
                            <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                <label for="games" class="mr-2">XBox</label>
                            </span>
                        </div>
                    </div>
                    <div>
                        <label for="games" class="font-semibold text-gray-800">What Controler do you use to play Games?<span class="text-red-600 ml-2">●</span><i class="fas fa-globe-americas text-gray-600 ml-2"></i></label>
                        <div>
                        <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                <label for="games" class="mr-2">Keyboard/Mouse</label>
                            </span>
                            <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                <label for="games" class="mr-2">Controller</label>
                            </span>
                            <span class="rounded bg-gray-200 px-2 py-1 my-1 mr-2">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                <label for="games" class="mr-2">Wheel</label>
                            </span>
                        </div>
                    </div>
                    <div class="font-semibold text-gray-700 mt-6">
                        <div>
                            <span class="text-red-600 mr-2">●</span>Mandatory Fields
                        </div>
                        <div>
                            <i class="fas fa-globe-americas text-gray-600 mr-2"></i>Publicly visible fields
                        </div>
                    </div>
                </div>
                
            </div>
            <div>
                <button class="bg-blue-200 rounded text-blue-800 font-semibold px-8 py-2 hover:bg-blue-300">Submit</button>
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

@endsection