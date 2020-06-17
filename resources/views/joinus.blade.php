@extends('layouts.welcomeLayout')
<style>
      body {
         min-height: 100vh;
         background-image:url('https://cdn.dribbble.com/users/1189560/screenshots/5795496/alfa-romeo-f1_4x.png?compress=1&resize=800x600');
         background-size: 950px;
         background-repeat:no-repeat;
         background-position:right bottom;
      }
    </style>
@section('body')
<div class="px-32 py-16">
	<h2 class="text-4xl font-bold text-gray-900 mb-4">Join Us</h2>
	<p class="font-semibold text-2xl text-gray-800 mb-2">Before You join</p> 
	<div class="flex">
		<div class="font-semibold bg-red-100 rounded-md p-2 my-1 text-red-800">This community is only for Indians across the world.</div>
	</div>

	<div class="flex">
		<div class="font-semibold bg-red-100 rounded-md p-2 my-1 text-red-800">If you are found lying about your identity, you will be banned from the community.</div>
	</div>
	<div class="my-8">
		<p class="font-semibold mb-2 text-gray-700">You may join our discord server through the link below</p>
		<a href="https://discord.gg/dWG2bX6">
			<i style="font-size: 40px;" class='fab fa-discord text-indigo-500'></i>
		</a>	
	</div>
</div>

@endsection
