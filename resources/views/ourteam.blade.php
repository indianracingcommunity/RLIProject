@extends('layouts.app')

@section('body')

<div class="mx-4 my-10 md:mx-16 lg:mx-16">
	<div class="flex font-extrabold text-4xl mb-4">
		Meet the Team!!!!
	</div>
	<div class="grid grid-cols-2 mb-8 md:grid-cols-4 lg:grid-cols-8" id="role_tab"></div>

    <div class="w-full grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-3" id="team_container">
        <div class="flex items-center shadow-xl shadow-gray-800 border-2 border-gray-200 rounded-full">
            <img
                src="https://sufyan.me/_nuxt/images/sufyan-e995a0.webp"
                class="object-cover w-24 h-24 m-4 rounded-full shadow"
            />
            <div class="m-4">
                <p class="text-lg font-bold text-gray-800">Name here</p>
                <p class="text-sm text-gray-600">CEO &amp; Founder</p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var data = <?php echo json_encode($data); ?>;
    var index = Array(data.length).fill(0) 
    console.log(data);
    displayNewTab(0);
    function displayNewTab(idx) {
        var temp_str = '';
        var unselected = "items-center justify-center mr-4 my-4 px-4 flex py-2 bg-purple-600 text-white text-lg rounded-full font-semibold shadow-md cursor-pointer hover:bg-purple-800 hover:text-white hover:shadow-none ";
        var selected = "items-center justify-center mr-4 my-4 px-4 flex py-2 bg-gray-800 text-white text-lg rounded-full font-semibold shadow-md cursor-pointer hover:bg-gray-900 hover:text-white hover:shadow-none";
        index = Array(data.length).fill(0)
        index[idx] = 1;
        for(var i=0 ; i < data.length ; i++) {
            if (index[i] == 0) {
                if (data[i].icon == null) {
                    temp_str += `<button class="${unselected}" onclick="displayNewTab(${i})">
                                    <span class="mx-2"> ${data[i]["role_name"]}</span>
                                </button>`;
                }
                else {
                    temp_str += `<button class="${unselected}" onclick="displayNewTab(${i})">
                                    <img
                                    src="${data[i].icon}"
                                    class="object-contain w-16 h-8"
                                    />
                                    <span class="mx-2"> ${data[i]["role_name"]}</span>
                                </button>`;
                }
            } else {
                if (data[i].icon == null) {
                    temp_str += `<button class="${selected}" onclick="displayNewTab(${i})">
                                    <span class="mx-2"> ${data[i]["role_name"]}</span>
                                </button>`;
                }
                else {
                    temp_str += `<button class="${selected}" onclick="displayNewTab(${i})">
                                    <img
                                    src="${data[i].icon}"
                                    class="object-contain w-16 h-8"
                                    />
                                    <span class="mx-2"> ${data[i]["role_name"]}</span>
                                </button>`;
                }
            }
        }
        document.getElementById("role_tab").innerHTML = temp_str;
        document.getElementById("team_container").scrollIntoView({behavior: "smooth"});
        fillTeamMembers(idx);
    }

    function fillTeamMembers(idx){
        var temp_str = '';
        for(var i=0 ; i < data[idx]["users"].length ; i++) {
            temp_str += `<div class="flex items-center shadow-xl shadow-gray-900 border rounded-full" style="border-color:#${data[idx]["role_color"]};">
                            <img
                                src="${data[idx]["users"][i]["avatar"]}"
                                onerror="this.onerror=null;this.src='https://cdn.discordapp.com/embed/avatars/3.png';"
                                class="object-cover w-24 h-24 m-4 rounded-full shadow"
                            />
                            <div class="m-4">
                                <p class="text-xl font-bold text-gray-800 md:text-2xl lg:text-2xl">${data[idx]["users"][i]["name"]}</p>
                                <p class="text-lg text-gray-600">${data[idx]["role_name"]}</p>
                            </div>
                        </div>`;
        }
        document.getElementById("team_container").innerHTML = temp_str;
    }
</script>

@endsection
