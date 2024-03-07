@extends('layouts.app')
@section('body')

<div class="flex flex-col xl:flex-row items-center justify-center mb-10 w-full">
	<div class="flex flex-col items-center xl:items-start justify-center gap-8 p-6 md:px-10 xl:px-14 xl:w-2/3">
		<h2 class="hidden md:flex text-center md:text-left text-4xl xl:px-2 font-bold text-gray-900">Frequently Asked Questions</h2>
		<h2 class="md:hidden text-center md:text-left text-4xl xl:px-2 font-bold text-gray-900">FAQs</h2>

		<div class="flex flex-col gap-8">
			<div class="flex flex-col">
				<p class="font-semibold bg-purple-200 text-black py-2 px-3 rounded-t-md">
					What are the prerequisites to join?
				</p>
	
				<p class="font-semibold bg-gray-200 rounded-b-md py-2 px-3 text-gray-700">
					There is only one criterion to join us and that is you need to be an Indian racing enthusiast. That's it.
				</p>
			</div>

			<div class="flex flex-col">
				<p class="font-semibold bg-purple-200 text-black py-2 px-3 rounded-t-md">
					How do I join IRC?
				</p>
	
				<p class="font-semibold bg-gray-200 rounded-b-md py-2 px-3 text-gray-700">
					You can head to the our <a href="{{route('joinus')}}" target="_blank" class="underline text-purple-700">Join Us</a> page to become a permanent member. Joining our discord server is <span class="uppercase text-black">mandatory</span> to be an IRC member.
				</p>
			</div>

			<div class="flex flex-col">
				<p class="font-semibold bg-purple-200 text-black py-2 px-3 rounded-t-md">
					Do I need to be a gamer to join?
				</p>
	
				<p class="font-semibold bg-gray-200 rounded-b-md py-2 px-3 text-gray-700">
					No. Any Indian avid motorsports fan is more than welcome to join us. We also engage in real life motorsport chatter, memes, and everything in between.
				</p>
			</div>

			<div class="flex flex-col">
				<p class="font-semibold bg-purple-200 text-black py-2 px-3 rounded-t-md">
					Why does the website ask for a discord and steam login?
				</p>
	
				<div class="flex flex-col gap-3 font-semibold bg-gray-200 rounded-b-md py-2 px-3 text-gray-700">
					<p>The IRC ecosystem contains a deep integration with steam and discord to identify drivers and provide a seamless experience with our functionalities.</p>

					<ul class="flex flex-col gap-2 list-disc px-4">
						<li>Steam login gives us your unique Steam64 ID.</li>
						<li>Discord login authorises us to manage your roles on the IRC discord server.</li>
						<li>Your unique identifiers, which include your Email, are <span style="color: black;" class="uppercase">not public</span> to the community.</li>
					</ul>
				</div>
			</div>

			<div class="flex flex-col">
				<p class="font-semibold bg-purple-200 text-black py-2 px-3 rounded-t-md">
					Are there any cross-platform leagues?
				</p>
	
				<p class="font-semibold bg-gray-200 rounded-b-md py-2 px-3 text-gray-700">
					IRC does run an F1 league on the latest F1 game which does support cross-platform. Additionally we have a dedicated space for members on PS and XBOX console platforms to interact with each other and host online races.
				</p>
			</div>
		</div>
	</div>
	<div class="flex items-center justify-center w-2/3 xl:w-1/2 2xl:w-1/2">
		<img class="object-contain" src='https://cdn.dribbble.com/users/1189560/screenshots/5795496/alfa-romeo-f1_4x.png?compress=1&resize=800x600'>
	</div>
</div>
@endsection
