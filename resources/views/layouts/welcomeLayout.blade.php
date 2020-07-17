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

        <nav class="block sm:block md:block lg:flex xl:flex items-center justify-between border-b">
            
            <div class="flex justify-center items-center px-2 m-0 sm:m-0 md:m-0 lg:m-2 xl:m-2 bg-gray-800 text-white h-12 font-bold rounded-md hover:bg-gray-700 w-full sm:w-full md:w-full lg:w-1/5 xl:w-1/5 cursor-pointer">
                <a href="/" class="flex bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700"><div class="w-12 flex item-center justify-center"><img class="object-contain" src="/img/IRC_logo/logo_square_new.png"></div> <div class="flex mx-3 items-center justify-center">Indian Racing Community</div></a>
            </div>
            <div class="flex sm:w-full md:w-full lg:w-1/2 xl:w-3/4 p-2 items-center">
                <div class="flex items-center justify-center w-1/5 sm:w-1/5 md:w-1/5 lg:w-auto xl:w-auto px-0 sm:px-0 md:px-0 lg:px-3 xl:px-3 m-0 sm:m-0 md:m-0 lg:m-2 xl:m-2 py-0 sm:py-0 md:py-0 lg:py-3 xl:py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer">
                    <a  href="/faq"><i class='fas fa-question-circle mx-1 text-blue-500'></i> FAQ</a>
                </div>
                <div class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer mx-2 dropdown">
                    <button class="font-semibold px-4 rounded inline-flex items-center">
                        <span> <i class='fas fa-trophy mx-1 text-yellow-500'></i> Championship Standings</span>
                    </button>
                    <ul class="dropdown-content absolute hidden text-gray-700 -ml-4 pt-3" style="width: 17.1rem;">
                        @foreach($topBarSeasons as $series)
                            <li class="dropdown">
                                <a class="bg-indigo-100 hover:bg-blue-300 py-2 px-4 block whitespace-no-wrap rounded" href="#"><i class='fas fa-caret-right pr-3 text-green-500'></i> {{$series['name']['name']}}</a>
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
                <div class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer mx-2 dropdown">
                    <button class="font-semibold px-4 rounded inline-flex items-center">
                        <span>🏁 Race Results</span>
                    </button>
                    <ul class="dropdown-content absolute hidden text-gray-700 -ml-4 pt-3" style="width: 11.2rem;">
                        @foreach($topBarSeasons as $series)
                            <li class="dropdown">
                                <a class="bg-indigo-100 hover:bg-blue-300 py-2 px-4 block whitespace-no-wrap rounded" href="#"><i class='fas fa-caret-right pr-3 text-green-500'></i> {{$series['name']['name']}}</a>
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
                <div class="px-4 py-3 font-semibold rounded hover:bg-blue-200 cursor-pointer mx-2 dropdown">
                    <button class="font-semibold pl-6 pr-6 rounded inline-flex items-center">
                        <a  href="#"><i class="fa fa-info-circle" aria-hidden="true"></i> Info</a>
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
        @if(session()->has('error'))
        <div class="bg-red-200 rounded text-black-800 p-4 mb-3 font-semibold">
            {{session()->get('error')}}
            </div>
        @endif
        @yield('body')
        <script type="text/javascript">
            $( document ).ready(function() {
                $('.pageBody').show('slow', function() {});
            });
        </script>
    </body>
</html>
