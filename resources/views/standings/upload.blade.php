@extends('layouts.app')
@section('content')

<div id="missingTrackAlert" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 py-2 px-4 mb-4 rounded" role="alert">
    <p><strong>'Track'</strong> key missing in the uploaded JSON</p>
</div>

<div id="missingResultsAlert" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 py-2 px-4 mb-4 rounded" role="alert">
    <p><strong>'Results'</strong> key missing in the uploaded JSON</p>
</div>

<div class="flex justify-center items-center mt-2">
    <div id="successPost" class="hidden flex items-center justify-center gap-2 w-full text-center text-lg bg-green-100 border-l-4 border-r-4 border-green-500 text-green-700 p-2 mb-2 rounded" role="alert">
        <i class="text-green-700 text-sm fa fa-check-circle" aria-hidden="true"></i></i>    
        <p>Results uploaded <strong>SUCCESSFULLY</strong></p>
    </div>
</div>

<div class="flex justify-center items-center mt-2">
    <div id="failedPost" class="hidden flex items-center justify-center gap-2 w-full text-center text-lg bg-red-100 border-l-4 border-r-4 border-red-500 text-red-700 p-2 mb-2 rounded" role="alert">
        <i class="text-red-700 fa fa-times" aria-hidden="true"></i>
        <p id="failText"></p>
    </div>
</div>

<!-- <select class="bg-gray-200 w-48 p-1 mb-10 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
    @foreach ($tracks as $value)
    <option value="{{$value->id}}">{{$value->name}}</option>
    @endforeach
</select> -->

<div class="mb-10">
    <input type="file" id="fileInput">
</div>

<div class="w-7/12 rounded mb-10">
    <div id="errorSeasonAlert" class="hidden w-1/2 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
        <p><strong>SEASON</strong> [field is missing]</p>
    </div>

    <div id="errorRoundAlert" class="hidden w-1/2 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
        <p><strong>ROUND NUMBER</strong> [field must be a positive integer]</p>
    </div>

    <div id="errorCircuitAlert" class="hidden w-1/2 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
        <p><strong>CIRCUIT</strong> [field is missing]</p>
    </div>

    <div id="errorPointsAlert" class="hidden w-1/2 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
        <p><strong>POINTS SCHEME</strong> [invalid field]</p>
    </div>

    <table id="jsonTableTrack" class="w-full shadow-lg table-auto mt-2">
        <thead id="trackHeaderFields" class="hidden text-center bg-purple-500 text-white">
            <tr>
                <th class="border font-bold rounded px-4 py-2">Season</th>
                <th class="border font-bold rounded px-4 py-2">Round Number</th>
                <th class="border font-bold rounded px-4 py-2">Circuit</th>
                <th class="border font-bold rounded px-4 py-2">Points Scheme</th>
            </tr>
        </thead>
        <tbody class="bg-white" id="trackTableBody">
        </tbody>
    </table>
</div>

<div class="w-full rounded mb-10">
    <div id="resultsAlerts"></div>

    <table id="jsonTableResults" class="w-full table-auto shadow-lg mt-2">
        <thead id="resultsHeaderFields" class="hidden text-center bg-purple-500 text-white">
            <tr>
                <th class="border font-bold rounded px-4 py-2">Position</th>
                <th class="border font-bold rounded px-4 py-2">Driver</th>
                <th class="hidden border font-bold rounded px-4 py-2">Driver ID</th>
                <th class="border font-bold rounded px-4 py-2">Constructor</th>
                <th class="border font-bold rounded px-4 py-2">Starting Grid</th>
                <th class="border font-bold rounded px-4 py-2">Laps Completed</th>
                <th class="border font-bold rounded px-4 py-2">Fastest Lap</th>
                <th class="border font-bold rounded px-4 py-2">Race Time</th>
                <th class="border font-bold rounded px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody class="bg-white" id="resultsTableBody">
        </tbody>
    </table>
</div>

<div class="flex justify-center items-center">
    <button id="submit" class="hidden bg-purple-500 hover:bg-purple-700 text-white font-semibold py-2 px-4 border border-purple-700 rounded">Submit</button>
</div>

<div class="flex justify-center items-center mt-2">
    <div id="errorSubmitAlert" class="hidden w-auto bg-red-100 border-l-4 border-r-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
            <p>Please clear all the<strong> ERRORS </strong> before submitting</p>
    </div>
</div>

<div class="bg-black bg-opacity-50 fixed inset-0 hidden justify-center items-start w-screen max-h-screen" id="pointsOverlay">
    <div class="bg-gray-200 rounded-lg w-3/4 max-h-screen py-2 px-3 shadow-xl overflow-scroll">
        <div class="flex justify-between items-center border-b border-gray-400">
            <h4 class="p-2 text-lg md:text-xl font-bold">Points scheme details</h4>
            <svg id="cross" class=" w-6 h-7 cursor-pointer hover:bg-gray-400 rounded-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="close-modal"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </div>
        <div>
            <p class="text-center text-red-600 text-md md:text-lg font-bold pt-3 pb-1">Choose the required points scheme</p>
        </div>
        <div class="justify-center px-4 py-2 w-full">
            <table id="pointsTable" class="table-auto">
                <thead id="pointsTableHeaders" class="text-center bg-purple-500 text-white">
                </thead>
                <tbody class="bg-white" id="pointsTableBody">
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- <div>
    <button id="test" class="bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-2 border border-red-700 rounded">
        <i class="fa fa-undo" aria-hidden="true"></i>
    </button>
    <button id="test2" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
        <i class="fa fa-undo" aria-hidden="true"></i>
    </button>
