@extends('layouts.app')
@section('content')
<div class="w-full" id="info" style="display: none;">{{$data}}</div>

<form class="bg-white w-full shadow-lg rounded px-8 pt-6 pb-8 mb-4" method="POST" action="/testform" enctype="multipart/form-data">
    <label class="block text-gray-700 text-2xl font-bold mb-2">Standings verification</label>
    <div class="flex w-full">
        <div class="inline-block w-3/4 h-auto mt-5">
            <img src="/storage/try.jpg"></img>
        </div>
        <div class="inline-block w-1/4 h-auto mt-5 ml-10" id="page1">
            <label class="block text-gray-700 text-xl font-bold mb-2">Race details</label>
            <div class="block w-full">
                <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Select Track</label>
                <div class="inline-block relative">
                    <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" name="circuit_id" id="circuitid">                       
                        @foreach ($tracks as $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                    <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <div class="block w-full mt-10">
                <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Championship/Tier</label>
                <div class="inline-block relative">  
                    <select class="inline-block appearance-none w-56 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 ml-3 pl-2 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" name="season_id" id="seasonid">
                        @foreach ($season as $value)
                            @foreach ($value->constructors as $constructor)
                            <option value="{{$value->id}}">{{$constructor['name']}}</option>
                            @endforeach 
                        @endforeach 
                    </select>
                    <div class="inline-block pointer-events-none absolute inset-y-0 right-0 pr-2 flex items-center text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <div class="w-full mt-16">
                <label class="inline-block text-gray-700 text-base font-bold">
                Round number
                </label>
                <div class="inline-block pl-3">
                    <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-20 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" type="number" name="round" id="roundid">
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
            <div class="block w-full h-8 text-gray-700 text-xl font-bold mb-2">Driver details</div>
            <div class="block w-auto">
                <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5 pl-6 ml-2">Position</label>
                <div class="inline-block relative">
                    <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" name="position" id="positionid">                       
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>

                    </select>
                    <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            
            <div class="block w-auto">
                <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-10 ml-1">Constructor</label>
                <div class="inline-block relative">
                    <select class="inline-block appearance-none  bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 ml-3 pl-2 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" name="constructor_id" id="constructorid">
                        @foreach ($season as $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach 
                    </select>
                    <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <div class="block w-auto">
                <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-10">Driver Name</label>
                <div class="inline-block relative">
                    <select class="inline-block appearance-none  bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 ml-3 pl-2 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500" name="driver_id" id="drivernameid">
                        @foreach ($driver as $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach 
                    </select>
                    <div class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <div class="w-auto mt-10">
                <label class="inline-block text-gray-700 text-base font-bold">
                Fastest Time
                </label>
                <div class="inline-block pl-3">
                    <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-32 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" type="text" name="fastestlaptime" id="fastesttimeid">
                </div>
            </div>

            <div class="w-auto mt-10">
                <label class="inline-block text-gray-700 text-base font-bold ml-12 pl-3">
                Grid
                </label>
                <div class="inline-block pl-3">
                    <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-20 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" type="number" name="grid_id" id="gridid">
                </div>
            </div>

            <div class="w-auto mt-10 ml-12 pl-3">
                <label class="inline-block text-gray-700 text-base font-bold">
                Stop
                </label>
                <div class="inline-block pl-3">
                    <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-20 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" type="number" name="stops" id="stopsid">
                </div>
            </div>

            <div class="w-auto mt-10 ml-4">
                <label class="inline-block text-gray-700 text-base font-bold">
                Race Time
                </label>
                <div class="inline-block pl-3">
                    <input class="bg-gray-200 appearance-none border shadow-lg border-gray-500 rounded w-32 py-2 px-3 text-gray-700 text-basic leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-500" type="text" name="time" id="timeid">
                </div>
            </div>
            
            <div class="flex w-auto mt-10 content-center items-center justify-center">
                <button class="bg-purple-500 hover:bg-purple-600 text-white text-lg font-bold shadow-lg py-2 w-32 rounded focus:outline-none focus:shadow-outline" type="button" onclick="driverpreviousFunction()">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4 rotate-90 fill-current mb-1" viewBox="0 0 24 24"><path d="M16.67 0l2.83 2.829-9.339 9.175 9.339 9.167-2.83 2.829-12.17-11.996z"/></svg>
                    Previous
                </button>

                <button class="bg-purple-500 hover:bg-purple-600 text-white text-lg font-bold shadow-lg py-2 pl-4 mx-5 w-32 rounded focus:outline-none focus:shadow-outline" type="button" onclick="drivernextFunction()">
                    Next
                    <svg class="inline-block w-4 h-4 mr-2 rotate-90 fill-current mb-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5 3l3.057-3 11.943 12-11.943 12-3.057-3 9-9z"/></svg>
                </button>

                
                
            </div>
            
        </div>
    </div>

</form>
    


<script>
    updatelist1 = function(){
      document.getElementById("filenamet1").innerHTML = document.getElementById("imgt1").files[0].name;
    }
    function racenextFunction() {
        document.getElementById("page1").style.display = "none";
        document.getElementById("page2").style.display = "block";
        jsondata.track.circuit_id = parseInt(document.getElementById("circuitid").value);
        jsondata.track.round = parseInt(document.getElementById("roundid").value);
        jsondata.track.season_id = parseInt(document.getElementById("seasonid").value);
        
        index = index + 1;
        console.log(index);
    }

    function drivernextFunction(){
        index = index + 1;
        document.getElementById("positionid").value = jsondata.results[index].position;
        document.getElementById("constructorid").value = jsondata.results[index].constructor_id;
        document.getElementById("drivernameid").value = jsondata.results[index].driver_id;
        document.getElementById("fastesttimeid").value = jsondata.results[index].fastestlaptime;
        document.getElementById("gridid").value = jsondata.results[index].grid;
        document.getElementById("stopsid").value = jsondata.results[index].stops;
        document.getElementById("timeid").value = jsondata.results[index].time;
        
    }

    function driverpreviousFunction(){
        
        if (index == 0 || index == -1){
            document.getElementById("page1").style.display = "block";
            document.getElementById("page2").style.display = "none";
        }
        else{
            index = index - 1;
            document.getElementById("positionid").value = jsondata.results[index].position;
            document.getElementById("constructorid").value = jsondata.results[index].constructor_id;
            document.getElementById("drivernameid").value = jsondata.results[index].driver_id;
            document.getElementById("fastesttimeid").value = jsondata.results[index].fastestlaptime;
            document.getElementById("gridid").value = jsondata.results[index].grid;
            document.getElementById("stopsid").value = jsondata.results[index].stops;
            document.getElementById("timeid").value = jsondata.results[index].time;
        }
    }
    var jsondata = JSON.parse(document.getElementById("info").innerHTML);
    var index =  -1;
    
    document.getElementById("circuitid").value = jsondata.track.circuit_id; 
    document.getElementById("positionid").value = jsondata.results[0].position;
    document.getElementById("constructorid").value = jsondata.results[0].constructor_id;
    document.getElementById("drivernameid").value = jsondata.results[0].driver_id;
    document.getElementById("fastesttimeid").value = jsondata.results[0].fastestlaptime;
    document.getElementById("gridid").value = jsondata.results[0].grid;
    document.getElementById("stopsid").value = jsondata.results[0].stops;
    document.getElementById("timeid").value = jsondata.results[0].time;
    console.log(jsondata);

</script>

@endsection
