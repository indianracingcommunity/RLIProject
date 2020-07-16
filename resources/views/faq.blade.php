@extends('layouts.welcomeLayout')

@section('body')
<div class="sm:block md:flex lg:flex xl:flex items-center">
	<div class="sm:block md:inline-block lg:inline-block xl:inline-block p-5 sm:px-5 md:pl-10 lg:pl-10 xl:pl-10 sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2 pt-16">
		<h2 class="text-4xl font-bold text-gray-900 mb-10">Frequently Asked Questions</h2>
		<p class="font-semibold text-2xl text-gray-800 mb-2"><i style="font-size: 18px;" class="fa fa-arrow-right"></i> What are the pre-requisites to join?</p> 
		<div class="flex">
			<div class="font-semibold bg-gray-100 rounded-md p-2 my-1 text-gray-800">There is only one criterion to join us: You need to be an Indian racing enthusiast. That's it.</div>
		</div>
		<p class="font-semibold text-2xl mt-8 text-gray-800 mb-2"><i style="font-size: 18px;" class="fa fa-arrow-right"></i> How do I join IRC?</p> 
		<div class="flex">
			<div class="font-semibold bg-gray-100 rounded-md p-2 my-1 text-gray-800">You can head to the our <a href="/joinus" target="_blank" class="hover:underline text-red-800">Join Us</a> Page to become a permanent member.</br>Joining our Discord Server is <span style="color: red;">mandatory</span> to be an IRC member.</div>
		</div>
		<p class="font-semibold text-2xl mt-8 text-gray-800 mb-2"><i style="font-size: 18px;" class="fa fa-arrow-right"></i> Do I need to be a gamer to join?</p> 
		<div class="flex">
			<div class="font-semibold bg-gray-100 rounded-md p-2 my-1 text-gray-800">No. Any avid motorsports fan are more than welcome to join us. </br>We also engage in real life motorsport chatter, memes, and everything in between.</div>
		</div>
		<p class="font-semibold text-2xl mt-8 text-gray-800 mb-2"><i style="font-size: 18px;" class="fa fa-arrow-right"></i> Do you have an Xbox or PS4 leagues right now?</p> 
		<div class="flex">
			<div class="font-semibold bg-gray-100 rounded-md p-2 my-1 text-gray-800">Not currently. However we have a dedicated space for members on PS4 and XBOX console platforms to interact with each other and host online races.</br>The console community is still growing and with enough engagement we can start a league in the future.</div>
		</div>
		<p class="font-semibold text-2xl mt-8 text-gray-800 mb-2"><i style="font-size: 18px;" class="fa fa-arrow-right"></i> How difficult is the league on the latest official F1 PC game?</p> 
		<div class="flex">
			<div class="font-semibold bg-gray-100 rounded-md p-2 my-1 text-gray-800">This community is open for all people of any skill level to join. This community lets you improve your skills by giving valuable experience racing side-by-side with our members. You can start as a lower tier driver, gain some experience and skills throughout the season, and eventually compete in Tier-1, if your performance is promising.</div>
		</div>
	</div>
	<div class="sm:flex md:inline-flex lg:inline-flex xl:inline-flex items-center justify-center sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2">
		<img class="object-contain" src='https://cdn.dribbble.com/users/1189560/screenshots/5795496/alfa-romeo-f1_4x.png?compress=1&resize=800x600'>
	</div>
</div>
@endsection