</div> -->


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
                        let unitsPlace, originalStatus = [];
                        for(let i = 0; i < Object.keys(json.results).length; i++) {
                            originalStatus[i] = json.results[i].status;
                            unitsPlace = parseInt(json.results[i].status % 10);
                            json.results[i].status = unitsPlace;
                        }
                        
                        //Printing values of track key of json in table
                        $('#trackHeaderFields').toggleClass('hidden');

                        var rowTrack = `<tr class="text-center">
                                            <td class="border rounded py-2 px-1" id="trackBodySeason">
                                                <select id="seasonSelect" class="bg-gray-200 w-48 p-1 font-semibold leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                </select>
                                                <button id="undoSeason" class="bg-white absolute text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                            <td class="border rounded p-2" id="trackBodyRound">
                                                <input class="pl-3 w-16 text-center font-semibold" type="number" id="inputRound" min="1" value="${json.track.round}"\>
                                                <button id="undoRound" class="bg-white absolute text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                            <td class="border rounded py-2 px-1" id="trackBodyCircuit">
                                                <select id="tracksSelect" class="bg-gray-200 w-48 p-1 font-semibold leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                </select>
                                                <button id="undoCircuit" class="bg-white absolute text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                            <td class="border rounded py-2 px-1" id="trackBodyPoints">
                                                <button id="pointsBtn" type="button" class="px-5 font-semibold bg-gray-300 border border-gray-500 rounded">${json.track.points}</button>
                                                <button id="undoPoints" class="bg-white absolute text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>`;
                        $('#trackTableBody').append(rowTrack);

                        let seasonCol = document.getElementById(`seasonSelect`);
                        let circuitCol = document.getElementById(`tracksSelect`);
                        let pointsCol = document.getElementById(`pointsSelect`);
                        populateTrackDropdowns(season, tracks, points, json, seasonCol, circuitCol, pointsCol);

                        //Printing values of results key of json in table
                        $('#resultsHeaderFields').toggleClass('hidden');

                        for(let i = 0; i < Object.keys(json.results).length; i++) {
                            var rowResult = `<tr class="text-center">
                                                <td class="border rounded p-2" id="resultsBodyPos${i}">
                                                    <input class="pl-3 w-16 text-center font-semibold" type="number" id="inputPos${i}" min="1" value="${json.results[i].position}"\>
                                                    <button id="undoPos${i}" class="bg-white absolute text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                                <td class="border rounded py-2 px-1" id="resultsBodyDriver${i}">
                                                    <select id='driverSelect${i}' class="bg-gray-200 font-semibold w-48 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">
                                                    </select>
                                                    <button id="undoDriver${i}" class="bg-white absolute text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                                <td class="hidden border rounded p-2">
                                                    <input class="w-12 text-center font-semibold" type="text" id="inputDriver${i}" value="${json.results[i].driver_id}"\>
                                                </td>
                                                <td class="border rounded py-2 px-1" id="resultsBodyConstructor${i}">
                                                    <select id='constructorSelect${i}' class="bg-gray-200 font-semibold w-48 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                    </select>
                                                    <button id="undoConstructor${i}" class="bg-white absolute text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                                <td class="border rounded p-2" id="resultsBodyGrid${i}">
                                                    <input class="pl-3 w-16 text-center font-semibold" type="number" id="inputGrid${i}" min="1" value="${json.results[i].grid}"\>
                                                    <button id="undoGrid${i}" class="bg-white absolute text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                                <td class="border rounded p-2" id="resultsBodyStops${i}">
                                                    <input class="pl-3 w-16 text-center font-semibold" type="number" id="inputStops${i}" min="0" value="${json.results[i].stops}"\>
                                                    <button id="undoStops${i}" class="bg-white absolute text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                                <td class="border rounded p-2" id="resultsBodyFl${i}">
                                                    <input class="w-24 text-center font-semibold" type="text" id="inputFl${i}" value="${json.results[i].fastestlaptime}"\>
                                                    <button id="undoFl${i}" class="bg-white absolute text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                                <td class="border rounded p-2" id="resultsBodyTime${i}">
                                                    <input class="w-24 text-center font-semibold" type="text" id="inputTime${i}" value="${json.results[i].time}"\>
                                                    <button id="undoTime${i}" class="bg-white absolute text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                                <td class="border rounded py-2 px-1" id="resultsBodyStatus${i}">
                                                    <select id='statusSelect${i}' class="bg-gray-200 font-semibold w-36 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                    </select>
                                                    <button id="undoStatus${i}" class="bg-white absolute text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                            </tr>`;
                            $('#resultsTableBody').append(rowResult);

                            var resultsAlertsCreation = `<div id="errorPosAlert${i}" class="hidden w-3/4 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
                                                            <p>Row<strong> ${i+1}</strong> -<strong> POSITION</strong> [field must be a positive integer]</p>
                                                        </div>

                                                        <div id="errorDriverAlert${i}" class="hidden w-3/4 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
                                                            <p>Row<strong> ${i+1}</strong> -<strong> DRIVER</strong> [field is missing]</p>
                                                        </div>

                                                        <div id="errorConstructorAlert${i}" class="hidden w-3/4 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
                                                            <p>Row<strong> ${i+1}</strong> -<strong> CONSTRUCTOR</strong> [field is missing]</p>
                                                        </div>

                                                        <div id="errorGridAlert${i}" class="hidden w-3/4 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
                                                            <p>Row<strong> ${i+1}</strong> -<strong> STARTING GRID</strong> [field must be a positive integer]</p>
                                                        </div>

                                                        <div id="errorStopsAlert${i}" class="hidden w-3/4 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
                                                            <p>Row<strong> ${i+1}</strong> -<strong> LAPS COMPLETED</strong> [field must be a non-negative integer]</p>
                                                        </div>

                                                        <div id="errorFlAlert${i}" class="hidden w-3/4 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
                                                            <p>Row<strong> ${i+1}</strong> -<strong> FASTEST LAP</strong> [field must be in the following format: <strong>'1:06.006'</strong>]</p>
                                                        </div>

                                                        <div id="errorTimeAlert${i}" class="hidden w-3/4 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
                                                            <p>Row<strong> ${i+1}</strong> -<strong> RACE TIME</strong> [field must be in one of the following formats:<strong> '-'</strong>, <strong>'1:06.006'</strong>, <strong>+X Lap(s)</strong>, <strong>DNS</strong>, <strong>DNF</strong> or <strong>DSQ</strong>]</p>
                                                        </div>

                                                        <div id="errorStatusAlert${i}" class="hidden w-3/4 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
                                                            <p>Row<strong> ${i+1}</strong> -<strong> STATUS</strong> [invalid field]</p>
                                                        </div>`;
                            $('#resultsAlerts').append(resultsAlertsCreation);
                            
                            let driverCol = document.getElementById(`driverSelect${i}`);
                            let constructorCol = document.getElementById(`constructorSelect${i}`);
                            let statusCol = document.getElementById(`statusSelect${i}`);
                            populateResultsDropdowns(driver, constructor, status, json, driverCol, constructorCol, statusCol, i);
                        }
                        
                        let headerFill = "";
                        for(let i = 0; i < points.length; i++) {
                            headerFill += "<th class='border rounded font-bold px-4 py-2'> <input type='checkbox' class='transform scale-125 cursor-pointer' id='select"+ (i+1) +"'><p>" + points[i].id + "</p></th>";
                        }
                        var pointsHeader = `<tr>
                        <th class='border rounded font-bold px-4 py-2'>Pos</th>
                                                ${headerFill}
                                            </tr>`;
                        $('#pointsTableHeaders').append(pointsHeader);
                        
                        for(let i = 0; i < Object.keys(points[0]).length - 3; i++) {
                            let columnFill = "";
                            for(let j = 0; j < points.length; j++) {
                                columnFill += "<td class='border text-center rounded py-1 px-3' contenteditable='false'>" + points[j]['P' + (i+1)] + "</td>";
                            }
                            var pointsRow = `<tr>
                            <td class='border text-center font-semibold rounded p-1' contenteditable='false'>P${i+1}</td>
                            ${columnFill}
                            </tr>`;
                            $('#pointsTableBody').append(pointsRow);
                        }

                        $('#pointsBtn').click(function(event) {
                            $('#pointsOverlay').removeClass('hidden');
                            $('#pointsOverlay').addClass('flex');
                            selectIndex = $('#pointsBtn').html();
                            $(`#select${selectIndex}`).prop('checked', true);
                        });

                        for(let i = 0; i < points.length; i++) {
                            $(`#select${i+1}`).click(function(event) {
                                $('input:checkbox').not(this).prop('checked', false);
                                $('#pointsBtn').html(i+1);
                                $('#trackBodyPoints').removeClass('bg-red-600');
                                $('#errorPointsAlert').slideUp(500);
                                $('#pointsOverlay').removeClass('flex');
                                $('#pointsOverlay').addClass('hidden');
                            });
                        }
                        
                        dataChecks(json, season, tracks, points, driver, constructor, status);
                        isValidTimeFormat(json);
                        
                        undoFields(json);
                        $('#undoPoints').click(function(event) {
                            if(points.find(item => {return item.id == json.track.points}) == undefined) {
                                $('#pointsBtn').html('0');
                                $('input:checkbox').not(this).prop('checked', false);
                                $('#trackBodyPoints').addClass('bg-red-600');
                                $('#errorPointsAlert').slideDown(500);
                            } else {
                                $('#pointsBtn').html(json.track.points);
                                $('input:checkbox').not(this).prop('checked', false);
                            }
                        });
                        
                        clearWarnings(json, season, tracks, driver, constructor, status);

                        for(let i = 0; i < Object.keys(json.results).length; i++) {
                            let flValue, timeValue;
                            
                            $(`#inputFl${i}`).change(function(event) {
                                flValue = $(`#inputFl${i}`).val();
                                flFormatCheck(flValue, json, i);
                            });
                            
                            $(`#inputTime${i}`).change(function(event) {
                                timeValue = $(`#inputTime${i}`).val();
                                raceTimeFormatCheck(timeValue, json, i);
                            });
                        }

                        $('#inputRound').change(function(event) {
                            let roundCell = $('#inputRound').val();
                            let fractionCheck = roundCell % 1;
                            if(isNaN(roundCell) || (roundCell < 1) || (fractionCheck != 0)) {
                                $('#trackBodyRound').addClass('bg-red-600');
                                $('#inputRound').addClass('bg-red-600');
                                $('#inputRound').addClass('font-bold');
                                $('#inputRound').addClass('text-white');
                                $('#errorRoundAlert').slideDown(500);
                            } else {
                                $('#trackBodyRound').removeClass('bg-red-600');
                                $('#inputRound').removeClass('bg-red-600');
                                $('#inputRound').removeClass('font-bold');
                                $('#inputRound').removeClass('text-white');
                                $('#errorRoundAlert').slideUp(500);
                            }
                        });

                        for(let i = 0; i < Object.keys(json.results).length; i++) {
                            let posValue, gridValue, stopsValue;

                            $(`#inputPos${i}`).change(function(event) {
                                posValue = $(`#inputPos${i}`).val();
                                checkPosFormat(posValue, json, i);
                            });

                            $(`#inputGrid${i}`).change(function(event) {
                                gridValue = $(`#inputGrid${i}`).val();
                                checkGridFormat(gridValue, json, i);
                            });

                            $(`#inputStops${i}`).change(function(event) {
                                stopsValue = $(`#inputStops${i}`).val();
                                checkStopsFormat(stopsValue, json, i);
                            });
                        }

                        $('#cross').click(function(event) {
                            $('#pointsOverlay').removeClass('flex');
                            $('#pointsOverlay').addClass('hidden');
                        });
                        
                        $('#submit').toggleClass('hidden');
                        
                        $('#submit').click(function(event) {
                            let trackContent = tableToJSON(document.getElementById('jsonTableTrack'));
                            let resultsContent = tableToJSON(document.getElementById('jsonTableResults'));
                            
                            let tempNum, resultString;
                            for(let i = 0; i < Object.keys(json.results).length; i++) {
                                tempNum = Math.abs(originalStatus[i] - json.results[i].status);
                                if(resultsContent[i].status >= 0)
                                    resultString = (tempNum + resultsContent[i].status).toFixed(2);
                                else
                                    resultString = (-tempNum + resultsContent[i].status).toFixed(2);
                                resultsContent[i].status = parseFloat(resultString);
                            }
                            
                            let newJson = {
                                track: trackContent[0],
                                results: resultsContent
                                        };
                            console.log(newJson)

                            let trackOuterDivs = ['#trackBodySeason', '#trackBodyRound', '#trackBodyCircuit', '#trackBodyPoints'];
                            let postStatusTrack = 1;
                            for(let i = 0; i < trackOuterDivs.length; i++) {
                                postStatusTrack-= checkForError(trackOuterDivs[i]);
                            }

                            let postStatusResults = 1;
                            for(let i = 0; i < Object.keys(newJson.results).length; i++) {
                                let resultsOuterDivs = [`#resultsBodyPos${i}`, 
                                                        `#resultsBodyDriver${i}`, 
                                                        `#resultsBodyConstructor${i}`, 
                                                        `#resultsBodyGrid${i}`, 
                                                        `#resultsBodyStops${i}`, 
                                                        `#resultsBodyFl${i}`, 
                                                        `#resultsBodyTime${i}`, 
                                                        `#resultsBodyStatus${i}`];
                                for(let j = 0; j < resultsOuterDivs.length; j++) {
                                    postStatusResults-= checkForError(resultsOuterDivs[j]);
                                }
                            }
                            
                            $('#errorSubmitAlert').slideUp(500);
                            if(isValidTimeFormat(newJson) && (postStatusTrack == 1) && (postStatusResults == 1)) {
                                $('#errorSubmitAlert').slideUp(500);
                                postJson(JSON.stringify(newJson));
                            } else {
                                $('#errorSubmitAlert').slideDown(500);
                            }
                        });
                    }      
                });
            }
        });
    });

    function tableToJSON(table) {
        let data = [];
        let headers = [];
        let jsonKeyHeaders = [
                                {
                                    tableHeader: 'Season',
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
                                }
                            ];
        let statusMap = [0, 1, -2, -3];

        for(let i = 0; i < table.rows[0].cells.length; i++) {
            for(let j = 0; j < jsonKeyHeaders.length; j++) {
                let temp = table.rows[0].cells[i].innerHTML;
                if(temp == jsonKeyHeaders[j].tableHeader) {
                    tableHeader = jsonKeyHeaders[j].jsonHeader;
                    headers[i] = tableHeader;
                }
            }
        }

        for(let i = 1; i < table.rows.length; i++) {
            let tableRow = table.rows[i];
            let rowData = {};
            let rowContent, treeTraversal, status;
            for(let j = 0; j < tableRow.cells.length; j++) {
                if(tableRow.cells[j].children.length != 0) {
                    treeTraversal = tableRow.cells[j].children[0].options;
                    if(headers[j] == 'driver'){
                        rowContent = treeTraversal[treeTraversal.selectedIndex].innerHTML;
                    } else if(headers[j] == 'status') {
                        tempRow = treeTraversal.selectedIndex - 1;
                        rowContent = statusMap[tempRow];
                    } else if(headers[j] == 'points') {
                        rowContent = tableRow.cells[j].children[0].innerHTML;
                    } else if(headers[j] == 'driver_id') {
                        leftCellTraversal = tableRow.cells[1].children[0].options;
                        rowContent = leftCellTraversal.selectedIndex;
                    } else {
                        rowContent = tableRow.cells[j].children[0].value;
                    }
                } else {
                    rowContent = tableRow.cells[j].innerHTML;
                }
                status = Number(rowContent);
                rowData[headers[j]] = (isNaN(status)) ? rowContent : status;
            }
            data.push(rowData);
        }
        // console.log(table.rows[1].cells[2].children.length)
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
                $('#submit').toggleClass('hidden');
                $('#jsonTableResults').addClass('hidden');
                $('#jsonTableTrack').addClass('hidden');
                $('#fileInput').addClass('hidden');
                $('#successPost').toggleClass('hidden');
            },
            error: function (result, status) {
                console.log(result);
                $('#failText').html("Something went wrong");
                // $('#failText').html(result.responseJson.message);
                $('#failedPost').toggleClass('hidden');
            }
        });
    }

    function checkJsonKeys(json) {
        if(json.hasOwnProperty('track') && json.hasOwnProperty('results')) {
            return 1;
        } else if(json.hasOwnProperty('track') == false) {
            $('#missingTrackAlert').slideDown(500);
        } else {
            $('#missingResultsAlert').slideDown(500);
        }
    }

    function dataChecks(json, season, tracks, points, driver, constructor, status) {
        let checkFields = [
                            {
                                input: json.track.season_id,
                                stored: season,
                                cell: '#trackBodySeason',
                                alert: '#errorSeasonAlert'
                            },
                            {
                                input: json.track.circuit_id,
                                stored: tracks,
                                cell: '#trackBodyCircuit',
                                alert: '#errorCircuitAlert'
                            },
                            {
                                input: json.track.points,
                                stored: points,
                                cell: '#trackBodyPoints',
                                alert: '#errorPointsAlert'
                            },
                            
                        ];
        
        for(let i = 0; i < checkFields.length; i++) {
            if(checkFields[i].stored.find(item => {return item.id == checkFields[i].input}) == undefined) {
                $(checkFields[i].cell).addClass('bg-red-600');
                $(checkFields[i].alert).slideDown(500);
                if(i == 2)
                    $('#pointsBtn').html('0');
            }
        }

        let value = json.track.round;
        let fractionCheck = value % 1;
        if(isNaN(value) || (value < 1) || (fractionCheck != 0)) {
            $('#trackBodyRound').addClass('bg-red-600');
            $('#inputRound').addClass('bg-red-600');
            $('#inputRound').addClass('font-bold');
            $('#inputRound').addClass('text-white');
            $('#errorRoundAlert').slideDown(500);
        } else {
            $('#trackBodyRound').removeClass('bg-red-600');
            $('#inputRound').removeClass('bg-red-600');
            $('#inputRound').removeClass('font-bold');
            $('#inputRound').removeClass('text-white');
            $('#errorRoundAlert').slideUp(500);
        }
        
        for(let i = 0; i < Object.keys(json.results).length; i++) {
            let posValue, gridValue, stopsValue;
            let posFractionCheck, gridFractionCheck, stopsFractionCheck;
            
            if(driver.find(item => {return item.id == json.results[i].driver_id}) == undefined) {
                $(`#resultsBodyDriver${i}`).addClass('bg-red-600');
                $(`#errorDriverAlert${i}`).slideDown(500);
            }

            if(constructor.find(item => {return item.id == json.results[i].constructor_id}) == undefined) {
                $(`#resultsBodyConstructor${i}`).addClass('bg-red-600');
                $(`#errorConstructorAlert${i}`).slideDown(500);
            }

            if(status.find(item => {return item.id == json.results[i].status}) == undefined) {
                $(`#resultsBodyStatus${i}`).addClass('bg-red-600');
                $(`#errorStatusAlert${i}`).slideDown(500);
            }

            posValue = json.results[i].position;
            posFractionCheck = posValue % 1;
            if(isNaN(posValue) || (posValue < 1) || (posFractionCheck != 0)) {
                $(`#resultsBodyPos${i}`).addClass('bg-red-600');
                $(`#inputPos${i}`).addClass('bg-red-600');
                $(`#inputPos${i}`).addClass('font-bold');
                $(`#inputPos${i}`).addClass('text-white');
                $(`#errorPosAlert${i}`).slideDown(500);
            } else {
                $(`#resultsBodyPos${i}`).removeClass('bg-red-600');
                $(`#inputPos${i}`).removeClass('bg-red-600');
                $(`#inputPos${i}`).removeClass('font-bold');
                $(`#inputPos${i}`).removeClass('text-white');
                $(`#errorPosAlert${i}`).slideUp(500);
            }

            gridValue = json.results[i].grid;
            gridFractionCheck = gridValue % 1;
            if(isNaN(gridValue) || (gridValue < 1) || (gridFractionCheck != 0)) {
                $(`#resultsBodyGrid${i}`).addClass('bg-red-600');
                $(`#inputGrid${i}`).addClass('bg-red-600');
                $(`#inputGrid${i}`).addClass('font-bold');
                $(`#inputGrid${i}`).addClass('text-white');
                $(`#errorGridAlert${i}`).slideDown(500);
            } else {
                $(`#resultsBodyGrid${i}`).removeClass('bg-red-600');
                $(`#inputGrid${i}`).removeClass('bg-red-600');
                $(`#inputGrid${i}`).removeClass('font-bold');
                $(`#inputGrid${i}`).removeClass('text-white');
                $(`#errorGridAlert${i}`).slideUp(500);
            }

            stopsValue = json.results[i].stops;
            stopsFractionCheck = stopsValue % 1;
            if(isNaN(stopsValue) || (stopsValue < 0) || (stopsFractionCheck != 0)) {
                $(`#resultsBodyStops${i}`).addClass('bg-red-600');
                $(`#inputStops${i}`).addClass('bg-red-600');
                $(`#inputStops${i}`).addClass('font-bold');
                $(`#inputStops${i}`).addClass('text-white');
                $(`#errorStopsAlert${i}`).slideDown(500);
            } else {
                $(`#resultsBodyStops${i}`).removeClass('bg-red-600');
                $(`#inputStops${i}`).removeClass('bg-red-600');
                $(`#inputStops${i}`).removeClass('font-bold');
                $(`#inputStops${i}`).removeClass('text-white');
                $(`#errorStopsAlert${i}`).slideUp(500);
            }
        }
    }

    function isValidTimeFormat(json) {
        let timeExpRace = "^\\+?(\\d+\\:)?[0-5]?\\d[.]\\d{3}$|^DNF$|^DSQ$|^DNS$|^\\+1 Lap$|^\\+[2-9][0-9]* Laps$|^\\-$";
        let timeCheckRace = new RegExp(timeExpRace);
        let timeExpFl = "^(\\d+\\:)?[0-5]?\\d[.]\\d{3}$|^\\-$";
        let timeCheckFl = new RegExp(timeExpFl);
        let postStatus = 1;

        for(let i = 0; i < Object.keys(json.results).length; i++) {
            if(!(timeCheckFl.test(json.results[i].fastestlaptime))) {
                $(`#resultsBodyFl${i}`).addClass('bg-red-600');
                $(`#inputFl${i}`).addClass('bg-red-600');
                $(`#inputFl${i}`).addClass('font-bold');
                $(`#inputFl${i}`).addClass('text-white');
                $(`#errorFlAlert${i}`).slideDown(500);
                postStatus = 0;
            } 
            
            if(!(timeCheckRace.test(json.results[i].time))) {
                $(`#resultsBodyTime${i}`).addClass('bg-red-600');
                $(`#inputTime${i}`).addClass('bg-red-600');
                $(`#inputTime${i}`).addClass('font-bold');
                $(`#inputTime${i}`).addClass('text-white');
                $(`#errorTimeAlert${i}`).slideDown(500);
                postStatus = 0;
            }
        }
        return postStatus;
    }

    function populateTrackDropdowns(season, tracks, points, json, seasonCol, circuitCol, pointsCol) {
        let dataMapping = [
                            {
                                data: season,
                                upload: json.track.season_id,
                                colId: seasonCol
                            },
                            {
                                data: tracks,
                                upload: json.track.circuit_id,
                                colId: circuitCol
                            }
                        ];  

        for(let i = 0; i < dataMapping.length; i++) {
            let selection = "<option hidden selected value> -- Missing ID -- </option>"; 
            let dispValue;
            for(let j = 0; j < dataMapping[i].data.length; j++) {
                dispValue = dataMapping[i].data[j].name;
                if(dataMapping[i].data[j].id != dataMapping[i].upload) {
                    selection += "<option value='"+dataMapping[i].data[j].id+"'>"+dispValue+"</option>";
                } else {
                    dataMapping[i].data[j].id = dataMapping[i].upload;
                    selection += "<option selected value='"+dataMapping[i].data[j].id+"'>"+dispValue+"</option>";
                }
                dataMapping[i].colId.innerHTML = selection;
            }
        }
    }

    function populateResultsDropdowns(driver, constructor, status, json, driverCol, constructorCol, statusCol, i) {
        let dataMapping = [
                            {
                                data: driver,
                                upload: json.results[i].driver_id,
                                colId: driverCol
                            },
                            {
                                data: constructor,
                                upload: json.results[i].constructor_id,
                                colId: constructorCol
                            },
                            {
                                data: status,
                                upload: json.results[i].status,
                                colId: statusCol
                            }
                        ];
            
        for(let x = 0; x < dataMapping.length; x++) {
            let selection = "<option hidden selected value> -- Missing ID -- </option>"; 
            let dispValue;
            for(let j = 0; j < dataMapping[x].data.length; j++) {
                dispValue = dataMapping[x].data[j].name;
                if(dataMapping[x].data == status) {
                    dispValue = dataMapping[x].data[j].value;
                }
                if(dataMapping[x].data[j].id != dataMapping[x].upload) {
                    selection += "<option value='"+dataMapping[x].data[j].id+"'>"+dispValue+"</option>";
                } else {
                    dataMapping[x].data[j].id = dataMapping[x].upload;
                    selection += "<option selected value='"+dataMapping[x].data[j].id+"'>"+dispValue+"</option>";
                }
                dataMapping[x].colId.innerHTML = selection;
            }
        }
    }

    function clearWarnings(json, season, tracks, driver, constructor, status) {
        let dataMappingTrack = [
                                    {
                                        input: json.track.season_id,
                                        stored: season,
                                        innerObj: '#seasonSelect',
                                        outerDiv: '#trackBodySeason',
                                        alert: '#errorSeasonAlert'
                                    },
                                    {
                                        input: json.track.circuit_id,
                                        stored: tracks,
                                        innerObj: '#tracksSelect',
                                        outerDiv: '#trackBodyCircuit',
                                        alert: '#errorCircuitAlert'
                                    },
                                ];
        
        for(let i = 0; i < dataMappingTrack.length; i++) {
            $(dataMappingTrack[i].innerObj).change(function(event) {
                let indexVal = $(dataMappingTrack[i].innerObj).val();
                if(dataMappingTrack[i].stored.find(item => {return item.id == dataMappingTrack[i].input}) == undefined) {
                    if(indexVal == null) {
                        $(dataMappingTrack[i].outerDiv).addClass('bg-red-600');
                        $(dataMappingTrack[i].alert).slideDown(500);
                    } else {
                        $(dataMappingTrack[i].outerDiv).removeClass('bg-red-600');
                        $(dataMappingTrack[i].alert).slideUp(500);
                    } 
                }
            });
        }

        for(let i = 0; i < Object.keys(json.results).length; i++) {
            let dataMappingResults = [
                                        {
                                            input: json.results[i].driver_id,
                                            stored: driver,
                                            innerObj: `#driverSelect${i}`,
                                            outerDiv: `#resultsBodyDriver${i}`,
                                            alert: `#errorDriverAlert${i}`
                                        },
                                        {
                                            input: json.results[i].constructor_id,
                                            stored: constructor,
                                            innerObj: `#constructorSelect${i}`,
                                            outerDiv: `#resultsBodyConstructor${i}`,
                                            alert: `#errorConstructorAlert${i}`
                                        },
                                        {
                                            input: json.results[i].status,
                                            stored: status,
                                            innerObj: `#statusSelect${i}`,
                                            outerDiv: `#resultsBodyStatus${i}`,
                                            alert: `#errorStatusAlert${i}`
                                        },
                                    ];
                                    
            for(let j = 0; j < dataMappingResults.length; j++) {
                $(dataMappingResults[j].innerObj).change(function(event) {
                    let indexVal = $(dataMappingResults[j].innerObj).val();
                    if(dataMappingResults[j].stored.find(item => {return item.id == dataMappingResults[j].input}) == undefined) {
                        if(indexVal == null) {
                            $(dataMappingResults[j].outerDiv).addClass('bg-red-600');
                            $(dataMappingResults[j].alert).slideDown(500);
                        } else {
                            $(dataMappingResults[j].outerDiv).removeClass('bg-red-600');
                            $(dataMappingResults[j].alert).slideUp(500);
                        } 
                    }
                });
            }
            
        }
    }

    function flFormatCheck(value, json, i) {
        let timeExpFl = "^(\\d+\\:)?[0-5]?\\d[.]\\d{3}$|^\\-$";
        let timeCheckFl = new RegExp(timeExpFl);
        
        if(!(timeCheckFl.test(value))) {
            $(`#resultsBodyFl${i}`).addClass('bg-red-600');
            $(`#inputFl${i}`).addClass('bg-red-600');
            $(`#inputFl${i}`).addClass('font-bold');
            $(`#inputFl${i}`).addClass('text-white');
            $(`#errorFlAlert${i}`).slideDown(500);
        } else {
            $(`#resultsBodyFl${i}`).removeClass('bg-red-600');
            $(`#inputFl${i}`).removeClass('bg-red-600');
            $(`#inputFl${i}`).removeClass('font-bold');
            $(`#inputFl${i}`).removeClass('text-white');
            $(`#errorFlAlert${i}`).slideUp(500);
        }
    }

    function raceTimeFormatCheck(value, json, i) {
        let timeExpRace = "^\\+?(\\d+\\:)?[0-5]?\\d[.]\\d{3}$|^DNF$|^DSQ$|^DNS$|^\\+1 Lap$|^\\+[2-9][0-9]* Laps$|^\\-$";
        let timeCheckRace = new RegExp(timeExpRace);
        
        if(!(timeCheckRace.test(value))) {
            $(`#resultsBodyTime${i}`).addClass('bg-red-600');
            $(`#inputTime${i}`).addClass('bg-red-600');
            $(`#inputTime${i}`).addClass('font-bold');
            $(`#inputTime${i}`).addClass('text-white');
            $(`#errorTimeAlert${i}`).slideDown(500);
        } else {
            $(`#resultsBodyTime${i}`).removeClass('bg-red-600');
            $(`#inputTime${i}`).removeClass('bg-red-600');
            $(`#inputTime${i}`).removeClass('font-bold');
            $(`#inputTime${i}`).removeClass('text-white');
            $(`#errorTimeAlert${i}`).slideUp(500);
        }
    }

    function checkPosFormat(value, json, i) {
        let fractionCheck = value % 1;
        if(isNaN(value) || (value < 1) || (fractionCheck != 0)) {
            $(`#resultsBodyPos${i}`).addClass('bg-red-600');
            $(`#inputPos${i}`).addClass('bg-red-600');
            $(`#inputPos${i}`).addClass('font-bold');
            $(`#inputPos${i}`).addClass('text-white');
            $(`#errorPosAlert${i}`).slideDown(500);
        } else {
            $(`#resultsBodyPos${i}`).removeClass('bg-red-600');
            $(`#inputPos${i}`).removeClass('bg-red-600');
            $(`#inputPos${i}`).removeClass('font-bold');
            $(`#inputPos${i}`).removeClass('text-white');
            $(`#errorPosAlert${i}`).slideUp(500);
        }
    }

    function checkGridFormat(value, json, i) {
        let fractionCheck = value % 1;
        if(isNaN(value) || (value < 1) || (fractionCheck != 0)) {
            $(`#resultsBodyGrid${i}`).addClass('bg-red-600');
            $(`#inputGrid${i}`).addClass('bg-red-600');
            $(`#inputGrid${i}`).addClass('font-bold');
            $(`#inputGrid${i}`).addClass('text-white');
            $(`#errorGridAlert${i}`).slideDown(500);
        } else {
            $(`#resultsBodyGrid${i}`).removeClass('bg-red-600');
            $(`#inputGrid${i}`).removeClass('bg-red-600');
            $(`#inputGrid${i}`).removeClass('font-bold');
            $(`#inputGrid${i}`).removeClass('text-white');
            $(`#errorGridAlert${i}`).slideUp(500);
        }
    }

    function checkStopsFormat(value, json, i) {
        let fractionCheck = value % 1;
        if(isNaN(value) || (value < 0) || (fractionCheck != 0)) {
            $(`#resultsBodyStops${i}`).addClass('bg-red-600');
            $(`#inputStops${i}`).addClass('bg-red-600');
            $(`#inputStops${i}`).addClass('font-bold');
            $(`#inputStops${i}`).addClass('text-white');
            $(`#errorStopsAlert${i}`).slideDown(500);
        } else {
            $(`#resultsBodyStops${i}`).removeClass('bg-red-600');
            $(`#inputStops${i}`).removeClass('bg-red-600');
            $(`#inputStops${i}`).removeClass('font-bold');
            $(`#inputStops${i}`).removeClass('text-white');
            $(`#errorStopsAlert${i}`).slideUp(500);
        }
    }

    function checkForError(value) {
        let flag = 0;
        if($(value).hasClass('bg-red-600'))
            flag = 1;
        return flag;
    }

    function undoFields(json) {
        let dataMappingTrack = [
                                    {
                                        undo: '#undoSeason',
                                        field: '#seasonSelect',
                                        jsonValue: json.track.season_id
                                    },
                                    {
                                        undo: '#undoRound',
                                        field: '#inputRound',
                                        jsonValue: json.track.round
                                    },
                                    {
                                        undo: '#undoCircuit',
                                        field: '#tracksSelect',
                                        jsonValue: json.track.circuit_id
                                    }
                                ];
        
        for(let i = 0; i < dataMappingTrack.length; i++) {
            $(dataMappingTrack[i].undo).click(function(event) {
                $(dataMappingTrack[i].field).val(dataMappingTrack[i].jsonValue);
                const e = new Event("change");
                const element = document.querySelector(dataMappingTrack[i].field);
                element.dispatchEvent(e);
            });
        }

        for(let i = 0; i < Object.keys(json.results).length; i++) {
            let dataMappingResults = [
                                    {
                                        undo: `#undoPos${i}`,
                                        field: `#inputPos${i}`,
                                        jsonValue: json.results[i].position
                                    },
                                    {
                                        undo: `#undoDriver${i}`,
                                        field: `#driverSelect${i}`,
                                        jsonValue: json.results[i].driver_id
                                    },
                                    {
                                        undo: `#undoConstructor${i}`,
                                        field: `#constructorSelect${i}`,
                                        jsonValue: json.results[i].constructor_id
                                    },
                                    {
                                        undo: `#undoGrid${i}`,
                                        field: `#inputGrid${i}`,
                                        jsonValue: json.results[i].grid
                                    },
                                    {
                                        undo: `#undoStops${i}`,
                                        field: `#inputStops${i}`,
                                        jsonValue: json.results[i].stops
                                    },
                                    {
                                        undo: `#undoFl${i}`,
                                        field: `#inputFl${i}`,
                                        jsonValue: json.results[i].fastestlaptime
                                    },
                                    {
                                        undo: `#undoTime${i}`,
                                        field: `#inputTime${i}`,
                                        jsonValue: json.results[i].time
                                    },
                                    {
                                        undo: `#undoStatus${i}`,
                                        field: `#statusSelect${i}`,
                                        jsonValue: json.results[i].status
                                    }
                                ];
            
            for(let j = 0; j < dataMappingResults.length; j++) {
                $(dataMappingResults[j].undo).click(function(event) {
                    $(dataMappingResults[j].field).val(dataMappingResults[j].jsonValue);
                    const e = new Event("change");
                    const element = document.querySelector(dataMappingResults[j].field);
                    element.dispatchEvent(e);
                });
            }
        }
    }
</script>
@endsection
