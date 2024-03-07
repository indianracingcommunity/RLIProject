@extends('layouts.app')
@section('body')

<div class="flex flex-col xl:flex-row items-center justify-center mb-10 w-full">
	<div class="flex flex-col items-center xl:items-start justify-center gap-8 xl:gap-6 p-5 md:px-10 xl:px-14 xl:w-full">
		<h2 class="text-center md:text-left text-4xl xl:px-2 font-bold text-gray-900">Join Us</h2>

		<div class="font-semibold bg-blue-100 p-3 rounded-md text-green-800 xl:text-xl">
			<p>Membership in IRC requires you to be <u>an Indian or of Indian origin</u>, irrespective of whether you reside in India.</p>
		</div>

		<div class="flex flex-col items-center justify-center gap-3">
			<p class="p-3 xl:text-xl bg-gray-100 rounded-md font-bold text-gray-800">You may proceed by joining our discord server below.</p>

			<div class="flex">
				<a href="https://discord.gg/ngvX9Mm">
					<img class="rounded-md" src="https://discord.com/api/guilds/{{$irc_guild}}/widget.png?style=banner4">
				</a>
			</div>	
			
			<p class="p-3 xl:px-0 xl:py-2 text-gray-600">
				<strong>Already in our discord server? <a class="capitalize underline text-purple-700" href="{{route('login.discord')}}">login</a> to complete your profile.</strong>
			</p>
		</div>
	</div>
	
	<div class="flex items-center justify-center w-full 2xl:w-1/2">
		<img class="object-fill object-right-bottom" src='https://cdn.dribbble.com/users/2463018/screenshots/13930887/media/29d55ec7c88c76ee8291fcae19d7149a.jpg?compress=1&resize=800x300'>
	</div>
</div>

@endsection
