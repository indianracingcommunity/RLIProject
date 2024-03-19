@extends('layouts.app')
@section('content')

<div class="flex flex-col xl:flex-row items-start justify-center mb-10 w-full">
	<div class="flex flex-col items-center xl:items-start justify-center gap-8 xl:gap-6 p-5 md:px-10 xl:px-14">
		<h2 class="text-center md:text-left text-4xl xl:px-2 font-bold text-gray-900">About Us</h2>

		<div class="flex flex-col xl:flex-row items-center justify-center xl:justify-start">
			<div class="flex flex-col gap-3 xl:gap-6 justify-text tracking-wide xl:w-9/12">
				<div class="font-semibold bg-green-100 p-3 rounded-md text-black-500"><strong>Indian Racing Community</strong> is one of the largest hubs for Indian racing enthusiasts & sim racers. This is the place for all discussions related to motorsports and IRC events. We engage in real life motorsport chatter, memes, and everything in between. You will find one of the most engaging Indian motorsport community to interact with, race with and make friends with.
				</div>
				
				<div class="font-semibold bg-gray-200 p-3 rounded-md text-gray-700">
					<span class="text-green-600">●</span>
					<strong>IRC eSports</strong> is a wholly owned subsidiary of IRC currently hosted on our Discord server. IRC eSports division holds league races on the latest official F1 game (cross-platform) and on Assetto Corsa Competizione, which is open to all Indian players.
				</div>
				
				<div class="font-semibold bg-orange-100 p-3 rounded-md text-gray-700">
					<span class="text-green-600">●</span>
					Major Racing games featured across the community include the Official F1, Assetto Corsa, Assetto Corsa Competizione, etc., each having a space to interact on our Discord server. We have a dedicated space for members on PS and XBOX console platforms to interact with each other and host online races.
				</div>
			</div>

			<div class="flex items-center justify-center h-26 xl:h-4">
				<img class="object-fit" src="https://cdn.dribbble.com/users/2463018/screenshots/5415613/image.png">
			</div>
		</div>

		<div class="flex flex-col items-center xl:items-start justify-center gap-2 xl:gap-1">
			<p class="font-semibold text-lg text-gray-700 xl:px-1">Follow us</p>

			<div class="flex flex-col items-center xl:items-start justify-center gap-3">
				<div class="flex w-11/12">
					<a href="https://discord.gg/ngvX9Mm">
						<img class="rounded-md" src="https://discord.com/api/guilds/{{$irc_guild}}/widget.png?style=banner2">
					</a>
				</div>
			
				<div class="flex flex-row gap-2 text-white">
					<a href="https://www.youtube.com/channel/UC2Li3g3zak9gQ6YtE3YThXw" target="_blank">
						<i style='background:#FF0000' class='fab fa-youtube text-3xl p-2 rounded-md'></i>
					</a>	
					<a href="https://www.instagram.com/indianracingcommunity/" target="_blank">
						<i style='background:#E1306C' class="fab fa-instagram text-3xl mx-2 p-2 rounded-md bg-pink-600"></i>
					</a>
					<a href="https://steamcommunity.com/groups/indianracingcommunity" target="_blank">
						<i style='background:#1f3d7a' class='fab fa-steam text-3xl p-2 rounded-md'></i> 
					</a>		
					<a href="https://twitter.com/racing_indian" target="_blank">
						<i style='background:#1DA1F2' class='fab fa-twitter text-3xl mx-2 p-2 rounded-md bg-blue-500'></i> 
					</a>
					<a href="https://www.facebook.com/indianracingcommunity/" target="_blank">
						<i style='background:#4267B2' class='fab fa-facebook text-3xl p-2 rounded-md bg-blue-800'></i> 
					</a>
					<!-- <a href="https://www.reddit.com/r/IndianRacingCommunity/" target="_blank">
						<i style="background:#ff581a" class="fab fa-reddit text-3xl mx-2 p-2 rounded-md" ></i>
					</a> -->
				</div>
			</div>
		</div>
	</div>
	
	<div class="hidden flex items-center justify-center w-full 2xl:w-1/2">
		<img class="object-cover" src="https://cdn.dribbble.com/users/2463018/screenshots/5415613/image.png">
	</div>
</div>

@endsection
