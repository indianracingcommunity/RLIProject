@extends('layouts.app')
@section('content')

<!-- <form class="hidden bg-white w-full shadow-lg rounded-md px-5" method="POST" action="/testform" enctype="multipart/form-data">
    <div class="flex-row pb-5">
        <div>
            <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Select Tier</label>
            <div class="inline-block relative">
                <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                    @foreach ($season as $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Enter Round Number</label>
            <input maxlength="4" type="number" placeholder="Round number" class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">
        </div>
        <div>
            <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Select Circuit</label>
            <div class="inline-block relative">
                <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                    @foreach ($tracks as $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Enter Points Scheme</label>
            <input maxlength="3" type="number" placeholder="9 for season 8" class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">
        </div>
    </div>

    <div class="flex-row pb-5">
        <div>
            <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Select Driver</label>
            <div class="inline-block relative">
                <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                    @foreach ($driver as $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Select Constructor</label>
            <div class="inline-block relative">
                <select class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                    @foreach ($constructor as $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Enter Grid</label>
            <input maxlength="3" type="number" placeholder="" class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">
        </div>
        <div>
            <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Enter Laps completed</label>
            <input maxlength="3" type="number" placeholder="" class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">
        </div>
        <div>
            <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Enter fastest lap</label>
            <input maxlength="40" type="text" placeholder="" class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">
        </div>
        <div>
            <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Enter race time/interval</label>
            <input maxlength="40" type="text" placeholder="" class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">
        </div>
        <div>
            <label class="inline-block text-gray-700 text-base font-bold mb-2 mt-5">Enter status</label>
            <input maxlength="3" type="number" placeholder="" class="inline-block appearance-none w-27 bg-gray-200 shadow-lg text-basic border border-gray-500 py-2 pl-2 pr-6 ml-3 rounded leading-tight hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">
        </div>
    </div>
    
    <div class="flex gap-5 justify-center items-center">
        <button type="button" class="text-sm flex items-center justify-center content-center w-1/4 mt-3 bg-purple-600 rounded text-white font-semibold hover:bg-white hover:text-purple-600 shadow-xl" style="display: block;">Add Driver</button>
        <button type="button" class="text-sm flex items-center justify-center content-center w-1/4 mt-3 bg-purple-600 rounded text-white font-semibold hover:bg-white hover:text-purple-600 shadow-xl" style="display: block;">Verify</button>
    </div>
</form> -->

<div id="missingTrackAlert" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 py-2 px-4 mb-4 rounded" role="alert">
    <p><strong>'Track'</strong> key missing in the uploaded result JSON.</p>
</div>

<div id="missingResultsAlert" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 py-2 px-4 mb-4 rounded" role="alert">
    <p><strong>'Results'</strong> key missing in the uploaded result JSON.</p>
</div>

<div class="mb-10">
    <input type="file" id="fileInput">
</div>

<div class="bg-gray-200 w-1/2 shadow-lg rounded mb-10">
    <table id="jsonTableTrack" class="w-full table-auto">
        <thead id="trackHeaderFields" class="hidden text-center bg-purple-500 text-white">
            <tr>
            <th class="border rounded px-4 py-2">season_id</th>
            <th class="border rounded px-4 py-2">round</th>
            <th class="border rounded px-4 py-2">circuit_id</th>
            <th class="border rounded px-4 py-2">points</th>
            </tr>
        </thead>
        <tbody class="bg-white" id="trackTableBody">
            <!-- <tr class="text-center">
                <td class="border rounded p-1" contenteditable="true" id="trackBodySeason"></td>
                <td class="border rounded p-1" contenteditable="true" id="trackBodyRound"></td>
                <td class="border rounded p-1" contenteditable="true" id="trackBodyCircuit"></td>
                <td class="border rounded p-1" contenteditable="true" id="trackBodyPoints"></td>
            </tr> -->
        </tbody>
    </table>
</div>

<div class="bg-gray-200 w-full shadow-lg rounded">
    <table id="jsonTableResults" class="w-full table-auto">
        <thead id="resultsHeaderFields" class="hidden text-center bg-purple-500 text-white">
            <tr>
            <th class="border rounded px-4 py-2">position</th>
            <th class="border rounded px-4 py-2">driver</th>
            <th class="hidden border rounded px-4 py-2">driver_id</th>
            <th class="border rounded px-4 py-2">constructor_id</th>
            <th class="border rounded px-4 py-2">grid</th>
            <th class="border rounded px-4 py-2">stops</th>
            <th class="border rounded px-4 py-2">fastestlaptime</th>
            <th class="border rounded px-4 py-2">time</th>
            <th class="border rounded px-4 py-2">status</th>
            </tr>
        </thead>
        <tbody class="bg-white" id="resultsTableBody">
            <!-- <tr id="resultsRow">
                <td class="border rounded" id="resultsBodyPosition"></td>
                <td class="border rounded" id="resultsBodyDriver"></td>
                <td class="border rounded" id="resultsBodyConstructor"></td>
                <td class="border rounded" id="resultsBodyGrid"></td>
                <td class="border rounded" id="resultsBodyStops"></td>
                <td class="border rounded" id="resultsBodyFastestLap"></td>
                <td class="border rounded" id="resultsBodyTime"></td>
                <td class="border rounded" id="resultsBodyStatus"></td>
            </tr> -->
        </tbody>
    </table>
</div>

<div class="flex justify-center items-center my-3">
    <button id="submit" class="hidden bg-purple-500 hover:bg-purple-700 text-white font-semibold py-2 px-4 border border-purple-700 rounded">Submit</button>
</div>

<div>
    <button id="test" class="bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-2 border border-red-700 rounded">Cancel</button>
    <button id="test2" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">Save</button>
</div>



<script>
    $(document).ready(function() {
        var season = <?php echo json_encode($season); ?>;
        var points = <?php echo json_encode($points); ?>;
        var tracks = <?php echo json_encode($tracks); ?>;
        var constructor = <?php echo json_encode($constructor); ?>;
        var driver = <?php echo json_encode($driver); ?>;
        // console.log(points);
        //JS to upload JSON, slot values into table
        var upload = document.getElementById('fileInput');
        upload.addEventListener('change', function() {
            //Execute only when a file is selected/uploaded
            if(upload.files.length > 0) {
                var reader = new FileReader();
                //Reading the uploaded JSON
                reader.readAsText(upload.files[0]);
                //Execute when reader has read the file
                reader.addEventListener('load', function() {
                    //Parse the JSON into an object
                    var json = JSON.parse(reader.result);

                    if(checkJsonKeys(json)) {   
                        checkExistence(json, season, tracks, points, driver, constructor);            
                        //Printing values of track key of json in table
                        // var trackSeason = document.getElementById('trackBodySeason');
                        // var trackRound = document.getElementById('trackBodyRound');
                        // var trackCircuit = document.getElementById('trackBodyCircuit');
                        // var trackPoints = document.getElementById('trackBodyPoints');
                        
                        // trackSeason.innerHTML = json.track.season_id;
                        // trackRound.innerHTML = json.track.round;
                        // trackCircuit.innerHTML = json.track.circuit_id;
                        // trackPoints.innerHTML = json.track.points;
                        $('#trackHeaderFields').toggleClass('hidden');
                        var rowTrack = `<tr class="text-center">
                                            <td class="border rounded p-1" contenteditable="true" id="trackBodySeason">${json.track.season_id}</td>
                                            <td class="border rounded p-1" contenteditable="true" id="trackBodyRound">${json.track.round}</td>
                                            <td class="border rounded p-1" contenteditable="true" id="trackBodyCircuit">${json.track.circuit_id}</td>
                                            <td class="border rounded p-1" contenteditable="true" id="trackBodyPoints">${json.track.points}</td>
                                        </tr>`;
                        $('#trackTableBody').append(rowTrack);

                        //Printing values of results key of json in table
                        // var resultsPosition = document.getElementById('resultsBodyPosition');
                        // var resultsDriver = document.getElementById('resultsBodyDriver');
                        // var resultsConstructor = document.getElementById('resultsBodyConstructor');
                        // var resultsGrid = document.getElementById('resultsBodyGrid');
                        // var resultsStops = document.getElementById('resultsBodyStops');
                        // var resultsFastestLap = document.getElementById('resultsBodyFastestLap');
                        // var resultsTime = document.getElementById('resultsBodyTime');
                        // var resultsStatus = document.getElementById('resultsBodyStatus');
                        // var resultsRow = document.getElementById('resultsRow');

                        // for (let i = 0; i < Object.keys(json.results).length; i++){
                        //     resultsPosition.innerHTML = json.results[i].position;
                        //     resultsDriver.innerHTML = json.results[i].driver;
                        //     resultsConstructor.innerHTML = json.results[i].constructor_id;
                        //     resultsGrid.innerHTML = json.results[i].grid;
                        //     resultsStops.innerHTML = json.results[i].stops;
                        //     resultsFastestLap.innerHTML = json.results[i].fastestlaptime;
                        //     resultsTime.innerHTML = json.results[i].time;
                        //     resultsStatus.innerHTML = json.results[i].status;
                        // }
                        $('#resultsHeaderFields').toggleClass('hidden');
                        for (let i = 0; i < Object.keys(json.results).length; i++){
                            var rowResult = `<tr class="text-center">
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].position}</td>
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].driver}</td>
                                                <td class="hidden border rounded p-2" contenteditable="true">${json.results[i].driver_id}</td>
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].constructor_id}</td>
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].grid}</td>
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].stops}</td>
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].fastestlaptime}</td>
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].time}</td>
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].status}</td>
                                            </tr>`;
                            $('#resultsTableBody').append(rowResult);
                        }

                        $('#submit').toggleClass('hidden');
                        
                        $('#submit').click(function(event) {
                            var trackContent = tableToJSON(document.getElementById('jsonTableTrack'));
                            var resultsContent = tableToJSON(document.getElementById('jsonTableResults'));
                            var newJson = {
                                track: trackContent[0],
                                results: resultsContent
                            }
                            postJson(JSON.stringify(newJson));
                        });
                    }

                    function tableToJSON(table) {
                        var data = [];
                        var headers = [];
                        for(var i = 0; i < table.rows[0].cells.length; i++) {
                            headers[i] = table.rows[0].cells[i].innerHTML;
                        }
                        for(var i = 1; i < table.rows.length; i++) {
                            var tableRow = table.rows[i];
                            var rowData = {};
                            for(var j = 0; j < tableRow.cells.length; j++) {
                                var status = Number(tableRow.cells[j].innerHTML);
                                rowData[headers[j]] = (isNaN(status)) ? (tableRow.cells[j].textContent) : status;
                            }
                            data.push(rowData);
                        }
                        return data;
                    }
                
                    function postJson(json) {
                        $.ajax({
                            type: "POST",
                            url: "/results/race",
                            data: json,
                            contentType: "application/json",
                            success: function (result) {
                                console.log(result);
                            },
                            error: function (result, status) {
                                console.log(result);
                            }
                        });
                    }

                    function checkJsonKeys(json) {
                        if(json.hasOwnProperty('track') && json.hasOwnProperty('results')) {
                            return 1;
                        } else if(json.hasOwnProperty('track') == false) {
                            $('#missingTrackAlert').show(500);
                        } else {
                            $('#missingResultsAlert').show(500);
                        }
                    }

                    function checkExistence(json, season, tracks, points, driver, constructor) {
                        var checkFields = [
                                            {
                                                input: json.track.season_id,
                                                stored: season,
                                                message: 'Season  ID = ' + json.track.season_id + ' not present in DB'
                                            },
                                            {
                                                input: json.track.circuit_id,
                                                stored: tracks,
                                                message: 'Circuit ID = ' + json.track.circuit_id + ' not present in DB'
                                            },
                                            {
                                                input: json.track.points,
                                                stored: points,
                                                message: 'Points ID = ' + json.track.points + ' not present in DB'
                                                },
                                            {
                                                input: json.results,
                                                stored: driver,
                                                message: 'Driver ID not present in DB'
                                            },
                                            {
                                                input: json.results,
                                                stored: constructor,
                                                message: 'Constructor ID not present in DB'
                                            }
                                        ];
                        
                        for(let i = 0; i < checkFields.length - 2; i++) {
                            if(checkFields[i].stored.find(item => {return item.id == checkFields[i].input}) == undefined) {
                                console.log(checkFields[i].message);
                            }
                        }
                        
                        for(let i = 0; i < Object.keys(json.results).length; i++) {
                            if(checkFields[3].stored.find(item => {return item.id == checkFields[3].input[i].driver_id}) == undefined) {
                                console.log(checkFields[3].message);
                            }

                            if(checkFields[4].stored.find(item => {return item.id == checkFields[4].input[i].constructor_id}) == undefined) {
                                console.log(checkFields[4].message);
                            }
                        }
                    }
                });
            }
        });
    });
</script>


















<!-- {{-- <div class="w-full" id="info" style="display: none;">{{$data}}</div> --}}

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

</script> -->

@endsection
