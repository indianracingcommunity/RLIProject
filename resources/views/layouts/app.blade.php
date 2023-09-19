<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{url('/img/IRC_logo/logo_square.png')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:title" content="Indian Racing Community">
        @if(isset($metaUserAvatar))
            <meta property="og:description" content="{{$metaName}}">
            <meta property="og:image" content="{{$metaUserAvatar}}">
        @else
            <meta property="og:description" content="A place For Every Indian Racing Enthusiast.">
            <meta property="og:image" content="/img/IRC_logo/logo_square_new.png">
        @endif
        <meta property="og:url" content="https://indianracingcommunity.co.in">
        <title>Indian Racing Community</title>
        <!-- <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
         -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('js/scripts.js') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('/css/custom.css')}}">
        <script src="{{ asset('js/jquery35.js')}}"></script>
        <script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js" charset="utf-8"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');
            * {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>


    <body class="bodyClass">

        <div class="" id="screen">
            <div class="md:w-auto bg-white z-50 hidden min-h-full fixed border-r border-gray-400 shadow-lg" style="min-width:250px" id="sidebar">
                <div class="h-screen py-2 text-black">
                    <div class="flex items-center px-4">
                        <div class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-800 cursor-pointer">
                            <a href="{{route('home')}}"   class="flex" class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700"><img src="/img/IRC_logo/logo_square.png" style='height:45px;' width="45"> <span class="py-3 pl-2">Indian Racing Community</span></a>
                        </div>
                        <div class="items-center py-4 px-2 flex-shrink-0 cursor-pointer" onclick="menu()"></div>
                    </div>
                    <div>
                        <div class="my-8" id="main-menu">
                            <div class="font-bold text-sm px-5 tracking-wide">LEAGUE RACING</div>
                            <div class="my-1">
                                <a href="{{route('driver.signup')}}" class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fas fa-edit"></i></div>All sign ups</a>
                            </div>
                            <div class="font-bold text-sm px-5 mt-4 tracking-wide">LEAGUE RULES</div>
                            <div class="my-1">
                                <a href="/IRC_Rules__Regs_V4.pdf" target="_blank" class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fas fa-desktop"></i></div>F1</a>
                                <a href="/IRC_ACC_Rules_Regs_V2.pdf" class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fas fa-desktop"></i></div>PC ACC</a>
                                <!-- <a href="{{route('rules.xboxf1')}}" class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fab fa-xbox"></i></div>XBOX F1</a> -->
                            </div>

                            <div class="font-bold text-sm px-5 mt-4 tracking-wide">LEAGUE INFO</div>
                            <div class="my-1 ">
                                <div data-origin='champ' class="subMenuShow py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class='fas fa-trophy'></i></div>Championship Standings</div>
                                <div data-origin='race' class="subMenuShow py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fa fa-flag-checkered"></i></div>Race Results</div>
                            </div>
                            @auth
                                @can('admin|coordinator|steward|signup')
                                <div class="font-bold text-sm px-5 mt-4 tracking-wide">ADMIN CONTROLS</div>
                                @endcan
                                <div class="my-1">
                                    @can('admin|coordinator')
                                    <a href="{{route('coordinator.driverlist')}}" class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fas fa-sort"></i></div>View/Allot Drivers</a>
                                    <a href="{{route('race.upload')}}" class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fas fa-upload"></i></div>Upload Race Results</a>
                                    @endcan
                                    @can('steward|coordinator')
                                    {{-- Enable this route later when we need it otherwise it breaks the site --}}
                                    {{-- <a href="{{route('steward.list')}}" class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fas fa-exclamation"></i></div>View Reports</a> --}}
                                    @endcan
                                    @can('admin|signup')
                                    <a href="{{route('coordinator.signup')}}" class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fa fa-eye"></i></div>View Sign Ups</a>
                                    @endcan
                                </div>
                                
                                
                            @endauth
                        </div>


                        <!-- <div style="display: none" class="my-8 mx-6 rounded-lg border" id="sub-menu">

                            <div class="font-bold text-sm px-5 mt-4 mb-2 tracking-wide cursor-pointer goBackMainMenu"><i class="fas fa-arrow-left"></i> Main Menu</div>

                            <hr>
                            <div class="font-bold text-sm px-5 mt-4 tracking-wide">Select Series</div>
                            <div class="px-5 w-full">
                                <select class="seriesOptions border-2 rounded w-full border-gray-800 hover:bg-gray-900 bg-white text-black hover:text-white p-1 my-2">
                                    <option class="" selected value="">Choose Series</option>
                                    @foreach($topBarSeasons as $series)
                                        <option value='{{str_replace(' ', '_',strtolower($series['name']['website']))}}'>{{$series['name']['website']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="tierSelectDiv" style="display: none;">
                                <div class="font-bold text-sm px-5 mt-4 tracking-wide">Select Tier</div>
                                <div class="px-5 w-full">
                                    <select class="tierOptions border-2 w-full border-gray-800 rounded hover:bg-gray-900 bg-white text-black hover:text-white p-1 my-2">
                                        <option class="" selected value="">Choose Tier</option>
                                        @foreach($topBarSeasons as $series)
                                            @foreach($series['tier'] as $tier)
                                                <option value="{{$tier[0]['tier']}}" class="allTierOptions tiersOf_{{str_replace(' ', '_',strtolower($series['name']['website']))}}" data-tier='{{$tier[0]['tier']}}' data-series='{{str_replace(' ', '_',strtolower($series['name']['website']))}}'>{{$tier[0]['tiername']}}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="seasonSelectDiv" style="display: none;">
                                <div class="font-bold text-sm px-5 mt-4 tracking-wide">Select Season</div>
                                <div class="px-5 w-full">
                                    <select class="seasonOptions border-2 border-gray-800 rounded w-full hover:bg-gray-900 bg-white text-black hover:text-white p-1 my-2">
                                        <option class="" selected value="">Choose Season</option>
                                        @foreach($topBarSeasons as $series)
                                            @foreach($series['tier'] as $tier)
                                                @foreach($tier as $season)
                                                    <option class="allSeasonOptions seasonOf_{{$tier[0]['tier']}}_{{str_replace(' ', '_',strtolower($series['name']['website']))}}" data-champLink='/{{$series['name']['code']}}/{{$season['tier']}}/{{$season['season']}}/standings' data-raceLink='/{{$series['name']['code']}}/{{$season['tier']}}/{{$season['season']}}/races'>Season {{floor($season['season'])}}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="text-center my-2 mx-6 font-semibold">
                                <div style="display: none;" class="lickAndSend px-4 py-2 bg-blue-600 text-white rounded font-semibold shadow-md cursor-pointer hover:bg-blue-700 hover:text-white hover:shadow-none">
                                    <button id="lickAndSend" type="button" class="text-center">Send It!</button>
                                </div>
                                <span style="display: none;" id="optionError" class="text-red-800"><i class="fa fa-exclamation-triangle pt-2 pr-2" aria-hidden="true"></i> Please select all the options</span>
                            </div>
                            <a style="display: none;" id="redirectLickAndSend" href=""></a>

                        </div> -->

                        <div id="race-menu">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:w-full" id="content">
            <nav class="flex items-center border-b border-gray-400 justify-between px-2 py-2 bg-white z-100">
                <div class="flex items-center">
                    <div class="items-center p-4 flex-shrink-0 cursor-pointer menuButton" onclick="menu()"><i class="fas fa-bars"></i></div>
                    <div class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700 cursor-pointer">
                        <a href="{{route('home')}}" class="flex" class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700 "><img src="/img/IRC_logo/logo_square.png" class="h-10 mt-1"> <span class="py-3 pl-2  md:block hidden">Indian Racing Community</span></a>
                    </div>
                    {{-- <div class="hidden md:block rounded-md py-3 items-center flex-shrink-0 font-semibold px-4 cursor-pointer hover:bg-gray-900 hover:text-white dropdown">
                        <button data-origin='champ' class="subMenuShow font-semibold cursor-default px-4 rounded inline-flex items-center">
                            <span> <i class='fas fa-trophy mx-1 text-yellow-500'></i> Championship Standings</span>
                        </button>
                    </div>
                    <div class="hidden md:block rounded-md py-3 items-center flex-shrink-0 font-semibold px-4 cursor-pointer hover:bg-gray-900 hover:text-white dropdown">
                        <button data-origin='race' class="subMenuShow font-semibold cursor-default px-4 rounded inline-flex items-center">
                            <span><i class="fa fa-flag-checkered mx-1 text-black-500"></i> Race Results</span>
                        </button>
                    </div> --}}

                    <div class="hidden md:block rounded-md py-3 items-center flex-shrink-0 font-semibold px-4 cursor-pointer hover:bg-gray-900 hover:text-white dropdown">
                        <button class="font-semibold cursor-default px-4 rounded inline-flex items-center">
                            <span> <i class='fas fa-trophy mx-1 text-yellow-500'></i> Championship Standings</span>
                        </button>
                        <ul class="dropdown-content absolute hidden text-gray-700 -ml-4 pt-3" style="width: 17.1rem;">
                            @foreach($topBarSeasons as $series)
                                <li class="dropdown">
                                    <a class="bg-indigo-100 cursor-default hover:bg-blue-300 py-2 px-4 block whitespace-no-wrap rounded" href="#"><i class='fas fa-caret-right pr-3 text-green-500'></i> {{$series['name']['website']}}</a>
                                    <ul class="dropdown-content hidden absolute text-gray-700 -mt-10" style="margin-left: 17rem; width: 7.5rem;">
                                        @foreach($series['tier'] as $tier)
                                        <li class="dropdown">
                                            <!-- <a class="bg-orange-100 hover:bg-green-300 py-2 px-4 block whitespace-no-wrap rounded" href="{{route('standings', ['code' => $series['name']['code'], 'tier' => $tier[0]['tier'], 'season' => $tier[0]['season']])}}"><i class='fas fa-caret-right pr-3 text-blue-500'></i> Tier {{$tier[0]['tier']}}</a> -->
                                            <a class="bg-orange-100 hover:bg-green-300 py-2 px-4 w-64 block whitespace-no-wrap rounded" href="{{route('standings', ['code' => $series['name']['code'], 'tier' => $tier[0]['tier'], 'season' => $tier[0]['season']])}}"><i class='fas fa-caret-right pr-3 text-blue-500'></i> {{$tier[0]['tiername']}} </a>
                                            <ul class="dropdown-content absolute hidden text-gray-700 pl-10 -mt-10" style="margin-left:210px">
                                                @foreach($tier as $season)
                                                <li>
                                                    <a class="bg-purple-100 hover:bg-orange-300 py-2 px-4 block whitespace-no-wrap rounded" href="{{route('standings', ['code' => $series['name']['code'], 'tier' => $season['tier'], 'season' => $season['season']])}}"><i class='fas fa-caret-right pr-3 text-red-400'></i> Season {{floor($season['season'])}} </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="hidden md:block rounded-md py-3 items-center flex-shrink-0 font-semibold px-4 cursor-pointer hover:bg-gray-900 hover:text-white dropdown">
                        <button class="font-semibold cursor-default px-4 rounded inline-flex items-center">
                            <span><i class="fa fa-flag-checkered mx-1 text-dark-500"></i> Race Results</span>
                        </button>
                        <ul class="dropdown-content absolute hidden text-gray-700 -ml-4 pt-3" style="width: 11.2rem;">
                            @foreach($topBarSeasons as $series)
                                <li class="dropdown">
                                    <a class="bg-indigo-100 hover:bg-blue-300 cursor-default py-2 px-4 block whitespace-no-wrap rounded" href="#"><i class='fas fa-caret-right pr-3 text-green-500'></i> {{$series['name']['website']}}</a>
                                    <ul class="dropdown-content hidden absolute text-gray-700 -mt-10" style="margin-left: 11.1rem; width: 7.5rem;">
                                        @foreach($series['tier'] as $tier)
                                        <li class="dropdown">
                                            <!-- <a class="bg-orange-100 hover:bg-green-300 py-2 px-4 block whitespace-no-wrap rounded" href="{{route('allraces', ['code' => $series['name']['code'], 'tier' => $tier[0]['tier'], 'season' => $tier[0]['season']])}}"><i class='fas fa-caret-right pr-3 text-blue-500'></i> Tier {{$tier[0]['tier']}}</a> -->
                                            <a class="bg-orange-100 hover:bg-green-300 py-2 px-4 w-64 block whitespace-no-wrap rounded" href="{{route('allraces', ['code' => $series['name']['code'], 'tier' => $tier[0]['tier'], 'season' => $tier[0]['season']])}}"><i class='fas fa-caret-right pr-3 text-blue-500'></i> {{$tier[0]['tiername']}}</a>
                                            <ul class="dropdown-content absolute hidden text-gray-700 -mt-10" style="margin-left:250px">
                                                @foreach($tier as $season)
                                                <li>
                                                    <a class="bg-purple-100 hover:bg-orange-300 px-4 py-2 block whitespace-no-wrap rounded" href="{{route('allraces', ['code' => $series['name']['code'], 'tier' => $season['tier'], 'season' => $season['season']])}}"><i class='fas fa-caret-right pr-3 text-red-400'></i> Season {{floor($season['season'])}} </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @guest
                    <div class="hidden md:block rounded-md py-3 items-center flex-shrink-0 font-semibold px-4 cursor-pointer hover:bg-gray-900 hover:text-white dropdown">
                        <button class="font-semibold cursor-default px-4 rounded inline-flex items-center">
                            <a href="{{route('faq')}}"><span><i class="mr-1 text-blue-700 far fa-question-circle"></i> FAQ</span></a>
                        </button>
                    </div>
                    <div class="hidden md:block rounded-md py-3 items-center flex-shrink-0 font-semibold px-4 cursor-pointer hover:bg-gray-900 hover:text-white dropdown">
                        <button class="font-semibold cursor-default px-4 rounded inline-flex items-center">
                            <a href="{{route('ourteam')}}"><span><i class="mr-1 text-purple-700 far fas fa-user-friends"></i> Our Team</span></a>
                        </button>
                    </div>
                    <div class="hidden md:block rounded-md py-3 items-center flex-shrink-0 font-semibold px-4 cursor-pointer hover:bg-gray-900 hover:text-white dropdown">
                        <button class="font-semibold cursor-default px-4 rounded inline-flex items-center">
                            <a href="{{route('aboutus')}}"><span><i class="mr-1 text-teal-700 far fa-address-card"></i> About us</span></a>
                        </button>
                    </div>
                    @endguest
                </div>
                <button data-origin='champ' class="subMenuShow font-semibold cursor-default px-1 text-xl md:hidden rounded inline-flex items-center">
                    <span> <i class='fas fa-trophy mx-1 text-yellow-500'></i></span>
                </button>
                <button data-origin='race' class="subMenuShow font-semibold cursor-default px-1 text-xl md:hidden rounded inline-flex items-center">
                    <span><i class="fa fa-flag-checkered mx-1 text-black-500"></i></span>
                </button>
                @guest
                    <div class="px-4 flex py-2 bg-purple-600 text-white rounded font-semibold shadow-md cursor-pointer hover:bg-gray-900 hover:text-white hover:shadow-none">
                        <a href="{{route('login.discord')}}"><i class='far fa-user mr-2'></i>Login</a>
                    </div>
                @endguest
                
                @auth
                <div class="flex items-center">
                    <div class="py-2 items-center flex-shrink-0 font-semibold px-4 dropdown cursor-pointer">
                        <button class="font-semibold cursor-default px-4 rounded inline-flex items-center">
                            <img src="{{Auth::user()->avatar}}" class="rounded-full w-10" alt="">
                        </button>
                        <div class="dropdown-content profileDropdown bg-white shadow-lg border rounded-md cursor p-4">
                            <div class="flex items-center mb-4">
                                <div class="w-10">
                                    <img src="{{Auth::user()->avatar}}" class="rounded-full w-10" alt="">
                                </div>
                                <div class="ml-2 leading-none">
                                    <div class="font-bold uppercase">
                                        {{Auth::user()->name}}
                                    </div>
                                    <div class="font-semibold text-sm text-gray-700">
                                        {{Auth::user()->name}}#{{Auth::user()->discord_discrim}}
                                    </div>
                                </div>

                            </div>
                            <a href="{{route('user.home')}}" class="flex items-center py-2 px-1 hover:bg-gray-900 hover:text-white rounded">
                                <div class="w-10"><i class="ml-2 far fa-user"></i></div>
                                <div>Profile</div>
                            </a>
                            <a href="{{route('faq')}}" class="flex items-center  py-2 px-1 hover:bg-gray-900 hover:text-white rounded">
                                <div class="w-10"><i class="ml-2 far fa-question-circle"></i></div>
                                <div>FAQ</div>
                            </a>
                            <a href="{{route('aboutus')}}" class="flex items-center  py-2 px-1 hover:bg-gray-900 hover:text-white rounded">
                                <div class="w-10"><i class="ml-2 far fa-address-card"></i></div>
                                <div>About us</div>
                            </a>
                            <a href="{{route('ourteam')}}" class="flex items-center  py-2 px-1 hover:bg-gray-900 hover:text-white rounded">
                                <div class="w-10"><i class="ml-2 fas fa-user-friends"></i></div>
                                <div>Our Team</div>
                            </a>
                            <div class="flex items-center  py-2 px-1 hover:bg-red-600 hover:text-white rounded text-red-600" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <div class="w-10"><i class="ml-2 fas fa-sign-out-alt"></i></div>
                                    <div><a>
                                        Logout
                                    </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    {{ csrf_field() }}
                                </form></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endauth
            </nav>
            <div class="fixed z-50 inset-0 overflow-y-auto champResModal" style='display:none;'>
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class='bg-gray-900 mb-3 p-1 flex justify-end'>
                        <div class="modalTitle text-white w-full p-1 pl-4">
                        </div>
                        <button id='closeModal' class="rounded-full text-white font-bold h-8 w-8 flex items-center justify-center"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="mb-8 mx-6 rounded-lg border" id="sub-menu">
                        <div class="font-bold text-sm px-5 mt-4 tracking-wide">Select Series</div>
                        <div class="px-5 w-full">
                            <select class="seriesOptions border-2 rounded w-full border-gray-800 hover:bg-gray-900 bg-white text-black hover:text-white p-1 my-2">
                                <option class="" selected value="">Choose Series</option>
                                @foreach($topBarSeasons as $series)
                                    <option value='{{str_replace(' ', '_',strtolower($series['name']['website']))}}'>{{$series['name']['website']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="tierSelectDiv" style="display: none;">
                            <div class="font-bold text-sm px-5 mt-4 tracking-wide">Select Tier</div>
                            <div class="px-5 w-full">
                                <select class="tierOptions border-2 w-full border-gray-800 rounded hover:bg-gray-900 bg-white text-black hover:text-white p-1 my-2">
                                    <option class="" selected value="">Choose Tier</option>
                                    @foreach($topBarSeasons as $series)
                                        @foreach($series['tier'] as $tier)
                                            <option value="{{$tier[0]['tier']}}" class="allTierOptions tiersOf_{{str_replace(' ', '_',strtolower($series['name']['website']))}}" data-tier='{{$tier[0]['tier']}}' data-series='{{str_replace(' ', '_',strtolower($series['name']['website']))}}'>{{$tier[0]['tiername']}}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="seasonSelectDiv" style="display: none;">
                            <div class="font-bold text-sm px-5 mt-4 tracking-wide">Select Season</div>
                            <div class="px-5 w-full">
                                <select class="seasonOptions border-2 border-gray-800 rounded w-full hover:bg-gray-900 bg-white text-black hover:text-white p-1 my-2">
                                    <option class="" selected value="">Choose Season</option>
                                    @foreach($topBarSeasons as $series)
                                        @foreach($series['tier'] as $tier)
                                            @foreach($tier as $season)
                                                <option class="allSeasonOptions seasonOf_{{$tier[0]['tier']}}_{{str_replace(' ', '_',strtolower($series['name']['website']))}}" data-champLink='/{{$series['name']['code']}}/{{$season['tier']}}/{{$season['season']}}/standings' data-raceLink='/{{$series['name']['code']}}/{{$season['tier']}}/{{$season['season']}}/races'>Season {{floor($season['season'])}}</option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="text-center my-2 mx-6 font-semibold">
                            <div style="display: none;" class="lickAndSend px-4 py-2 bg-blue-600 text-white rounded font-semibold shadow-md cursor-pointer hover:bg-blue-700 hover:text-white hover:shadow-none">
                                <button id="lickAndSend" type="button" class="text-center">Send It!</button>
                            </div>
                            <span style="display: none;" id="optionError" class="text-red-800"><i class="fa fa-exclamation-triangle pt-2 pr-2" aria-hidden="true"></i> Please select all the options</span>
                        </div>
                        <a style="display: none;" id="redirectLickAndSend" href=""></a>

                    </div>
                    </div>
                </div>
            </div>
            <div class='mainContent'>
                @auth
    
                    @if (session()->has('error'))
                        <div class="container mx-auto">
                            <div class="rounded text-red-600 p-4 mb-3 border-2 border-red-600 font-semibold my-4">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{session()->get('error')}}
                            </div>
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="container mx-auto">
                            <div class="rounded text-green-600 p-4 mb-3 border-2 border-green-600 font-semibold my-4">
                                <i class="far fa-check-circle mr-2"></i>{{session()->get('success')}}
                            </div>
                        </div>
                    @endif
                    <main class="container mx-auto my-4">
                        @yield('content')
                    </main>
                    <main class="w-full">
                        @yield('body')
                    </main>
                @endauth
                @guest
                    <main class="container mx-auto">
                        @yield('content')
                    </main>
                    <main class="w-full">
                        @yield('body')
                    </main>
                @endguest
            </div>
            <!-- <div class='clearfixFooter'></div> -->
            <footer class="border-t p-8 justify-between md:items-center bg-white flex flex-col md:flex-row mt-10 w-full">
                <div class="leading-tight">
                    <div class="text-gray-700 font-bold">Indian Racing Community</div>
                    <div class="text-gray-600 font-semibold text-sm">A place for every racing enthusiast.</div>
                </div>
                <div class="text-sm font-bold text-gray-600 md:my-0 my-0">
                    <span class="mr-4 hover:text-gray-900 cursor-pointer">
                        <a href="{{route('faq')}}">FAQ</a>
                    </span>
                    <span class="mr-4 hover:text-gray-900 cursor-pointer">
                        <a href="{{route('aboutus')}}"> About Us</a>
                    </span>
                    <span class="mr-4 hover:text-gray-900 cursor-pointer">
                        <a href="{{route('ourteam')}}">Our Team</a>
                    </span>
                </div>
                <div>
                    <span class="mr-2 text-xl text-pink-800 hover:text-gray-900 cursor-pointer">
                        <a href="https://www.instagram.com/indianracingcommunity/" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </span>
                    <span class="mr-2 text-xl text-pink-800 hover:text-gray-900 cursor-pointer">
                        <a href="https://www.facebook.com/indianracingcommunity/" target="_blank">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </span>
                    <span class="mr-2 text-xl text-blue-600 hover:text-gray-900 cursor-pointer">
                        <a href="https://twitter.com/racing_indian" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </span>
                    <span class="mr-2 text-xl text-red-600 hover:text-gray-900 cursor-pointer">
                        <a href="https://www.youtube.com/channel/UC2Li3g3zak9gQ6YtE3YThXw" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </span>
                    <span class="mr-2 text-xl text-blue-800 hover:text-gray-900 cursor-pointer">
                        <a href="https://steamcommunity.com/groups/indianracingcommunity" target="_blank">
                            <i class="fab fa-steam"></i>
                        </a>
                    </span>
                    {{-- <span class="text-xl text-gray-600 hover:text-gray-900 cursor-pointer">
                        <a href="https://www.reddit.com/r/IndianRacingCommunity/" target="_blank">
                            <i class="fab fa-reddit" style="color: #ff581a"></i>
                        </a>
                    </span> --}}
                </div>
            </footer>
        </div>

    </body>
    <script src="{{ asset('js/scripts.js') }}" type="text/javascript">
    </script>
    @if ("{{Auth::user()->mothertongue}}" == "")
        <script>
            $( document ).ready(function() {
            $('#sidebar').show('slow', function() {});
            sidebarVisible = 0;
            });
        </script>
    @endif
</html>
