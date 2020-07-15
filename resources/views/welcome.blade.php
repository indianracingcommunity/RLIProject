@extends('layouts.welcomeLayout')

@section('body')
<div class="sm:block md:flex lg:flex xl:flex w-full">
    <div class="block sm:p-5 md:p-10 lg:p-32 xl:p-32 sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2">
        <div class="block text-5xl font-bold text-gray-900">
            Welcome to IRC!
        </div>
        <div class="block text-3xl font-semibold text-gray-700">
            A place for every Indian Racing Enthusiast.
        </div>
        <div class="flex">
            <div class="mt-16 text-2xl font-semibold px-4 py-2 bg-indigo-600 shadow-lg text-white rounded-md cursor">
                <a href="/joinus">Join us</a>
            </div>
        </div>
        <div class="mt-10">
            <div class="text-xl font-semibold text-gray-600">
                Follow Us
            </div>
            <div class="flex">
                <div class="text-4xl text-red-600">
                    <a href="https://www.youtube.com/channel/UC2Li3g3zak9gQ6YtE3YThXw" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
                <div class="text-4xl text-blue-600 ml-4">
                    <a href="https://twitter.com/racing_indian" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
                <div class="text-4xl text-pink-800 ml-4">
                    <a href="https://www.instagram.com/indianracingcommunity/" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
                <div class="text-4xl text-blue-800 ml-4">
                    <a href="https://steamcommunity.com/groups/indianracingcommunity" target="_blank">
                        <i class="fab fa-steam"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="sm:flex md:inline-flex lg:inline-flex xl:inline-flex items-center justify-center sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2">
		<img class="object-contain" src='https://cdn.dribbble.com/users/1568450/screenshots/7880617/media/2b89eb9a9496fba5dc1f7bf7d1418855.png'>
	</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@widgetbot/crate@3" async defer>
    new Crate({
      server: '641545840619683841',
      channel: '645515279593373717'
    })
  </script>
@endsection
