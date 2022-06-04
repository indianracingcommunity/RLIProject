@extends('layouts.app')
@section('content')

<div id="missingTrackAlert" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 py-2 px-4 mb-4 rounded" role="alert">
    <p><strong>'Track'</strong> key missing in the uploaded result JSON.</p>
</div>

<div id="missingResultsAlert" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 py-2 px-4 mb-4 rounded" role="alert">
    <p><strong>'Results'</strong> key missing in the uploaded result JSON.</p>
</div>

<select class="bg-gray-200 w-48 p-1 mb-10 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
    @foreach ($tracks as $value)
    <option value="{{$value->id}}">{{$value->name}}</option>
    @endforeach
</select>

<div class="mb-10">
    <input type="file" id="fileInput">
</div>

<div class="bg-gray-200 w-7/12 shadow-lg rounded mb-10">
    <table id="jsonTableTrack" class="w-full table-auto">
        <thead id="trackHeaderFields" class="hidden text-center bg-purple-500 text-white">
            <tr>
            <th class="border rounded px-4 py-2">Tier</th>
            <th class="border rounded px-4 py-2">Round Number</th>
            <th class="border rounded px-4 py-2">Circuit</th>
            <th class="border rounded px-4 py-2">Points Scheme</th>
            </tr>
        </thead>
        <tbody class="bg-white" id="trackTableBody">
        </tbody>
    </table>
</div>

