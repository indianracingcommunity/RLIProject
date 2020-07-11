<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Indian Racing Community</title>
        <link rel="icon" href="{{url('/img/IRC_logo/logo_square.png')}}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
        
        <script src="{{ URL::to('assets/js/jquery3.5.js') }}"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/custom.css">
    </head>
    <body>
        <nav class="flex justify-between border-b">
            <div class="flex py-2">
                <div class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700 cursor-pointer">
                    <a href="/"   class="flex" class="px-3 bg-gray-800 mx-2 text-white font-bold rounded-md hover:bg-gray-700"><img src="/img/IRC_logo/logo_square.png"height="45" width="45"> <span class="p-3">Indian Racing Comunity</span> </a>
                </div>
                <div class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer mx-2">
                    <a  href="/joinus"><i class='fas fa-question-circle mx-1 text-blue-500'></i> FAQ</a>
                </div>
                <div class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer mx-2 dropdown">
                    <a class="dropbtn" href="/standings"><i class='fas fa-trophy mx-1 text-yellow-500'></i> Championship Standings</a>
                    <div class="dropdown-content mx-5 my-3">
                        <a href="/1/4/standings" class="hover:bg-blue-300 "><i class='fas fa-caret-right px-5 text-green-500'></i> Tier 1</a>
                        <a href="/2/1/standings" class="hover:bg-green-300"><i class='fas fa-caret-right px-5 text-blue-500'></i> Tier 2</a>
                        <a href="/1/4.5/standings" class="hover:bg-blue-300 "><i class='fas fa-caret-right px-5 text-orange-500'></i> Mini Championship</a>
                        <a href="/1/4.75/standings" class="hover:bg-green-300"><i class='fas fa-caret-right px-5 text-yellow-500'></i> Classic Cars</a>
                    </div>
                </div>
                <!-- <div class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer mx-2">
                    <a  href="/report"><i class='far fa-edit text-red-500 mx-1'></i>Report</a>
                </div> -->
                <div class="px-4 py-3 font-semibold rounded hover:bg-gray-200 cursor-pointer mx-2">
                    <a  href="/aboutus"><i class='far fa-address-card mx-1 text-indigo-500'></i>About Us</a>
                </div>
            </div>
            <div>
            <div class="px-4 flex py-2 m-2 bg-blue-600 text-white rounded font-semibold shadow-lg cursor-pointer hover:bg-blue-700 hover:shadow-none">
               @auth
               <a  href="/home"><i class='far fa-user mr-2'></i>{{Auth::user()->name}}</a>
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
    </body>
</html>
