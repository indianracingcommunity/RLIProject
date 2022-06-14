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
    


<div>
    <button id="test" class="bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-2 border border-red-700 rounded">Cancel</button>
    <button id="test2" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">Save</button>
    <input type="text" id="test3" value="Hey"></input>
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

        $('#test3').change(function(event) {
            if($('#test3').val() == "Subham")
                console.log(1)
        });
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
                        //Printing values of track key of json in table
                        $('#trackHeaderFields').toggleClass('hidden');

                        var rowTrack = `<tr class="text-center">
                                            <td class="border rounded py-2 px-1" id="trackBodySeason">
                                                <select id="seasonSelect" class="bg-gray-200 w-48 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                </select>   
                                            </td>
                                            <td class="border rounded p-2" id="trackBodyRound">
                                                <input class="w-12 text-center" type="text" id="inputRound" value="${json.track.round}"\>
                                            </td>
                                            <td class="border rounded py-2 px-1" id="trackBodyCircuit">
                                                <select id="tracksSelect" class="bg-gray-200 w-48 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                </select>
                                            </td>
                                            <td class="border rounded py-2 px-1" id="trackBodyPoints">
                                                <button id="pointsBtn" type="button" class="px-5 bg-gray-300 border border-gray-500 rounded">${json.track.points}</button>
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
                                                    <input class="w-12 text-center" type="text" id="inputPos${i}" value="${json.results[i].position}"\>
                                                </td>
                                                <td class="border rounded py-2 px-1" id="resultsBodyDriver${i}">
                                                    <select id='driverSelect${i}' class="bg-gray-200 w-48 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">
                                                    </select>
                                                </td>
                                                <td class="hidden border rounded p-2">
                                                    <input class="w-12 text-center" type="text" id="inputDriver${i}" value="${json.results[i].driver_id}"\>
                                                </td>
                                                <td class="border rounded py-2 px-1" id="resultsBodyConstructor${i}">
                                                    <select id='constructorSelect${i}' class="bg-gray-200 w-48 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                    </select>
                                                </td>
                                                <td class="border rounded p-2" id="resultsBodyGrid${i}">
                                                    <input class="w-12 text-center" type="text" id="inputGrid${i}" value="${json.results[i].grid}"\>
                                                </td>
                                                <td class="border rounded p-2" id="resultsBodyStops${i}">
                                                    <input class="w-12 text-center" type="text" id="inputStops${i}" value="${json.results[i].stops}"\>
                                                </td>
                                                <td class="border rounded p-2" id="resultsBodyFl${i}">
                                                    <input class="w-24 text-center" type="text" id="inputFl${i}" value="${json.results[i].fastestlaptime}"\>
                                                </td>
                                                <td class="border rounded p-2" id="resultsBodyTime${i}">
                                                    <input class="w-24 text-center" type="text" id="inputTime${i}" value="${json.results[i].time}"\>
                                                </td>
                                                <td class="border rounded py-2 px-1" id="resultsBodyStatus${i}">
                                                    <select id='statusSelect${i}' class="bg-gray-200 w-36 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500">                       
                                                    </select>
                                                </td>
                                            </tr>`;
                            $('#resultsTableBody').append(rowResult);
                            
                            let driverCol = document.getElementById(`driverSelect${i}`);
                            let constructorCol = document.getElementById(`constructorSelect${i}`);
                            let statusCol = document.getElementById(`statusSelect${i}`);
                            populateResultsDropdowns(driver, constructor, status, json, driverCol, constructorCol, statusCol, i);
                        }
                        
                        let defaultSelect;
                        $('#pointsBtn').click(function(event) {
                            $('#pointsOverlay').removeClass('hidden');
                            $('#pointsOverlay').addClass('flex');
                            
                            defaultSelect = '#select' + json.track.points;
                            $(defaultSelect).attr('checked', 'checked');
                        });
                        
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
                        
                        let pointsSelectId;
                        for(let i = 0; i < points.length; i++) {
                            pointsSelectId = '#select' + (i+1);
                            $(pointsSelectId).click(function(event) {
                                $('input:checkbox').not(this).prop('checked', false);
                                $('#pointsBtn').html(i+1);
                                $('#trackBodyPoints').removeClass('bg-red-600');
                                $('#pointsOverlay').removeClass('flex');
                                $('#pointsOverlay').addClass('hidden');
                            });
                        }
                        
                        dataChecks(json, season, tracks, points, driver, constructor, status);
                        isValidTimeFormat(json);
                            
                        clearWarnings(json);

                        for(let i = 0; i < Object.keys(json.results).length; i++) {
                            let flCell = '#inputFl' + i;
                            let timeCell = '#inputTime' + i;
                            let flValue, timeValue;
                            
                            $(flCell).change(function(event) {
                                flValue = $(flCell).val();
                                flFormatCheck(flValue, json, i);
                            });
                            
                            $(timeCell).change(function(event) {
                                timeValue = $(timeCell).val();
                                raceTimeFormatCheck(timeValue, json, i);
                            });
                        }

                        $('#inputRound').change(function(event) {
                            let roundCell = $('#inputRound').val();
                            if(isNaN(roundCell)) {
                                console.log('Round Number field is not a number');
                                $('#trackBodyRound').addClass('bg-red-600');
                                $('#inputRound').addClass('bg-red-600');
                                $('#inputRound').addClass('font-bold');
                                $('#inputRound').addClass('text-white');
                            } else {
                                $('#trackBodyRound').removeClass('bg-red-600');
                                $('#inputRound').removeClass('bg-red-600');
                                $('#inputRound').removeClass('font-bold');
                                $('#inputRound').removeClass('text-white');
                            }
                        });

                        for(let i = 0; i < Object.keys(json.results).length; i++) {
                            let posCell = '#inputPos' + i;
                            let gridCell = '#inputGrid' + i;
                            let stopsCell = '#inputStops' + i;
                            let posValue, gridValue, stopsValue;

                            $(posCell).change(function(event) {
                                posValue = $(posCell).val();
                                isPosNumber(posValue, json, i);
                            });

                            $(gridCell).change(function(event) {
                                gridValue = $(gridCell).val();
                                isGridNumber(gridValue, json, i);
                            });

                            $(stopsCell).change(function(event) {
                                stopsValue = $(stopsCell).val();
                                isStopsNumber(stopsValue, json, i);
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
                            let newJson = {
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
                });
            }
        });
    });

    function tableToJSON(table) {
        let data = [];
        let headers = [];
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

    function dataChecks(json, season, tracks, points, driver, constructor, status) {
        let checkFields = [
                            {
                                input: json.track.season_id,
                                stored: season,
                                message: 'Season ID ' + json.track.season_id + ' not present in DB',
                                cell: '#trackBodySeason'
                            },
                            {
                                input: json.track.circuit_id,
                                stored: tracks,
                                message: 'Circuit ID ' + json.track.circuit_id + ' not present in DB',
                                cell: '#trackBodyCircuit'
                            },
                            {
                                input: json.track.points,
                                stored: points,
                                message: 'Points ID ' + json.track.points + ' not present in DB',
                                cell: '#trackBodyPoints'
                            },
                            
                        ];
        
        for(let i = 0; i < checkFields.length; i++) {
            if(checkFields[i].stored.find(item => {return item.id == checkFields[i].input}) == undefined) {
                console.log(checkFields[i].message);
                $(checkFields[i].cell).addClass('bg-red-600');
                if(i == 2)
                    $('#pointsBtn').html('0');
            }
        }

        let value = json.track.round;
        if(isNaN(value)) {
            console.log('Round Number field is not a number');
            $('#trackBodyRound').addClass('bg-red-600');
            $('#inputRound').addClass('bg-red-600');
            $('#inputRound').addClass('font-bold');
            $('#inputRound').addClass('text-white');
        } else {
            $('#trackBodyRound').removeClass('bg-red-600');
            $('#inputRound').removeClass('bg-red-600');
            $('#inputRound').removeClass('font-bold');
            $('#inputRound').removeClass('text-white');
        }
        
        for(let i = 0; i < Object.keys(json.results).length; i++) {
            let tableCell;
            let posValue, gridValue, stopsValue;
            let posInputCell, posTableCell, gridInputCell, gridTableCell, stopsInputCell, stopsTableCell;
            
            if(driver.find(item => {return item.id == json.results[i].driver_id}) == undefined) {
                let positionId = json.results[i].position;
                let driverId = json.results[i].driver_id;
                console.log('Driver ID ' + driverId + ' not present in DB for position ' + positionId);
                tableCell = '#resultsBodyDriver' + i;
                $(tableCell).addClass('bg-red-600');
            }

            if(constructor.find(item => {return item.id == json.results[i].constructor_id}) == undefined) {
                let positionId = json.results[i].position;
                let constructorId = json.results[i].constructor_id;
                console.log('Contructor ID ' + constructorId + ' not present in DB for position ' + positionId);
                tableCell = '#resultsBodyConstructor' + i;
                $(tableCell).addClass('bg-red-600');
            }

            if(status.find(item => {return item.id == json.results[i].status}) == undefined) {
                let positionId = json.results[i].position;
                let statusId = json.results[i].status;
                console.log('Contructor ID ' + statusId + ' not present in DB for position ' + positionId);
                tableCell = '#resultsBodyStatus' + i;
                $(tableCell).addClass('bg-red-600');
            }

            posValue = json.results[i].position;
            if(isNaN(posValue)) {
                posTableCell = '#resultsBodyPos' + i;
                posInputCell = '#inputPos' + i;
                console.log('Position field is not a number for position ' + (i+1));
                $(posTableCell).addClass('bg-red-600');
                $(posInputCell).addClass('bg-red-600');
                $(posInputCell).addClass('font-bold');
                $(posInputCell).addClass('text-white');
            } else {
                $(posTableCell).removeClass('bg-red-600');
                $(posInputCell).removeClass('bg-red-600');
                $(posInputCell).removeClass('font-bold');
                $(posInputCell).removeClass('text-white');
            }

            gridValue = json.results[i].grid;
            if(isNaN(gridValue)) {
                let positionId = json.results[i].position;
                gridTableCell = '#resultsBodyGrid' + i;
                gridInputCell = '#inputGrid' + i;
                console.log('Starting Grid field is not a number for position ' + positionId);
                $(gridTableCell).addClass('bg-red-600');
                $(gridInputCell).addClass('bg-red-600');
                $(gridInputCell).addClass('font-bold');
                $(gridInputCell).addClass('text-white');
            } else {
                $(gridTableCell).removeClass('bg-red-600');
                $(gridInputCell).removeClass('bg-red-600');
                $(gridInputCell).removeClass('font-bold');
                $(gridInputCell).removeClass('text-white');
            }

            stopsValue = json.results[i].stops;
            if(isNaN(stopsValue)) {
                let positionId = json.results[i].position;
                stopsTableCell = '#resultsBodyStops' + i;
                stopsInputCell = '#inputStops' + i;
                console.log('Laps Completed field is not a number for position ' + positionId);
                $(stopsTableCell).addClass('bg-red-600');
                $(stopsInputCell).addClass('bg-red-600');
                $(stopsInputCell).addClass('font-bold');
                $(stopsInputCell).addClass('text-white');
            } else {
                $(stopsTableCell).removeClass('bg-red-600');
                $(stopsInputCell).removeClass('bg-red-600');
                $(stopsInputCell).removeClass('font-bold');
                $(stopsInputCell).removeClass('text-white');
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
            let tableCell, inputCell;
            if(!(timeCheckFl.test(json.results[i].fastestlaptime))) {
                let positionId = json.results[i].position;
                console.log('Fastest lap format wrong for position ' + positionId);
                tableCell = '#resultsBodyFl' + i;
                inputCell = '#inputFl' + i;
                $(tableCell).addClass('bg-red-600');
                $(inputCell).addClass('bg-red-600');
                $(inputCell).addClass('font-bold');
                $(inputCell).addClass('text-white');
                postStatus = 0;
            } 
            
            if(!(timeCheckRace.test(json.results[i].time))) {
                let positionId = json.results[i].position;
                console.log('Race time format wrong for position ' + positionId);
                tableCell = '#resultsBodyTime' + i;
                inputCell = '#inputTime' + i;
                $(tableCell).addClass('bg-red-600');
                $(inputCell).addClass('bg-red-600');
                $(inputCell).addClass('font-bold');
                $(inputCell).addClass('text-white');
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
            let selection = "<option hidden style='color: #ff0000' selected value> -- Missing ID -- </option>"; 
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

    function clearWarnings(json) {
        let dataMapping = [
                            {
                                innerObj: '#seasonSelect',
                                outerDiv: '#trackBodySeason'
                            },
                            {
                                innerObj: '#tracksSelect',
                                outerDiv: '#trackBodyCircuit'
                            },
                        ];
        
        for(let i = 0; i < dataMapping.length; i++) {
            $(dataMapping[i].innerObj).change(function(event) {
                $(dataMapping[i].outerDiv).removeClass('bg-red-600');
            });
        }

        for(let i = 0; i < Object.keys(json.results).length; i++) {
            let selectDriver = '#driverSelect' + i;
            let driverDiv = '#resultsBodyDriver' + i;
            let selectConstructor = '#constructorSelect' + i;
            let constructorDiv = '#resultsBodyConstructor' + i;
            let selectStatus = '#statusSelect' + i;
            let statusDiv = '#resultsBodyStatus' + i;
            
            $(selectDriver).change(function(event) {
                $(driverDiv).removeClass('bg-red-600');
            });
            
            $(selectConstructor).change(function(event) {
                $(constructorDiv).removeClass('bg-red-600');
            });
            
            $(selectStatus).change(function(event) {
                $(statusDiv).removeClass('bg-red-600');
            });
        }
    }

    function flFormatCheck(value, json, i) {
        let timeExpFl = "^(\\d+\\:)?[0-5]?\\d[.]\\d{3}$|^\\-$";
        let timeCheckFl = new RegExp(timeExpFl);
        let tableCell, inputCell;
        tableCell = '#resultsBodyFl' + i;
        inputCell = '#inputFl' + i;
        
        if(!(timeCheckFl.test(value))) {
            let positionId = json.results[i].position;
            console.log('Fastest lap format wrong for position ' + positionId);
            $(tableCell).addClass('bg-red-600');
            $(inputCell).addClass('bg-red-600');
            $(inputCell).addClass('font-bold');
            $(inputCell).addClass('text-white');
        } else {
            $(tableCell).removeClass('bg-red-600');
            $(inputCell).removeClass('bg-red-600');
            $(inputCell).removeClass('font-bold');
            $(inputCell).removeClass('text-white');
        }
    }

    function raceTimeFormatCheck(value, json, i) {
        let timeExpRace = "^\\+?(\\d+\\:)?[0-5]?\\d[.]\\d{3}$|^DNF$|^DSQ$|^DNS$|^\\+1 Lap$|^\\+[2-9][0-9]* Laps$|^\\-$";
        let timeCheckRace = new RegExp(timeExpRace);
        let tableCell, inputCell;
        tableCell = '#resultsBodyTime' + i;
        inputCell = '#inputTime' + i;
        
        if(!(timeCheckRace.test(value))) {
            let positionId = json.results[i].position;
            console.log('Race time format wrong for position ' + positionId);
            $(tableCell).addClass('bg-red-600');
            $(inputCell).addClass('bg-red-600');
            $(inputCell).addClass('font-bold');
            $(inputCell).addClass('text-white');
        } else {
            $(tableCell).removeClass('bg-red-600');
            $(inputCell).removeClass('bg-red-600');
            $(inputCell).removeClass('font-bold');
            $(inputCell).removeClass('text-white');
        }
    }

    function isPosNumber(value, json, i) {
        let tableCell, inputCell;
        tableCell = '#resultsBodyPos' + i;
        inputCell = '#inputPos' + i;
        if(isNaN(value)) {
            console.log('Position field is not a number for position ' + (i+1));
            $(tableCell).addClass('bg-red-600');
            $(inputCell).addClass('bg-red-600');
            $(inputCell).addClass('font-bold');
            $(inputCell).addClass('text-white');
        } else {
            $(tableCell).removeClass('bg-red-600');
            $(inputCell).removeClass('bg-red-600');
            $(inputCell).removeClass('font-bold');
            $(inputCell).removeClass('text-white');
        }
    }

    function isGridNumber(value, json, i) {
        let tableCell, inputCell;
        tableCell = '#resultsBodyGrid' + i;
        inputCell = '#inputGrid' + i;
        if(isNaN(value)) {
            let positionId = json.results[i].position;
            console.log('Starting Grid field is not a number for position ' + positionId);
            $(tableCell).addClass('bg-red-600');
            $(inputCell).addClass('bg-red-600');
            $(inputCell).addClass('font-bold');
            $(inputCell).addClass('text-white');
        } else {
            $(tableCell).removeClass('bg-red-600');
            $(inputCell).removeClass('bg-red-600');
            $(inputCell).removeClass('font-bold');
            $(inputCell).removeClass('text-white');
        }
    }

    function isStopsNumber(value, json, i) {
        let tableCell, inputCell;
        tableCell = '#resultsBodyStops' + i;
        inputCell = '#inputStops' + i;
        if(isNaN(value)) {
            let positionId = json.results[i].position;
            console.log('Laps Completed field is not a number for position ' + positionId);
            $(tableCell).addClass('bg-red-600');
            $(inputCell).addClass('bg-red-600');
            $(inputCell).addClass('font-bold');
            $(inputCell).addClass('text-white');
        } else {
            $(tableCell).removeClass('bg-red-600');
            $(inputCell).removeClass('bg-red-600');
            $(inputCell).removeClass('font-bold');
            $(inputCell).removeClass('text-white');
        }
    }
</script>
@endsection
