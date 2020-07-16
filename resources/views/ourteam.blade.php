@extends('layouts.welcomeLayout')

@section('body')

<div class="flex items-center w-full">
	<div class="inline-block text-center w-full">
		<div class="bg-gray-800 p-10 text-white justify-center font-bold rounded-md flex items-center flex-shrink-0">
			<img src="/img/IRC_logo/logo_square.png" height="55" width="55"> <span class="py-3 pl-2 text-2xl">Indian Racing Community Team</span> 
		</div>
		<h3 class="text-2xl pt-4 bg-gray-100 rounded font-bold text-black"><i class="fas fa-seedling"></i> FOUNDERS</h3>
		<div class="flex bg-gray-100 justify-center">
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(2,$fieldsTeams) ) href="/user/profile/view/2" @endif><img src="@if( array_key_exists(2,$fieldsTeams) && $fieldsTeams[2]['avatar'] != null) {{$fieldsTeams[2]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-800">Adil "MaranelloBaby" Chinoy</div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(101,$fieldsTeams)) href="/user/profile/view/101" @endif><img src="@if( array_key_exists(101,$fieldsTeams) && $fieldsTeams[101]['avatar'] != null) {{$fieldsTeams[101]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-800">Aditya "GryphuS" Jain</div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(27,$fieldsTeams)) href="/user/profile/view/27" @endif><img src="@if( array_key_exists(27,$fieldsTeams) && $fieldsTeams['27']['avatar'] != null) {{$fieldsTeams[27]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-800">Subham "The-Real-SD" Das</div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(16,$fieldsTeams)) href="/user/profile/view/16" @endif><img src="@if( array_key_exists(16,$fieldsTeams) && $fieldsTeams[16]['avatar'] != null) {{$fieldsTeams[16]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-800">Kapil "kapilace6" Bharath</div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-green-300 rounded font-bold  text-black"><i class='fas fa-crown text-yellow-600 p-3'></i>Discord Admins</h3>
		<div class="flex bg-green-300 justify-center">
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(2,$fieldsTeams) ) href="/user/profile/view/2" @endif><img src="@if( array_key_exists(2,$fieldsTeams) && $fieldsTeams[2]['avatar'] != null) {{$fieldsTeams[2]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Adil "MaranelloBaby" Chinoy</div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(101,$fieldsTeams)) href="/user/profile/view/101" @endif><img src="@if( array_key_exists(101,$fieldsTeams) && $fieldsTeams[101]['avatar'] != null) {{$fieldsTeams[101]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Aditya "GryphuS" Jain</div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(27,$fieldsTeams)) href="/user/profile/view/27" @endif><img src="@if( array_key_exists(27,$fieldsTeams) && $fieldsTeams['27']['avatar'] != null) {{$fieldsTeams[27]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Subham "The-Real-SD" Das</div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(95,$fieldsTeams)) href="/user/profile/view/95" @endif><img src="@if( array_key_exists(95,$fieldsTeams) && $fieldsTeams[95]['avatar'] != null) {{$fieldsTeams[95]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Kalpesh "theKC66" Choudhary</div>
			</div>
		</div>

		<h3 class="text-2xl pt-4 flex items-center rounded font-bold bg-purple-400 text-black"><i class="fa fa-gavel p-3"></i>Stewards</h3>
		<div class="flex bg-purple-400 justify-center">
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(101,$fieldsTeams)) href="/user/profile/view/101" @endif><img src="@if( array_key_exists(101,$fieldsTeams) && $fieldsTeams[101]['avatar'] != null) {{$fieldsTeams[101]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Head of Stewards</br><span class="font-semibold text-gray-900"> GryphuS</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(2,$fieldsTeams) ) href="/user/profile/view/2" @endif><img src="@if( array_key_exists(2,$fieldsTeams) && $fieldsTeams[2]['avatar'] != null) {{$fieldsTeams[2]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Steward</br><span class="font-semibold text-gray-900"> MaranelloBaby</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(27,$fieldsTeams)) href="/user/profile/view/27" @endif><img src="@if( array_key_exists(27,$fieldsTeams) && $fieldsTeams['27']['avatar'] != null) {{$fieldsTeams[27]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Steward</br><span class="font-semibold text-gray-900"> The-Real-SD</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(16,$fieldsTeams)) href="/user/profile/view/16" @endif><img src="@if( array_key_exists(16,$fieldsTeams) && $fieldsTeams[16]['avatar'] != null) {{$fieldsTeams[16]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Steward</br><span class="font-semibold text-gray-900"> kapilace6</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(17,$fieldsTeams)) href="/user/profile/view/17" @endif><img src="@if( array_key_exists(17,$fieldsTeams) && $fieldsTeams[17]['avatar'] != null) {{$fieldsTeams[17]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Steward</br><span class="font-semibold text-gray-900"> BlackSheep</span></div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-pink-300 rounded font-bold  text-black"><i class="fa fa-flag-checkered p-3" aria-hidden="true"></i>eSports Team</h3>
		<div class="flex bg-pink-300 justify-center">
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(95,$fieldsTeams)) href="/user/profile/view/95" @endif><img src="@if( array_key_exists(95,$fieldsTeams) && $fieldsTeams[95]['avatar'] != null) {{$fieldsTeams[95]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Head of eSports</br><span class="font-semibold text-gray-900"> theKC66</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(12,$fieldsTeams)) href="/user/profile/view/12" @endif><img src="@if( array_key_exists(12,$fieldsTeams) && $fieldsTeams[12]['avatar'] != null) {{$fieldsTeams[12]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Tier-1 Coordinator</br><span class="font-semibold text-gray-900"> 5zan</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(7,$fieldsTeams)) href="/user/profile/view/7" @endif><img src="@if( array_key_exists(7,$fieldsTeams) && $fieldsTeams[7]['avatar'] != null) {{$fieldsTeams[7]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Tier-1 Coordinator</br><span class="font-semibold text-gray-900"> Streeter</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(34,$fieldsTeams)) href="/user/profile/view/34" @endif><img src="@if( array_key_exists(34,$fieldsTeams) && $fieldsTeams[34]['avatar'] != null) {{$fieldsTeams[34]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Tier-1 Coordinator</br><span class="font-semibold text-gray-900"> notsomonsoon</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(1,$fieldsTeams)) href="/user/profile/view/1" @endif><img src="@if( array_key_exists(1,$fieldsTeams) && $fieldsTeams[1]['avatar'] != null) {{$fieldsTeams[1]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Tier-2 Coordinator</br><span class="font-semibold text-gray-900"> Freeman</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(32,$fieldsTeams)) href="/user/profile/view/32" @endif><img src="@if( array_key_exists(32,$fieldsTeams) && $fieldsTeams[32]['avatar'] != null) {{$fieldsTeams[32]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Tier-2 Coordinator</br><span class="font-semibold text-gray-900"> no more pp</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(45,$fieldsTeams)) href="/user/profile/view/45" @endif><img src="@if( array_key_exists(45,$fieldsTeams) && $fieldsTeams[45]['avatar'] != null) {{$fieldsTeams[45]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Tier-2 Coordinator</br><span class="font-semibold text-gray-900"> IRC_Tanish</span></div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-teal-300 rounded font-bold  text-black"><i class="fas fa-tools p-3" aria-hidden="true"></i>Website Team</h3>
		<div class="flex bg-teal-300 justify-center">
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(16,$fieldsTeams)) href="/user/profile/view/16" @endif><img src="@if( array_key_exists(16,$fieldsTeams) && $fieldsTeams[16]['avatar'] != null) {{$fieldsTeams[16]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Head of Website Dev</br><span class="font-semibold text-gray-900"> kapilace6</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(1,$fieldsTeams)) href="/user/profile/view/1" @endif><img src="@if( array_key_exists(1,$fieldsTeams) && $fieldsTeams[1]['avatar'] != null) {{$fieldsTeams[1]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Team Member</br><span class="font-semibold text-gray-900"> Freeman</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(32,$fieldsTeams)) href="/user/profile/view/32" @endif><img src="@if( array_key_exists(32,$fieldsTeams) && $fieldsTeams[32]['avatar'] != null) {{$fieldsTeams[32]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Team Member</br><span class="font-semibold text-gray-900"> no more pp</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(64,$fieldsTeams)) href="/user/profile/view/64" @endif><img src="@if( array_key_exists(64,$fieldsTeams) && $fieldsTeams[64]['avatar'] != null) {{$fieldsTeams[64]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Team Member</br><span class="font-semibold text-gray-900"> dawn29</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(95,$fieldsTeams)) href="/user/profile/view/95" @endif><img src="@if( array_key_exists(95,$fieldsTeams) && $fieldsTeams[95]['avatar'] != null) {{$fieldsTeams[95]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Team Member</br><span class="font-semibold text-gray-900"> theKC66</span></div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-orange-400 rounded font-bold  text-black"><i class="fab fa-youtube p-3"></i>YouTube & Editorials</h3>
		<div class="flex bg-orange-400 justify-center">
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(27,$fieldsTeams)) href="/user/profile/view/27" @endif><img src="@if( array_key_exists(27,$fieldsTeams) && $fieldsTeams['27']['avatar'] != null) {{$fieldsTeams[27]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Head of YouTube</br><span class="font-semibold text-gray-900"> The-Real-SD</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(21,$fieldsTeams)) href="/user/profile/view/21" @endif><img src="@if( array_key_exists(21,$fieldsTeams) && $fieldsTeams['21']['avatar'] != null) {{$fieldsTeams[21]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Editor-in-Chief</br><span class="font-semibold text-gray-900"> NinjaZero</span></div>
			</div>	
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(72,$fieldsTeams)) href="/user/profile/view/72" @endif><img src="@if( array_key_exists(72,$fieldsTeams) && $fieldsTeams['72']['avatar'] != null) {{$fieldsTeams[72]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Member of Editorial</br><span class="font-semibold text-gray-900"> thirdworldprophet</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(33,$fieldsTeams)) href="/user/profile/view/33" @endif><img src="@if( array_key_exists(33,$fieldsTeams) && $fieldsTeams['33']['avatar'] != null) {{$fieldsTeams[33]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Member of Editorial</br><span class="font-semibold text-gray-900"> rbferalo14</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(95,$fieldsTeams)) href="/user/profile/view/95" @endif><img src="@if( array_key_exists(95,$fieldsTeams) && $fieldsTeams[95]['avatar'] != null) {{$fieldsTeams[95]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Member of Editorial</br><span class="font-semibold text-gray-900"> theKC66</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(13,$fieldsTeams)) href="/user/profile/view/13" @endif><img src="@if( array_key_exists(13,$fieldsTeams) && $fieldsTeams[13]['avatar'] != null) {{$fieldsTeams[13]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Member of Editorial</br><span class="font-semibold text-gray-900"> WashingPowderNirma</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(110,$fieldsTeams)) href="/user/profile/view/110" @endif><img src="@if( array_key_exists(110,$fieldsTeams) && $fieldsTeams[110]['avatar'] != null) {{$fieldsTeams[110]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Member of Editorial</br><span class="font-semibold text-gray-900"> Sai_Tarun</span></div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-purple-300 rounded font-bold  text-black"><i class="fas fa-video p-3" aria-hidden="true"></i>Stream & Telemetry</h3>
		<div class="flex bg-purple-300 justify-center">
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(32,$fieldsTeams)) href="/user/profile/view/32" @endif><img src="@if( array_key_exists(32,$fieldsTeams) && $fieldsTeams[32]['avatar'] != null) {{$fieldsTeams[32]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Head of Stream</br><span class="font-semibold text-gray-900"> no more pp</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(34,$fieldsTeams)) href="/user/profile/view/34" @endif><img src="@if( array_key_exists(34,$fieldsTeams) && $fieldsTeams[34]['avatar'] != null) {{$fieldsTeams[34]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Head of Telemetry</br><span class="font-semibold text-gray-900"> notsomahsoom</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(33,$fieldsTeams)) href="/user/profile/view/33" @endif><img src="@if( array_key_exists(33,$fieldsTeams) && $fieldsTeams['33']['avatar'] != null) {{$fieldsTeams[33]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Streaming Member</br><span class="font-semibold text-gray-900"> rbferalo14</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(16,$fieldsTeams)) href="/user/profile/view/16" @endif><img src="@if( array_key_exists(16,$fieldsTeams) && $fieldsTeams[16]['avatar'] != null) {{$fieldsTeams[16]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Streaming Member</br><span class="font-semibold text-gray-900"> kapilace6</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(21,$fieldsTeams)) href="/user/profile/view/21" @endif><img src="@if( array_key_exists(21,$fieldsTeams) && $fieldsTeams[21]['avatar'] != null) {{$fieldsTeams[21]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Commentator</br><span class="font-semibold text-gray-900"> NinjaZero</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(17,$fieldsTeams)) href="/user/profile/view/17" @endif><img src="@if( array_key_exists(17,$fieldsTeams) && $fieldsTeams[17]['avatar'] != null) {{$fieldsTeams[17]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Commentator</br><span class="font-semibold text-gray-900"> Blacksheep</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(100,$fieldsTeams)) href="/user/profile/view/100" @endif><img src="@if( array_key_exists(100,$fieldsTeams) && $fieldsTeams[100]['avatar'] != null) {{$fieldsTeams[100]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Commentator</br><span class="font-semibold text-gray-900"> RusttyNish</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(72,$fieldsTeams)) href="/user/profile/view/72" @endif><img src="@if( array_key_exists(72,$fieldsTeams) && $fieldsTeams[72]['avatar'] != null) {{$fieldsTeams[72]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Commentator</br><span class="font-semibold text-gray-900"> thirdworldprophet</span></div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-yellow-300 rounded font-bold  text-black"><i class="fas fa-hashtag p-3"></i>Social Media</h3>
		<div class="flex bg-yellow-300 justify-center">
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(101,$fieldsTeams)) href="/user/profile/view/101" @endif><img src="@if( array_key_exists(101,$fieldsTeams) && $fieldsTeams[101]['avatar'] != null) {{$fieldsTeams[101]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Instagram & Steam</br><span class="font-semibold text-gray-900"> GryphuS</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(2,$fieldsTeams)) href="/user/profile/view/2" @endif><img src="@if( array_key_exists(2,$fieldsTeams) && $fieldsTeams[2]['avatar'] != null) {{$fieldsTeams[2]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Twitter</br><span class="font-semibold text-gray-900"> MaranelloBaby</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(27,$fieldsTeams)) href="/user/profile/view/27" @endif><img src="@if( array_key_exists(27,$fieldsTeams) && $fieldsTeams[27]['avatar'] != null) {{$fieldsTeams[27]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Youtube</br><span class="font-semibold text-gray-900"> The-Real-SD</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(9,$fieldsTeams)) href="/user/profile/view/9" @endif><img src="@if( array_key_exists(9,$fieldsTeams) && $fieldsTeams[9]['avatar'] != null) {{$fieldsTeams[9]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Reddit</br><span class="font-semibold text-gray-900"> Oxygen</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(111,$fieldsTeams)) href="/user/profile/view/111" @endif><img src="@if( array_key_exists(111,$fieldsTeams) && $fieldsTeams[111]['avatar'] != null) {{$fieldsTeams[111]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-600">Reddit</br><span class="font-semibold text-gray-900"> Modo</span></div>
			</div>
		</div>
		<h3 class="text-2xl pt-4  bg-blue-300 rounded font-bold  text-black"><i class="fas fa-podcast p-3"></i>Podcast</h3>
		<div class="flex bg-blue-300 justify-center">
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(2,$fieldsTeams)) href="/user/profile/view/2" @endif><img src="@if( array_key_exists(2,$fieldsTeams) && $fieldsTeams[2]['avatar'] != null) {{$fieldsTeams[2]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Head of Podcast</br><span class="font-semibold text-gray-900"> MaranelloBaby</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(31,$fieldsTeams)) href="/user/profile/view/31" @endif><img src="@if( array_key_exists(31,$fieldsTeams) && $fieldsTeams[31]['avatar'] != null) {{$fieldsTeams[31]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Podcast Member</br><span class="font-semibold text-gray-900"> Baba.G</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(17,$fieldsTeams)) href="/user/profile/view/17" @endif><img src="@if( array_key_exists(17,$fieldsTeams) && $fieldsTeams[17]['avatar'] != null) {{$fieldsTeams[17]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
				</div>
				<div class="font-bold mb-2 text-gray-700">Podcast Member</br><span class="font-semibold text-gray-900"> Blacksheep</span></div>
			</div>
			<div class="block align-center text-center p-4" style="text-align: -webkit-center;">
				<div class="flex justify-center rounded overflow-hidden text-center w-full py-5">
					<a @if(array_key_exists(16,$fieldsTeams)) href="/user/profile/view/16" @endif><img src="@if( array_key_exists(16,$fieldsTeams) && $fieldsTeams[16]['avatar'] != null) {{$fieldsTeams[16]['avatar']}} @else {{asset('img/avatars/blankpic.png')}} @endif" class="rounded-full border-green-300 border-2 w-20 object-contain"></a>
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
