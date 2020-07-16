@extends('layouts.welcomeLayout')

@section('body')
<div class="flex items-center w-full">
	<div class="inline-block text-center w-full">
		<div class="bg-gray-800 p-10 text-white justify-center font-bold rounded-md flex items-center flex-shrink-0">
			<img src="/img/IRC_logo/logo_square.png" height="55" width="55"> <span class="py-3 pl-2 text-2xl">Indian Racing Community Team</span> 
		</div>
		<h3 class="text-2xl pt-4 bg-gray-100 rounded font-bold text-black"><i class="fas fa-seedling"></i> FOUNDERS</h3>
		<div class="flex bg-gray-100 justify-center">
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-800">Adil "MaranelloBaby" Chinoy</div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-800">Aditya "GryphuS" Jain</div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-800">Subham "The-Real-SD" Das</div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-800">Kapil "kapilace6" Bharath</div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-green-300 rounded font-bold  text-black"><i class='fas fa-crown text-yellow-600 p-3'></i>Discord Admins</h3>
		<div class="flex bg-green-300 justify-center">
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Adil "MaranelloBaby" Chinoy</div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Aditya "GryphuS" Jain</div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Subham "The-Real-SD" Das</div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Kalpesh "theKC66" Choudhary</div>
			</div>
		</div>

		<h3 class="text-2xl pt-4  rounded font-bold bg-purple-400 text-black"><i class="fa fa-gavel p-3"></i>Stewards</h3>
		<div class="flex bg-purple-400 justify-center">
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Head of Stewards</br><span class="font-semibold text-gray-900"> GryphuS</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Steward</br><span class="font-semibold text-gray-900"> MaranelloBaby</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Steward</br><span class="font-semibold text-gray-900"> The-Real-SD</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Steward</br><span class="font-semibold text-gray-900"> kapilace6</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Steward</br><span class="font-semibold text-gray-900"> BlackSheep</span></div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-pink-300 rounded font-bold  text-black"><i class="fa fa-flag-checkered p-3" aria-hidden="true"></i>eSports Team</h3>
		<div class="flex bg-pink-300 justify-center">
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Head of eSports</br><span class="font-semibold text-gray-900"> theKC66</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Tier-1 Coordinator</br><span class="font-semibold text-gray-900"> 5zan</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Tier-1 Coordinator</br><span class="font-semibold text-gray-900"> Streeter</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Tier-1 Coordinator</br><span class="font-semibold text-gray-900"> notsomonsoon</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Tier-2 Coordinator</br><span class="font-semibold text-gray-900"> Freeman</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Tier-2 Coordinator</br><span class="font-semibold text-gray-900"> no more pp</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Tier-2 Coordinator</br><span class="font-semibold text-gray-900"> IRC_Tanish</span></div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-teal-300 rounded font-bold  text-black"><i class="fas fa-tools p-3" aria-hidden="true"></i>Website Team</h3>
		<div class="flex bg-teal-300 justify-center">
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Head of Website Dev</br><span class="font-semibold text-gray-900"> kapilace6</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Team Member</br><span class="font-semibold text-gray-900"> Freeman</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Team Member</br><span class="font-semibold text-gray-900"> no more pp</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Team Member</br><span class="font-semibold text-gray-900"> dawn29</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Team Member</br><span class="font-semibold text-gray-900"> theKC66</span></div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-orange-400 rounded font-bold  text-black"><i class="fab fa-youtube p-3"></i>YouTube & Editorials</h3>
		<div class="flex bg-orange-400 justify-center">
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<img src="{{Auth::user()->avatar}}" class="rounded-full border-white border-2" alt="">
				</div>
				<div class="font-bold mb-2 text-gray-700">Head of YouTube</br><span class="font-semibold text-gray-900"> The-Real-SD</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<img src="{{Auth::user()->avatar}}" class="rounded-full border-white border-2" alt="">
				</div>
				<div class="font-bold mb-2 text-gray-700">Editor-in-Chief</br><span class="font-semibold text-gray-900"> NinjaZero</span></div>
			</div>	
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<img src="{{Auth::user()->avatar}}" class="rounded-full border-white border-2" alt="">
				</div>
				<div class="font-bold mb-2 text-gray-700">Member of Editorial</br><span class="font-semibold text-gray-900"> thirdworldprophet</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<img src="{{Auth::user()->avatar}}" class="rounded-full border-white border-2" alt="">
				</div>
				<div class="font-bold mb-2 text-gray-700">Member of Editorial</br><span class="font-semibold text-gray-900"> rbferalo14</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<img src="{{Auth::user()->avatar}}" class="rounded-full border-white border-2" alt="">
				</div>
				<div class="font-bold mb-2 text-gray-700">Member of Editorial</br><span class="font-semibold text-gray-900"> theKC66</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<img src="{{Auth::user()->avatar}}" class="rounded-full border-white border-2" alt="">
				</div>
				<div class="font-bold mb-2 text-gray-700">Member of Editorial</br><span class="font-semibold text-gray-900"> WashingPowderNirma</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<img src="{{Auth::user()->avatar}}" class="rounded-full border-white border-2" alt="">
				</div>
				<div class="font-bold mb-2 text-gray-700">Member of Editorial</br><span class="font-semibold text-gray-900"> Sai_Tarun</span></div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-purple-300 rounded font-bold  text-black"><i class="fas fa-video p-3" aria-hidden="true"></i>Stream & Telemetry</h3>
		<div class="flex bg-purple-300 justify-center">
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Head of Stream</br><span class="font-semibold text-gray-900"> no more pp</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Head of Telemetry</br><span class="font-semibold text-gray-900"> notsomahsoom</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Streaming Member</br><span class="font-semibold text-gray-900"> rbferalo14</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Streaming Member</br><span class="font-semibold text-gray-900"> kapilace6</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Commentator</br><span class="font-semibold text-gray-900"> NinjaZero</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Commentator</br><span class="font-semibold text-gray-900"> Blacksheep</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Commentator</br><span class="font-semibold text-gray-900"> RusttyNish</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Commentator</br><span class="font-semibold text-gray-900"> thirdworldprophet</span></div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-yellow-300 rounded font-bold  text-black"><i class="fas fa-hashtag p-3"></i>Social Media</h3>
		<div class="flex bg-yellow-300 justify-center">
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Instagram & Steam</br><span class="font-semibold text-gray-900"> GryphuS</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Twitter</br><span class="font-semibold text-gray-900"> MaranelloBaby</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Youtube</br><span class="font-semibold text-gray-900"> The-Real-SD</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Reddit</br><span class="font-semibold text-gray-900"> Oxygen</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Reddit</br><span class="font-semibold text-gray-900"> Modo</span></div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-blue-300 rounded font-bold  text-black"><i class="fas fa-podcast p-3"></i>Podcast</h3>
		<div class="flex bg-blue-300 justify-center">
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Head of Podcast</br><span class="font-semibold text-gray-900"> MaranelloBaby</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Podcast Member</br><span class="font-semibold text-gray-900"> Baba.G</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Podcast Member</br><span class="font-semibold text-gray-900"> Blacksheep</span></div>
			</div>
			<div class="text-center p-4" style="text-align: -webkit-center;">
				<div class="rounded m-5 overflow-hidden text-center" style="width: 80px;">
					<a href="/user/profile/view/27"><img src="{{Auth::user()->avatar}}" class="rounded-full border-green-300 border-2" alt=""></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Podcast Member</br><span class="font-semibold text-gray-900"> kapilace6</span></div>
			</div>
		</div>

<hr>
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
	</div>
</div>

@endsection
