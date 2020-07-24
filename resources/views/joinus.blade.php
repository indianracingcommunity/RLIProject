@extends('layouts.welcomeLayout')
<!-- <style>
      body {
         min-height: 100vh;
         background-image:url('https://cdn.dribbble.com/users/1189560/screenshots/5795496/alfa-romeo-f1_4x.png?compress=1&resize=800x600');
         background-size: 950px;
         background-repeat:no-repeat;
         background-position:right bottom;
      }
    </style> -->
@section('body')
<div class="sm:block md:flex lg:flex xl:flex items-center w-full">
	<div class="sm:block md:inline-block lg:inline-block xl:inline-block p-5 sm:px-5 md:pl-20 lg:pl-20 xl:pl-20 pt-16 sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2">
		<h2 class="text-4xl font-bold text-gray-900 mb-4">Join Us</h2>
		<p class="font-semibold text-3xl text-gray-800 mb-2">Before You Join</p> 
		<div class="flex">
			<div class="font-semibold text-xl bg-blue-100 rounded-md p-2 my-1 text-green-800"><span class="text-green-600 ml-2 mr-2">●</span>Permanent Membership of IRC requires you to be an Indian.</div>
		</div>
		<div class="flex">
			<div class="font-semibold bg-blue-100 text-xl rounded-md p-2 my-1 text-green-800"><span class="text-green-600 ml-2 mr-2">●</span>Indians residing overseas are also eligible for Permanent Membership.</div>
		</div>
		<div class="my-8">
			<p class="font-semibold mb-2 rounded p-3 text-xl bg-gray-100 text-gray-700"><strong>You may now proceed by joining our Discord Server below</strong></p>
			<div class="block rounded mt-3">
			<a href="https://discord.gg/dWG2bX6">
				<img class="" src="https://discord.com/api/guilds/{{$irc_guild}}/widget.png?style=banner1">
			</a>
			</div>	
		</div>
	</div>
	<div class="sm:flex md:inline-flex lg:inline-flex xl:inline-flex items-center justify-center w-full sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2 pr-10">
		<img class="object-fill object-right-bottom" src='https://cdn.dribbble.com/users/1189560/screenshots/5795496/alfa-romeo-f1_4x.png?compress=1&resize=800x600'>
	</div>
</div>

@endsection
