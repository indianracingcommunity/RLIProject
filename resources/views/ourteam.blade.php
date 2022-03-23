@extends('layouts.app')
@section('body')
@component('layouts.slickCarousal')@endcomponent

<div class="mx-4 my-10 md:mx-16 lg:mx-16">
	<div class="flex font-extrabold text-4xl mb-4">
		Meet the Team!
	</div>
	<div class="grid grid-cols-2 mb-8 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-7" id="role_tab">
        @foreach($data as $roleData)
            <button class="items-center justify-center mr-4 my-4 px-4 flex py-2 bg-purple-600 text-white text-lg rounded-full font-semibold shadow-md cursor-pointer hover:bg-purple-800 hover:text-white hover:shadow-none @if($loop->first) activeBtn @endif buttonAll btn_{{$roleData['role_id']}}" onclick="displayThis('{{$roleData['role_id']}}')">
                <span class="mx-2">{{$roleData['role_name']}}</span>
            </button>
        @endforeach
    </div>

    <div class="w-full grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" id="team_container">
        @foreach($data as $indData)
            @foreach($indData['users'] as $insideUsers)
            <div style='display:none;' class="role_{{$indData['role_id']}} userPills flex items-center shadow-xl shadow-gray-800 border-2 border-gray-200 rounded-full" style="border-color:#{{$indData['role_color']}}">
                <img src="{{$insideUsers['avatar']}}" onerror="this.onerror=null;this.src='https://cdn.discordapp.com/embed/avatars/3.png';" class="object-cover w-24 h-24 m-4 rounded-full shadow"/>
                <div class="m-4">
                    <p class="text-lg font-bold text-gray-800">{{$insideUsers['name']}}</p>
                    <p class="text-sm text-gray-600">{{$indData['role_name']}}</p>
                </div>
            </div>
            @endforeach
        @endforeach
    </div>
</div>

<script type="text/javascript">
    var data = <?php echo json_encode($data); ?>;
    // console.log(data);
    function displayThis(roleId){
        $('.userPills').hide();
        $(`.role_${roleId}`).show();
        $(`.buttonAll`).removeClass('activeBtn');
        $(`.buttonAll`).removeClass('bg-gray-800 hover:bg-gray-900');
        $(`.buttonAll`).addClass('bg-purple-600 hover:bg-purple-800');
        $(`.btn_${roleId}`).removeClass('activeBtn bg-purple-600 hover:bg-purple-800');
        $(`.btn_${roleId}`).addClass('activeBtn bg-gray-800 hover:bg-gray-900');
    }
    $(document).ready(function () {
        $('.userPills').hide();
        $('.activeBtn').trigger('click');
    });
</script>

@endsection