<div class="bg-gray-200 w-full shadow-lg rounded">
    <table id="jsonTableResults" class="w-full table-auto">
        <thead id="resultsHeaderFields" class="hidden text-center bg-purple-500 text-white">
            <tr>
            <th class="border rounded px-4 py-2">Position</th>
            <th class="border rounded px-4 py-2">Driver</th>
            <th class="hidden border rounded px-4 py-2">Driver ID</th>
            <th class="border rounded px-4 py-2">Constructor</th>
            <th class="border rounded px-4 py-2">Starting Grid</th>
            <th class="border rounded px-4 py-2">Laps Completed</th>
            <th class="border rounded px-4 py-2">Fastest Lap</th>
            <th class="border rounded px-4 py-2">Race Time</th>
            <th class="border rounded px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody class="bg-white" id="resultsTableBody">
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
        var status = [
                        {
                            id: 0,
                            value: 'Finished'
                        },
                        {
                            id: 1,
                            value: 'Fastest Lap'
                        },
                        {
                            id: -2,
                            value: 'DNF'
                        },
                        {
                            id: -3,
                            value: 'DSQ'
                        }
                    ];
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
                    // console.log(json.track.points);

                    if(checkJsonKeys(json)) {   
                        checkExistence(json, season, tracks, points, driver, constructor);
                        isValidTimeFormat(json);     
                        
                        //Printing values of track key of json in table
                        $('#trackHeaderFields').toggleClass('hidden');
                        // var rowTrack = `<tr class="text-center">
                        //                     <td class="border rounded p-1" contenteditable="true" id="trackBodySeason">${json.track.season_id}</td>
                        //                     <td class="border rounded p-1" contenteditable="true" id="trackBodyRound">${json.track.round}</td>
                        //                     <td class="border rounded p-1" contenteditable="true" id="trackBodyCircuit">${json.track.circuit_id}</td>
                        //                     <td class="border rounded p-1" contenteditable="true" id="trackBodyPoints">${json.track.points}</td>
                        //                 </tr>`;
                        // $('#trackTableBody').append(rowTrack);

                        var rowTrack = `<tr class="text-center">
                                            <td class="border rounded p-1" contenteditable="true" id="trackBodySeason">
                                                <select id="seasonSelect" class="bg-gray-200 w-48 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                </select>
                                            </td>
                                            <td class="border rounded p-1" contenteditable="true" id="trackBodyRound">${json.track.round}</td>
                                            <td class="border rounded p-1" contenteditable="true" id="trackBodyCircuit">
                                                <select id="tracksSelect" class="bg-gray-200 w-48 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                </select>
                                            </td>
                                            <td class="border rounded p-1" contenteditable="true" id="trackBodyPoints">
                                                <select id="pointsSelect" class="bg-gray-200 w-24 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                </select>
                                            </td>
                                        </tr>`;
                        $('#trackTableBody').append(rowTrack);

                        let seasonSelected, tracksSelected, pointsSelected;

                        for(let i = 0; i < season.length; i++) {
                            if (season[i].id != json.track.season_id) {
                                seasonSelected += "<option value='"+season[i].id+"'>"+season[i].name+"</option>";
                            } else {
                                season[i].id = json.results.season_id;
                                seasonSelected += "<option selected value='"+season[i].id+"'>"+season[i].name+"</option>";
                            }
                            document.getElementById(`seasonSelect`).innerHTML = seasonSelected;
                        }
                        
                        for(let i = 0; i < tracks.length; i++) {
                            if (tracks[i].id != json.track.circuit_id) {
                                tracksSelected += "<option value='"+tracks[i].id+"'>"+tracks[i].name+"</option>";
                            } else {
                                tracks[i].id = json.results.circuit_id;
                                tracksSelected += "<option selected value='"+tracks[i].id+"'>"+tracks[i].name+"</option>";
                            }
                            document.getElementById(`tracksSelect`).innerHTML = tracksSelected;
                        }

                        for(let i = 0; i < points.length; i++) {
                            if (points[i].id != json.track.points) {
                                pointsSelected += "<option value='"+points[i].id+"'>"+points[i].id+"</option>";
                            } else {
                                points[i].id = json.track.points;
                                pointsSelected += "<option selected value='"+points[i].id+"'>"+points[i].id+"</option>";
                            }
                            document.getElementById(`pointsSelect`).innerHTML = pointsSelected;
                        }


                        //Printing values of results key of json in table
                        $('#resultsHeaderFields').toggleClass('hidden');
                        // for (let i = 0; i < Object.keys(json.results).length; i++){
                        //     var rowResult = `<tr class="text-center">
                        //                         <td class="border rounded p-2" contenteditable="true">${json.results[i].position}</td>
                        //                         <td class="border rounded p-2" contenteditable="true">${json.results[i].driver}</td>
                        //                         <td class="hidden border rounded p-2" contenteditable="true">${json.results[i].driver_id}</td>
                        //                         <td class="border rounded p-2" contenteditable="true">${json.results[i].constructor_id}</td>
                        //                         <td class="border rounded p-2" contenteditable="true">${json.results[i].grid}</td>
                        //                         <td class="border rounded p-2" contenteditable="true">${json.results[i].stops}</td>
                        //                         <td class="border rounded p-2" contenteditable="true">${json.results[i].fastestlaptime}</td>
                        //                         <td class="border rounded p-2" contenteditable="true">${json.results[i].time}</td>
                        //                         <td class="border rounded p-2" contenteditable="true">${json.results[i].status}</td>
                        //                     </tr>`;
                        //     $('#resultsTableBody').append(rowResult);
                        // }

                        for (let i = 0; i < Object.keys(json.results).length; i++){
                            var rowResult = `<tr class="text-center">
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].position}</td>
                                                <td class="border rounded py-2 px-1" contenteditable="true">
                                                    <select id='driverSelect${i}' class="bg-gray-200 w-48 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">
                                                    </select>
                                                </td>
                                                <td class="hidden border rounded p-2" contenteditable="true">${json.results[i].driver_id}</td>
                                                <td class="border rounded py-2 px-1" contenteditable="true">
                                                    <select id='constructorSelect${i}' class="bg-gray-200 w-48 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                    </select>
                                                </td>
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].grid}</td>
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].stops}</td>
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].fastestlaptime}</td>
                                                <td class="border rounded p-2" contenteditable="true">${json.results[i].time}</td>
                                                <td class="border rounded py-2 px-1" contenteditable="true">
                                                    <select id='statusSelect${i}' class="bg-gray-200 w-36 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                    </select>
                                                </td>
                                            </tr>`;
                            $('#resultsTableBody').append(rowResult);
                            
                            let driverSelected, constructorSelected, statusSelected;

                            for(let j = 0; j < driver.length; j++) {
                                if (driver[j].id != json.results[i].driver_id) {
                                    driverSelected += "<option value='"+driver[j].id+"'>"+driver[j].name+"</option>";
                                } else {
                                    driver[j].id = json.results[i].driver_id;
                                    driverSelected += "<option selected value='"+driver[j].id+"'>"+driver[j].name+"</option>";
                                }
                                document.getElementById(`driverSelect${i}`).innerHTML = driverSelected;
                            }

                            for(let j = 0; j < constructor.length; j++) {
                                if (constructor[j].id != json.results[i].constructor_id) {
                                    constructorSelected += "<option value='"+constructor[j].id+"'>"+constructor[j].name+"</option>";
                                } else {
                                    constructor[j].id = json.results[i].constructor_id;
                                    constructorSelected += "<option selected value='"+constructor[j].id+"'>"+constructor[j].name+"</option>";
                                }
                                document.getElementById(`constructorSelect${i}`).innerHTML = constructorSelected;
                            }

                            for(let j = 0; j < status.length; j++) {
                                if (status[j].id != json.results[i].status) {
                                    statusSelected += "<option value='"+status[j].id+"'>"+status[j].value+"</option>";
                                } else {
                                    status[j].id = json.results[i].status;
                                    statusSelected += "<option selected value='"+status[j].id+"'>"+status[j].value+"</option>";
                                }
                                document.getElementById(`statusSelect${i}`).innerHTML = statusSelected;
                            }
                        }

                        
                        $('#submit').toggleClass('hidden');
                        
                        $('#submit').click(function(event) {
                            var trackContent = tableToJSON(document.getElementById('jsonTableTrack'));
                            var resultsContent = tableToJSON(document.getElementById('jsonTableResults'));
                            var newJson = {
                                            track: trackContent[0],
                                            results: resultsContent
                                        };
                            console.log(newJson)
                            
                            if(isValidTimeFormat(newJson)) {
                                postJson(JSON.stringify(newJson));
                            } else {
                                console.log("Cannot post JSON due to errors in time format")
                            }
                        });
                    }
                    
                    function tableToJSON(table) {
                        var data = [];
                        var headers = [];
                        for(var i = 0; i < table.rows[0].cells.length; i++) {
                            let jsonKeyHeaders = [
                                                    {
                                                        tableHeader: 'Tier',
                                                        jsonHeader: 'season_id'
                                                    },
                                                    {
                                                        tableHeader: 'Round Number',
                                                        jsonHeader: 'round'
                                                    },
                                                    {
                                                        tableHeader: 'Circuit',
                                                        jsonHeader: 'circuit_id'
                                                    },
                                                    {
                                                        tableHeader: 'Points Scheme',
                                                        jsonHeader: 'points'
                                                    },
                                                    {
                                                        tableHeader: 'Position',
                                                        jsonHeader: 'position'
                                                    },
                                                    {
                                                        tableHeader: 'Driver',
                                                        jsonHeader: 'driver'
                                                    },
                                                    {
                                                        tableHeader: 'Driver ID',
                                                        jsonHeader: 'driver_id'
                                                    },
                                                    {
                                                        tableHeader: 'Constructor',
                                                        jsonHeader: 'constructor_id'
                                                    },
                                                    {
                                                        tableHeader: 'Starting Grid',
                                                        jsonHeader: 'grid'
                                                    },
                                                    {
                                                        tableHeader: 'Laps Completed',
                                                        jsonHeader: 'stops'
                                                    },
                                                    {
                                                        tableHeader: 'Fastest Lap',
                                                        jsonHeader: 'fastestlaptime'
                                                    },
                                                    {
                                                        tableHeader: 'Race Time',
                                                        jsonHeader: 'time'
                                                    },
                                                    {
                                                        tableHeader: 'Status',   
                                                        jsonHeader: 'status'
                                                    },
                                                ];
                            for(let j = 0; j < jsonKeyHeaders.length; j++) {
                                let temp = table.rows[0].cells[i].innerHTML;
                                if(temp == jsonKeyHeaders[j].tableHeader) {
                                    tableHeader = jsonKeyHeaders[j].jsonHeader;
                                    headers[i] = tableHeader;
                                }
                            }
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
                        let checkFields = [
                                            {
                                                input: json.track.season_id,
                                                stored: season,
                                                message: 'Season  ID ' + json.track.season_id + ' not present in DB'
                                            },
                                            {
                                                input: json.track.circuit_id,
                                                stored: tracks,
                                                message: 'Circuit ID ' + json.track.circuit_id + ' not present in DB'
                                            },
                                            {
                                                input: json.track.points,
                                                stored: points,
                                                message: 'Points ID ' + json.track.points + ' not present in DB'
                                                }
                                        ];
                        
                        for(let i = 0; i < checkFields.length; i++) {
                            if(checkFields[i].stored.find(item => {return item.id == checkFields[i].input}) == undefined) {
                                console.log(checkFields[i].message);
                            }
                        }
                        
                        for(let i = 0; i < Object.keys(json.results).length; i++) {
                            if(driver.find(item => {return item.id == json.results[i].driver_id}) == undefined) {
                                let positionId = json.results[i].position;
                                let driverId = json.results[i].driver_id;
                                console.log('Driver ID ' + driverId + ' not present in DB for position ' + positionId);
                            }

                            if(constructor.find(item => {return item.id == json.results[i].constructor_id}) == undefined) {
                                let positionId = json.results[i].position;
                                let contructorId = json.results[i].contructor_id;
                                console.log('Contructor ID ' + contructorId + ' not present in DB for position ' + positionId);
                            }
                        }
                    }

                    function isValidTimeFormat(json) {
                        let timeExpRace = "^\\+?(\\d+\\:)?[0-5]?\\d[.]\\d{3}$|^DNF$|^DSQ$|^DNS$|^\\+1 Lap$|^\\+[2-9][0-9]* Laps$|^\\-$";
                        let timeCheckRace = new RegExp(timeExpRace);
                        let timeExpFl = "^(\\d+\\:)?[0-5]?\\d[.]\\d{3}$|^\\-$";
                        let timeCheckFl = new RegExp(timeExpFl);
                        let status = 1;

                        for(let i = 0; i < Object.keys(json.results).length; i++) {
                            if(!(timeCheckFl.test(json.results[i].fastestlaptime))) {
                                let positionId = json.results[i].position;
                                console.log('Fastest lap format wrong for position ' + positionId);
                                status = 0;
                            }
                            
                            if(!(timeCheckRace.test(json.results[i].time))) {
                                let positionId = json.results[i].position;
                                console.log('Race time format wrong for position ' + positionId);
                                status = 0;
                            }
                        }
                        return status;
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
