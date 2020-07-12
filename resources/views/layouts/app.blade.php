<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{url('/img/IRC_logo/logo_square.png')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Indian Racing Comunity</title>
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
            <link rel="stylesheet" href="/css/custom.css">
            <script src="{{ asset('js/jquery35.js')}}"></script>
        </head>
        <body class="w-full">
            <nav class="flex justify-between border-b fixed bg-white w-screen z-10 py-2">
                <div class="flex items-center flex-shrink-0">
                    <div class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700 cursor-pointer flex items-center flex-shrink-0">
                        <a href="/"   class="flex" class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700"><img src="/img/IRC_logo/logo_square.png" height="45" width="45"> <span class="p-3">Indian Racing Comunity</span> </a>
                    </div>
                    <div class=" mx-2 flex items-center flex-shrink-0">
                        <a  class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer" href="/joinus"><i class='fas fa-question-circle mx-1 text-blue-500'></i> FAQ</a>
                    </div>
                    <div class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer mx-2 dropdown">
                        <a class="dropbtn"><i class='fas fa-trophy mx-1 text-yellow-500'></i> Championship Standings</a>
                        <div class="dropdown-content mx-5 my-3">
                            <a href="/1/4/standings" class="hover:bg-blue-300 "><i class='fas fa-caret-right pr-3 text-green-500'></i> Tier 1</a>
                            <a href="/2/1/standings" class="hover:bg-green-300"><i class='fas fa-caret-right pr-3 text-blue-500'></i> Tier 2</a>
                            <a href="/1/4.5/standings" class="hover:bg-yellow-300 "><i class='fas fa-caret-right pr-3 text-orange-500'></i> Mini Championship</a>
                            <a href="/1/4.75/standings" class="hover:bg-orange-300"><i class='fas fa-caret-right pr-3 text-yellow-500'></i> Classic Cars</a>
                        </div>
                    </div>
                    <div class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer mx-2 dropdown">
                        <a class="dropbtn">🏁 Race Results</a>
                        <div class="dropdown-content mx-5 my-3">
                            <a href="/1/4/races" class="hover:bg-blue-300 "><i class='fas fa-caret-right pr-3 text-green-500'></i> Tier 1</a>
                            <a href="/2/1/races" class="hover:bg-green-300"><i class='fas fa-caret-right pr-3 text-blue-500'></i> Tier 2</a>
                            <a href="/1/4.5/races" class="hover:bg-yellow-300 "><i class='fas fa-caret-right pr-3 text-orange-500'></i> Mini Championship</a>
                            <a href="/1/4.75/races" class="hover:bg-orange-300"><i class='fas fa-caret-right pr-3 text-yellow-500'></i> Classic Cars</a>
                        </div>
                    </div>
                    <div class=" mx-2 flex items-center flex-shrink-0">
                        <a  class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer" href="/aboutus"><i class='far fa-address-card mx-1 text-indigo-500'></i>About Us</a>
                    </div>
                </div>
                <div class="flex items-center flex-shrink-0 mr-8">
                    @auth
                    <div class="px-4 py-2 bg-red-200 text-red-700 rounded font-semibold cursor-pointer hover:bg-red-300 text-center">
                        <a  href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt text-red-600 mr-2 text-center"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    </div>
                    @endauth
                    @guest
                    <div class="px-4 flex py-2 bg-blue-600 text-white rounded font-semibold shadow-md cursor-pointer hover:bg-blue-700 hover:shadow-none">
                        <a href="/login/discord"><i class='far fa-user mr-2'></i>Login</a>
                    </div>
                    @endguest
                </div>
            </nav>
            <div class="flex">
                @auth
                <div class="sidebar fixed h-screen bg-gray-100 border w-56 py-4 px-4 shadow mt-16">
                    <a href="/user/profile/" class="flex hover:bg-gray-200 rounded-md py-4 px-2">
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
                        <a href="/signup/" class="px-3 py-2 font-semibold hover:bg-gray-300 hover:text-blue-600 rounded-md text-gray-700"><i class="text-indigo-600 fas fa-edit w-8 text-center"></i>Sign Up </a>
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
                    </div>
                    @endif
                </div>
                @endauth
                @auth
                <main class="py-20 ml-64 w-full">
                    @if (session()->has('error'))
                    <div class="bg-red-200 rounded text-red-800 p-4 mb-3 font-semibold">
                        {{session()->get('error')}}
                    </div>
                    @endif
                    @yield('content')
                </main>
                @endauth
                @guest
                <main class="py-20 w-full">
                    @yield('content')
                </main>
                @endguest
            </div>
        </div>
    </body>
</html>
