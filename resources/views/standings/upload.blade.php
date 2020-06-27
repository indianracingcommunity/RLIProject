@extends('layouts.app')
@section('content')
<div class="w-full" id="info" style="display: none;">{{$data}}</div>

<form class="bg-white shadow-lg rounded px-8 pt-6 pb-8 mb-4" method="POST" action="/testform" enctype="multipart/form-data">
    <label class="block text-gray-700 text-2xl font-bold mb-2">Standings verification</label>
    <div class="flex w-full h-auto">
        <div class="inline-block w-3/4 h-auto mt-5">
            <img src="http://rliproject.test/storage/try.jpg"></img>
        </div>
        <div class="inline-block w-1/4 h-auto mt-5 ml-10" id="page1">
            <label class="block text-gray-700 text-xl font-bold mb-2">Race details</label>
            <div class="block w-full">
                <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Select Track</label>
                <div class="inline-block relative">
                    <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" name="circuit_id" id="circuitid">
                        <option value="1">Australia</option>
                        <option value="2">Barhain</option>
                        <option value="3">Monaco</option>
                        <option value="4">Italy</option>
                        <option value="5">Britain</option>
                    </select>
                    <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <div class="block w-full mt-10">
                <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Championship/Tier</label>
                <div class="inline-block relative">
                    <select class="inline-block appearance-none w-auto bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 ml-3 pl-2 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" name="season_id">
                        <option>Mini Championship</option>
                        <option>Classic Car championship</option>
                        <option>Tier 2</option>
                    </select>
                    <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <div class="w-full mt-16">
                <label class="inline-block text-gray-700 text-base font-bold">
                Round number
                </label>
                <div class="inline-block pl-3">
                    <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-20 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" type="number" name="round">
                </div>
            </div>

            <div class="flex w-full mt-10 content-center items-center justify-center">
                
                <button class="bg-purple-500 hover:bg-purple-600 text-white text-lg font-bold shadow-lg py-2 pl-4 rounded focus:outline-none focus:shadow-outline" type="button" onclick="racenextFunction()">
                Next
                <svg class="inline-block w-4 h-4 mr-2 fill-current mb-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5 3l3.057-3 11.943 12-11.943 12-3.057-3 9-9z"/></svg>
                </button>
                
            </div>
        </div>

        <div class="inline-block w-1/4 h-auto mt-5 ml-10" id="page2" style="display: none;">
            <label class="block text-gray-700 text-xl font-bold mb-2">Driver Info</label>
        </div>
    </div>

</form>
    


<script>
    updatelist1 = function(){
      document.getElementById("filenamet1").innerHTML = document.getElementById("imgt1").files[0].name;
    }
    function racenextFunction() {
        document.getElementById("page1").style.display = "none";
        document.getElementById("page2").style.display = "flex";
        jsondata.track.circuit_id = parseInt(document.getElementById("circuitid").value)
        console.log(jsondata);
        index = index + 1;
    }
    var jsondata = JSON.parse(document.getElementById("info").innerHTML);
    var index =  -1;
    console.log(jsondata);

</script>

@endsection