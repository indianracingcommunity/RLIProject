@extends('layouts.welcomeLayout')


<style>
	body {
		min-height: 100vh;
		background-image:url('https://cdn.dribbble.com/users/2463018/screenshots/5415613/image.png');
		background-size: 800px;
		background-repeat:no-repeat;
		background-position:right;
	}
</style>
@section('body')

<div class="px-32 py-16 w-3/5">
	<h2 class="text-4xl font-bold text-gray-900 mb-4">About Us</h2>
	<div class="flex">
		<div class="font-semibold bg-gray-100 rounded-md p-2 my-1 text-gray-800">If you're an Indian and a motorsport enthusiast, you are in the right place. Join us on Discord where we have 200+ members now! We run a F1 2019 League currently which has already completed 4 Seasons, as well as have members who are into Assetto Corsa, iRacing and other racing games. Cheers!</div>
	</div>
	<div class="my-8">
		<p class="font-semibold mb-2 text-gray-700">Get in touch with us on:</p>
		<a href="https://steamcommunity.com/groups/indianracingcommunity" target="_blank">
			<i style='color:#1f3d7a;' class='fab fa-steam text-3xl '></i> 
		</a>		
		<a href="https://twitter.com/racing_indian" target="_blank">
			<i class='fab fa-twitter text-blue-500 text-3xl mx-2'></i> 
		</a>
		<a href="https://www.youtube.com/channel/UC2Li3g3zak9gQ6YtE3YThXw" target="_blank">
			<i style='color:red;' class='fab fa-youtube text-3xl'></i>
		</a>	
		 <a href="https://www.instagram.com/indianracingcommunity/" target="_blank">
            <i class="fab fa-instagram mx-2 text-pink-800 text-3xl"></i>
        </a>
	</div>
	<a href="https://discord.gg/dWG2bX6">
		<img class="rounded mt-3" style="position: absolute;" src="https://discord.com/api/guilds/533143665921622017/widget.png?style=banner1">
	</a>
</div>


@endsection
