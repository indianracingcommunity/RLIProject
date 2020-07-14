<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Indian Racing Community</title>
        <link rel="icon" href="{{url('/img/IRC_logo/logo_square.png')}}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <script src="{{ asset('js/jquery35.js')}}"></script>
        <link rel="stylesheet" href="/css/custom.css">
    </head>
    <body class="pageBody" style="display: none;">
        
        <nav class="flex justify-between border-b">
            <div class="flex py-2">
                <div class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700 cursor-pointer">
                    <a href="/"   class="flex" class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700"><img src="/img/IRC_logo/logo_square.png" height="45" width="45"> <span class="py-3 pl-2">Indian Racing Community</span></a>
                </div>
                <div class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer mx-2">
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
                <div class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer mx-2">
                    <a  href="/aboutus"><i class='far fa-address-card mx-1 text-indigo-500'></i>About Us</a>
                </div>
            </div>
            <div>
            <div class="px-4 flex py-2 m-2 bg-blue-600 text-white rounded font-semibold shadow-lg cursor-pointer hover:bg-blue-700 hover:shadow-none">
               @auth
               <a  href="/user/profile"><i class='far fa-user mr-2'></i>{{Auth::user()->name}}</a>
               @endauth
                @guest
                <a href="/login/discord"><i class='far fa-user mr-2'></i>Login</a>
                @endguest
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
