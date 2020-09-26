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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="{{ asset('/css/custom.css')}}"> -->
        <script src="{{ asset('js/jquery35.js')}}"></script>
        <style>
            .box {
                position:absolute;
                top:0px;
                right:0px;
                bottom:0px;
                left:0px;
            }
            .dropdown {
                position: relative;
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                right: 10px;
            }

            .dropdown:hover .dropdown-content {
                display: block;
            }
        </style>
    </head>


    <body class="bg-gray-100">
        <div class="" id="screen">
            <div class="md:w-auto bg-white z-100 hidden min-h-full fixed border-r border-gray-400 shadow-lg" style="min-width:250px" id="sidebar">
                <div class="h-screen py-2 text-black">
                    <div class="flex items-center px-4">
                        <div class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700 cursor-pointer">
                            <a href="/"   class="flex" class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700"><img src="/img/IRC_logo/logo_square.png" height="45" width="45"> <span class="py-3 pl-2">Indian Racing Community</span></a>
                        </div>
                        <div class="items-center py-4 px-2 flex-shrink-0 cursor-pointer" onclick="menu()"><i class="fas fa-times"></i></div>
                    </div>
                    <div>
                        <div class="my-8">
                            <div class="font-bold text-sm px-5 tracking-wide">LEAGUE RACING</div>
                            <div class="my-1">
                                <div class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fas fa-edit"></i></div>All sign up</div>
                            </div>
                            <div class="font-bold text-sm px-5 mt-4 tracking-wide">LEAGUE RULES</div>
                            <div class="my-1">
                                <div class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fas fa-desktop"></i></div>PC F1</div>
                                <div class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fab fa-xbox"></i></div>XBOX F1</div>
                            </div>
                            <div class="font-bold text-sm px-5 mt-4 tracking-wide">LEAGUE INFO</div>
                            <div class="my-1">
                                <div class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fas fa-desktop"></i></div>Championship Standings</div>
                                <div class="py-2 text-black cursor-pointer pr-4 mx-4 rounded-md hover:bg-gray-900 font-medium hover:text-white flex items-center"><div class="items-center flex-shrink-0 w-12 text-center"><i class="fab fa-xbox"></i></div>Race Results</div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:w-full" id="content">
                <nav class="flex items-center border-b border-gray-400 justify-between px-2 py-2 bg-white z-100">
                    <div class="flex items-center">
                        <div class="items-center p-4 flex-shrink-0 cursor-pointer" onclick="menu()"><i class="fas fa-bars"></i></div>
                        <div class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700 cursor-pointer">
                            <a href="/"   class="flex" class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700"><img src="/img/IRC_logo/logo_square.png" height="45" width="45"> <span class="py-3 pl-2  md:block hidden">Indian Racing Community</span></a>
                        </div>
                        <div class="hidden md:block rounded-md py-2 items-center flex-shrink-0 font-semibold px-4 cursor-pointer hover:bg-gray-900 hover:text-white">Championship Standings</div>
                        <div class="hidden md:block rounded-md py-2 items-center flex-shrink-0 font-semibold px-4 cursor-pointer hover:bg-gray-900 hover:text-white">Race Results</div>
                    </div>
                    <div class="flex items-center">
                        <div class="py-2 items-center flex-shrink-0 font-semibold px-4 dropdown cursor-pointer">
                            <img src="{{Auth::user()->avatar}}" class="rounded-full w-10" alt="">
                            <div class="dropdown-content bg-white shadow-lg border rounded-md cursor p-4">
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
                                <div class="flex items-center  py-2 px-1 hover:bg-gray-900 hover:text-white rounded">
                                    <div class="w-10"><i class="ml-2 far fa-user"></i></div>
                                    <div>Profile</div>
                                </div>
                                <div class="flex items-center  py-2 px-1 hover:bg-gray-900 hover:text-white rounded">
                                    <div class="w-10"><i class="ml-2 far fa-question-circle"></i></div>
                                    <div>FAQ</div>
                                </div>
                                <div class="flex items-center  py-2 px-1 hover:bg-gray-900 hover:text-white rounded">
                                    <div class="w-10"><i class="ml-2 far fa-address-card"></i></div>
                                    <div>About us</div>
                                </div>
                                <div class="flex items-center  py-2 px-1 hover:bg-gray-900 hover:text-white rounded">
                                    <div class="w-10"><i class="ml-2 fas fa-user-friends"></i></div>
                                    <div>Our Team</div>
                                </div>
                                <div class="flex items-center  py-2 px-1 hover:bg-red-600 hover:text-white rounded text-red-600">
                                    <div class="w-10"><i class="ml-2 fas fa-sign-out-alt"></i></div>
                                    <div>Logout</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                @auth
                <main class="container mx-auto my-4">
                    @if (session()->has('error'))
                    <div class="rounded text-red-600 p-4 mb-3 border-2 border-red-600 font-semibold my-4">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{session()->get('error')}}
                    </div>
                    @endif
                    @if (session()->has('success'))
                    <div class="rounded text-green-600 p-4 mb-3 border-2 border-green-600 font-semibold my-4">
                    <i class="far fa-check-circle mr-2"></i>{{session()->get('success')}}
                    </div>
                    @endif
                    @yield('content')
                </main>
                @endauth
                @guest
                <main class="container mx-auto">
                    @yield('content')
                </main>
                @endguest
                <footer class="mx-8 border-t py-8 justify-between md:items-center flex flex-col md:flex-row mt-10">
                    <div class="leading-tight">
                        <div class="text-gray-700 font-bold">Indian Racing Comunity</div>
                        <div class="text-gray-600 font-semibold text-sm">A place for every racing enthusiast.</div>
                    </div>
                    <div class="text-sm font-bold text-gray-600 md:my-0 my-0">
                        <span class="mr-4 hover:text-gray-900 cursor-pointer">
                            FAQ
                        </span>
                        <span class="mr-4 hover:text-gray-900 cursor-pointer">
                            About Us
                        </span>
                        <span class="mr-4 hover:text-gray-900 cursor-pointer">
                            Our Team
                        </span>
                    </div>
                    <div>
                        <span class="mr-2 text-xl text-gray-600 hover:text-gray-900 cursor-pointer">
                            <i class="fab fa-instagram"></i>
                        </span>
                        <span class="mr-2 text-xl text-gray-600 hover:text-gray-900 cursor-pointer">
                            <i class="fab fa-twitter"></i>
                        </span>
                        <span class="mr-2 text-xl text-gray-600 hover:text-gray-900 cursor-pointer">
                            <i class="fab fa-youtube"></i>
                        </span>
                        <span class="mr-2 text-xl text-gray-600 hover:text-gray-900 cursor-pointer">
                            <i class="fab fa-steam"></i>
                        </span>
                        <span class="text-xl text-gray-600 hover:text-gray-900 cursor-pointer">
                            <i class="fab fa-reddit"></i>
                        </span>
                    </div>
                </footer>
            </div>
        </div>

    </body>
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
                $('#sidebar').show('slow', function() {});
                sidebarVisible = 0
            } else {
                $('#sidebar').hide('slow', function() {});
                sidebarVisible = 1
            }
        }
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
