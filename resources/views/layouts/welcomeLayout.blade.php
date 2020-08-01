<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Indian Racing Community</title>
        <link rel="icon" href="{{url('/img/IRC_logo/logo_square.png')}}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=1378">
        <meta property="og:title" content="Indian Racing Community">
        <meta property="og:description" content="A place For Every Indian Racing Enthusiast.">
        <meta property="og:image" content="/img/IRC_logo/logo_square_new.png">
        <meta property="og:url" content="https://indianracingcommunity.co.in">
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <script src="{{ asset('js/jquery35.js')}}"></script>
        <link rel="stylesheet" href="{{ asset('/css/custom.css')}}">
    </head>
    <body class="pageBody" style="display: none;">

        <nav class="flex justify-between border-b fixed bg-white w-full" style="z-index: 5;">
            <div class="flex py-2">
                @auth
                <div class="block pt-3 items-center px-2 flex-shrink-0 cursor-pointer hover:bg-gray-200 py-2 ml-2 rounded" onclick="menu()"><i class="fas fa-bars"></i></div>
                @endauth
                <div class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700 cursor-pointer">
                    <a href="/"   class="flex" class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700"><img src="/img/IRC_logo/logo_square.png" height="45" width="45"> <span class="py-3 pl-2">Indian Racing Community</span></a>
                </div>
                <div class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer mx-2">
                    <a  href="/faq"><i class='fas fa-question-circle mx-1 text-blue-500'></i> FAQ</a>
                </div>
                <div class="px-4 py-3 font-semibold cursor-default rounded hover:bg-gray-200 mx-2 dropdown">
                    <button class="font-semibold cursor-default px-4 rounded inline-flex items-center">
                        <span> <i class='fas fa-trophy mx-1 text-yellow-500'></i> Championship Standings</span>
                    </button>
                    <ul class="dropdown-content absolute hidden text-gray-700 -ml-4 pt-3" style="width: 17.1rem;">
                        @foreach($topBarSeasons as $series)
                            <li class="dropdown">
                                <a class="bg-indigo-100 cursor-default hover:bg-blue-300 py-2 px-4 block whitespace-no-wrap rounded" href="#"><i class='fas fa-caret-right pr-3 text-green-500'></i> {{$series['name']['name']}}</a>
                                <ul class="dropdown-content hidden absolute text-gray-700 -mt-10" style="margin-left: 17rem; width: 7.5rem;">
                                    @foreach($series['tier'] as $tier)
                                    <li class="dropdown">
                                        <a class="bg-orange-100 hover:bg-green-300 py-2 px-4 block whitespace-no-wrap rounded" href="/{{$series['name']['code']}}/{{$tier[0]['tier']}}/{{$tier[0]['season']}}/standings"><i class='fas fa-caret-right pr-3 text-blue-500'></i> Tier {{$tier[0]['tier']}}</a>
                                        <ul class="dropdown-content absolute hidden text-gray-700 ml-20 pl-10 -mt-10">
                                            @foreach($tier as $season)
                                            <li>
                                                <a class="bg-purple-100 hover:bg-orange-300 py-2 px-4 block whitespace-no-wrap rounded" href="/{{$series['name']['code']}}/{{$season['tier']}}/{{$season['season']}}/standings"><i class='fas fa-caret-right pr-3 text-red-400'></i> Season {{$season['season']}}</a>
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
                <div class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-default mx-2 dropdown">
                    <button class="font-semibold cursor-default px-4 rounded inline-flex items-center">
                        <span>🏁 Race Results</span>
                    </button>
                    <ul class="dropdown-content absolute hidden text-gray-700 -ml-4 pt-3" style="width: 11.2rem;">
                        @foreach($topBarSeasons as $series)
                            <li class="dropdown">
                                <a class="bg-indigo-100 hover:bg-blue-300 cursor-default py-2 px-4 block whitespace-no-wrap rounded" href="#"><i class='fas fa-caret-right pr-3 text-green-500'></i> {{$series['name']['name']}}</a>
                                <ul class="dropdown-content hidden absolute text-gray-700 -mt-10" style="margin-left: 11.1rem; width: 7.5rem;">
                                    @foreach($series['tier'] as $tier)
                                    <li class="dropdown">
                                        <a class="bg-orange-100 hover:bg-green-300 py-2 px-4 block whitespace-no-wrap rounded" href="/{{$series['name']['code']}}/{{$tier[0]['tier']}}/{{$tier[0]['season']}}/races"><i class='fas fa-caret-right pr-3 text-blue-500'></i> Tier {{$tier[0]['tier']}}</a>
                                        <ul class="dropdown-content absolute hidden text-gray-700 -mt-10" style="margin-left: 7.4rem;">
                                            @foreach($tier as $season)
                                            <li>
                                                <a class="bg-purple-100 hover:bg-orange-300 px-4 py-2 block whitespace-no-wrap rounded" href="/{{$series['name']['code']}}/{{$season['tier']}}/{{$season['season']}}/races"><i class='fas fa-caret-right pr-3 text-red-400'></i> Season {{$season['season']}}</a>
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
                <div class="px-4 py-3 font-semibold rounded cursor-default hover:bg-blue-200 mx-2 dropdown">
                    <button class="font-semibold pl-6 pr-6 cursor-default rounded inline-flex items-center">
                        <i class="fa fa-info-circle pr-1" aria-hidden="true"></i> Info
                    </button>
                    <ul class="dropdown-content absolute hidden text-gray-700 -ml-4 pt-3" style="width: 8.2rem;">
                        <li class="dropdown">
                            <a class="bg-gray-200 hover:bg-blue-300 py-2 text-center px-4 block whitespace-no-wrap rounded" href="/aboutus"><i class='pr-2 far fa-address-card text-indigo-500'></i> About Us</a>
                        </li>
                        <li class="dropdown">
                            <a class="bg-gray-200 hover:bg-green-300 py-2 text-center px-4 block whitespace-no-wrap rounded" href="/ourteam"><i class="pr-2 fa fa-users text-yellow-500" aria-hidden="true"></i> Our Team</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="w-full sm:w-full md:w-full lg:w-1/4 xl:w-1/4 flex items-center justify-end">
               <div class="flex items-center justify-center px-4 py-2 m-2 w-full sm:w-full md:w-full lg:w-auto xl:w-auto bg-blue-600 text-white rounded font-semibold shadow-lg cursor-pointer hover:bg-blue-700 hover:shadow-none">
               @auth
               <a  href="/user/profile"><i class='far fa-user mr-2'></i>{{Auth::user()->name}}</a>
               @endauth
                @guest
                <a href="/login/discord"><i class='far fa-user mr-2'></i>Login</a>
                @endguest
                </div>
            </div>
        </nav>
        @auth
        <div class="flex"  style="z-index: 4;">
            <div class="sidebar hidden fixed h-screen bg-gray-100 border w-56 py-4 px-4 shadow" id="sidebar">
                <a href="/user/profile/" class="flex hover:bg-gray-200 rounded-md mt-16 py-4 px-2">
                    <img src="{{Auth::user()->avatar}}" class="rounded-full w-16" alt="">
                    <div class="px-4 py-2">
                        <div class="font-semibold text-indigo-600">
                            {{Auth::user()->name}}
                        </div>
                        <div class="font-semibold text-sm">
                            #{{Auth::user()->discord_discrim}}
                        </div>
                    </div>
                </a>
                <div class="pt-8 text-sm font-bold text-gray-700">
                    USER CONTROLS
                </div>
                <div class="flex flex-col">
                    <a href="/signup/" class="px-3 py-2 font-semibold hover:bg-gray-300 hover:text-blue-600 rounded-md text-gray-700"><i class="text-indigo-600 fas fa-edit w-8 text-center"></i> League Sign Up </a>
                    <a href="/f1leaguerules" class="px-3 py-2 font-semibold hover:bg-gray-300 hover:text-blue-600 rounded-md text-gray-700"><i class="text-indigo-600 fa fa-gavel w-8 text-center"></i>F1 League Rules </a>
                    <!-- <a href="/home/report/create" class="px-3 py-2 font-semibold hover:bg-gray-300 hover:text-blue-600 rounded-md text-gray-700"><i class="text-orange-500 fas fa-exclamation-triangle w-8 text-center"></i>Create Report</a> -->
                </div>
                @if(Auth::user()->isadmin==1)
                <div class="pt-8 text-sm font-bold text-gray-700">
                    ADMIN CONTROLS
                </div>
                <div class="flex flex-col">
                    <a href="/home/admin/users" class="px-3 py-2 font-semibold hover:bg-gray-300 hover:text-blue-600 rounded-md text-gray-700"><i class="text-blue-500 fas fa-binoculars w-8 text-center"></i>View/Allot Drivers</a>
                    <a href="" class="px-3 py-2 font-semibold hover:bg-gray-300 hover:text-blue-600 rounded-md text-gray-700"><i class="text-purple-600 fas fa-pen-alt w-8 text-center"></i>Update Standings</a>
                    <a href="/home/admin/report" class="px-3 py-2 font-semibold hover:bg-gray-300 hover:text-blue-600 rounded-md text-gray-700"><i class="text-orange-500 fas fa-exclamation-triangle w-8 text-center"></i>View Reports</a>
                    <a href="/home/admin/view-signups" class="px-3 py-2 font-semibold hover:bg-gray-300 hover:text-blue-600 rounded-md text-gray-700"><i class="text-green-600 fa fa-eye w-8 text-center"></i> View Sign Ups </a>
                </div>
                @endif
            </div>
        </div>
        @endauth
        @if(session()->has('error'))
        <div class="bg-red-200 rounded text-black-800 p-4 mb-3 font-semibold">
            {{session()->get('error')}}
            </div>
        @endif
        <div class="pt-16">
            @yield('body')
        </div>
        <script type="text/javascript">
            $( document ).ready(function() {
                $('.pageBody').show('slow', function() {});
            });
            let sidebarVisible = 1
            function menu() {
                console.log("function called")
                let element = document.getElementById("sidebar");
                let element2 = document.getElementById("customMargin");
                if (sidebarVisible == 1) {
                    // element.classList.remove("hidden");
                    $('#sidebar').show('slow', function() {});
                    // element2.classList.add("ml-64")
                    sidebarVisible = 0
                } else {
                    $('#sidebar').hide('slow', function() {});
                    sidebarVisible = 1
                }
            }
        </script>
    </body>
</html>
