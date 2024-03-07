@extends('layouts.app')
@section('content')
<div class="flex flex-col xl:flex-row justify-between items-center gap-10 p-5 md:px-10">
    <div class="flex flex-col items-center xl:items-start justify-center gap-10 xl:ml-10 xl:w-7/12">
        <div class="flex flex-col items-center xl:items-start justify-center gap-8 xl:gap-12 text-center xl:text-left">
            <div class="flex flex-col">
                <p class="text-3xl md:text-4xl xl:text-5xl font-bold text-gray-900">Welcome to IRC!</p>     
                <p class="text-xl md:text-2xl xl:text-3xl font-semibold text-gray-700">A place for every Indian racing enthusiast.</p>
            </div>
            
            @guest
                <a href="{{route('joinus')}}" class="flex items-center justify-center xl:justify-start">
                    <p class="text-xl font-bold px-4 py-2 bg-purple-600 shadow-lg text-white rounded-md cursor">
                        Join us
                    </p>
                </a>
            @endguest
        </div>

        <div class="flex flex-col items-center xl:items-start justify-center gap-3">
            <p class="font-semibold text-lg text-gray-700 xl:px-1">Follow us</p>

			<div class="flex flex-row gap-2 text-white">
                <a href="https://www.youtube.com/channel/UC2Li3g3zak9gQ6YtE3YThXw" target="_blank">
                    <i style='background:#FF0000' class='fab fa-youtube text-2xl md:text-3xl p-2 rounded-md'></i>
                </a>	
                <a href="https://www.instagram.com/indianracingcommunity/" target="_blank">
                    <i style='background:#E1306C' class="fab fa-instagram text-2xl md:text-3xl mx-2 p-2 rounded-md bg-pink-600"></i>
                </a>
                <a href="https://steamcommunity.com/groups/indianracingcommunity" target="_blank">
                    <i style='background:#1f3d7a' class='fab fa-steam text-2xl md:text-3xl p-2 rounded-md'></i> 
                </a>		
                <a href="https://twitter.com/racing_indian" target="_blank">
                    <i style='background:#1DA1F2' class='fab fa-twitter text-2xl md:text-3xl mx-2 p-2 rounded-md bg-blue-500'></i> 
                </a>
                <a href="https://www.facebook.com/indianracingcommunity/" target="_blank">
                    <i style='background:#4267B2' class='fab fa-facebook text-2xl md:text-3xl p-2 rounded-md bg-blue-800'></i> 
                </a>
                <!-- <a href="https://www.reddit.com/r/IndianRacingCommunity/" target="_blank">
                    <i style="background:#ff581a" class="fab fa-reddit text-2xl md:text-3xl mx-2 p-2 rounded-md" ></i>
                </a> -->
			</div>
		</div>
    </div>
    
    <div class="flex items-center justify-center md:w-2/3">
        <img class="object-contain" src='https://cdn.dribbble.com/users/1568450/screenshots/7880617/media/2b89eb9a9496fba5dc1f7bf7d1418855.png'>
    </div>

    <div class="popover__wrapper hidden xl:block fixed right-0 bottom-0 mr-10 mb-24">
        <img class="object-contain rounded-full w-20" src='{{asset('/img/homeDiscord.png')}}'>
        
        <div class="popover__content">
            <iframe src="https://discord.com/widget?id={{$irc_guild}}&theme=dark" class="mt-5" width="300" height="500" allowtransparency="true"></iframe>
        </div>
    </div>
</div>
<!-- <div style="height:250px; width:100%; clear:both;"></div> -->

{{-- <script src="https://cdn.jsdelivr.net/npm/@widgetbot/crate@3" async defer>
    new Crate({
      server: '641545840619683841',
      channel: '645515279593373717'
    })
  </script> --}}
@endsection
