@extends('layouts.app')
@section('body')
@component('layouts.slickCarousal')@endcomponent

<style>
    .slick-slider{
        display: flex !important;
    }
</style>
<div class="mx-4 my-10 md:mx-16 lg:mx-16">
	<div class="font-extrabold md:text-left text-center text-4xl mb-4">
		Meet the Team! <i class='loaderCircle fas fa-circle-notch'></i>
	</div>
    <div class="font-extrabold text-center text-4xl mb-4 md:hidden">
        <div id="roleSelectDiv">
            <div class="font-bold text-base mt-4 tracking-wide">Select a Role</div>
            <div class="w-2/4 item-center m-auto">
                <select onchange="displayThis('null','mob')" class="roleSelectOptions border-2 w-full text-base border-gray-800 rounded hover:bg-gray-900 bg-white text-black hover:text-white p-1 my-2">
                    @foreach($data as $roleData)
                        <option @if($loop->first) selected @endif value="{{$roleData['role_id']}}">{{$roleData['role_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
	</div>
	<div class="flex items-center hidden md:block" style='display:none;' id="role_tab">
        @foreach($data as $roleData)
        <div>
            <button class="items-center justify-center mr-4 my-4 px-4 flex py-2 bg-purple-600 text-white text-lg rounded-full font-semibold shadow-md cursor-pointer hover:bg-purple-800 hover:text-white hover:shadow-none @if($loop->first) activeBtn @endif buttonAll btn_{{$roleData['role_id']}}" onclick="displayThis('{{$roleData['role_id']}}','desk')">
                <span class="mx-2">{{$roleData['role_name']}}</span>
            </button>
        </div>
        @endforeach 
    </div>
    <hr>
    <div class="pt-4 w-full grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" style='display:none;' id="team_container">
        @foreach($data as $indData)
            @foreach($indData['users'] as $insideUsers)
            <div class="role_{{$indData['role_id']}} userPills flex items-center shadow-xl shadow-gray-800 border-2 border-gray-200 rounded-full" style="border-color:#{{$indData['role_color']}}">
                <img src="{{$insideUsers['avatar']}}" onerror="this.onerror=null;this.src='https://cdn.discordapp.com/embed/avatars/3.png';" class="object-cover w-24 h-24 m-4 rounded-full shadow"/>
                <div class="m-4">
                    <p class="text-lg font-bold text-gray-800">{{$insideUsers['name']}}</p>
                    @php
                        $theRole = trim($indData['role_name']);
                        $roleIs = str_ends_with($theRole, 's') ? substr($theRole,0,-1) : $theRole;
                        $roleIs = str_contains($theRole,'Team') ? str_replace('Team','Team Member',$theRole) : $roleIs;
                    @endphp
                    <p class="text-sm text-gray-600">{{ $roleIs }}</p>
                </div>
            </div>
            @endforeach
        @endforeach
    </div>
</div>

<script type="text/javascript">
    var data = <?php echo json_encode($data); ?>;
    // console.log(data);
    function displayThis(roleId,dev){
        if(roleId == 'null'){
            roleId = $('.roleSelectOptions').val();
        }
        $('.userPills').hide();
        $(`.role_${roleId}`).fadeIn();
        if(dev == 'desk'){
            $(`.buttonAll`).removeClass('activeBtn');
            $(`.buttonAll`).removeClass('bg-gray-800 hover:bg-gray-900');
            $(`.buttonAll`).addClass('bg-purple-600 hover:bg-purple-800');
            $(`.btn_${roleId}`).removeClass('activeBtn bg-purple-600 hover:bg-purple-800');
            $(`.btn_${roleId}`).addClass('activeBtn bg-gray-800 hover:bg-gray-900');
        }
    }
    $(document).ready(function () {
        $('.userPills').hide();
        $('.activeBtn').trigger('click');
        var width = $(window).width(); 
        if(width > 600){
            $('#role_tab').slick({
                dots: false,
                arrows: true,
                infinite: false,
                prevArrow: "<div class='cursor-pointer px-3'><i class='fas fa-angle-left'></i></div>",
                nextArrow: "<div class='cursor-pointer px-3'><i class='fas fa-angle-right'></i></div>",
                speed: 700,
                slidesToShow: 6,
                centerMode: false,
                variableWidth: true,
                // autoplay: true,
                // autoplaySpeed: 1000,
                edgeFriction: 2,
                swipeToSlide: true,
                pauseOnFocus: true,
            });
            setTimeout(function () {
                $('.loaderCircle').fadeOut();
                $('#role_tab').fadeIn();
                $('#team_container').fadeIn();
            }, 1000);
        }else{
            setTimeout(function () {
                $('.loaderCircle').fadeOut();
                $('#team_container').fadeIn();
            }, 1000);
        }               
    });
</script>

@endsection
