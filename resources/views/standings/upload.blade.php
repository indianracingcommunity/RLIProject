@extends('layouts.app')
@section('content')

<style>
    .disable {
        opacity: 0.75;
        cursor: not-allowed;
        pointer-events: none;
    }

    .disableActionBtns {
        cursor: not-allowed;
        pointer-events: none;
        background-color: #a0aec0;
        border-color: #4a5568;
    }

    .tooltip {
        position: relative;
    }

    .tooltip::after {
        content: "Clear 'RACE TIME' errors";
        background-color: #333;
        border-radius: 10px;
        color: #ffffff;
        display: none;
        padding: 10px 15px;
        width: 100%;
        position: absolute;
        text-align: center;
        font-size: 14px;
        z-index: 999;
        top: 0;
        left: 50%;
        transform: translate(-50%, calc(-100% - 10px));
    }

    .tooltip::before {
        background-color: #333;
        content: ' ';
        display: none;
        position: absolute;
        width: 30px;
        height: 30px;
        z-index: 999;
        top: 0;
        left: 50%;
        transform: translate(-50%, calc(-100% - 5px)) rotate(45deg);
    }

    .tooltip:hover::after {
        display: block;
    }

    .tooltip:hover::before {
        display: block;
    }

    #reviewJSONTextArea:focus {
        outline: none !important;
        border: none !important;
    }
</style>

<!-- Screen to show various JSON selection methods for upload -->
<div id="homeScreen">
    <div id="missingTrackAlert" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 py-2 px-4 my-4 rounded" role="alert">
        <p><strong>Track Key</strong> [track] is missing in the uploaded JSON</p>
    </div>
    
    <div id="missingResultsAlert" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 py-2 px-4 my-4 rounded" role="alert">
        <p><strong>Results Key</strong> [results] is missing in the uploaded JSON</p>
    </div>

    <div id="JSONFormatErrorsAlert" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 py-2 px-4 my-4 rounded" role="alert">
        <span><strong>JSON Format Error</strong></span>
        <span id="JSONFormatErrorMessage"></span>
        <span>
            [<a id="JSLintHrefLink" href="" class="text-blue-700" target="_blank"><strong><u>Click Here</u></strong></a> to validate JSON]
        </span>
    </div>

    <div id="positionKeyErrorAlert" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 py-2 px-4 my-4 rounded" role="alert">
    </div>

    <div id="incorrectRaceNumber" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 py-2 px-4 my-4 rounded" role="alert">
        <p><strong>Race ID</strong> is not valid</p>
    </div>

    <p class="mt-5 text-4xl font-bold">Choose a starting point</p>
    <hr>

    <div class="flex flex-row mt-10 mb-8 justify-center gap-10">
        <!-- Upload an existing valid JSON -->
        <div class="flex flex-col align-items justify-center border-solid border-4 border-purple-500 py-32 px-24 rounded-md">
            <p class="text-3xl font-semibold mb-3 text-gray-500">Edit a new valid JSON</p>
            <input id="fileInput" type="file" class="hidden"/>
            <label id="fileInputLabel" for="fileInput" class="text-center bg-purple-500 hover:bg-purple-700 text-white font-semibold py-2 px-4 border border-purple-700 rounded cursor-pointer">Upload JSON</label>
        </div>

        <!-- Import an uploaded race JSON -->
        <div class="flex flex-col align-items justify-end border-solid border-4 border-red-500 py-32 px-24 rounded-md">
            <p class="text-3xl font-semibold mb-4 text-gray-500">Import uploaded race result</p>
            <div class="flex flex-row gap-2 mb-1">
                <p class="text-xl text-gray-700 font-semibold">Enter race id: </p>
                <input class="w-16 text-lg text-center font-semibold" type="number" id="raceNumber" min="1" value="1"/>
            </div>
            <button id="importRace" class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 border border-red-700 rounded">Import JSON</button>
        </div>
    </div>
    
    <!-- Start from an empty JSON -->
    <div class="flex flex-row align-items justify-center gap-3">
        <p class="text-2xl font-semibold text-gray-500">Don't have a reference point?</p>
        <button id="scratch" class="px-2 bg-orange-500 hover:bg-orange-700 text-white font-semibold border rounded">Start from scratch</button>
    </div>

    <div class="flex flex-row align-items justify-center mt-6">
        <button id="moreOptionsBtn" class="px-2 py-1 bg-gray-500 hover:bg-gray-700 text-white font-semibold border border-gray-700 rounded">
            Additional options
            <i class="fa fa-arrow-down pl-1" aria-hidden="true"></i>
        </button>
    </div>
   
    <div id="moreOptionsContent" class="flex flex-row align-items justify-center mt-3 gap-5">
        <div class="flex flex-row gap-2">
            <input class="cursor-pointer" type="checkbox" id="noPointsForFlCheck" />
            <label class="cursor-pointer" for="noPointsForFlCheck">No points for fastest lap</label>
        </div>

        <div class="flex flex-row gap-2">
            <input class="cursor-pointer" type="checkbox" id="bypassConstructorsCheck" />
            <label class="cursor-pointer" for="bypassConstructorsCheck">Populate all constructors in dropdowns</label>
        </div>
    </div>

</div>

<!-- Screen to edit details in the uploaded JSON with validation checks -->
<div id="editScreen">
    <div class="flex flex-row justify-between items-center">
        <p class="mt-5 text-4xl font-bold">Review all fields</p>
        
        <div class="flex flex-row gap-3">
            <button id="startOver" class="flex items-center justify-center gap-3 bg-red-500 hover:bg-red-700 text-white font-semibold px-4 py-2 border border-red-700 rounded">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                Start Over
            </button>

            <button id="toggleControls" class="flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-700 text-white font-semibold px-4 py-2 border border-blue-700 rounded">
                <i class="fas fa-edit" aria-hidden="true"></i>
                Edit
            </button>
        </div>
    </div>
    <hr>
    
    <div id="showAdditionsInfoDiv" class="flex flex-row gap-3 mt-2">
        <p class="text-sm text-yellow-600 font-bold">Selected options:</p>
        <p id="showNoFlPointsInfo" class="text-sm text-gray-600 font-bold">No points for fastest lap</p>
        <p id="showPopulateAllConstructorsInfo" class="text-sm text-gray-600 font-bold">Populate all constructors in dropdowns</p>
    </div>
    
    <div class="w-7/12 rounded mb-10 my-2">
        <p class="mt-5 text-xl text-gray-600 font-bold">Track and season</p>

        <!-- Shows a warning when round no. and season id combination is already present in DB -->
        <div id="warningSeasonRoundSameAsInitialAlert" class="hidden w-1/2 bg-yellow-100 border-l-4 text-sm border-yellow-500 text-yellow-700 py-1 px-3 mb-2 rounded" role="alert">
            <p><strong>SEASON</strong> and <strong>ROUND NUMBER</strong> should not be same as that of an exising race result</p>
        </div>

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

        <table id="trackDetailsTable" class="w-full shadow-lg table-auto mt-1">
            <thead id="trackTableHeaders" class="hidden text-center bg-purple-500 text-white">
                <tr>
                    <th class="border w-32 font-bold rounded px-4 py-2">Season</th>
                    <th class="border w-32 font-bold rounded px-4 py-2 w-">Round Number</th>
                    <th class="border w-32 font-bold rounded px-4 py-2">Circuit</th>
                    <th class="border w-32 font-bold rounded px-4 py-2">Points Scheme</th>
                    <th class="border w-32 font-bold rounded px-4 py-2">More Details</th>
                </tr>
            </thead>
            <tbody class="bg-white" id="trackTableBody">
            </tbody> 
        </table>
    </div>

    <div class="w-full rounded mb-8">
        <div class="flex flex-row items-center justify-between">
            <p class="mt-1 text-xl text-gray-600 font-bold">Finishing order</p>

            <div class="flex flex-row items-center justify-center gap-3">
                <div id="rowReorderBtnWrapper" class="cursor-pointer">
                    <button id="rowReorderToggleBtn" class="flex flex-row items-center justify-center gap-2 bg-white text-sm hover:bg-orange-500 text-orange-700 font-semibold hover:text-white py-1 px-2 border border-orange-500 hover:border-transparent rounded">
                        Show Row Reorder
                    </button>
                </div>
            
                <button id="undoToggleBtn" class="flex flex-row items-center justify-center gap-2 bg-white text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                    Show Reset
                </button>

                <div id="raceTimeFormatBtnWrapper" class="cursor-pointer">
                    <button id="raceTimeFormatToggleBtn" class="flex flex-row items-center justify-center gap-2 bg-white text-sm hover:bg-red-500 text-red-700 font-semibold hover:text-white py-1 px-2 border border-red-500 hover:border-transparent rounded">
                        Show Intervals
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-2">
            <div id="warningNoPosWithStatus1Alert" class="hidden w-3/4 bg-yellow-100 border-l-4 text-sm border-yellow-500 text-yellow-700 py-1 px-3 mb-2 rounded" role="alert">
                <p>No row has 'Fastest Lap' <strong>STATUS</strong></p>
            </div>

            <div id="warningFlStatusNotMatchingAlert" class="hidden w-3/4 bg-yellow-100 border-l-4 text-sm border-yellow-500 text-yellow-700 py-1 px-3 mb-2 rounded" role="alert"></div>

            <div id="warningFlBelowP10Alert" class="hidden w-3/4 bg-yellow-100 border-l-4 text-sm border-yellow-500 text-yellow-700 py-1 px-3 mb-2 rounded" role="alert"></div>

            <div id="warningRaceTimeFirstPosNotAbsoluteAlert" class="hidden w-3/4 bg-yellow-100 border-l-4 text-sm border-yellow-500 text-yellow-700 py-1 px-3 mb-2 rounded" role="alert">
                <p><strong>RACE TIME</strong> of Row <strong>1</strong> is not an absolute time in format: <strong>'1:06.006'</strong></p>
            </div>

            <div id="errorResultsAlerts"></div>
        </div>

        <table id="resultsDetailsTable" class="w-full table-auto shadow-lg mt-1">
            <thead id="resultsTableHeaders" class="hidden text-center bg-purple-500 text-white">
                <tr>
                    <th class="border w-32 font-bold rounded px-4 py-2">Position</th>
                    <th class="border w-32 font-bold rounded px-4 py-2">Driver</th>
                    <th class="hidden border w-32 font-bold rounded px-4 py-2">Driver ID</th>
                    <th class="border w-32 font-bold rounded px-4 py-2">Constructor</th>
                    <th class="border w-32 font-bold rounded px-4 py-2">Starting Grid</th>
                    <th class="border w-32 font-bold rounded px-4 py-2">Laps Completed</th>
                    <th class="border w-32 font-bold rounded px-4 py-2">Fastest Lap</th>
                    <th class="border w-32 rounded px-4 py-2 raceTimeCol absoluteTime">
                        <div class="font-bold">
                            Race Time
                        </div>
                        <div id="raceTimeFormatText" class="font-light">
                            [Absolute]
                        </div>
                    </th>
                    <th class="border w-32 font-bold rounded px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white" id="resultsTableBody">
            </tbody>
        </table>

        <div id="addRemoveRowControls" class="hidden pt-3 justify-center items-center gap-5">
            <button id="addRow" class="bg-green-500 hover:bg-green-700 text-white font-semibold px-3 py-1 border border-green-700 rounded mr-2">+</button>
            
            <button id="removeRow" class="bg-red-500 hover:bg-red-700 text-white font-semibold px-3 py-1 border border-red-700 rounded">-</button>
        </div>
    </div>

    <div class="flex justify-center items-center gap-3">
        <button id="submitJSON" class="hidden bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 border border-red-700 rounded">Submit</button>

        <a id="reviewJSON" class="hidden bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 border border-blue-700 rounded cursor-pointer">Review JSON</a>
    </div>

    <div class="flex justify-center items-center mt-2">
        <div id="errorSubmitJSONAlert" class="hidden w-auto bg-red-100 border-l-4 border-r-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
            <p>Please clear all the<strong> ERRORS </strong> before submitting</p>
        </div>
    </div>

    <div id="pointsSelectionOverlay" class="bg-black bg-opacity-50 fixed inset-0 hidden justify-center items-start w-screen max-h-screen">
        <div class="my-6 bg-gray-200 rounded-lg w-3/4 max-h-screen py-2 px-3 shadow-xl">
            <div class="flex justify-between items-center border-b border-gray-400">
                <h4 class="p-2 text-lg md:text-xl font-bold">Points scheme details</h4>
                <svg class="w-6 h-7 cursor-pointer hover:bg-gray-400 rounded-sm cross" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="close-modal"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            
            <div>
                <p class="text-center text-red-600 text-md md:text-lg font-bold pt-3 pb-1">Choose the required points scheme</p>
            </div>
            
            <div class="justify-center px-4 py-2 w-full h-screen overflow-scroll" style="max-height: 80vh">
                <table id="pointsTable" class="table-auto">
                    <thead id="pointsTableHeaders" class="text-center bg-purple-500 text-white">
                    </thead>
                    <tbody class="bg-white" id="pointsTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="additionalDetailsInputOverlay" class="bg-black bg-opacity-50 fixed inset-0 hidden justify-center items-start w-screen max-h-screen">
        <div class="my-6 bg-gray-200 rounded-lg w-2/5 max-h-screen py-2 px-3 shadow-xl">
            <div class="flex justify-between items-center border-b border-gray-400">
                <h4 class="p-2 text-lg md:text-xl font-bold">Add more details</h4>
                <svg class="w-6 h-7 cursor-pointer hover:bg-gray-400 rounded-sm cross" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="close-modal"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>

            <div class="flex flex-row items-center justify-evenly my-3">
                <div class="flex flex-col items-center justify-center">
                    <p id="infoTitle" class="text-gray-600 text-md md:text-lg font-semibold mb-2"></p>

                    <table class="table-auto">
                        <thead class="text-center bg-gray-500 text-white">
                            <th id="infoHeader1" class="border rounded font-bold px-4 py-2"></th>
                            <th id="infoHeader2" class="border rounded font-bold px-4 py-2"></th>
                            <th id="infoHeader3" class="border rounded font-bold px-4 py-2"></th>
                        </thead>
                        
                        <tbody class="text-center bg-white">
                            <td id="infoValue1" class="border rounded disable px-4 py-2"></td>
                            <td id="infoValue2" class="border rounded disable px-4 py-2"></td>
                            <td id="infoValue3" class="border rounded disable px-4 py-2"></td>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-row items-center justify-evenly my-10">
                <div class="flex flex-col items-center justify-center">
                    <p class="text-gray-600 text-md md:text-lg font-semibold mb-2">Additional attributes</p>

                    <table id="additionalDetailsTable" class="table-auto">
                        <thead id="additionalDetailsTableHeaders" class="text-center bg-purple-500 text-white">
                            <th class="border rounded font-bold px-4 py-2">Attribute</th>
                            <th class="border rounded font-bold px-4 py-2">Value</th>
                        </thead>
                        
                        <tbody class="text-center bg-white" id="additionalDetailsTableBody">
                            <tr id="attributeRow" class="text-center">
                                <td id="attributeName" class="border rounded px-4 py-2 font-bold"></td>
                                <td class="flex justify-center items-center border rounded px-4 py-2">
                                    <input id="attributeValue" class="text-center font-bold" type="number" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="reviewJSONOverlay" class="bg-black bg-opacity-50 fixed inset-0 hidden justify-center items-start w-screen max-h-screen">
        <div class="my-6 bg-gray-200 rounded-lg w-2/5 max-h-screen py-2 px-3 shadow-xl">
            <div class="flex justify-between items-center border-b border-gray-400">
                <h4 class="p-2 text-lg md:text-xl font-bold">Review final JSON details</h4>
                <svg class="w-6 h-7 cursor-pointer hover:bg-gray-400 rounded-sm cross" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="close-modal"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>

            <div class="justify-center mt-2 px-4 py-2 w-full h-screen" style="max-height: 80vh">
                <textarea name="" id="reviewJSONTextArea" class="w-full h-full px-3 py-2 rounded-md"></textarea>
            </div>
        </div>
    </div>
</div>

<!-- Screen 3 to show server response and post result upload scenario -->
<div id="serverResponseScreen">
    <div class="flex justify-center items-center my-10">
        <div id="onSuccess" class="flex flex-col items-center justify-center gap-3 w-full text-center text-lg bg-green-100 border-l-4 border-r-4 border-green-500 text-green-700 px-2 py-24 rounded" role="alert">
            <i class="text-6xl mb-2 fa fa-check-circle" aria-hidden="true"></i> 

            <p class="text-5xl font-bold mb-2">Success!</p>

            <div id="raceID" class="text-3xl mb-2"></div>

            <div class="flex flex-row justify-center items-center gap-5 mt-5">
                <button class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 border border-red-700 rounded homeBtn">Upload more</button>

                <a id="download" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 border border-blue-700 rounded cursor-pointer">Download result</a>
            </div>
        </div>
    </div>

    <div class="flex justify-center items-center my-10">
        <div id="onFailure" class="flex flex-col items-center justify-center gap-3 w-full text-center text-lg bg-red-100 border-l-4 border-r-4 border-red-500 text-red-700 px-2 py-24 rounded" role="alert">
            <i class="text-6xl mb-2 fa fa-times" aria-hidden="true"></i>
            
            <p class="text-5xl font-bold mb-2">Failed!</p>

            <p id="failureText" class="text-3xl mb-2"></p>

            <div class="flex flex-row justify-center items-center gap-5 mt-5">
                <button id="backToEditScreen" class="flex items-center justify-center gap-3 bg-blue-500 hover:bg-blue-700 text-white font-semibold px-4 py-2 border border-blue-700 rounded">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    Back
                </button>

                <button class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 border border-red-700 rounded homeBtn">Start Over</button>
            </div>
        </div>
    </div>
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
        var currentAddRowSelected = 0;
        var currentPointsSchemeSelected = 1;
        // {
        //     0: 'Finished',
        //     1: 'Fastest Lap',
        //     -2: 
        // }
        // console.log(points);
        
        // $('#homeScreen').toggleClass('hidden');
        $('#editScreen').toggleClass('hidden');
        $('#serverResponseScreen').toggleClass('hidden');

        $('#moreOptionsContent').toggleClass('hidden');
        $('#moreOptionsBtn').click(function(event) {
            $('#moreOptionsContent').toggleClass('hidden');

            if($('#moreOptionsBtn').hasClass('open')) {
                $('#moreOptionsBtn').removeClass('bg-gray-700 hover:bg-gray-500 open');
                $('#moreOptionsBtn').addClass('bg-gray-500 hover:bg-gray-700');
                $('#moreOptionsBtn').html('Additional options <i class="fa fa-arrow-down pl-1" aria-hidden="true"></i>');
            }
            else {
                $('#moreOptionsBtn').removeClass('bg-gray-500 hover:bg-gray-700');
                $('#moreOptionsBtn').addClass('bg-gray-700 hover:bg-gray-500 open');
                $('#moreOptionsBtn').html('Additional options <i class="fa fa-arrow-up pl-1" aria-hidden="true"></i>');
            }
        })

        $('#startOver').click(function(event) {
            let choice = window.confirm('Are you sure you want to start over?')
            if(choice) {
                $('#startOver').html('<i class="fas fa-sync fa-spin"></i> Start Over');
                location.reload(true);
            }     
        });
        
        $('.homeBtn').click(function(event) {
            location.reload(true);
            $('.homeBtn').html('<i class="fas fa-sync fa-spin"></i>');
        });

        $('#backToEditScreen').click(function(event) {
            $('#serverResponseScreen').toggleClass('hidden');
            $('#submitJSON').html('Submit');
            $('#editScreen').toggleClass('hidden');
        });

        $('#undoToggleBtn').addClass('hidden');
        $('#rowReorderToggleBtn').addClass('hidden');
        // $('#toggleAddMore').addClass('hidden');

        $('#showAdditionsInfoDiv').addClass('hidden');
        $('#showNoFlPointsInfo').addClass('hidden');
        $('#showPopulateAllConstructorsInfo').addClass('hidden');

        let importBtn = document.getElementById('importRace');
        importBtn.addEventListener('click', function(event) {
            // check if race id is a number and greater than 0
            let raceNumber = $('#raceNumber').val();
            
            // add a case for when entered number is greater than the last uploaded id
            if(raceNumber === '' || raceNumber === '0') {
                $('#incorrectRaceNumber').slideDown(500);
            }
            else {
                $('#incorrectRaceNumber').slideUp(500);
                $('#importRace').html('<i class="fas fa-spinner fa-spin"></i>');
                // fetch the race track details and finishing order based on the selected race id
                fetchResultByIDAndPassForEdit(raceNumber, season, points, tracks, constructor, driver, status);
            }
        });

        let scratchBtn = document.getElementById('scratch');
        scratchBtn.addEventListener('click', function(event) {
            let json = {
                        track: {
                            circuit_id: 0,
                            season_id: 0,
                            round: 0,
                            points: 0
                        },
                        results: [
                            {
                                position: 1,
                                constructor_id: 0,
                                grid: 0,
                                stops: -1,
                                time: "",
                                fastestlaptime: "",
                                status: -2,
                                driver_id: 0,
                                driver: ""
                            }
                        ]
            }
            let isResultImportedOrFromScratch = -1;

            viewJSONData(json, season, points, tracks, constructor, driver, status, isResultImportedOrFromScratch);

            $('#toggleControls').removeClass('bg-blue-500 hover:bg-blue-700 border-blue-700');
            $('#toggleControls').addClass('bg-green-500 hover:bg-green-700 border-green-700');
            $('#toggleControls').toggleClass('editing');

            $('.selectInp').attr('disabled', false);
            $('.selectInp').addClass('open');
            $('.selectInp').removeClass('cursor-not-allowed');
            $('.numInp').removeClass('disable');
            $('.numInp').removeClass('cursor-not-allowed');
            $('.addMoreBtn').removeClass('disable');
            $('.addMoreBtn').removeClass('cursor-not-allowed');
            $('#addMoreTrack').removeClass('disable');
            $('#addMoreTrack').removeClass('cursor-not-allowed');

            $('#undoToggleBtn').toggleClass('hidden');
            $('#rowReorderToggleBtn').toggleClass('hidden');

            $('#addRemoveRowControls').toggleClass('hidden');
            $('#removeRow').removeClass('hover:bg-red-700');
            $('#removeRow').addClass('opacity-50 cursor-not-allowed');
        })

        //JS to upload JSON, slot values into table
        let uploadBtn = document.getElementById('fileInput');
        uploadBtn.addEventListener('change', function() {
            //Execute only when a file is selected/uploaded
            if(uploadBtn.files.length > 0) {
                let reader = new FileReader();
                //Reading the uploaded JSON
                reader.readAsText(uploadBtn.files[0]);
                //Execute when reader has read the file
                reader.addEventListener('load', function() {
                    //Parse the JSON into an object
                    let json = parseJSONWithErrorHandling(reader.result);
                    // console.log(json.track.points);

                    if(checkJsonKeys(json) && isAllPositionKeysPresentAndValidWithoutDuplicates(json.results)) {
                        // for(let i = 0; i < json.results.length; i++) {
                        //     let pos = json.results[i].position;
                        //     let isFraction = pos % 1;
                            
                        //     if((pos < 1) || (pos > json.results.length) || (pos == '') || (pos == '.') || (isFraction != 0)) {
                        //         pos = NaN;
                        //     }
    
                        //     json.results[i].position = pos; 
                        // }
                        
                        // json.results.sort((a,b) => a.position - b.position || isNaN(a.position) - isNaN(b.position));
                        json.results.sort((a,b) => a.position - b.position);
                        viewJSONData(json, season, points, tracks, constructor, driver, status);
                        
                        $('.numInp').addClass('disable');
                        $('.numInp').addClass('cursor-not-allowed');
                        $('.addMoreBtn').addClass('disable');
                        $('.addMoreBtn').addClass('cursor-not-allowed');
                        $('#addMoreTrack').addClass('disable');
                        $('#addMoreTrack').addClass('cursor-not-allowed');

                        enableEditOnErrorAfterLoading(json);
                    }
                });
                uploadBtn.value = '';
            }
        });
    });

    function viewJSONData(json, season, points, tracks, constructor, driver, status, isResultImportedOrFromScratch = 0) {
        $('#homeScreen').toggleClass('hidden');
        $('#editScreen').toggleClass('hidden');
        
        let originalStatusMinusUnitsPlace = [], indexPosMap = [], additionalResultsPoints = [];
        let raceTimeInIntervals = [], raceTimeInAbsolutes = [];
        let driverIDStore = [], gridStore = [], stopsStore = [], statusStore = [];
        let trackDetailsStore = {season: json.track.season_id, round: json.track.round};
        // let resultsExtraDetailsStore = {maxLapsCompleted: json.results[0].stops};
        let isPointsUndefined = points.find(item => {return item.id === json.track.points}) === undefined ? true : false;
        let isResultImported = {currentVal: isResultImportedOrFromScratch, originalVal: isResultImportedOrFromScratch};
        
        let noPointsForFL = $('#noPointsForFlCheck').is(':checked');

        if(!json.track.hasOwnProperty('round')) json.track.round = '';
        
        let unitsPlace;
        for(let i = 0; i < json.results.length; i++) {
            // originalStatusMinusUnitsPlace[i] = json.results[i].status;
            unitsPlace = parseInt(json.results[i].status % 10);
            originalStatusMinusUnitsPlace[i] = Math.abs(json.results[i].status - unitsPlace);
            json.results[i].status = unitsPlace;
            statusStore.push(json.results[i].status);

            let driverID = json.results[i].driver_id;
            if(isNaN(driverID) || driverID > driver.length || driverID === '') driverID = null;    
            driverIDStore.push(driverID);

            indexPosMap.push(i + 1);

            let pointsToAdd = json.results[i].hasOwnProperty('points') ? json.results[i].points : 0;
            additionalResultsPoints.push(pointsToAdd);
            // if(noPointsForFL && !isPointsUndefined) {
            //     if(json.results[i].status === 1 && points[json.track.points - 1]['P' + (i + 1)] > 0) {
            //         if(!isResultImportedOrFromScratch) pointsToAdd -= 1;
            //         additionalResultsPoints.push(pointsToAdd);
            //     }
            //     else additionalResultsPoints.push(pointsToAdd);
            // }
            // else additionalResultsPoints.push(pointsToAdd);

            raceTimeInAbsolutes.push(json.results[i].time);

            gridStore.push(json.results[i].grid);

            stopsStore.push(json.results[i].stops);

            if(!json.results[i].hasOwnProperty('grid') || json.results[i].grid === null) json.results[i].grid = '';
            if(!json.results[i].hasOwnProperty('stops') || json.results[i].stops === null) json.results[i].stops = '';
            if(!json.results[i].hasOwnProperty('fastestlaptime')) json.results[i].fastestlaptime = '';
            if(!json.results[i].hasOwnProperty('time')) json.results[i].time = '';
        }
        // console.log(additionalResultsPoints)

        if(noPointsForFL && isPointsUndefined) alert("Warning: 'Points scheme' is not present in database. Begin editing by changing it to an appropirate value");
        
        if(noPointsForFL) {
            $('#showAdditionsInfoDiv').removeClass('hidden');
            $('#showNoFlPointsInfo').toggleClass('hidden');
        }

        let additionalRaceDistance = json.track.hasOwnProperty('distance') ? {distance: json.track.distance} : {distance: ''};
        let fastestLapIndexStore = {current: 0, previous: 0};
        
        let regexFl = "^((\\d+\\:[0-5])|[0-5]?)\\d[.]\\d{3}$|^\\-$";
        let regexTimeAbsolute = "^((\\d+\\:[0-5])|[0-5]?)\\d[.]\\d{3}$|^DNF$|^DSQ$|^DNS$|^\\+1 Lap$|^\\+[2-9][0-9]* Laps$|^\\-$";
        let regexTimeInterval = "^(\\+|\\-)((\\d+\\:[0-5])|[0-5]?)\\d[.]\\d{3}$|^DNF$|^DSQ$|^DNS$|^\\+1 Lap$|^\\+[2-9][0-9]* Laps$|^\\-$";
        let regexTimePos1Absolute = "^((\\d+\\:[0-5])|[0-5]?)\\d[.]\\d{3}$";
        let regexTimeIsNotNumber = "^DNF$|^DSQ$|^DNS$|^\\+1 Lap$|^\\+[2-9][0-9]* Laps$|^\\-$";

        let isTimePos1Absolute = new RegExp(regexTimePos1Absolute);
        if(!isTimePos1Absolute.test(json.results[0].time)) $('#warningRaceTimeFirstPosNotAbsoluteAlert').slideDown(500);

        let availableDrivers = driver.filter(ele => !driverIDStore.includes(ele.id));
        let availableConstructors;

        let timeIsNotNumberCheck = new RegExp(regexTimeIsNotNumber);
        for(let i = 0; i < json.results.length; i++) {
            let intervalValue = convertAbsoluteTimeToInterval(json.results[i].time, json.results[0].time);
            if(i === 0 || timeIsNotNumberCheck.test(json.results[i].time)) intervalValue = json.results[i].time;
            if(json.results[0].time === '-' && !timeIsNotNumberCheck.test(json.results[i].time)) intervalValue = json.results[i].time;

            raceTimeInIntervals.push(intervalValue);
        }
        // console.log(raceTimeInIntervals)
        // console.log(raceTimeInAbsolutes)

        availableConstructors = constructor;
        if($('#bypassConstructorsCheck').is(':not(:checked)')) {
            for(let i = 0; i < season.length; i++) {
                if(season[i].id === json.track.season_id) availableConstructors = season[i].constructors;
            }
        }
        else {
            $('#showAdditionsInfoDiv').removeClass('hidden');
            $('#showPopulateAllConstructorsInfo').toggleClass('hidden');
        }

        currentPointsSchemeSelected = json.track.points;
        //Printing values of track key of json in table
        $('#trackTableHeaders').toggleClass('hidden');
        updateTrackTable(season, tracks, points, json);
        
        //Printing values of results key of json in table
        $('#resultsTableHeaders').toggleClass('hidden');
        updateResultsTable(driver, points, isResultImported, isPointsUndefined, noPointsForFL, indexPosMap, availableDrivers, additionalResultsPoints, availableConstructors, status, json);

        if(isResultImported.currentVal === 1) isResultImported.currentVal = 0;

        if(isResultImported.originalVal === -1) {
            $('#raceTimeFormatText').html('[Interval]');
            
            for(let i = 0; i < json.results.length; i++) {
                if((indexPosMap[i] - 1) > 0) {
                    $(`#errorTimeAlert${i}`).html(`<p>Row<strong> ${i+1}</strong> -<strong> RACE TIME</strong> [field must be in one of the following formats:<strong> '-'</strong>, <strong>'1:06.006'</strong>, <strong>'±10.324'</strong>, <strong>'±1:06.006'</strong>, <strong>+X Lap(s)</strong>, <strong>DNS</strong>, <strong>DNF</strong> or <strong>DSQ</strong>]</p>`);
                }
            }

            $('.raceTimeCol').removeClass('absoluteTime');
            $('#raceTimeFormatToggleBtn').html('Show Absolute Times');
        }
        
        checkAndMonitorTrackData(json, isResultImported, trackDetailsStore, isPointsUndefined, noPointsForFL, season, tracks, points, constructor, raceTimeInIntervals, regexFl, regexTimeAbsolute, regexTimeInterval, indexPosMap, additionalResultsPoints);
        checkDuplicateDiD(driverIDStore, indexPosMap);
        checkDuplicateStatus(statusStore, indexPosMap);
        
        openTrackMoreDetails(additionalRaceDistance);
        openResultsMoreDetails(json, additionalResultsPoints, indexPosMap);
        $('#attributeValue').change(function(event) {
            editMoreDetails(additionalRaceDistance, additionalResultsPoints, indexPosMap);
        });
        
        for(let k = 0; k < json.results.length; ++k) {
            checkRaceTimeMatchesWithStatus(json, indexPosMap, statusStore, stopsStore, k);
            checkAndMonitorResultsData(json, driver, fastestLapIndexStore, timeIsNotNumberCheck, isResultImported, isPointsUndefined, noPointsForFL, availableConstructors, status, points, regexFl, regexTimeAbsolute, regexTimeInterval, regexTimePos1Absolute, driverIDStore, raceTimeInIntervals, raceTimeInAbsolutes, gridStore, stopsStore, additionalResultsPoints, statusStore, indexPosMap, k);
            serialiseRowReorderControls(json, originalStatusMinusUnitsPlace, raceTimeInAbsolutes, stopsStore, additionalResultsPoints, indexPosMap, k);
        }
        
        checkDuplicateGrid(gridStore, indexPosMap);
        checkGridValueGreaterThanArraySize(gridStore, indexPosMap);
        checkGridValuesStartWith1(gridStore, indexPosMap);
        checkGridValuesForBreakInSequence(gridStore, indexPosMap);
        isAllGridValues0(gridStore, indexPosMap);
        isFastestLapPresentAndMatchingWithStatus(json, fastestLapIndexStore, indexPosMap, statusStore, regexFl);
        // console.log(indexPosMap)
        // convertAbsoluteTimeToInterval();

        $('.cross').click(function(event) {
            $('#pointsSelectionOverlay').removeClass('flex');
            $('#additionalDetailsInputOverlay').removeClass('flex');
            $('#reviewJSONOverlay').removeClass('flex');
            $('#pointsSelectionOverlay').addClass('hidden');
            $('#additionalDetailsInputOverlay').addClass('hidden');
            $('#reviewJSONOverlay').addClass('hidden');
        });

        $('#raceTimeFormatToggleBtn').click(function(event) {
            let updatedJSONFromTable = updateJSONFromTable(json, additionalRaceDistance, raceTimeInAbsolutes, originalStatusMinusUnitsPlace, additionalResultsPoints);
            toggleTimeFormat(updatedJSONFromTable, raceTimeInIntervals, raceTimeInAbsolutes, indexPosMap);
        });

        $('#toggleControls').click(function(event) {
            if($('#toggleControls').hasClass('editing')) {
                $('#toggleControls').removeClass('bg-green-500 hover:bg-green-700 border-green-700');
                $('#toggleControls').addClass('bg-blue-500 hover:bg-blue-700 border-blue-700');
                $('#toggleControls').toggleClass('editing');
            }
            else {
                $('#toggleControls').removeClass('bg-blue-500 hover:bg-blue-700 border-blue-700');
                $('#toggleControls').addClass('bg-green-500 hover:bg-green-700 border-green-700');
                $('#toggleControls').addClass('editing');
            }

            $('#undoToggleBtn').toggleClass('hidden');
            $('#rowReorderToggleBtn').toggleClass('hidden');
            // $('#toggleAddMore').toggleClass('hidden');

            $('.undo').addClass('hidden');
            if($('#undoToggleBtn').hasClass('editing')) {
                $('#undoToggleBtn').removeClass('bg-blue-500 text-white hover:bg-blue-700');
                $('#undoToggleBtn').addClass('bg-white text-blue-700 hover:text-white hover:bg-blue-500');
                $('#undoToggleBtn').html('Show Reset');
                $('#undoToggleBtn').toggleClass('editing');
            }

            $('.rowReorderBtn').addClass('hidden');
            if($('#rowReorderToggleBtn').hasClass('editing')) {
                $('#rowReorderToggleBtn').removeClass('bg-orange-500 text-white hover:bg-orange-700');
                $('#rowReorderToggleBtn').addClass('bg-white text-orange-700 hover:text-white hover:bg-orange-500');
                $('#rowReorderToggleBtn').html('Show Row Reorder');
                $('#rowReorderToggleBtn').toggleClass('editing');
            }

            // $('.addMoreBtn').addClass('hidden');
            // if($('#toggleAddMore').hasClass('editing')) {
            //     $('#toggleAddMore').removeClass('bg-green-500 text-white hover:bg-green-700');
            //     $('#toggleAddMore').addClass('bg-white text-green-700 hover:text-white hover:bg-green-500');
            //     $('#toggleAddMore').html('Show Add Details');
            //     $('#toggleAddMore').toggleClass('editing');
            // }
            
            $('#addRemoveRowControls').toggleClass('hidden');
            if($('.selectInp').hasClass('open')) {
                $('.selectInp').attr('disabled', true);
                $('.selectInp').removeClass('open');
                $('.selectInp').addClass('cursor-not-allowed');
            }
            else {
                $('.selectInp').attr('disabled', false);
                $('.selectInp').addClass('open');
                $('.selectInp').removeClass('cursor-not-allowed');
            }
            
            $('.numInp').toggleClass('disable');
            $('.numInp').toggleClass('cursor-not-allowed');
            $('.addMoreBtn').toggleClass('disable');
            $('.addMoreBtn').toggleClass('cursor-not-allowed');
            $('#addMoreTrack').toggleClass('disable');
            $('#addMoreTrack').toggleClass('cursor-not-allowed');
        });

        $('#undoToggleBtn').click(function(event) {
            if($('#undoToggleBtn').hasClass('editing')) {
                $('#undoToggleBtn').removeClass('bg-blue-500 text-white hover:bg-blue-700');
                $('#undoToggleBtn').addClass('bg-white text-blue-700 hover:text-white hover:bg-blue-500');
                $('#undoToggleBtn').html('Show Reset');
                $('#undoToggleBtn').toggleClass('editing');

                // $(("#raceTimeFormatToggleBtn")).removeClass('disableActionBtns text-white');
                // $(("#raceTimeFormatToggleBtn")).addClass('text-red-700');
            }
            else {
                $('#undoToggleBtn').removeClass('bg-white text-blue-700 hover:text-white hover:bg-blue-500');
                $('#undoToggleBtn').addClass('bg-blue-500 text-white hover:bg-blue-700');
                $('#undoToggleBtn').html('Hide Reset');
                $('#undoToggleBtn').toggleClass('editing');

                // if(!$('.raceTimeCol').hasClass('absoluteTime')) {
                //     const e = new Event("click");
                //     const element = document.querySelector("#raceTimeFormatToggleBtn");
                //     element.dispatchEvent(e);
                // }
                // $(("#raceTimeFormatToggleBtn")).addClass('disableActionBtns text-white');
                // $(("#raceTimeFormatToggleBtn")).removeClass('text-red-700');
            }

            $('.undo').toggleClass('hidden');
            $('.addMoreBtn').toggleClass('hidden');

            if($('#rowReorderToggleBtn').hasClass('editing')) {
                if(!$('#rowReorderToggleBtn').hasClass('disableActionBtns')) {
                    $('#rowReorderToggleBtn').removeClass('bg-orange-500 text-white hover:bg-orange-700');
                    $('#rowReorderToggleBtn').addClass('bg-white text-orange-700 hover:text-white hover:bg-orange-500');
                }
                $('#rowReorderToggleBtn').html('Show Row Reorder');
                $('#rowReorderToggleBtn').toggleClass('editing');

                // $("#raceTimeFormatToggleBtn").removeClass('disableActionBtns text-white');
                // $("#raceTimeFormatBtnWrapper").removeClass('tooltip');
                // $("#raceTimeFormatToggleBtn").addClass('text-red-700');
                
                $('.rowReorderBtn').toggleClass('hidden');
                $('.addMoreBtn').toggleClass('hidden');
            }

            // if(!$('.raceTimeCol').hasClass('absoluteTime')) {
            //     const e = new Event("click");
            //     const element = document.querySelector("#raceTimeFormatToggleBtn");
            //     element.dispatchEvent(e);

            //     $(("#raceTimeFormatToggleBtn")).addClass('disableActionBtns text-white');
            //     $(("#raceTimeFormatToggleBtn")).removeClass('text-red-700');
            // }
            // else {
            //     $(("#raceTimeFormatToggleBtn")).removeClass('disableActionBtns text-white');
            //     $(("#raceTimeFormatToggleBtn")).addClass('text-red-700');
            // }

            // if($('#toggleAddMore').hasClass('editing')) {
            //     $('#toggleAddMore').removeClass('bg-green-500 text-white hover:bg-green-700');
            //     $('#toggleAddMore').addClass('bg-white text-green-700 hover:text-white hover:bg-green-500');
            //     $('#toggleAddMore').html('Show Add Details');
            //     $('#toggleAddMore').toggleClass('editing');

            //     $('.addMoreBtn').toggleClass('hidden');
            // }
        })

        $('#rowReorderToggleBtn').click(function(event) {
            if($('#rowReorderToggleBtn').hasClass('editing')) {
                $('#rowReorderToggleBtn').removeClass('bg-orange-500 text-white hover:bg-orange-700');
                $('#rowReorderToggleBtn').addClass('bg-white text-orange-700 hover:text-white hover:bg-orange-500');
                $('#rowReorderToggleBtn').html('Show Row Reorder');
                $('#rowReorderToggleBtn').toggleClass('editing');

                let updatedJSONFromTable = updateJSONFromTable(json, additionalRaceDistance, raceTimeInAbsolutes, originalStatusMinusUnitsPlace, additionalResultsPoints);
                let noTimeErrors = 1;
                
                let raceTimePos1 = $(`#inputTime${indexPosMap[0] - 1}`).val();

                for(let i = 0; i < updatedJSONFromTable.results.length; i++) noTimeErrors -= checkForError(`#resultsBodyTime${i}`);
                
                if(noTimeErrors === 1 && isTimePos1Absolute.test(raceTimePos1)) {
                    $(("#raceTimeFormatToggleBtn")).removeClass('disableActionBtns text-white');
                    $("#raceTimeFormatBtnWrapper").removeClass('tooltip');
                    $(("#raceTimeFormatToggleBtn")).addClass('text-red-700');
                }
            }
            else {
                $('#rowReorderToggleBtn').removeClass('bg-white text-orange-700 hover:text-white hover:bg-orange-500');
                $('#rowReorderToggleBtn').addClass('bg-orange-500 text-white hover:bg-orange-700');
                $('#rowReorderToggleBtn').html('Hide Row Reorder');
                $('#rowReorderToggleBtn').toggleClass('editing');
                
                if(!$('.raceTimeCol').hasClass('absoluteTime')) {
                    const e = new Event("click");
                    const element = document.querySelector("#raceTimeFormatToggleBtn");
                    element.dispatchEvent(e);
                }
                // $(("#raceTimeFormatToggleBtn")).addClass('disableActionBtns text-white');
                // $(("#raceTimeFormatToggleBtn")).removeClass('text-red-700');
            }
            
            $('.rowReorderBtn').toggleClass('hidden');
            $('.addMoreBtn').toggleClass('hidden');

            if($('#undoToggleBtn').hasClass('editing')) {
                $('#undoToggleBtn').removeClass('bg-blue-500 text-white hover:bg-blue-700');
                $('#undoToggleBtn').addClass('bg-white text-blue-700 hover:text-white hover:bg-blue-500');
                $('#undoToggleBtn').html('Show Reset');
                $('#undoToggleBtn').toggleClass('editing');

                $('.undo').toggleClass('hidden');
                $('.addMoreBtn').toggleClass('hidden');

                // $(("#raceTimeFormatToggleBtn")).addClass('disableActionBtns text-white');
                // $("#raceTimeFormatBtnWrapper").addClass('tooltip');
                // $(("#raceTimeFormatToggleBtn")).removeClass('text-red-700');
            }

            // if(!$('.raceTimeCol').hasClass('absoluteTime')) {
            //     const e = new Event("click");
            //     const element = document.querySelector("#raceTimeFormatToggleBtn");
            //     element.dispatchEvent(e);

            //     $(("#raceTimeFormatToggleBtn")).addClass('disableActionBtns text-white');
            //     $(("#raceTimeFormatToggleBtn")).removeClass('text-red-700');
            // }
            // else {
            //     $(("#raceTimeFormatToggleBtn")).removeClass('disableActionBtns text-white');
            //     $(("#raceTimeFormatToggleBtn")).addClass('text-red-700');
            // }

            // if($('#toggleAddMore').hasClass('editing')) {
            //     $('#toggleAddMore').removeClass('bg-green-500 text-white hover:bg-green-700');
            //     $('#toggleAddMore').addClass('bg-white text-green-700 hover:text-white hover:bg-green-500');
            //     $('#toggleAddMore').html('Show Add Details');
            //     $('#toggleAddMore').toggleClass('editing');

            //     $('.addMoreBtn').toggleClass('hidden');
            // }
        })

        // $('#toggleAddMore').click(function(event) {
        //     if($('#toggleAddMore').hasClass('editing')) {
        //         $('#toggleAddMore').removeClass('bg-green-500 text-white hover:bg-green-700');
        //         $('#toggleAddMore').addClass('bg-white text-green-700 hover:text-white hover:bg-green-500');
        //         $('#toggleAddMore').html('Show Add Details');
        //         $('#toggleAddMore').toggleClass('editing');
        //     }
        //     else {
        //         $('#toggleAddMore').removeClass('bg-white text-green-700 hover:text-white hover:bg-green-500');
        //         $('#toggleAddMore').addClass('bg-green-500 text-white hover:bg-green-700');
        //         $('#toggleAddMore').html('Hide Add Details');
        //         $('#toggleAddMore').toggleClass('editing');
        //     }
            
        //     $('.addMoreBtn').toggleClass('hidden');

        //     if($('#undoToggleBtn').hasClass('editing')) {
        //         $('#undoToggleBtn').removeClass('bg-blue-500 text-white hover:bg-blue-700');
        //         $('#undoToggleBtn').addClass('bg-white text-blue-700 hover:text-white hover:bg-blue-500');
        //         $('#undoToggleBtn').html('Show Reset');
        //         $('#undoToggleBtn').toggleClass('editing');

        //         $('.undo').toggleClass('hidden');
        //     }

        //     if($('#rowReorderToggleBtn').hasClass('editing')) {
        //         $('#rowReorderToggleBtn').removeClass('bg-orange-500 text-white hover:bg-orange-700');
        //         $('#rowReorderToggleBtn').addClass('bg-white text-orange-700 hover:text-white hover:bg-orange-500');
        //         $('#rowReorderToggleBtn').html('Show Row Reorder');
        //         $('#rowReorderToggleBtn').toggleClass('editing');

        //         $('.rowReorderBtn').toggleClass('hidden');
        //     }
        // })

        $('.undo').click(function(event) {
            $('.undo').toggleClass('hidden');
            $('#undoToggleBtn').removeClass('bg-blue-500 text-white hover:bg-blue-700');
            $('#undoToggleBtn').addClass('bg-white text-blue-700 hover:text-white hover:bg-blue-500');
            $('#undoToggleBtn').html('Show Reset');
            $('#undoToggleBtn').toggleClass('editing');

            $('.addMoreBtn').toggleClass('hidden');

            let updatedJSONFromTable = updateJSONFromTable(json, additionalRaceDistance, raceTimeInAbsolutes, originalStatusMinusUnitsPlace, additionalResultsPoints);
            let noTimeErrors = 1;
            
            let raceTimePos1 = $(`#inputTime${indexPosMap[0] - 1}`).val();

            for(let i = 0; i < updatedJSONFromTable.results.length; i++) noTimeErrors -= checkForError(`#resultsBodyTime${i}`);
            
            if(noTimeErrors === 1 && isTimePos1Absolute.test(raceTimePos1)) {
                $(("#raceTimeFormatToggleBtn")).removeClass('disableActionBtns text-white');
                $("#raceTimeFormatBtnWrapper").removeClass('tooltip');
                $(("#raceTimeFormatToggleBtn")).addClass('text-red-700');
            }

            if(!$('#rowReorderToggleBtn').hasClass('disableActionBtns')) {
                $('#rowReorderToggleBtn').removeClass('bg-orange-500 text-white hover:bg-orange-700');
                $('#rowReorderToggleBtn').addClass('bg-white text-orange-700 hover:text-white hover:bg-orange-500');
            }
        })
        
        $('#addRow').click(function(event) {
            let addRowTemplate = {
                position: json.results.length + 1,
                constructor_id: 0,
                grid: 0,
                stops: -1,
                time: "",
                fastestlaptime: "",
                status: -2,
                driver_id: 0,
                driver: ""
            };
            
            json.results.push(addRowTemplate);
            originalStatusMinusUnitsPlace.push(0);
            driverIDStore.push(addRowTemplate.driver_id);
            gridStore.push(addRowTemplate.grid);
            stopsStore.push(addRowTemplate.stops);
            statusStore.push(addRowTemplate.status);
            indexPosMap.push(addRowTemplate.position);
            additionalResultsPoints.push(0);
            raceTimeInIntervals.push(addRowTemplate.time);
            raceTimeInAbsolutes.push(addRowTemplate.time);
            
            if((json.results.length) >= 1) {
                $('#removeRow').removeClass('opacity-50 cursor-not-allowed');
                $('#removeRow').addClass('hover:bg-red-700');                 
            }
            
            let i = json.results.length - 1;

            updateResultsTable(driver, points, isResultImported, isPointsUndefined, noPointsForFL, indexPosMap, availableDrivers, additionalResultsPoints, availableConstructors, status, json, i);            
            availableDrivers = driver.filter(ele => !driverIDStore.includes(ele.id));
            repopulateDriverResultsDropdowns(driver, availableDrivers, json);
            
            let updatedJSONFromTable = updateJSONFromTable(json, additionalRaceDistance, raceTimeInAbsolutes, originalStatusMinusUnitsPlace, additionalResultsPoints);
            if($('#bypassConstructorsCheck').is(':not(:checked)')) {
                availableConstructors = constructor;
                for(let i = 0; i < season.length; i++) {
                    if(season[i].id === updatedJSONFromTable.track.season_id) availableConstructors = season[i].constructors;
                }
                repopulateConstructorResultsDropdowns(availableConstructors, updatedJSONFromTable);
            }
            
            if((updatedJSONFromTable.results.length) >= 2 && $('#toggleControls').hasClass('editing')) {
                $('.selectInp').attr('disabled', false);
                $('.selectInp').addClass('open');
                $('.selectInp').removeClass('cursor-not-allowed');
            }
            
            if($('#rowReorderToggleBtn').hasClass('editing')) {
                $(`#moveRowUp${i}`).toggleClass('hidden');
                $(`#moveRowDown${i}`).toggleClass('hidden');
            }
            
            if($('#rowReorderToggleBtn').hasClass('editing') || $('#toggleRowUndo').hasClass('editing')) $(`#addMore${i}`).toggleClass('hidden');
            
            checkRaceTimeMatchesWithStatus(updatedJSONFromTable, indexPosMap, statusStore, stopsStore, i);
            checkAndMonitorResultsData(json, driver, fastestLapIndexStore, timeIsNotNumberCheck, isResultImported, isPointsUndefined, noPointsForFL, availableConstructors, status, points, regexFl, regexTimeAbsolute, regexTimeInterval, regexTimePos1Absolute, driverIDStore, raceTimeInIntervals, raceTimeInAbsolutes, gridStore, stopsStore, additionalResultsPoints, statusStore, indexPosMap, i);
            serialiseRowReorderControls(json, originalStatusMinusUnitsPlace, raceTimeInAbsolutes, stopsStore, additionalResultsPoints, indexPosMap, i);
            openResultsMoreDetails(json, additionalResultsPoints, indexPosMap, i);
        });

        // let lastPopedRow = [];
        $('#removeRow').click(function(event) {
            let errorIndex = json.results.length;
            
            if(errorIndex == 1) return alert('Cannot remove row! Finishing order should have atleast one entry.');

            let choice = window.confirm('Are you sure you want to delete the last row?')
            if(choice) {
                let updatedJSONFromTable = updateJSONFromTable(json, additionalRaceDistance, raceTimeInAbsolutes, originalStatusMinusUnitsPlace, additionalResultsPoints, 0);
                
                if(errorIndex > 1) {
                    json.results.pop();
                    originalStatusMinusUnitsPlace.pop();
                    driverIDStore.pop();
                    gridStore.pop();
                    stopsStore.pop();
                    statusStore.pop();
                    indexPosMap.pop();
                    additionalResultsPoints.pop();
                    raceTimeInIntervals.pop();
                    raceTimeInAbsolutes.pop();

                    $('.resultRow').last().remove();
                }

                availableDrivers = driver.filter(ele => !driverIDStore.includes(ele.id));
                repopulateDriverResultsDropdowns(driver, availableDrivers, json);

                $(`#errorPosAlert${json.results.length}`).slideUp(500);
                $(`#errorDriverAlert${json.results.length}`).slideUp(500);
                $(`#errorConstructorAlert${json.results.length}`).slideUp(500);
                $(`#errorStatusAlert${json.results.length}`).slideUp(500);
                $(`#errorGridAlert${json.results.length}`).slideUp(500);
                $(`#errorStopsAlert${json.results.length}`).slideUp(500);
                $(`#errorFlAlert${json.results.length}`).slideUp(500);
                $(`#errorTimeAlert${json.results.length}`).slideUp(500);

                if(errorIndex <= 2) {
                    $('#removeRow').removeClass('hover:bg-red-700');
                    $('#removeRow').addClass('opacity-50 cursor-not-allowed');
                }
                
                disableFirstAndLastReorderBtns();
                isFastestLapPresentAndMatchingWithStatus(json, fastestLapIndexStore, indexPosMap, statusStore, regexFl);
                disableToggleBtnsOnTimeError(json, regexTimePos1Absolute, indexPosMap);
                checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);

                for(let i = 0; i < updatedJSONFromTable.results.length; i++) {
                    reflectFastestLap(points, isResultImported, isPointsUndefined, noPointsForFL, indexPosMap, additionalResultsPoints, updatedJSONFromTable.results[i].status, i);
                }

                // console.log(driverIDStore)

                // let temp = updatedJSONFromTable.results.pop();
                // lastPopedRow.push(temp);
                // console.log(lastPopedRow);
            }
        });

        $('#reviewJSON').toggleClass('hidden');
        $('#submitJSON').toggleClass('hidden');
        
        // checkAllTableFields(regexFl, regexTime, json);
        // checkAllTrackFields();
        checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);
        
        $('#reviewJSON').click(function(event) {
            let newJson = updateJSONFromTable(json, additionalRaceDistance, raceTimeInAbsolutes, originalStatusMinusUnitsPlace, additionalResultsPoints, 1);
            // console.log(newJson.results)

            $('#reviewJSONTextArea').text(JSON.stringify(newJson, null, "\t"));

            $('#reviewJSONOverlay').removeClass('hidden');
            $('#reviewJSONOverlay').addClass('flex');
            
            // let btnName = 'reviewJSON'
            // downloadJSON(newJson, btnName, season, newJson.track.season_id, newJson.track.round);

            // $('#errorSubmitJSONAlert').slideUp(500);
            // if(checkAllTableFields(regexFl, regexTime, newJson)) {
            //     $('#errorSubmitJSONAlert').slideUp(500);
                
            // } else {
            //     $('#errorSubmitJSONAlert').html('<p>Please clear all the<strong> ERRORS </strong> before downloading JSON</p>');
            //     $('#errorSubmitJSONAlert').slideDown(500);
            // }
        });

        $('#submitJSON').click(function(event) {
            let newJson = updateJSONFromTable(json, additionalRaceDistance, raceTimeInAbsolutes, originalStatusMinusUnitsPlace, additionalResultsPoints, 1);
            // console.log(newJson.results)

            postJson(JSON.stringify(newJson), season);

            $('#submitJSON').html('<i class="fas fa-spinner fa-spin"></i>');

        });
    }
    
    function toggleTimeFormat(json, raceTimeInIntervals, raceTimeInAbsolutes, indexPosMap) {
        const e = new Event('change');
        
        if($('.raceTimeCol').hasClass('absoluteTime')) {
            $('#raceTimeFormatText').html('[Interval]');
            
            for(let i = 0; i < json.results.length; i++) {
                $(`#inputTime${i}`).val(raceTimeInIntervals[indexPosMap[i] - 1]);
                if((indexPosMap[i] - 1) > 0) {
                    $(`#errorTimeAlert${i}`).html(`<p>Row<strong> ${i+1}</strong> -<strong> RACE TIME</strong> [field must be in one of the following formats:<strong> '-'</strong>, <strong>'1:06.006'</strong>, <strong>'±10.324'</strong>, <strong>'±1:06.006'</strong>, <strong>+X Lap(s)</strong>, <strong>DNS</strong>, <strong>DNF</strong> or <strong>DSQ</strong>]</p>`);
                }

                // const element = document.querySelector(`#inputTime${i}`);
                // element.dispatchEvent(e);
            }
            $('.raceTimeCol').removeClass('absoluteTime');
            $('#raceTimeFormatToggleBtn').html('Show Absolute Times');

            if($('#rowReorderToggleBtn').hasClass('editing')) {
                const e = new Event("click");
                const element = document.querySelector("#rowReorderToggleBtn");
                element.dispatchEvent(e);
            }
        }
        else {
            $('#raceTimeFormatText').html('[Absolute]');

            for(let i = 0; i < json.results.length; i++) {
                $(`#inputTime${i}`).val(raceTimeInAbsolutes[indexPosMap[i] - 1]);
                if((indexPosMap[i] - 1) > 0) {
                    $(`#errorTimeAlert${i}`).html(`<p>Row<strong> ${i+1}</strong> -<strong> RACE TIME</strong> [field must be in one of the following formats:<strong> '-'</strong>, <strong>'1:06.006'</strong>, <strong>+X Lap(s)</strong>, <strong>DNS</strong>, <strong>DNF</strong> or <strong>DSQ</strong>]</p>`);
                }

                // const element = document.querySelector(`#inputTime${i}`);
                // element.dispatchEvent(e);
            }
            $('.raceTimeCol').addClass('absoluteTime');
            $('#raceTimeFormatToggleBtn').html('Show Intervals');
        }
    }

    function openTrackMoreDetails(additionalRaceDistance) {
        $('#addMoreTrack').click(function(event) {
            // console.log(additionalRaceDistance);
            let seasonIndex = $('#seasonSelect')[0].selectedIndex;
            let circuitIndex = $('#tracksSelect')[0].selectedIndex;
            
            let selectedSeason = $('#seasonSelect')[0][seasonIndex].innerText;
            let selectedCircuit = $('#tracksSelect')[0][circuitIndex].innerText;
            let selectedPoints = $('#pointsBtn').html();

            $('#infoTitle').html('Race details');

            $('#infoHeader1').html('Season');
            $('#infoHeader2').html('Track');
            $('#infoHeader3').html('Points');

            $('#attributeName').html('Distance');

            $('#infoValue1').html(selectedSeason);
            $('#infoValue2').html(selectedCircuit);
            $('#infoValue3').html(selectedPoints);

            $('#attributeValue').val(additionalRaceDistance.distance);

            $('#additionalDetailsInputOverlay').removeClass('hidden');
            $('#additionalDetailsInputOverlay').addClass('flex');
        });

        if(additionalRaceDistance.distance != '') {
            $('#addMoreTrack').removeClass('bg-white text-green-500');
            $('#addMoreTrack').addClass('bg-green-500 text-white');
        }
    }

    function openResultsMoreDetails(json, additionalResultsPoints, indexPosMap, i = 0) {
        let upperLimit = i === 0 ? json.results.length - 1 : i;

        for(let x = i; x <= upperLimit; x++) {
            $(`#addMore${x}`).click(function(event) {
                let index = parseInt($(this).closest('tr')[0].querySelector('.selectDriver').selectedIndex);
                let statusIndex = parseInt($(this).closest('tr')[0].querySelector('.selectStatus').selectedIndex);
                
                let currentPos = parseInt($(this).closest('tr')[0].querySelector('.inputPos').value);
                let currentDriver = $(this).closest('tr')[0].querySelector('.selectDriver')[index].innerText;
                let currentStatus = $(this).closest('tr')[0].querySelector('.selectStatus')[statusIndex].innerText;

                $('#infoTitle').html('Current Driver');

                $('#infoHeader1').html('Position');
                $('#infoHeader2').html('Driver');
                $('#infoHeader3').html('Status');

                $('#attributeName').html('Points');
    
                $('#infoValue1').html(currentPos);
                $('#infoValue2').html(currentDriver);
                $('#infoValue3').html(currentStatus);
    
                $('#attributeValue').val(additionalResultsPoints[indexPosMap[x] - 1]);
                
                $('#additionalDetailsInputOverlay').removeClass('hidden');
                $('#additionalDetailsInputOverlay').addClass('flex');
                currentAddRowSelected = x;
                // console.log(indexPosMap[x] - 1)
            });

            if(additionalResultsPoints[x] != 0) {
                $(`#addMore${x}`).removeClass('bg-white text-green-500');
                $(`#addMore${x}`).addClass('bg-green-500 text-white');
            }
        }
    }

    function editMoreDetails(additionalRaceDistance, additionalResultsPoints, indexPosMap) {
        // console.log(indexPosMap[currentAddRowSelected])

        let selectedVal = $('#attributeValue').val();
        let attr = $('#attributeName').html();
        
        if(selectedVal !== '') {
            if(attr === 'Points') {
                additionalResultsPoints[indexPosMap[currentAddRowSelected] - 1] = parseInt(selectedVal);
                
                if(selectedVal != 0) {
                    $(`#addMore${currentAddRowSelected}`).removeClass('bg-white text-green-500');
                    $(`#addMore${currentAddRowSelected}`).addClass('bg-green-500 text-white');
                }
                else {
                    $(`#addMore${currentAddRowSelected}`).addClass('bg-white text-green-500');
                    $(`#addMore${currentAddRowSelected}`).removeClass('bg-green-500 text-white');
                }
            }

            if(attr === 'Distance') {
                additionalRaceDistance.distance = +selectedVal;

                if(selectedVal != '') {
                    $('#addMoreTrack').removeClass('bg-white text-green-500');
                    $('#addMoreTrack').addClass('bg-green-500 text-white');
                }
                else {
                    $('#addMoreTrack').addClass('bg-white text-green-500');
                    $('#addMoreTrack').removeClass('bg-green-500 text-white');
                }
            }
        }
        // console.log(additionalResultsPoints);
    }

    // function checkAllTableFields(regexFl, regexTime, json) {
    //     let pass = 0;

    //     let trackOuterDivs = ['#trackBodySeason', '#trackBodyRound', '#trackBodyCircuit', '#trackBodyPoints'];
    //     let postStatusTrack = 1;
    //     for(let i = 0; i < trackOuterDivs.length; i++) {
    //         postStatusTrack -= checkForError(trackOuterDivs[i]);
    //     }

    //     let postStatusResults = 1;
    //     for(let i = 0; i < json.results.length; i++) {
    //         let resultsOuterDivs = [`#resultsBodyPos${i}`, 
    //                                 `#resultsBodyDriver${i}`, 
    //                                 `#resultsBodyConstructor${i}`, 
    //                                 `#resultsBodyGrid${i}`, 
    //                                 `#resultsBodyStops${i}`, 
    //                                 `#resultsBodyFl${i}`, 
    //                                 `#resultsBodyTime${i}`, 
    //                                 `#resultsBodyStatus${i}`];
    //         for(let j = 0; j < resultsOuterDivs.length; j++) {
    //             postStatusResults -= checkForError(resultsOuterDivs[j]);
    //         }
    //     }

    //     if(isValidTimeFormat(raceTimeInIntervals, regexFl, regexTime, json) && (postStatusTrack == 1) && (postStatusResults == 1)) pass = 1;

    //     return pass;
    // }

    // function checkAllTrackFields() {
    //     let trackOuterDivs = ['#trackBodySeason', '#trackBodyRound', '#trackBodyCircuit', '#trackBodyPoints'];
    //     let postStatusTrack = 1;

    //     for(let i = 0; i < trackOuterDivs.length; i++) postStatusTrack -= checkForError(trackOuterDivs[i]);

    //     // $('#errorSubmitJSONAlert').slideUp(500);
    //     if(postStatusTrack === 1) {
    //         $('#errorSubmitJSONAlert').slideUp(500);
    //         $('#submitJSON').removeClass('disableActionBtns');
    //         $('#reviewJSON').removeClass('disableActionBtns');
    //     }
    //     else {
    //         $('#submitJSON').addClass('disableActionBtns');
    //         $('#reviewJSON').addClass('disableActionBtns');
    //         $('#errorSubmitJSONAlert').html('<p>Please clear all the <strong>ERRORS</strong></p>');
    //         $('#errorSubmitJSONAlert').slideDown(500);
    //     }
    // }

    function checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json) {
        let trackOuterDivs = ['#trackBodySeason', '#trackBodyRound', '#trackBodyCircuit', '#trackBodyPoints'];
        
        let postStatusTrack = 1;
        for(let i = 0; i < trackOuterDivs.length; i++) postStatusTrack -= checkForError(trackOuterDivs[i]);
        
        let postStatusResults = 1;
        for(let i = 0; i < json.results.length; i++){
            let resultsOuterDivs = [`#resultsBodyPos${i}`, 
                                    `#resultsBodyDriver${i}`, 
                                    `#resultsBodyConstructor${i}`, 
                                    `#resultsBodyGrid${i}`, 
                                    `#resultsBodyStops${i}`, 
                                    `#resultsBodyFl${i}`, 
                                    `#resultsBodyTime${i}`, 
                                    `#resultsBodyStatus${i}`];
            for(let j = 0; j < resultsOuterDivs.length; j++) {
                postStatusResults -= checkForError(resultsOuterDivs[j]);
            }
        }

        // console.log(isValidTimeFormat(raceTimeInIntervals, regexFl, regexTimeAbsolute, regexTimeInterval, json), (postStatusTrack === 1), (postStatusResults === 1))

        if(isValidTimeFormat(raceTimeInIntervals, regexFl, regexTimeAbsolute, regexTimeInterval, json) && (postStatusTrack === 1) && (postStatusResults === 1)) {
            $('#errorSubmitJSONAlert').slideUp(500);
            $('#submitJSON').removeClass('disableActionBtns');
            $('#reviewJSON').removeClass('disableActionBtns');
        }
        else {
            $('#submitJSON').addClass('disableActionBtns');
            $('#reviewJSON').addClass('disableActionBtns');
            $('#errorSubmitJSONAlert').html('<p>Please clear all the <strong>ERRORS</strong></p>');
            $('#errorSubmitJSONAlert').slideDown(500);
        }
    }

    function enableEditOnErrorAfterLoading(json) {
        
        let trackOuterDivs = ['#trackBodySeason', '#trackBodyRound', '#trackBodyCircuit', '#trackBodyPoints'];
        
        let postStatusTrack = 1;
        for(let i = 0; i < trackOuterDivs.length; i++) postStatusTrack -= checkForError(trackOuterDivs[i]);
        
        let postStatusResults = 1;
        for(let i = 0; i < json.results.length; i++){
            let resultsOuterDivs = [`#resultsBodyPos${i}`, 
                                    `#resultsBodyDriver${i}`, 
                                    `#resultsBodyConstructor${i}`, 
                                    `#resultsBodyGrid${i}`, 
                                    `#resultsBodyStops${i}`, 
                                    `#resultsBodyFl${i}`, 
                                    `#resultsBodyTime${i}`, 
                                    `#resultsBodyStatus${i}`];
            for(let j = 0; j < resultsOuterDivs.length; j++) {
                postStatusResults -= checkForError(resultsOuterDivs[j]);
            }
        }

        if((postStatusTrack !== 1) || (postStatusResults !== 1)) {
            $('#toggleControls').removeClass('bg-blue-500 hover:bg-blue-700 border-blue-700');
            $('#toggleControls').addClass('bg-green-500 hover:bg-green-700 border-green-700');
            $('#toggleControls').toggleClass('editing');

            $('.selectInp').attr('disabled', false);
            $('.selectInp').addClass('open');
            $('.selectInp').removeClass('cursor-not-allowed');
            $('.numInp').removeClass('disable');
            $('.numInp').removeClass('cursor-not-allowed');
            $('.addMoreBtn').removeClass('disable');
            $('.addMoreBtn').removeClass('cursor-not-allowed');
            $('#addMoreTrack').removeClass('disable');
            $('#addMoreTrack').removeClass('cursor-not-allowed');

            $('#undoToggleBtn').toggleClass('hidden');
            $('#rowReorderToggleBtn').toggleClass('hidden');

            $('#addRemoveRowControls').toggleClass('hidden');
        }
    }

    function parseJSONWithErrorHandling(readerResult) {
        $('#JSONFormatErrorsAlert').slideUp(500);

        try {
            return JSON.parse(readerResult);
        }
        catch(err) {
            $('#JSONFormatErrorMessage').html(`[${err.message}]`);
            $('#JSLintHrefLink').attr('href', `https://jsonlint.com/?json=${readerResult}`);
            $('#JSONFormatErrorsAlert').slideDown(500);
        }
    }

    function checkJsonKeys(json) {
        $('#missingResultsAlert').slideUp(500);
        $('#missingTrackAlert').slideUp(500);
        $('#positionKeyErrorAlert').slideUp(500);

        if(json !== undefined) {
            if(json.hasOwnProperty('track') && json.hasOwnProperty('results')) {
                return 1;
            } else if(json.hasOwnProperty('track') == false) {
                $('#missingTrackAlert').slideDown(500);
            } else {
                $('#missingResultsAlert').slideDown(500);
            }
        }
    }

    function isAllPositionKeysPresentAndValidWithoutDuplicates(resultsArray) {
        let allKeysPresentAndValidWithoutDuplicate;
        let positionStore = [];

        $('#positionKeyErrorAlert').slideUp(500);
        
        for(let i = 0; i < resultsArray.length; i++) {
            let pos = resultsArray[i].position;
            let isFraction = pos % 1;

            if(!resultsArray[i].hasOwnProperty('position')) {
                $('#positionKeyErrorAlert').html(`<p><strong>Position Key</strong> [position] is missing at index <strong>${i}</strong> of the 'results' array</p>`);
                $('#positionKeyErrorAlert').slideDown(500);

                return allKeysPresentAndValidWithoutDuplicate = 0;
            } else if((isNaN(pos)) || (pos < 1) || (pos > resultsArray.length) || (isFraction != 0)) {
                $('#positionKeyErrorAlert').html(`<p><strong>Position Key</strong> [position] value at index <strong>${i}</strong> should be a positive integer less than the length of the 'results' array</p>`);
                $('#positionKeyErrorAlert').slideDown(500);

                return allKeysPresentAndValidWithoutDuplicate = 0;
            } else if(positionStore.includes(pos)) {
                $('#positionKeyErrorAlert').html(`<p><strong>Position Key</strong> [position] value at index <strong>${i}</strong> is a duplicate value</p>`);
                $('#positionKeyErrorAlert').slideDown(500);

                return allKeysPresentAndValidWithoutDuplicate = 0;
            }

            positionStore.push(pos);
        }

        return allKeysPresentAndValidWithoutDuplicate = 1;
    }

    function updateTrackTable(season, tracks, points, json) {
        var rowTrack = `<tr class="text-center">
                            <td class="border rounded py-2 px-1" id="trackBodySeason">
                                <div class="flex px-2 justify-center gap-2">
                                    <select id="seasonSelect" class="bg-gray-200 p-1 font-semibold leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500 cursor-not-allowed selectInp" disabled>                    
                                    </select>
                                    <button id="undoSeason" class="hidden bg-white text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded undo">
                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="border rounded p-2" id="trackBodyRound">
                                <div class="flex px-2 justify-center gap-1">
                                    <input class="pl-6 w-16 text-center font-semibold numInp" type="number" id="inputRound" min="1" value="${json.track.round}"\>
                                    <button id="undoRound" class="hidden bg-white text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded undo">
                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="border rounded py-2 px-1" id="trackBodyCircuit">
                                <div class="flex px-2 justify-center gap-2">
                                    <select id="tracksSelect" class="bg-gray-200 w-48 p-1 font-semibold leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500 cursor-not-allowed selectInp" disabled>                       
                                    </select>
                                    <button id="undoCircuit" class="hidden bg-white text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded undo">
                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="border rounded py-2 px-1" id="trackBodyPoints">
                                <div class="flex px-2 justify-center gap-2">
                                    <button id="pointsBtn" type="button" class="px-5 font-semibold bg-gray-300 border border-gray-500 rounded cursor-not-allowed selectInp" disabled>${json.track.points}</button>
                                    <button id="undoPoints" class="hidden bg-white text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded undo">
                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <button id="addMoreTrack" class="bg-white text-sm hover:bg-green-700 text-green-500 hover:text-white font-semibold py-1 px-2 border border-green-500 hover:border-transparent rounded">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>`;
        $('#trackTableBody').append(rowTrack);

        let seasonCol = document.getElementById(`seasonSelect`);
        let circuitCol = document.getElementById(`tracksSelect`);
        let pointsCol = document.getElementById(`pointsSelect`);
        populateTrackDropdowns(season, tracks, points, json, seasonCol, circuitCol, pointsCol);
        populatePointsOverlay(points);
    }

    function populateTrackDropdowns(season, tracks, points, json, seasonCol, circuitCol, pointsCol) {
        let selectInpFields = {
            season: {
                data: season,
                upload: json.track.season_id,
                colId: seasonCol
            },
            track: {
                data: tracks,
                upload: json.track.circuit_id,
                colId: circuitCol
            }
        }

        let seasonSelect = "<option hidden selected value> -- Missing ID -- </option>";
        let seasonDispValue;

        for(let i = 0; i < selectInpFields.season.data.length; i++) {
            seasonDispValue = selectInpFields.season.data[i].name;
            
            if(selectInpFields.season.data[i].id !== selectInpFields.season.upload) {
                seasonSelect += `<option value=${selectInpFields.season.data[i].id}>${seasonDispValue}</option>`;
            }
            else {
                seasonSelect += `<option selected value=${selectInpFields.season.upload}>${seasonDispValue}</option>`;
            }
            selectInpFields.season.colId.innerHTML = seasonSelect;
        }

        let trackSelect = "<option hidden selected value> -- Missing ID -- </option>";
        let trackDispValue;

        for(let i = 0; i < selectInpFields.track.data.length; i++) {
            trackDispValue = `${selectInpFields.track.data[i].id} - ${selectInpFields.track.data[i].name}`;
            
            if(selectInpFields.track.data[i].id !== selectInpFields.track.upload) {
                trackSelect += `<option value=${selectInpFields.track.data[i].id}>${trackDispValue}</option>`;
            }
            else {
                trackSelect += `<option selected value=${selectInpFields.track.upload}>${trackDispValue}</option>`;
            }
            selectInpFields.track.colId.innerHTML = trackSelect;
        }
    }

    function updateResultsTable(driver, points, isResultImported, isPointsUndefined, noPointsForFL, indexPosMap, availableDrivers, additionalResultsPoints, constructor, status, json, i = 0) {
        let upperLimit = i == 0 ? json.results.length - 1 : i;

        for(i; i <= upperLimit; i++) {
            var rowResult = `<tr class="text-center resultRow" id="resultsRow${i}">
                                <td class="border rounded p-2" id="resultsBodyPos${i}">
                                    <div class="flex px-2 justify-center gap-1">
                                        <button id="moveRowUp${i}" class="hidden bg-green-500 hover:bg-green-700 text-white font-semibold px-1 border border-green-700 rounded rowReorderBtn">
                                                <i class="text-sm fa fa-arrow-up"></i>
                                        </button>
                                        <button id="moveRowDown${i}" class="hidden bg-red-500 hover:bg-red-700 text-white font-semibold px-1 border border-red-700 rounded rowReorderBtn">
                                            <i class="text-sm fa fa-arrow-down"></i>
                                        </button>
                                        <input class="pl-6 w-16 text-center font-semibold numInp inputPos bg-white" type="number" id="inputPos${i}" min="1" value="${i + 1}" disabled\>
                                    </div>
                                </td>
                                <td class="border rounded py-2 px-1" id="resultsBodyDriver${i}">
                                    <div class="flex px-2 justify-center gap-2">
                                        <select id='driverSelect${i}' class="bg-gray-200 font-semibold w-32 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500 cursor-not-allowed selectInp selectDriver" disabled>
                                        </select>
                                        <button id="undoDriver${i}" class="hidden bg-white text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded undo">
                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="hidden border rounded p-2">
                                    <input class="w-12 text-center font-semibold" type="text" id="inputDriver${i}" value="${json.results[i].driver_id}"\>
                                </td>
                                <td class="border rounded py-2 px-1" id="resultsBodyConstructor${i}">
                                    <div class="flex px-2 justify-center gap-2">
                                        <select id='constructorSelect${i}' class="bg-gray-200 font-semibold w-32 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500 cursor-not-allowed selectInp" disabled>                       
                                        </select>
                                        <button id="undoConstructor${i}" class="hidden bg-white text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded undo">
                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="border rounded p-2" id="resultsBodyGrid${i}">
                                    <div class="flex px-2 justify-center gap-1">
                                        <input class="pl-3 w-16 text-center font-semibold numInp " type="number" id="inputGrid${i}" min="1" value="${json.results[i].grid}"\>
                                        <button id="undoGrid${i}" class="hidden bg-white text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded undo">
                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="border rounded p-2" id="resultsBodyStops${i}">
                                    <div class="flex px-2 justify-center gap-1">
                                        <input class="pl-3 w-16 text-center font-semibold numInp" type="number" id="inputStops${i}" min="0" value="${json.results[i].stops}"\>
                                        <button id="undoStops${i}" class="hidden bg-white text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded undo">
                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="border rounded p-2" id="resultsBodyFl${i}">
                                    <div class="flex px-2 justify-center gap-2">
                                        <input class="w-24 text-center font-semibold numInp" type="text" id="inputFl${i}" value="${json.results[i].fastestlaptime}"\>
                                        <button id="undoFl${i}" class="hidden bg-white text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded undo">
                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="border rounded p-2" id="resultsBodyTime${i}">
                                    <div class="flex px-2 justify-center gap-2">
                                        <input class="w-24 text-center font-semibold numInp" type="text" id="inputTime${i}" value="${json.results[i].time}"\>
                                        <button id="undoTime${i}" class="hidden bg-white text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded undo">
                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="border rounded py-2 px-1" id="resultsBodyStatus${i}">
                                    <div class="flex px-2 justify-around gap-2">
                                        <select id='statusSelect${i}' class="bg-gray-200 font-semibold w-24 p-1 leading-tight border border-gray-500 rounded hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-gray-500 cursor-not-allowed selectInp selectStatus" disabled>                       
                                        </select>
                                        <button id="undoStatus${i}" class="hidden bg-white text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded undo">
                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                        </button>
                                        <button id="addMore${i}" class="bg-white text-sm hover:bg-green-700 text-green-500 hover:text-white font-semibold py-1 px-2 border border-green-500 hover:border-transparent rounded addMoreBtn">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                                
                            </tr>`;
            $('#resultsTableBody').append(rowResult);

            var resultsAlertsCreation = `<div id="warningRaceTimeFasterThanPrevPos${i}" class="hidden w-3/4 bg-yellow-100 border-l-4 text-sm border-yellow-500 text-yellow-700 py-1 px-3 mb-2 rounded" role="alert"></div>

                                        <div id="raceTimeNotMatchingStatus${i}" class="hidden w-3/4 bg-yellow-100 border-l-4 text-sm border-yellow-500 text-yellow-700 py-1 px-3 mb-2 rounded" role="alert">
                                        </div>

                                        <div id="positionClassifiedForPoints${i}" class="hidden w-3/4 bg-yellow-100 border-l-4 text-sm border-yellow-500 text-yellow-700 py-1 px-3 mb-2 rounded" role="alert">
                                        </div>
            
                                        <div id="errorPosAlert${i}" class="hidden w-3/4 bg-red-100 border-l-4 text-sm border-red-500 text-red-700 py-1 px-3 mb-2 rounded" role="alert">
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
            $('#errorResultsAlerts').append(resultsAlertsCreation);
            
            let driverCol = document.getElementById(`driverSelect${i}`);
            let constructorCol = document.getElementById(`constructorSelect${i}`);
            let statusCol = document.getElementById(`statusSelect${i}`);
            populateResultsDropdowns(driver, availableDrivers, constructor, status, json, driverCol, constructorCol, statusCol, i);
            reflectFastestLap(points, isResultImported, isPointsUndefined, noPointsForFL, indexPosMap, additionalResultsPoints, json.results[i].status, i);
        }
    }

    function reflectFastestLap(points, isResultImported, isPointsUndefined, noPointsForFL, indexPosMap, additionalResultsPoints, selectedValue, i) {
        if(points[currentPointsSchemeSelected - 1] !== undefined) isPointsUndefined = false;

        if(noPointsForFL && !isPointsUndefined && isResultImported.currentVal !== 1) {
            if(selectedValue === 1 && points[currentPointsSchemeSelected - 1]['P' + indexPosMap[i]] > 0) {
                if(additionalResultsPoints[i] == 0) {
                    alert(`'Row ${indexPosMap[i]}' - Additional 'points' reset to -1 as it is a scoring position`);
                    additionalResultsPoints[indexPosMap[i] - 1] = -1;
                    $(`#addMore${i}`).removeClass('bg-white text-green-500');
                    $(`#addMore${i}`).addClass('bg-green-500 text-white');
                }
            }

            if(selectedValue === 1 && points[currentPointsSchemeSelected - 1]['P' + indexPosMap[i]] == 0) {
                if(additionalResultsPoints[i] == 0) {
                    alert(`'Row ${indexPosMap[i]}' - Additional 'points' reset to 0 as its a non scoring position`);
                    additionalResultsPoints[indexPosMap[i] - 1] = 0;
                    $(`#addMore${i}`).removeClass('bg-green-500 text-white');
                    $(`#addMore${i}`).addClass('bg-white text-green-500');
                }
            }
        }
        else if(!isPointsUndefined) {
            if(selectedValue === 1 && indexPosMap[i] > 10) {
                $('#warningFlBelowP10Alert').html(`<p>'Fastest Lap' <strong>STATUS</strong> at Row <strong>${indexPosMap[i]}</strong> [ensure -1 is added to additional attribute - <strong>POINTS</strong>]</p>`);
                
                if(points[currentPointsSchemeSelected - 1]['P' + indexPosMap[i]] != 0) {
                    $(`#resultsBodyStatus${indexPosMap[i] - 1}`).addClass('bg-yellow-600');
                    $('#warningFlBelowP10Alert').slideDown(500);
                }
                else {
                    $(`#resultsBodyStatus${indexPosMap[i] - 1}`).removeClass('bg-yellow-600');
                    $('#warningFlBelowP10Alert').slideUp(500);
                }
            }
            else $('#warningFlBelowP10Alert').slideUp(500);
        }
        
        if(selectedValue === 1) $(`#resultsRow${i}`).addClass('text-purple-600');
        else $(`#resultsRow${i}`).removeClass('text-purple-600');
    }

    function populateResultsDropdowns(driver, availableDrivers, constructor, status, json, driverCol, constructorCol, statusCol, i) {
        let selectInpFields = {
            driverID: {
                data: availableDrivers,
                originalData: driver,
                upload: json.results[i].driver_id,
                colId: driverCol
            },
            constructorID: {
                data: constructor,
                upload: json.results[i].constructor_id,
                colId: constructorCol
            },
            status: {
                data: status,
                upload: json.results[i].status,
                colId: statusCol
            }
        }

        let driverSelect = "<option hidden selected value> -- Missing ID -- </option>";
        let driverDispVal;

        for(let y = 0; y < selectInpFields.driverID.originalData.length; y++) {
            if(selectInpFields.driverID.originalData[y].id === selectInpFields.driverID.upload) {
                driverDispVal = selectInpFields.driverID.originalData[y].name;
                driverSelect += `<option selected value=${selectInpFields.driverID.originalData[y].id}>${driverDispVal}</option>`;
            }
        }

        for(let x = 0; x < selectInpFields.driverID.data.length; x++) {
            driverDispVal = selectInpFields.driverID.data[x].name;         
            driverSelect += `<option value=${selectInpFields.driverID.data[x].id}>${driverDispVal}</option>`;
            selectInpFields.driverID.colId.innerHTML = driverSelect;
        }
        // console.log(driverCol)

        let constructorSelect = "<option hidden selected value> -- Missing ID -- </option>";
        let constructorDispVal;
        for(let x = 0; x < selectInpFields.constructorID.data.length; x++) {
            constructorDispVal = `${selectInpFields.constructorID.data[x].id} - ${selectInpFields.constructorID.data[x].name}`;

            if(selectInpFields.constructorID.data[x].id !== selectInpFields.constructorID.upload) {
                constructorSelect += `<option value=${selectInpFields.constructorID.data[x].id}>${constructorDispVal}</option>`;
            }
            else {
                constructorSelect += `<option selected value=${selectInpFields.constructorID.data[x].id}>${constructorDispVal}</option>`;
            }
            selectInpFields.constructorID.colId.innerHTML = constructorSelect;
        }

        let statusSelect = "<option hidden selected value> -- Missing Status -- </option>";
        let statusDispVal;
        for(let x = 0; x < selectInpFields.status.data.length; x++) {
            statusDispVal = selectInpFields.status.data[x].value;

            if(selectInpFields.status.data[x].id !== selectInpFields.status.upload) {
                statusSelect += `<option value=${selectInpFields.status.data[x].id}>${statusDispVal}</option>`;
            }
            else {
                statusSelect += `<option selected value=${selectInpFields.status.data[x].id}>${statusDispVal}</option>`;
            }
            selectInpFields.status.colId.innerHTML = statusSelect;
        }
    }

    function repopulateDriverResultsDropdowns(driver, availableDrivers, json) {
        for(let x = 0; x < json.results.length; x++) {
            let driverSelect = "<option hidden selected value> -- Missing ID -- </option>";
            let driverDispVal;
            let driverCol = document.getElementById(`driverSelect${x}`);

            for(let y = 0; y < driver.length; y++) {
                if(driver[y].id === json.results[x].driver_id) {
                    driverDispVal = driver[y].name;
                    driverSelect += `<option selected value=${driver[y].id}>${driverDispVal}</option>`;
                }
            }

            for(let y = 0; y < availableDrivers.length; y++) {
                driverDispVal = availableDrivers[y].name;  
                driverSelect += `<option value=${availableDrivers[y].id}>${driverDispVal}</option>`;
                driverCol.innerHTML = driverSelect;
            }
        }
        // console.log(driverCol)
    }
    function repopulateConstructorResultsDropdowns(availableConstructors, json) {
        const e = new Event("change");

        for(let x = 0; x < json.results.length; x++) {
            let constructorSelect = "<option hidden selected value> -- Missing ID -- </option>";
            let constructorDispVal;
            let constructorCol = document.getElementById(`constructorSelect${x}`);

            for(let y = 0; y < availableConstructors.length; y++) {
                constructorDispVal = `${availableConstructors[y].id} - ${availableConstructors[y].name}`;

                if(availableConstructors[y].id !== json.results[x].constructor_id) {
                    constructorSelect += `<option value=${availableConstructors[y].id}>${constructorDispVal}</option>`;
                }
                else {
                    constructorSelect += `<option selected value=${availableConstructors[y].id}>${constructorDispVal}</option>`;
                }
                constructorCol.innerHTML = constructorSelect;
            }
            constructorCol.dispatchEvent(e);
        }
    }

    function populatePointsOverlay(points) {
        let headerFill = "";

        for(let i = 0; i < points.length; i++) {
            headerFill += "<th class='border rounded font-bold px-4 py-2'> <input type='checkbox' class='transform scale-125 cursor-pointer' id='select"+ (i+1) +"'><p>" + points[i].id + "</p></th>";
        }

        let pointsHeader = `<tr>
        <th class='border rounded font-bold px-4 py-2'>Pos</th>
                                ${headerFill}
                            </tr>`;
        $('#pointsTableHeaders').append(pointsHeader);
        
        for(let i = 0; i < Object.keys(points[0]).length - 3; i++) {
            let columnFill = "";

            for(let j = 0; j < points.length; j++) {
                columnFill += "<td class='border text-center rounded py-1 px-3' contenteditable='false'>" + points[j]['P' + (i+1)] + "</td>";
            }

            let pointsRow = `<tr>
            <td class='border text-center font-semibold rounded p-1' contenteditable='false'>P${i+1}</td>
            ${columnFill}
            </tr>`;

            $('#pointsTableBody').append(pointsRow);
        }
    }

    function updateJSONFromTable(json, additionalRaceDistance, raceTimeInAbsolutes, originalStatusMinusUnitsPlace, additionalResultsPoints, submitFlag = 0) {
        let trackContent = tableToJSON(document.getElementById('trackDetailsTable'));
        let resultsContent = tableToJSON(document.getElementById('resultsDetailsTable'));

        delete trackContent[0].undefined;

        if(submitFlag) {
            let tempNum, resultString, raceTimeInIntervals = false;
            // if(!$('.raceTimeCol').hasClass('absoluteTime')) raceTimeInIntervals = true;
            
            if(additionalRaceDistance.distance != '') trackContent[0].distance = additionalRaceDistance.distance;

            for(let i = 0; i < json.results.length; i++) {
                // tempNum = Math.abs(originalStatusMinusUnitsPlace[i] - json.results[i].status);
                // if(resultsContent[i].status >= 0) resultString = (tempNum + resultsContent[i].status).toFixed(2);
                // else resultString = (-tempNum + resultsContent[i].status).toFixed(2);

                if(resultsContent[i].status >= 0) resultString = (originalStatusMinusUnitsPlace[i] + resultsContent[i].status).toFixed(2);
                else resultString = (-originalStatusMinusUnitsPlace[i] + resultsContent[i].status).toFixed(2);

                resultsContent[i].status = parseFloat(resultString);
                
                if(additionalResultsPoints[i] !== 0) resultsContent[i].points = additionalResultsPoints[i];
                
                resultsContent[i].time = raceTimeInAbsolutes[i];
                
                if(!isNaN(resultsContent[i].fastestlaptime)) {
                    resultsContent[i].fastestlaptime = resultsContent[i].fastestlaptime.toFixed(3);
                }
            }
        }
    
        return {track: trackContent[0], results: resultsContent};
    }

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
                let temp = table.rows[0].cells[i].innerText;
                if(table.rows[0].cells[i].children[0] !== undefined) temp = table.rows[0].cells[i].children[0].innerText;

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
                if(tableRow.cells[j].children[0].children.length != 0) {
                    treeTraversal = tableRow.cells[j].children[0].children[0].options;
                    if(headers[j] == 'driver'){
                        rowContent = treeTraversal[treeTraversal.selectedIndex].innerHTML;
                    } else if(headers[j] == 'status') {
                        tempRow = treeTraversal.selectedIndex - 1;
                        rowContent = statusMap[tempRow];
                    } else if(headers[j] == 'points') {
                        rowContent = tableRow.cells[j].children[0].children[0].innerHTML;
                    } else if(headers[j] == 'position') {
                        rowContent = tableRow.cells[j].children[0].children[2].value;
                    } else {
                        rowContent = tableRow.cells[j].children[0].children[0].value;
                    }
                } else if(headers[j] == 'driver_id') {
                    leftCellTraversal = tableRow.cells[1].children[0].children[0].options;
                    rowContent = parseInt(leftCellTraversal[1].value);
                } else {
                    rowContent = tableRow.cells[j].innerHTML;
                }
                status = Number(rowContent);
                rowData[headers[j]] = (isNaN(status)) ? rowContent : status;
            }
            data.push(rowData);
        }
        return data;
    }

    function checkAndMonitorTrackData(json, isResultImported, trackDetailsStore, isPointsUndefined, noPointsForFL, season, tracks, points, constructor, raceTimeInIntervals, regexFl, regexTimeAbsolute, regexTimeInterval, indexPosMap, additionalResultsPoints) {
        let dataToCheck = {
            season: {
                jsonValue: json.track.season_id,
                allValues: season,
                selectInpNode: '#seasonSelect',
                parentNode: '#trackBodySeason',
                alertNode: '#errorSeasonAlert',
                undoBtn: '#undoSeason'
            },
            round: {
                jsonValue: json.track.round,
                inpNode: '#inputRound',
                parentNode: '#trackBodyRound',
                alertNode: '#errorRoundAlert',
                undoBtn: '#undoRound'
            },
            track: {
                jsonValue: json.track.circuit_id,
                allValues: tracks,
                selectInpNode: '#tracksSelect',
                parentNode: '#trackBodyCircuit',
                alertNode: '#errorCircuitAlert',
                undoBtn: '#undoCircuit'
            },
            points: {
                jsonValue: json.track.points,
                allValues: points,
                btnNode: '#pointsBtn',
                parentNode: '#trackBodyPoints',
                alertNode: '#errorPointsAlert',
                undoBtn: '#undoPoints',
                overlayNode: '#pointsSelectionOverlay'
            }
        }

        checkIfSeasonAndRoundCombinationAreExisting(isResultImported, trackDetailsStore, dataToCheck.season.jsonValue, dataToCheck.round.jsonValue);

        let seasonValidCheck = dataToCheck.season.allValues.find(item => {return item.id === dataToCheck.season.jsonValue});
        if(seasonValidCheck === undefined) {
            $(dataToCheck.season.parentNode).addClass('bg-red-600');
            $(dataToCheck.season.alertNode).slideDown(500);
        }
        $(dataToCheck.season.selectInpNode).change(function(event) {
            let selectedValue = $(dataToCheck.season.selectInpNode).val();
            trackDetailsStore.season = parseInt(selectedValue);

            clearSelectWarning(dataToCheck.season.selectInpNode, dataToCheck.season.allValues, selectedValue, dataToCheck.season.parentNode, dataToCheck.season.alertNode);
            let availableConstructors;
            if($('#bypassConstructorsCheck').is(':not(:checked)')) {
                availableConstructors = constructor;
                for(let i = 0; i < season.length; i++) {
                    if(season[i].id === parseInt(selectedValue)) availableConstructors = season[i].constructors;
                }
                repopulateConstructorResultsDropdowns(availableConstructors, json);
            }
            checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);
            checkIfSeasonAndRoundCombinationAreExisting(isResultImported, trackDetailsStore, dataToCheck.season.jsonValue, dataToCheck.round.jsonValue);
        })
        // test(dataToCheck.season.selectInpNode, dataToCheck.season.allValues, dataToCheck.season.jsonValue, dataToCheck.season.parentNode, dataToCheck.season.alertNode);
        resetField(dataToCheck.season.undoBtn, dataToCheck.season.selectInpNode, dataToCheck.season.jsonValue);

        
        inputFormatCheck(dataToCheck.round.jsonValue, dataToCheck.round.parentNode, dataToCheck.round.inpNode, dataToCheck.round.alertNode);
        $(dataToCheck.round.inpNode).change(function(event) {
            let selectedRoundVal = $(dataToCheck.round.inpNode).val();
            trackDetailsStore.round = parseInt(selectedRoundVal);

            inputFormatCheck(selectedRoundVal, dataToCheck.round.parentNode, dataToCheck.round.inpNode, dataToCheck.round.alertNode);
            checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);
            checkIfSeasonAndRoundCombinationAreExisting(isResultImported, trackDetailsStore, dataToCheck.season.jsonValue, dataToCheck.round.jsonValue);
        });
        resetField(dataToCheck.round.undoBtn, dataToCheck.round.inpNode, dataToCheck.round.jsonValue);


        let trackValidCheck = dataToCheck.track.allValues.find(item => {return item.id === dataToCheck.track.jsonValue});
        if(trackValidCheck === undefined) {
            $(dataToCheck.track.parentNode).addClass('bg-red-600');
            $(dataToCheck.track.alertNode).slideDown(500);
        }
        $(dataToCheck.track.selectInpNode).change(function(event) {
            let selectedValue = $(dataToCheck.track.selectInpNode).val();

            clearSelectWarning(dataToCheck.track.selectInpNode, dataToCheck.track.allValues, selectedValue, dataToCheck.track.parentNode, dataToCheck.track.alertNode);
            checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);
        });
        // test(dataToCheck.track.selectInpNode, dataToCheck.track.allValues, dataToCheck.track.jsonValue, dataToCheck.track.parentNode, dataToCheck.track.alertNode);
        resetField(dataToCheck.track.undoBtn, dataToCheck.track.selectInpNode, dataToCheck.track.jsonValue);
        
        let pointsValidCheck = dataToCheck.points.allValues.find(item => {return item.id === dataToCheck.points.jsonValue});
        if(pointsValidCheck === undefined) {
            $(dataToCheck.points.parentNode).addClass('bg-red-600');
            $(dataToCheck.points.alertNode).slideDown(500);
            $(dataToCheck.points.btnNode).html('0')
        }
        updatePointsSelection(json, points, isResultImported, isPointsUndefined, noPointsForFL, indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, additionalResultsPoints, dataToCheck.points.btnNode, dataToCheck.points.overlayNode, dataToCheck.points.parentNode, dataToCheck.points.alertNode);
        $(dataToCheck.points.undoBtn).click(function(event) {
            if(pointsValidCheck == undefined) {
                $(dataToCheck.points.btnNode).html('0');
                $('input:checkbox').not(this).prop('checked', false);
                $(dataToCheck.points.parentNode).addClass('bg-red-600');
                $(dataToCheck.points.alertNode).slideDown(500);
                checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);

            } else {
                $(dataToCheck.points.btnNode).html(dataToCheck.points.jsonValue);
                $('input:checkbox').not(this).prop('checked', false);
            }
        });        
    }

    function checkIfSeasonAndRoundCombinationAreExisting(isResultImported, trackDetailsStore, jsonSeasonValue, jsonRoundValue) {
        if(isResultImported.originalVal === 1) {
            let currentSeasonCheck = trackDetailsStore.season === jsonSeasonValue;
            let currentRoundCheck = trackDetailsStore.round === jsonRoundValue;

            if(currentSeasonCheck && currentRoundCheck) $('#warningSeasonRoundSameAsInitialAlert').slideDown(500);
            else $('#warningSeasonRoundSameAsInitialAlert').slideUp(500);
        }
    }

    function checkAndMonitorResultsData(json, driver, fastestLapIndexStore, timeIsNotNumberCheck, isResultImported, isPointsUndefined, noPointsForFL, constructor, status, points, regexFl, regexTimeAbsolute, regexTimeInterval, regexTimePos1Absolute, driverIDStore, raceTimeInIntervals, raceTimeInAbsolutes, gridStore, stopsStore, additionalResultsPoints, statusStore, indexPosMap, i) {
         
        let dataToCheck = {
            // position: {
            //     jsonValue: json.results[i].position,
            //     inpNode: `#inputPos${i}`,
            //     parentNode: `#resultsBodyPos${i}`,
            //     alertNode: `#errorPosAlert${i}`,
            //     undoBtn: `#undoPos${i}`
            // },
            driverID: {
                jsonValue: json.results[i].driver_id,
                allValues: driver,
                selectInpNode: `#driverSelect${i}`,
                parentNode: `#resultsBodyDriver${i}`,
                alertNode: `#errorDriverAlert${i}`,
                undoBtn: `#undoDriver${i}`
            },
            constructorID: {
                jsonValue: json.results[i].constructor_id,
                allValues: constructor,
                selectInpNode: `#constructorSelect${i}`,
                parentNode: `#resultsBodyConstructor${i}`,
                alertNode: `#errorConstructorAlert${i}`,
                undoBtn: `#undoConstructor${i}`
            },
            grid: {
                jsonValue: json.results[i].grid,
                inpNode: `#inputGrid${i}`,
                parentNode: `#resultsBodyGrid${i}`,
                alertNode: `#errorGridAlert${i}`,
                undoBtn: `#undoGrid${i}`
            },
            stops: {
                jsonValue: json.results[i].stops,
                inpNode: `#inputStops${i}`,
                parentNode: `#resultsBodyStops${i}`,
                alertNode: `#errorStopsAlert${i}`,
                undoBtn: `#undoStops${i}`
            },
            fastestLap: {
                jsonValue: json.results[i].fastestlaptime,
                inpNode: `#inputFl${i}`,
                parentNode: `#resultsBodyFl${i}`,
                alertNode: `#errorFlAlert${i}`,
                undoBtn: `#undoFl${i}`
            },
            time: {
                jsonValue: json.results[i].time,
                inpNode: `#inputTime${i}`,
                parentNode: `#resultsBodyTime${i}`,
                alertNode: `#errorTimeAlert${i}`,
                undoBtn: `#undoTime${i}`
            },
            status: {
                jsonValue: json.results[i].status,
                allValues: status,
                selectInpNode: `#statusSelect${i}`,
                parentNode: `#resultsBodyStatus${i}`,
                alertNode: `#errorStatusAlert${i}`,
                undoBtn: `#undoStatus${i}`
            }
        }

        // inputFormatCheck(dataToCheck.position.jsonValue, dataToCheck.position.parentNode, dataToCheck.position.inpNode, dataToCheck.position.alertNode);
        // $(dataToCheck.position.inpNode).change(function(event) {
        //     let selectedPosVal = $(dataToCheck.position.inpNode).val();
        //     dataToCheck.position.alertNode = `#errorPosAlert${indexPosMap[i] - 1}`;
        //     inputFormatCheck(selectedPosVal, dataToCheck.position.parentNode, dataToCheck.position.inpNode, dataToCheck.position.alertNode);
        // });
        // resetField(dataToCheck.position.undoBtn, dataToCheck.position.inpNode, dataToCheck.position.jsonValue);

        // Driver ID Checks
        let driverIDValidCheck = dataToCheck.driverID.allValues.find(item => {return item.id === dataToCheck.driverID.jsonValue});
        if(driverIDValidCheck === undefined) {
            $(dataToCheck.driverID.parentNode).addClass('bg-red-600');
            $(dataToCheck.driverID.alertNode).slideDown(500);
        }
        $(dataToCheck.driverID.selectInpNode).change(function(event) {
            let selectedValue = $(dataToCheck.driverID.selectInpNode).val();
            json.results[i].driver_id = parseInt(selectedValue)
            driverIDStore[i] = parseInt(selectedValue);

            dataToCheck.driverID.alertNode = `#errorDriverAlert${indexPosMap[i] - 1}`;

            availableDrivers = driver.filter(ele => !driverIDStore.includes(ele.id));
            repopulateDriverResultsDropdowns(driver, availableDrivers, json);
            
            checkDuplicateDiD(driverIDStore, indexPosMap);
            clearSelectWarning(dataToCheck.driverID.selectInpNode, dataToCheck.driverID.allValues, selectedValue, dataToCheck.driverID.parentNode, dataToCheck.driverID.alertNode);
            checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);
        })
        // test(dataToCheck.driverID.selectInpNode, dataToCheck.driverID.allValues, dataToCheck.driverID.jsonValue, dataToCheck.driverID.parentNode, dataToCheck.driverID.alertNode);
        resetField(dataToCheck.driverID.undoBtn, dataToCheck.driverID.selectInpNode, dataToCheck.driverID.jsonValue);

        // Constructor ID Checks
        let constructorIDValidCheck = dataToCheck.constructorID.allValues.find(item => {return item.id === dataToCheck.constructorID.jsonValue});
        if(constructorIDValidCheck === undefined) {
            $(dataToCheck.constructorID.parentNode).addClass('bg-red-600');
            $(dataToCheck.constructorID.alertNode).slideDown(500);
        }
        $(dataToCheck.constructorID.selectInpNode).change(function(event) {
            let selectedValue = $(dataToCheck.constructorID.selectInpNode).val();
            
            dataToCheck.constructorID.alertNode = `#errorConstructorAlert${indexPosMap[i] - 1}`;

            clearSelectWarning(dataToCheck.constructorID.selectInpNode, dataToCheck.constructorID.allValues, selectedValue, dataToCheck.constructorID.parentNode, dataToCheck.constructorID.alertNode);
            checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);
        })
        // test(dataToCheck.constructorID.selectInpNode, dataToCheck.constructorID.allValues, dataToCheck.constructorID.jsonValue, dataToCheck.constructorID.parentNode, dataToCheck.constructorID.alertNode);
        resetField(dataToCheck.constructorID.undoBtn, dataToCheck.constructorID.selectInpNode, dataToCheck.constructorID.jsonValue);

        // Starting Grid Checks
        inputFormatCheck(dataToCheck.grid.jsonValue, dataToCheck.grid.parentNode, dataToCheck.grid.inpNode, dataToCheck.grid.alertNode);
        $(dataToCheck.grid.inpNode).change(function(event) {
            let selectedGridVal = $(dataToCheck.grid.inpNode).val();

            gridStore[i] = parseInt(selectedGridVal);

            dataToCheck.grid.alertNode = `#errorGridAlert${indexPosMap[i] - 1}`;
            
            inputFormatCheck(selectedGridVal, dataToCheck.grid.parentNode, dataToCheck.grid.inpNode, dataToCheck.grid.alertNode);
            checkDuplicateGrid(gridStore, indexPosMap);
            checkGridValueGreaterThanArraySize(gridStore, indexPosMap);
            checkGridValuesStartWith1(gridStore, indexPosMap);
            checkGridValuesForBreakInSequence(gridStore, indexPosMap);
            isAllGridValues0(gridStore, indexPosMap);
            checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);
        });
        resetField(dataToCheck.grid.undoBtn, dataToCheck.grid.inpNode, dataToCheck.grid.jsonValue);

        
        // Laps Completed Checks
        inputFormatCheck(dataToCheck.stops.jsonValue, dataToCheck.stops.parentNode, dataToCheck.stops.inpNode, dataToCheck.stops.alertNode, 0);
        $(dataToCheck.stops.inpNode).change(function(event) {
            let selectedStopsVal = $(dataToCheck.stops.inpNode).val();
            let nextRow = $(this).closest('tr').next();
            
            // json.results[i].stops = parseInt(selectedStopsVal);
            stopsStore[indexPosMap[i] - 1] = parseInt(selectedStopsVal);
            // console.log(stopsStore)
            
            dataToCheck.stops.alertNode = `#errorStopsAlert${indexPosMap[i] - 1}`;

            // console.log('i check')
            checkIfCurrentTimeLessThanPosAbove(json, timeIsNotNumberCheck, stopsStore, raceTimeInAbsolutes, indexPosMap, i);
            
            if (nextRow.length) {
                let nextIndex = parseInt((nextRow[0].querySelector('.inputPos').id).match(/\d+/g)[0]);
                // console.log('nextRow check')
                
                checkIfCurrentTimeLessThanPosAbove(json, timeIsNotNumberCheck, stopsStore, raceTimeInAbsolutes, indexPosMap, nextIndex);
            }
            inputFormatCheck(selectedStopsVal, dataToCheck.stops.parentNode, dataToCheck.stops.inpNode, dataToCheck.stops.alertNode, 0);
            checkRaceTimeMatchesWithStatus(json, indexPosMap, statusStore, stopsStore, i);
            checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);
        });
        resetField(dataToCheck.stops.undoBtn, dataToCheck.stops.inpNode, dataToCheck.stops.jsonValue);
        

        // Fastest Lap Checks
        timeCheck(regexFl, dataToCheck.fastestLap.jsonValue, dataToCheck.fastestLap.inpNode, dataToCheck.fastestLap.parentNode, dataToCheck.fastestLap.alertNode);
        $(dataToCheck.fastestLap.inpNode).change(function(event) {
            let selectedFastestLapVal = $(dataToCheck.fastestLap.inpNode).val();
            json.results[i].fastestlaptime = selectedFastestLapVal;

            dataToCheck.fastestLap.alertNode = `#errorFlAlert${indexPosMap[i] - 1}`;

            timeCheck(regexFl, selectedFastestLapVal, dataToCheck.fastestLap.inpNode, dataToCheck.fastestLap.parentNode, dataToCheck.fastestLap.alertNode);
            isFastestLapPresentAndMatchingWithStatus(json, fastestLapIndexStore, indexPosMap, statusStore, regexFl);
            checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);
        });
        resetField(dataToCheck.fastestLap.undoBtn, dataToCheck.fastestLap.inpNode, dataToCheck.fastestLap.jsonValue);
        
        // Total Time Checks
        let originalAbsoluteRaceTime = raceTimeInAbsolutes[indexPosMap[i] - 1];
        let originalIntervalRaceTime = raceTimeInIntervals[indexPosMap[i] - 1];

        // if((indexPosMap[i] - 1) === 0) {
        //     $(`#errorTimeAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> RACE TIME</strong> [field must be in one of the following formats:<strong> '-'</strong>, <strong>'1:06.006'</strong>, <strong>+X Lap(s)</strong>, <strong>DNS</strong>, <strong>DNF</strong> or <strong>DSQ</strong>]</p>`);

        //     timeCheck(regexTimeAbsolute, dataToCheck.time.jsonValue, dataToCheck.time.inpNode, dataToCheck.time.parentNode, dataToCheck.time.alertNode);
        // }
        // else {
        checkIfCurrentTimeLessThanPosAbove(json, timeIsNotNumberCheck, stopsStore, raceTimeInAbsolutes, indexPosMap, i);
        if((indexPosMap[i] - 1) === 0) {
            $(`#errorTimeAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> RACE TIME</strong> [field must be in one of the following formats:<strong> '-'</strong> or <strong>'1:06.006'</strong>`);

            timeCheck(regexTimeAbsolute, dataToCheck.time.jsonValue, dataToCheck.time.inpNode, dataToCheck.time.parentNode, dataToCheck.time.alertNode);
        }
        else {
            if($('.raceTimeCol').hasClass('absoluteTime')) {
                timeCheck(regexTimeAbsolute, dataToCheck.time.jsonValue, dataToCheck.time.inpNode, dataToCheck.time.parentNode, dataToCheck.time.alertNode);
            }
            else {
                timeCheck(regexTimeInterval, dataToCheck.time.jsonValue, dataToCheck.time.inpNode, dataToCheck.time.parentNode, dataToCheck.time.alertNode);
            }
        }
        
        disableToggleBtnsOnTimeError(json, regexTimePos1Absolute, indexPosMap);
        $(dataToCheck.time.inpNode).change(function(event) {
            let selectedTimeVal = $(dataToCheck.time.inpNode).val();
            let timeCheckPos1Absolute = new RegExp(regexTimePos1Absolute);
            
            if($('.raceTimeCol').hasClass('absoluteTime')) {
                raceTimeInAbsolutes[indexPosMap[i] - 1] = selectedTimeVal;
                // regexTime = "^((\\d+\\:[0-5])|[0-5]?)\\d[.]\\d{3}$|^DNF$|^DSQ$|^DNS$|^\\+1 Lap$|^\\+[2-9][0-9]* Laps$|^\\-$";
                // let timeCheck = new RegExp(regexTime);
                
                if((indexPosMap[i] - 1) === 0) {
                    raceTimeInIntervals[0] = selectedTimeVal;
                    raceTimeInAbsolutes[0] = selectedTimeVal;
                    json.results[0].time = selectedTimeVal;
                    
                    if(timeCheckPos1Absolute.test(raceTimeInAbsolutes[0])) {
                        $(`#resultsBodyTime${i}`).removeClass('bg-yellow-600');
                        $(`#inputTime${i}`).removeClass('bg-yellow-600');
                        $(`#inputTime${i}`).removeClass('font-bold');
                        $(`#inputTime${i}`).removeClass('text-white');
                        $('#warningRaceTimeFirstPosNotAbsoluteAlert').slideUp(500);
                    }
                    else {
                        $(`#resultsBodyTime${i}`).addClass('bg-yellow-600');
                        $(`#inputTime${i}`).addClass('bg-yellow-600');
                        $(`#inputTime${i}`).addClass('font-bold');
                        $(`#inputTime${i}`).addClass('text-white');
                        $('#warningRaceTimeFirstPosNotAbsoluteAlert').slideDown(500);
                    }
                    
                    if(timeCheckPos1Absolute.test(selectedTimeVal)) {
                        for(let x = 1; x < json.results.length; x++) {
                            if(!timeIsNotNumberCheck.test(raceTimeInIntervals[x])) {
                                raceTimeInIntervals[x] = convertAbsoluteTimeToInterval(raceTimeInAbsolutes[x], raceTimeInIntervals[0]);
                            }
                        }
                    }
                }
                else {
                    raceTimeInIntervals[indexPosMap[i] - 1] = selectedTimeVal;
                    json.results[indexPosMap[i] - 1].time = selectedTimeVal;

                    if(!timeIsNotNumberCheck.test(selectedTimeVal)) {
                        raceTimeInIntervals[indexPosMap[i] - 1] = convertAbsoluteTimeToInterval(selectedTimeVal, raceTimeInIntervals[0]);
                        // if(!timeCheck.test(selectedTimeVal)) raceTimeInIntervals[indexPosMap[i] - 1] = 'Error';
                    }
                }
            }
            else {
                raceTimeInIntervals[indexPosMap[i] - 1] = selectedTimeVal;
                // regexTime = "^(\\+|\\-)((\\d+\\:[0-5])|[0-5]?)\\d[.]\\d{3}$|^DNF$|^DSQ$|^DNS$|^\\+1 Lap$|^\\+[2-9][0-9]* Laps$|^\\-$";
                // let timeCheck = new RegExp(regexTime);

                if((indexPosMap[i] - 1) === 0) {
                    raceTimeInAbsolutes[0] = selectedTimeVal;
                    raceTimeInIntervals[0] = selectedTimeVal;
                    json.results[0].time = selectedTimeVal;

                    if(timeCheckPos1Absolute.test(raceTimeInIntervals[0])) {
                        $(`#resultsBodyTime${i}`).removeClass('bg-yellow-600');
                        $(`#inputTime${i}`).removeClass('bg-yellow-600');
                        $(`#inputTime${i}`).removeClass('font-bold');
                        $(`#inputTime${i}`).removeClass('text-white');
                        $('#warningRaceTimeFirstPosNotAbsoluteAlert').slideUp(500);
                    }
                    else {
                        $(`#resultsBodyTime${i}`).addClass('bg-yellow-600');
                        $(`#inputTime${i}`).addClass('bg-yellow-600');
                        $(`#inputTime${i}`).addClass('font-bold');
                        $(`#inputTime${i}`).addClass('text-white');
                        $('#warningRaceTimeFirstPosNotAbsoluteAlert').slideDown(500);
                    }

                    if(timeCheckPos1Absolute.test(selectedTimeVal)) {
                        for(let x = 1; x < json.results.length; x++) {
                            if(!timeIsNotNumberCheck.test(raceTimeInIntervals[x])) {
                                raceTimeInIntervals[x] = convertAbsoluteTimeToInterval(raceTimeInAbsolutes[x], raceTimeInIntervals[0]);
                                $(`#inputTime${indexPosMap[x] - 1}`).val(raceTimeInIntervals[x]);
                            }
                        }
                    }

                }
                else {
                    raceTimeInAbsolutes[indexPosMap[i] - 1] = selectedTimeVal;
                    json.results[indexPosMap[i] - 1].time = selectedTimeVal;
                    
                    if(!timeIsNotNumberCheck.test(selectedTimeVal)) {
                        raceTimeInAbsolutes[indexPosMap[i] - 1] = convertIntervalTimeToAbsolute(selectedTimeVal, raceTimeInIntervals[0]);
                        // if(!timeCheck.test(selectedTimeVal)) raceTimeInAbsolutes[indexPosMap[i] - 1] = 'Error';
                    }
                }
            }

            // console.log('time check run i')
            checkIfCurrentTimeLessThanPosAbove(json, timeIsNotNumberCheck, stopsStore, raceTimeInAbsolutes, indexPosMap, i);
            dataToCheck.time.alertNode = `#errorTimeAlert${indexPosMap[i] - 1}`;
            if((indexPosMap[i] - 1) === 0) {
                $(`#errorTimeAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> RACE TIME</strong> [field must be in one of the following formats:<strong> '-'</strong> or <strong>'1:06.006'</strong>`);

                timeCheck(regexTimeAbsolute, selectedTimeVal, dataToCheck.time.inpNode, dataToCheck.time.parentNode, dataToCheck.time.alertNode);
            }
            else {
                if($('.raceTimeCol').hasClass('absoluteTime')) {
                    timeCheck(regexTimeAbsolute, selectedTimeVal, dataToCheck.time.inpNode, dataToCheck.time.parentNode, dataToCheck.time.alertNode);
                }
                else {
                    timeCheck(regexTimeInterval, selectedTimeVal, dataToCheck.time.inpNode, dataToCheck.time.parentNode, dataToCheck.time.alertNode);
                }
            }
            disableToggleBtnsOnTimeError(json, regexTimePos1Absolute, indexPosMap);
            checkRaceTimeMatchesWithStatus(json, indexPosMap, statusStore, stopsStore, i);
            // isFastestLapPresentAndMatchingWithStatus(json, fastestLapIndexStore, indexPosMap, statusStore, regexFl);
            checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);
        });
        // resetField(dataToCheck.time.undoBtn, dataToCheck.time.inpNode, dataToCheck.time.jsonValue);
        $(dataToCheck.time.undoBtn).click(function(event) {
            if($('.raceTimeCol').hasClass('absoluteTime')) {
                $(dataToCheck.time.inpNode).val(originalAbsoluteRaceTime);
            }
            else {
                let oldIntervalRaceTime = convertAbsoluteTimeToInterval(originalAbsoluteRaceTime, raceTimeInIntervals[0]);

                if((indexPosMap[i] - 1) === 0 || originalIntervalRaceTime === '') oldIntervalRaceTime = originalAbsoluteRaceTime;
                if(timeIsNotNumberCheck.test($(`#inputTime${i}`).val())) {
                    if(!timeIsNotNumberCheck.test(originalIntervalRaceTime)) {
                        originalIntervalRaceTime = convertAbsoluteTimeToInterval(originalAbsoluteRaceTime, raceTimeInIntervals[0]);
                    }
                    oldIntervalRaceTime = originalIntervalRaceTime;
                }

                $(dataToCheck.time.inpNode).val(oldIntervalRaceTime);
            }

            const e = new Event("change");
            const element = document.querySelector(dataToCheck.time.inpNode);
            element.dispatchEvent(e);
        });

        // Status Checks
        let statusValidCheck = dataToCheck.status.allValues.find(item => {return item.id === dataToCheck.status.jsonValue});
        if(statusValidCheck === undefined) {
            $(dataToCheck.status.parentNode).addClass('bg-red-600');
            $(dataToCheck.status.alertNode).slideDown(500);
        }
        $(dataToCheck.status.selectInpNode).change(function(event) {
            
            let selectedValue = $(dataToCheck.status.selectInpNode).val();
            statusStore[i] = parseInt(selectedValue);

            dataToCheck.status.alertNode = `#errorStatusAlert${indexPosMap[i] - 1}`;

            reflectFastestLap(points, isResultImported, isPointsUndefined, noPointsForFL, indexPosMap, additionalResultsPoints, parseInt(selectedValue), i);
            clearSelectWarning(dataToCheck.status.selectInpNode, dataToCheck.status.allValues, selectedValue, dataToCheck.status.parentNode, dataToCheck.status.alertNode);
            checkDuplicateStatus(statusStore, indexPosMap);
            checkRaceTimeMatchesWithStatus(json, indexPosMap, statusStore, stopsStore, i);
            isFastestLapPresentAndMatchingWithStatus(json, fastestLapIndexStore, indexPosMap, statusStore, regexFl);
            checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);
        })
        // test(dataToCheck.status.selectInpNode, dataToCheck.status.allValues, dataToCheck.status.jsonValue, dataToCheck.status.parentNode, dataToCheck.status.alertNode);
        resetField(dataToCheck.status.undoBtn, dataToCheck.status.selectInpNode, dataToCheck.status.jsonValue);
    }

    function checkIfCurrentTimeLessThanPosAbove(json, timeIsNotNumberCheck, stopsStore, raceTimeInAbsolutes, indexPosMap, i) {
         
        // console.log('r', raceTimeInAbsolutes)
        // console.log('in', indexPosMap)
        // console.log('i', i)
        if(indexPosMap[i] === 1)
            return;

        let prevRaceTime = raceTimeInAbsolutes[indexPosMap[i] - 2];
        let currentRaceTime = raceTimeInAbsolutes[indexPosMap[i] - 1];
        let prevRaceTimeInSeconds = convertTimeFormatToSeconds(prevRaceTime);
        let currentRaceTimeInSeconds = convertTimeFormatToSeconds(currentRaceTime);
        
        let prevStops = stopsStore[indexPosMap[i] - 2];
        let currentStops = stopsStore[indexPosMap[i] - 1];
        // console.log(indexPosMap[i], currentStops, prevStops)

        // Warning should not be displayed if:
        // 1. Pos i has laps completed more than Pos i + 1
        // or 2. Pos i has the same number of laps completed and lesser finishing time
        // else, Show Warning

        if(prevStops < currentStops) {
            $(`#resultsBodyStops${i}`).addClass('bg-yellow-600');
            $(`#resultsBodyTime${i}`).removeClass('bg-yellow-600');
            $(`#inputStops${i}`).addClass('bg-yellow-600');
            $(`#inputTime${i}`).removeClass('bg-yellow-600');
            $(`#inputStops${i}`).addClass('font-bold');
            $(`#inputTime${i}`).removeClass('font-bold');
            $(`#inputStops${i}`).addClass('text-white');
            $(`#inputTime${i}`).removeClass('text-white');

            $(`#warningRaceTimeFasterThanPrevPos${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> LAPS COMPLETED</strong> is more than the that of row above</p>`)
            $(`#warningRaceTimeFasterThanPrevPos${indexPosMap[i] - 1}`).slideDown(500);
        }
        else if(!timeIsNotNumberCheck.test(currentRaceTime) && !timeIsNotNumberCheck.test(prevRaceTime)) {
            if((currentRaceTimeInSeconds < prevRaceTimeInSeconds) && (currentStops === prevStops)) {
                $(`#resultsBodyTime${i}`).addClass('bg-yellow-600');
                $(`#resultsBodyStops${i}`).removeClass('bg-yellow-600');
                $(`#inputTime${i}`).addClass('bg-yellow-600');
                $(`#inputStops${i}`).removeClass('bg-yellow-600');
                $(`#inputTime${i}`).addClass('font-bold');
                $(`#inputTime${i}`).addClass('text-white');

                if(!$(`#inputStops${i}`).hasClass('bg-red-600')) {
                    $(`#inputStops${i}`).removeClass('font-bold');
                    $(`#inputStops${i}`).removeClass('text-white');
                }

                $(`#warningRaceTimeFasterThanPrevPos${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> RACE TIME</strong> is less than the that of row above having <strong>COMPLETED ${currentStops} LAPS</stron></p>`)
                $(`#warningRaceTimeFasterThanPrevPos${indexPosMap[i] - 1}`).slideDown(500);
            }
            else {
                $(`#resultsBodyTime${i}`).removeClass('bg-yellow-600');
                $(`#resultsBodyStops${i}`).removeClass('bg-yellow-600');
                $(`#inputTime${i}`).removeClass('bg-yellow-600');
                $(`#inputStops${i}`).removeClass('bg-yellow-600');
                $(`#inputTime${i}`).removeClass('font-bold');
                $(`#inputTime${i}`).removeClass('text-white');

                if(!$(`#inputStops${i}`).hasClass('bg-red-600')) {
                    $(`#inputStops${i}`).removeClass('font-bold');
                    $(`#inputStops${i}`).removeClass('text-white');
                }

                $(`#warningRaceTimeFasterThanPrevPos${indexPosMap[i] - 1}`).slideUp(500);
            }
        }
        else {
            $(`#resultsBodyTime${i}`).removeClass('bg-yellow-600');
            $(`#resultsBodyStops${i}`).removeClass('bg-yellow-600');
            $(`#inputTime${i}`).removeClass('bg-yellow-600');
            $(`#inputStops${i}`).removeClass('bg-yellow-600');
            $(`#inputTime${i}`).removeClass('font-bold');
            $(`#inputTime${i}`).removeClass('text-white');

            if(!$(`#inputStops${i}`).hasClass('bg-red-600')) {
                $(`#inputStops${i}`).removeClass('font-bold');
                $(`#inputStops${i}`).removeClass('text-white');
            }

            $(`#warningRaceTimeFasterThanPrevPos${indexPosMap[i] - 1}`).slideUp(500);
        }
    }

    function checkDuplicateDiD(driverIDStore, indexPosMap) {
        let uniqueDiD = new Set(driverIDStore);
        let filteredEle = driverIDStore.filter(ele => {
            if(uniqueDiD.has(ele)) uniqueDiD.delete(ele)
            else return ele;
        })
        
        let duplicateDiD = [...new Set(filteredEle)];

        for(let i = 0; i < driverIDStore.length; i++) {
            if(!isNaN(driverIDStore[i]) && driverIDStore[i] != null && driverIDStore[i] != 0) {
                let j = 0;
                for(j; j < duplicateDiD.length; j++) {
                    if(duplicateDiD[j] === driverIDStore[i]) {
                        break;
                    }
                }
                
                if(j === duplicateDiD.length) {
                    $(`#resultsBodyDriver${i}`).removeClass('bg-red-600');
                    $(`#errorDriverAlert${indexPosMap[i] - 1}`).slideUp(500);
                    $(`#errorDriverAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> DRIVER</strong> [field is missing]</p>`);
                }
                else {
                    $(`#resultsBodyDriver${i}`).addClass('bg-red-600');
                    $(`#errorDriverAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> DRIVER</strong> [field is a duplicate value]</p>`);
                    $(`#errorDriverAlert${indexPosMap[i] - 1}`).slideDown(500);
                }
            }
            else {
                $(`#errorDriverAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> DRIVER</strong> [field is missing]</p>`);
            }
        }
    }

    function checkDuplicateStatus(statusStore, indexPosMap) {
        let usedStatusNumbers = [-3, -2, 0, 1];
        let uniqueStatus = new Set(statusStore);
        let filteredEle = statusStore.filter(ele => {
            if(uniqueStatus.has(ele)) uniqueStatus.delete(ele)
            else return ele;
        })
        
        let duplicateStatus = [...new Set(filteredEle)];

        for(let i = 0; i < statusStore.length; i++) {
            if(statusStore[i] != null && !isNaN(statusStore[i]) && usedStatusNumbers.includes(statusStore[i])) {
                let j = 0;
                for(j; j < duplicateStatus.length; j++) {
                    if(duplicateStatus[j] === statusStore[i] && duplicateStatus[j] === 1) {
                        break;
                    }
                }
                
                if(j === duplicateStatus.length) {
                    $(`#resultsBodyStatus${i}`).removeClass('bg-red-600');
                    $(`#errorStatusAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> STATUS</strong> [invalid field]</p>`);
                    $(`#errorStatusAlert${indexPosMap[i] - 1}`).slideUp(500);
                }
                else {
                    $(`#resultsBodyStatus${i}`).removeClass('bg-yellow-600');
                    $(`#resultsBodyStatus${i}`).addClass('bg-red-600');
                    $(`#errorStatusAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> STATUS</strong> [field is a duplicate fastest lap value]</p>`);
                    $(`#errorStatusAlert${indexPosMap[i] - 1}`).slideDown(500);
                }
            }
            else {
                $(`#errorStatusAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> STATUS</strong> [invalid field]</p>`);
            }
        } 
    }

    function checkDuplicateGrid(gridStore, indexPosMap) {
        
        let uniqueGrid = new Set(gridStore);
        let filteredEle = gridStore.filter(ele => {
            if(uniqueGrid.has(ele)) uniqueGrid.delete(ele)
            else return ele;
        })
        
        let duplicateGrid = [...new Set(filteredEle)];

        for(let i = 0; i < gridStore.length; i++) {
            if(!isNaN(gridStore[i]) && gridStore[i] != null && gridStore[i] != 0) {
                let j = 0;
                for(j; j < duplicateGrid.length; j++) {
                    if(duplicateGrid[j] === gridStore[i]) {
                        break;
                    }
                }
                
                if(j === duplicateGrid.length) {
                    $(`#resultsBodyGrid${i}`).removeClass('bg-red-600');
                    $(`#inputGrid${i}`).removeClass('bg-red-600');
                    $(`#inputGrid${i}`).removeClass('font-bold');
                    $(`#inputGrid${i}`).removeClass('text-white');
                    $(`#errorGridAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> STARTING GRID</strong> [field must be a positive integer]</p>`);
                    $(`#errorGridAlert${indexPosMap[i] - 1}`).slideUp(500);
                }
                else {
                    $(`#resultsBodyGrid${i}`).addClass('bg-red-600');
                    $(`#inputGrid${i}`).addClass('bg-red-600');
                    $(`#inputGrid${i}`).addClass('font-bold');
                    $(`#inputGrid${i}`).addClass('text-white');
                    $(`#errorGridAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> STARTING GRID</strong> [field is a duplicate starting grid value]</p>`);
                    $(`#errorGridAlert${indexPosMap[i] - 1}`).slideDown(500);
                }
            }
            else {
                $(`#errorGridAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> STARTING GRID</strong> [field must be a positive integer]</p>`);
            }
        } 
    }

    function checkGridValueGreaterThanArraySize(gridStore, indexPosMap) {
        for(let i = 0; i < gridStore.length; i++) {
            if(gridStore[i] > gridStore.length && !$(`#resultsBodyGrid${i}`).hasClass('bg-red-600')) {
                $(`#resultsBodyGrid${i}`).addClass('bg-red-600');
                $(`#inputGrid${i}`).addClass('bg-red-600');
                $(`#inputGrid${i}`).addClass('font-bold');
                $(`#inputGrid${i}`).addClass('text-white');
                $(`#errorGridAlert${indexPosMap[i] - 1}`).html(`<p>Row<strong> ${indexPosMap[i]}</strong> -<strong> STARTING GRID</strong> [field value is greater than the number of position entries]</p>`);
                $(`#errorGridAlert${indexPosMap[i] - 1}`).slideDown(500);
            }
        }
    }

    // function to check whether all grid store includes 1
    function checkGridValuesStartWith1(gridStore, indexPosMap) {
        let minGrid = gridStore[0];
        let minGridIdx;

        for(let i = 0; i < gridStore.length; i++) if(gridStore[i] < minGrid) minGrid = gridStore[i];

        minGridIdx = gridStore.indexOf(minGrid);
        if(!gridStore.includes(1) && !$(`#resultsBodyGrid${minGrid}`).hasClass('bg-red-600')) {
            $(`#resultsBodyGrid${minGridIdx}`).addClass('bg-red-600');
            $(`#inputGrid${minGridIdx}`).addClass('bg-red-600');
            $(`#inputGrid${minGridIdx}`).addClass('font-bold');
            $(`#inputGrid${minGridIdx}`).addClass('text-white');
            $(`#errorGridAlert${indexPosMap[minGridIdx] - 1}`).html(`<p>Row<strong> ${indexPosMap[minGridIdx]}</strong> -<strong> STARTING GRID</strong> [grid sequence should start with 1]</p>`);
            $(`#errorGridAlert${indexPosMap[minGridIdx] - 1}`).slideDown(500);
        }
    }

    // function to check a break in sequence in grid store
    function checkGridValuesForBreakInSequence(gridStore, indexPosMap) {
        let breakIdx, isSequenceBroken = 0, increment = 0, expectedVal = 1;
        
        let sortedGridStore = gridStore.slice().sort((a, b) => a - b);

        let previousGridVal = 0;
        for(let i = 0; i < sortedGridStore.length; i++) {
            if(sortedGridStore[i] == previousGridVal) {
                increment++;
                if(sortedGridStore[i] != 0) expectedVal++;
                continue;
            }

            if(sortedGridStore[i] != sortedGridStore[0] + increment) {
                breakIdx = gridStore.indexOf(sortedGridStore[i]);
                isSequenceBroken = 1;
                break;
            }

            increment++;
            expectedVal++;
            previousGridVal = sortedGridStore[i];
        }

        if(isSequenceBroken && !$(`#resultsBodyGrid${breakIdx}`).hasClass('bg-red-600')) {
            $(`#resultsBodyGrid${breakIdx}`).addClass('bg-red-600');
            $(`#inputGrid${breakIdx}`).addClass('bg-red-600');
            $(`#inputGrid${breakIdx}`).addClass('font-bold');
            $(`#inputGrid${breakIdx}`).addClass('text-white');
            $(`#errorGridAlert${indexPosMap[breakIdx] - 1}`).html(`<p>Row<strong> ${indexPosMap[breakIdx]}</strong> -<strong> STARTING GRID</strong> [break in grid sequence, <strong>${expectedVal}</strong> is expected]</p>`);
            $(`#errorGridAlert${indexPosMap[breakIdx] - 1}`).slideDown(500);
        }
    }

    function isAllGridValues0(gridStore, indexPosMap) {
        let isAllGridValuesZero = !gridStore.some(item => item !== 0);

        if(isAllGridValuesZero) {
            for(let i = 0; i < gridStore.length; i++) {
                $(`#resultsBodyGrid${i}`).removeClass('bg-red-600');
                $(`#inputGrid${i}`).removeClass('bg-red-600');
                $(`#inputGrid${i}`).removeClass('font-bold');
                $(`#inputGrid${i}`).removeClass('text-white');
                $(`#errorGridAlert${indexPosMap[i] - 1}`).slideUp(500);
            }
        }
    }

    function serialiseRowReorderControls(json, originalStatusMinusUnitsPlace, raceTimeInAbsolutes, stopsStore, additionalResultsPoints, indexPosMap, i) {
        $(`#moveRowUp${i}`).click(function(event) {    
            let thisRow = $(this).closest('tr');
            let prevRow = thisRow.prev();
            if (prevRow.length) {
                let currentPos = parseInt(thisRow[0].querySelector('.inputPos').value);
                let prevPos = parseInt(prevRow[0].querySelector('.inputPos').value);
                let prevIndex = parseInt((prevRow[0].querySelector('.inputPos').id).match(/\d+/g)[0]);
                let tempStops, tempStatus, tempAddPoints;

                // Swapping values between rows
                indexPosMap[i] = prevPos;
                indexPosMap[prevIndex] = currentPos;
                // console.log(currentPos, prevIndex, indexPosMap)

                tempRaceTimeInAbsolutes = raceTimeInAbsolutes[currentPos - 1];
                raceTimeInAbsolutes[currentPos - 1] = raceTimeInAbsolutes[prevPos - 1];
                raceTimeInAbsolutes[prevPos - 1] = tempRaceTimeInAbsolutes;
                // console.log(raceTimeInAbsolutes)
                
                // tempStops = stopsStore[currentPos - 1];
                // stopsStore[currentPos - 1] = stopsStore[prevPos - 1];
                // stopsStore[prevPos - 1] = tempStops;

                tempStatus = originalStatusMinusUnitsPlace[currentPos - 1];
                originalStatusMinusUnitsPlace[currentPos - 1] = originalStatusMinusUnitsPlace[prevPos - 1];
                originalStatusMinusUnitsPlace[prevPos - 1] = tempStatus;

                tempAddPoints = additionalResultsPoints[currentPos - 1];
                additionalResultsPoints[currentPos - 1] = additionalResultsPoints[prevPos - 1];
                additionalResultsPoints[prevPos - 1] = tempAddPoints;

                currentPos -= 1;
                prevPos += 1;

                thisRow[0].querySelector('.inputPos').value = currentPos;
                prevRow[0].querySelector('.inputPos').value = prevPos;
                
                prevRow.before(thisRow);

                // console.log('fire prev i', prevIndex);
                fireChangeEvents(prevIndex);
                // console.log('fire i', i);
                fireChangeEvents(i);
            }

            disableFirstAndLastReorderBtns();
        })
        
        $(`#moveRowDown${i}`).click(function(event) {            
            let thisRow = $(this).closest('tr');
            let nextRow = thisRow.next();
            
            if (nextRow.length) {
                let currentPos = parseInt(thisRow[0].querySelector('.inputPos').value);
                let nextPos = parseInt(nextRow[0].querySelector('.inputPos').value);
                let nextIndex = parseInt((nextRow[0].querySelector('.inputPos').id).match(/\d+/g)[0]);
                let tempStops, tempStatus, tempAddPoints;

                indexPosMap[i] = nextPos;
                indexPosMap[nextIndex] = currentPos;
                // console.log(i, nextIndex, indexPosMap)

                tempRaceTimeInAbsolutes = raceTimeInAbsolutes[currentPos - 1];
                raceTimeInAbsolutes[currentPos - 1] = raceTimeInAbsolutes[nextPos - 1];
                raceTimeInAbsolutes[nextPos - 1] = tempRaceTimeInAbsolutes;
                // console.log(raceTimeInAbsolutes)

                // tempStops = stopsStore[currentPos - 1];
                // stopsStore[currentPos - 1] = stopsStore[nextPos - 1];
                // stopsStore[nextPos - 1] = tempStops;

                tempStatus = originalStatusMinusUnitsPlace[currentPos - 1];
                originalStatusMinusUnitsPlace[currentPos - 1] = originalStatusMinusUnitsPlace[nextPos - 1];
                originalStatusMinusUnitsPlace[nextPos - 1] = tempStatus;

                tempAddPoints = additionalResultsPoints[currentPos - 1];
                additionalResultsPoints[currentPos - 1] = additionalResultsPoints[nextPos - 1];
                additionalResultsPoints[nextPos - 1] = tempAddPoints;
                // console.log(additionalResultsPoints)
                
                currentPos += 1;
                nextPos -= 1;
                
                thisRow[0].querySelector('.inputPos').value = currentPos;
                nextRow[0].querySelector('.inputPos').value = nextPos;  
                
                nextRow.after(thisRow);

                fireChangeEvents(nextIndex);
                fireChangeEvents(i);
            }

            disableFirstAndLastReorderBtns();
        })

        disableFirstAndLastReorderBtns();
    }

    function fireChangeEvents(index) {
        let elements = [`#inputPos${index}`, `#driverSelect${index}`, `#constructorSelect${index}`, `#inputGrid${index}`, `#inputStops${index}`, `#inputFl${index}`, `#inputTime${index}`, `#statusSelect${index}`];

        const e = new Event("change");
        for(let i = 0; i < elements.length; i++) {
            const element = document.querySelector(elements[i]);
            element.dispatchEvent(e);
        }
    }

    function disableFirstAndLastReorderBtns() {
        let resultsTable = document.getElementById('resultsDetailsTable');
        let noOfRows = resultsTable.children[1].children.length;

        let firstUpBtn = resultsTable.children[1].children[0].children[0].children[0].children[0];
        let lastDownBtn = resultsTable.children[1].children[noOfRows - 1].children[0].children[0].children[1];

        if(noOfRows > 1) {
            let secondUpBtn = resultsTable.children[1].children[1].children[0].children[0].children[0];
            let secondLastDownBtn = resultsTable.children[1].children[noOfRows - 2].children[0].children[0].children[1];

            $(secondUpBtn).addClass('hover:bg-green-700');
            $(secondUpBtn).removeClass('opacity-50 cursor-not-allowed');

            $(secondLastDownBtn).addClass('hover:bg-red-700');
            $(secondLastDownBtn).removeClass('opacity-50 cursor-not-allowed');
        }

        $(firstUpBtn).removeClass('hover:bg-green-700');
        $(firstUpBtn).addClass('opacity-50 cursor-not-allowed');

        $(lastDownBtn).removeClass('hover:bg-red-700');
        $(lastDownBtn).addClass('opacity-50 cursor-not-allowed');
    }

    function inputFormatCheck(inputValue, parentNode, inpNode, alertNode, minVal = 1) {
         
        let isFraction = inputValue % 1;

        if(isNaN(inputValue) || (inputValue < minVal) || (inputValue == '') || (inputValue == '.') || (isFraction != 0)) {
            $(parentNode).addClass('bg-red-600');
            $(inpNode).addClass('bg-red-600');
            $(inpNode).addClass('font-bold');
            $(inpNode).addClass('text-white');
            $(alertNode).slideDown(500);
        } else {
            $(parentNode).removeClass('bg-red-600');
            $(inpNode).removeClass('bg-red-600');
            if(!$(parentNode).hasClass('bg-yellow-600')) {
                $(inpNode).removeClass('font-bold');
                $(inpNode).removeClass('text-white');
            }
            $(alertNode).slideUp(500);
        }
    }

    function clearSelectWarning(selectInpNode, allValues, selectedValue, parentNode, alertNode) {
        let validityCheck = allValues.find(item => {return item.id === selectedValue});

        if(validityCheck === undefined) {
            if(selectedValue === null || selectedValue === '') {
                $(parentNode).removeClass('bg-yellow-600');
                $(parentNode).addClass('bg-red-600');
                $(alertNode).slideDown(500);
            }
            else {
                $(parentNode).removeClass('bg-red-600');
                $(alertNode).slideUp(500);
            }
        }
    }

    // function test(selectInpNode, allValues, jsonValue, parentNode, alertNode) {
    //     $(selectInpNode).change(function(event) {
    //         let selectedValue = $(selectInpNode).val();
    //         let validityCheck = allValues.find(item => {return item.id === jsonValue});
            
    //         if(validityCheck === undefined) {
    //             if(selectedValue == null) {
    //                 $(parentNode).addClass('bg-red-600');
    //                 $(alertNode).slideDown(500);
    //             }
    //             else {
    //                 $(parentNode).removeClass('bg-red-600');
    //                 $(alertNode).slideUp(500);
    //             }
    //         }
    //     });
    // }

    function timeCheck(regex, value, inpNode, parentNode, alertNode) {
        let timeCheck = new RegExp(regex);

        if(!(timeCheck.test(value))) {
            if($(parentNode).hasClass('bg-yellow-600')) {
                $(parentNode).removeClass('bg-yellow-600');
                $(inpNode).removeClass('bg-yellow-600');
            }
            $(parentNode).addClass('bg-red-600');
            $(inpNode).addClass('bg-red-600');
            $(inpNode).addClass('font-bold');
            $(inpNode).addClass('text-white');
            $(alertNode).slideDown(500);   
        } else {
            $(parentNode).removeClass('bg-red-600');
            $(inpNode).removeClass('bg-red-600');
            $(inpNode).removeClass('font-bold');
            if(!$(parentNode).hasClass('bg-yellow-600')) $(inpNode).removeClass('text-white');
            $(alertNode).slideUp(500);    
        }

        // if($(parentNode).hasClass('bg-red-600')) {
        //     $(("#raceTimeFormatToggleBtn")).addClass('disableActionBtns text-white');
        //     $(("#raceTimeFormatToggleBtn")).removeClass('text-red-700');
        // }
        // else {
        //     $(("#raceTimeFormatToggleBtn")).removeClass('disableActionBtns text-white');
        //     $(("#raceTimeFormatToggleBtn")).addClass('text-red-700');
        // }
    }

    function disableToggleBtnsOnTimeError(json, regexTimePos1Absolute, indexPosMap) {
        let noTimeErrors = 1;
        let isTimePos1Absolute = new RegExp(regexTimePos1Absolute);
        let raceTimePos1 = json.results[0].time;

        for(let i = 0; i < json.results.length; i++) {
            noTimeErrors -= checkForError(`#resultsBodyTime${i}`);
        }

        // if(!isTimePos1Absolute.test(raceTimePos1)) {
        //     $(("#raceTimeFormatToggleBtn")).addClass('disableActionBtns text-white');
        //     $(("#raceTimeFormatToggleBtn")).removeClass('text-red-700');

        //     if(!$('.raceTimeCol').hasClass('absoluteTime')) {
        //         const e = new Event("click");
        //         const element = document.querySelector("#raceTimeFormatToggleBtn");
        //         element.dispatchEvent(e);
        //     }
        // }
        // else {
        //     $(("#raceTimeFormatToggleBtn")).removeClass('disableActionBtns text-white');
        //     $(("#raceTimeFormatToggleBtn")).addClass('text-red-700');
        // }
        

        if(noTimeErrors === 1) {
            if(isTimePos1Absolute.test(raceTimePos1) && (!$('#rowReorderToggleBtn').hasClass('editing'))) {
                $(("#raceTimeFormatToggleBtn")).removeClass('disableActionBtns text-white');
                $("#raceTimeFormatBtnWrapper").removeClass('tooltip');
                $(("#raceTimeFormatToggleBtn")).addClass('text-red-700');
            }
            
            if(!$('#rowReorderToggleBtn').hasClass('editing')) {
                $(("#rowReorderToggleBtn")).removeClass('disableActionBtns text-white');
                $("#rowReorderBtnWrapper").removeClass('tooltip');
                $(("#rowReorderToggleBtn")).addClass('text-orange-700');
            }
        }
        else {
            $(("#raceTimeFormatToggleBtn")).addClass('disableActionBtns text-white');
            $("#raceTimeFormatBtnWrapper").addClass('tooltip');
            $(("#raceTimeFormatToggleBtn")).removeClass('text-red-700');

            $(("#rowReorderToggleBtn")).addClass('disableActionBtns text-white');
            $("#rowReorderBtnWrapper").addClass('tooltip');
            $(("#rowReorderToggleBtn")).removeClass('text-orange-700');
        }


        if(!isTimePos1Absolute.test(raceTimePos1)) {
            $(("#raceTimeFormatToggleBtn")).addClass('disableActionBtns text-white');
            $("#raceTimeFormatBtnWrapper").addClass('tooltip');
            $(("#raceTimeFormatToggleBtn")).removeClass('text-red-700');

            if(!$('.raceTimeCol').hasClass('absoluteTime')) {
                const e = new Event("click");
                const element = document.querySelector("#raceTimeFormatToggleBtn");
                element.dispatchEvent(e);
            }
        }
        else {
            if(noTimeErrors === 1 && (!$('#rowReorderToggleBtn').hasClass('editing'))) {
                $(("#raceTimeFormatToggleBtn")).removeClass('disableActionBtns text-white');
                $("#raceTimeFormatBtnWrapper").removeClass('tooltip');
                $(("#raceTimeFormatToggleBtn")).addClass('text-red-700');
            }
        }
    }

    function resetField(undoBtn, node, jsonValue) {
        $(undoBtn).click(function(event) {
            $(node).val(jsonValue);
            if($(node).val() === null) $(node).prop('selectedIndex', 0);
            
            const e = new Event("change");
            const element = document.querySelector(node);
            element.dispatchEvent(e);
        });
    }

    function updatePointsSelection(json, points, isResultImported, isPointsUndefined, noPointsForFL, indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, additionalResultsPoints, btnNode, overlayNode, parentNode, alertNode) {
        $(btnNode).click(function(event) {
            $(overlayNode).removeClass('hidden');
            $(overlayNode).addClass('flex');
            let selectIndex = $(btnNode).html();
            $(`#select${selectIndex}`).prop('checked', true);
        });

        for(let i = 0; i < points.length; i++) {
            $(`#select${i+1}`).click(function(event) {
                $('input:checkbox').not(this).prop('checked', false);
                $(btnNode).html(i + 1);
                $(parentNode).removeClass('bg-red-600');
                $(alertNode).slideUp(500);
                $(overlayNode).removeClass('flex');
                $(overlayNode).addClass('hidden');

                currentPointsSchemeSelected = i + 1;
                isPointsUndefined = false;

                let selectedValue, flAtIndex;
                // const e = new Event("change");
                for(let x = 0; x < json.results.length; x++) {
                    // let selectedValue = parseInt($(`#statusSelect${x}`).val());
                    // if(selectedValue === 1 && points[currentPointsSchemeSelected - 1]['P' + (indexPosMap[x])] == 0) {    
                    //     alert(`Status change at 'Position ${indexPosMap[x]}' has reset 'points' attribute to '0'`);
                    //     additionalResultsPoints[indexPosMap[x] - 1] = 0;
                    //     $(`#addMore${x}`).removeClass('bg-green-500 text-white');
                    //     $(`#addMore${x}`).addClass('bg-white text-green-500');
                    // }
                    
                    // const element = document.querySelector(`#statusSelect${x}`);
                    // element.dispatchEvent(e);
                    
                    if(parseInt($(`#statusSelect${x}`).val()) === 1) {
                        selectedValue = parseInt($(`#statusSelect${x}`).val());
                        flAtIndex = x;
                    }
                }

                reflectFastestLap(points, isResultImported, isPointsUndefined, noPointsForFL, indexPosMap, additionalResultsPoints, selectedValue, flAtIndex);
                checkAllTableValueForErrors(indexPosMap, regexFl, regexTimeAbsolute, regexTimeInterval, raceTimeInIntervals, json);
            });
        }

        // reflectFastestLap(points, isResultImported, isPointsUndefined, noPointsForFL, indexPosMap, additionalResultsPoints, parseInt(selectedValue), i);
    }

    function checkForError(value) {
        let flag = 0;
        if($(value).hasClass('bg-red-600')) flag = 1;
        return flag;
    }

    function isFastestLapPresentAndMatchingWithStatus(json, fastestLapIndexStore, indexPosMap, statusStore, regex) {
        
        let flFormatCheck = new RegExp(regex);
        let shortestTime = Number.MAX_VALUE;
        let isFastestLapPresent = statusStore.includes(1);
        let fastestLapRowPosition;
        
        for(let i = 0; i < json.results.length; i++) {
            let currentFl = json.results[i].fastestlaptime;

            if(flFormatCheck.test(currentFl)) {
                let currentFastestLapInSeconds = convertTimeFormatToSeconds(json.results[i].fastestlaptime);
                if(currentFastestLapInSeconds <= shortestTime) {
                    shortestTime = currentFastestLapInSeconds;
                    fastestLapRowPosition = indexPosMap[i];
                    fastestLapIndexStore.current = i;
                }
                // if(currentFastestLapInSeconds === shortestTime) fastestLapRowPosition = i;
            }

            // if(selectedValue === 1 && indexPosMap[i] > 10) {
            //     $('#warningFlBelowP10Alert').html(`<p>'Fastest Lap' <strong>STATUS</strong> at Row <strong>${indexPosMap[i]}</strong> [ensure -1 is added to additional attribute - <strong>POINTS</strong>]</p>`);
                
            //     if(points[currentPointsSchemeSelected - 1]['P' + indexPosMap[i]] != 0) {

            // if($(`#resultsBodyStatus${i}`).hasClass('bg-yellow-600')) {
            //     $(`#resultsBodyStatus${i}`).removeClass('bg-yellow-600');
            // }
        }

        if(statusStore[fastestLapIndexStore.current] === 0) {
            $('#warningFlStatusNotMatchingAlert').html(`Row <strong>${fastestLapRowPosition}</strong> with fastest lap time does not have 'Fastest Lap' <strong>STATUS</strong>`);
            $(`#resultsBodyStatus${fastestLapIndexStore.previous}`).removeClass('bg-yellow-600');
            $(`#resultsBodyStatus${fastestLapIndexStore.current}`).addClass('bg-yellow-600');
            $('#warningFlStatusNotMatchingAlert').slideDown(500);
        }
        else {
            $(`#resultsBodyStatus${fastestLapIndexStore.previous}`).removeClass('bg-yellow-600');
            $(`#resultsBodyStatus${fastestLapIndexStore.current}`).removeClass('bg-yellow-600');
            $('#warningFlStatusNotMatchingAlert').slideUp(500);
        }

        if(!isFastestLapPresent) $('#warningNoPosWithStatus1Alert').slideDown(500);
        else $('#warningNoPosWithStatus1Alert').slideUp(500);

        fastestLapIndexStore.previous = fastestLapIndexStore.current;
    }

    function checkRaceTimeMatchesWithStatus(json, indexPosMap, statusStore, stopsStore, i) {
        let currentRaceTime = json.results[indexPosMap[i] - 1].time;

        // if((indexPosMap[i] - 1) === 0) stopsStore.maxLapsCompleted = json.results[indexPosMap[i] - 1].stops;

        let cutoffLaps = Math.ceil(stopsStore[0] * 0.75);

        if(currentRaceTime === 'DNF') {
            if(statusStore[i] !== -2 && stopsStore[indexPosMap[i] - 1] < cutoffLaps) {
                $(`#raceTimeNotMatchingStatus${indexPosMap[i] - 1}`).html(`Row <strong>${indexPosMap[i]}</strong> with race time of <strong>DNF</strong> does not have 'DNF' <strong>STATUS</strong>`);
                if(!$(`#resultsBodyStatus${i}`).hasClass('bg-red-600')) $(`#resultsBodyStatus${i}`).addClass('bg-yellow-600');
                $(`#positionClassifiedForPoints${indexPosMap[i] - 1}`).slideUp(500);
                $(`#raceTimeNotMatchingStatus${indexPosMap[i] - 1}`).slideDown(500);
            }
            else if(statusStore[i] === -2 && stopsStore[indexPosMap[i] - 1] >= cutoffLaps) {
                $(`#positionClassifiedForPoints${indexPosMap[i] - 1}`).html(`Row <strong>${indexPosMap[i]}</strong> with race time of <strong>DNF</strong> having completed <strong>${stopsStore[i]} LAPS</strong> should not have 'DNF' <strong>STATUS</strong>`);
                if(!$(`#resultsBodyStatus${i}`).hasClass('bg-red-600')) $(`#resultsBodyStatus${i}`).addClass('bg-yellow-600');
                $(`#raceTimeNotMatchingStatus${indexPosMap[i] - 1}`).slideUp(500);
                $(`#positionClassifiedForPoints${indexPosMap[i] - 1}`).slideDown(500);
            }
            else {
                $(`#resultsBodyStatus${i}`).removeClass('bg-yellow-600');
                $(`#raceTimeNotMatchingStatus${indexPosMap[i] - 1}`).slideUp(500);
                $(`#positionClassifiedForPoints${indexPosMap[i] - 1}`).slideUp(500);
            }
        }
        else if(currentRaceTime === 'DSQ') {
            if(statusStore[i] !== -3) {
                $(`#raceTimeNotMatchingStatus${indexPosMap[i] - 1}`).html(`Row <strong>${indexPosMap[i]}</strong> with race time of <strong>DSQ</strong> does not have 'DSQ' <strong>STATUS</strong>`);
                if(!$(`#resultsBodyStatus${i}`).hasClass('bg-red-600')) $(`#resultsBodyStatus${i}`).addClass('bg-yellow-600');
                $(`#raceTimeNotMatchingStatus${indexPosMap[i] - 1}`).slideDown(500);
            }
            else {
                $(`#resultsBodyStatus${i}`).removeClass('bg-yellow-600');
                $(`#raceTimeNotMatchingStatus${indexPosMap[i] - 1}`).slideUp(500);
            }
        }
        else if(statusStore[i] === -2 && stopsStore[indexPosMap[i] - 1] >= cutoffLaps) {
            $(`#positionClassifiedForPoints${indexPosMap[i] - 1}`).html(`Row <strong>${indexPosMap[i]}</strong> with race time of <strong>DNF</strong> having completed <strong>${stopsStore[i]} LAPS</strong> should not have 'DNF' <strong>STATUS</strong>`);
            if(!$(`#resultsBodyStatus${i}`).hasClass('bg-red-600')) $(`#resultsBodyStatus${i}`).addClass('bg-yellow-600');
            $(`#raceTimeNotMatchingStatus${indexPosMap[i] - 1}`).slideUp(500);
            $(`#positionClassifiedForPoints${indexPosMap[i] - 1}`).slideDown(500);
        }
        else {
            $(`#resultsBodyStatus${i}`).removeClass('bg-yellow-600');
            $(`#raceTimeNotMatchingStatus${indexPosMap[i] - 1}`).slideUp(500);
            $(`#positionClassifiedForPoints${indexPosMap[i] - 1}`).slideUp(500);
        }
    }

    function isValidTimeFormat(raceTimeInIntervals, regexFl, regexTimeAbsolute, regexTimeInterval, json) {
        let timeCheckFl = new RegExp(regexFl);
        let timeCheckAbsolute = new RegExp(regexTimeAbsolute);
        let timeCheckInterval = new RegExp(regexTimeInterval);
        let postStatus = 1;

        // console.log(json.results, raceTimeInIntervals)
        
        for(let i = 0; i < json.results.length; i++) {
            if(!(timeCheckFl.test(json.results[i].fastestlaptime))) postStatus = 0;
            
            if($('.raceTimeCol').hasClass('absoluteTime')) {
                if(i === 0) {
                    if(!(timeCheckAbsolute.test(raceTimeInIntervals[0]))) postStatus = 0;
                }
                else {
                    if(!(timeCheckAbsolute.test(json.results[i].time))) postStatus = 0;
                }
            }
            else {
                if(i === 0) {
                    if(!(timeCheckAbsolute.test(raceTimeInIntervals[0]))) postStatus = 0;
                }
                else {
                    if(!(timeCheckInterval.test(raceTimeInIntervals[i]))) postStatus = 0;
                }
            }
        }
        return postStatus;
    }

    function postJson(json, season) {
        $.ajax({
            type: "POST",
            url: "/results/race",
            data: json,
            contentType: "application/json",
            success: function (result) {
                // console.log(result);
                $('#onFailure').addClass('hidden');
                $('#onSuccess').removeClass('hidden');
                $('#editScreen').toggleClass('hidden');
                $('#serverResponseScreen').toggleClass('hidden');

                $('#raceID').html(`Race result uploaded with ID <strong>${result.race.id}</strong>`);
                
                $('#download').click(function(event) {   
                    let resultJSON = {
                        track: {
                            circuit_id: result.race.circuit_id,
                            season_id: result.race.season_id,
                            round: result.race.round,
                            points: result.race.points,
                            distance: result.race.distance
                        },
                        results: []
                    };

                    for(let i = 0; i < result.result.length; i++) {
                        resultJSON.results.push({
                            position: result.result[i].position,
                            constructor_id: result.result[i].constructor_id,
                            grid: result.result[i].grid,
                            stops: result.result[i].stops,
                            time: result.result[i].time,
                            fastestlaptime: result.result[i].fastestlaptime,
                            status: result.result[i].status,
                            driver_id: result.result[i].driver_id,
                            driver: JSON.parse(json).results[i].driver
                        })

                        if(result.result[i].points !== 0)  resultJSON.results[i].points = result.result[i].points;
                    }
                    
                    let btnName = 'download';
                    downloadJSON(resultJSON, btnName, season, resultJSON.track.season_id, resultJSON.track.round, result.race.id);
                })
            },
            error: function (result, status) {
                // console.log(result);
                // $('#failureText').html("Something went wrong");
                $('#failureText').html(`${result.responseJSON.message} of Position <strong>${result.responseJSON.error.position}</strong>`);
                $('#onSuccess').addClass('hidden');
                $('#onFailure').removeClass('hidden');
                $('#editScreen').toggleClass('hidden');
                $('#serverResponseScreen').toggleClass('hidden');
            }
        });
    }

    function downloadJSON(json, btnName, season, seasonID, roundNo, raceID = 'review') {
        let tierName;
        for(let i = 0; i < season.length; i++) {
            if(season[i].id === seasonID) tierName = season[i].tiername.split(" ").join("_");
        }

        let data = "text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(json, null, 4));
        $(`#${btnName}`).attr("href", "data:"+data);
        $(`#${btnName}`).attr("download", `S${seasonID}_R${roundNo}_${tierName}_${raceID}.json`);  
    }

    function convertTimeFormatToSeconds(fastestLapInMinutes) {
        let fastestLapSplit, minutes, seconds, fastestLapInSeconds;

        if(fastestLapInMinutes != null) {
            if(fastestLapInMinutes.includes(":")) {
                fastestLapSplit = fastestLapInMinutes.split(':');
                minutes = fastestLapSplit[0] * 60;
                seconds = +fastestLapSplit[1];
            }
            else {
                minutes = 0;
                seconds = +fastestLapInMinutes;
            }
        }
        fastestLapInSeconds = minutes + seconds;

        return fastestLapInSeconds;
    }

    function convertAbsoluteTimeToInterval(time, firstPosTime) {
        let firstPosTimeInSeconds = convertTimeFormatToSeconds(firstPosTime);
        let timeInSeconds = convertTimeFormatToSeconds(time);

        let interval = (timeInSeconds - firstPosTimeInSeconds).toFixed(3);
        if(Math.abs(+interval) > 60) {
            let minutes = Math.floor(interval / 60);
            let seconds = (interval % 60).toFixed(3);

            if(+interval < 0) seconds = (Math.abs(+interval) % 60).toFixed(3);
            if(parseFloat(+seconds) < 10) seconds = '0' + seconds;
    
            interval = [minutes, seconds].join(':');
        }

        if(firstPosTimeInSeconds > timeInSeconds) return `${interval}`;
        else return `+${interval}`;
    }

    function convertIntervalTimeToAbsolute(interval, firstPosTime) {
        let firstPosTimeInSeconds = convertTimeFormatToSeconds(firstPosTime);

        let timeToAdd = '';
        if(interval.includes('+')) timeToAdd = interval.split('+')[1];
        if(interval.includes('-')) timeToAdd = interval.split('-')[1];

        let secondsToAdd = +(convertTimeFormatToSeconds(timeToAdd));
        
        let absoluteTime = (firstPosTimeInSeconds + secondsToAdd).toFixed(3);
        if(interval.includes('-')) absoluteTime = (firstPosTimeInSeconds - secondsToAdd).toFixed(3);

        if(+absoluteTime > 60) {
            let minutes = Math.floor(absoluteTime / 60);
            let seconds = (absoluteTime % 60).toFixed(3);

            if(parseFloat(+seconds) < 10) seconds = '0' + seconds;
    
            absoluteTime = [minutes, seconds].join(':');
        }

        return absoluteTime;
    }
    
    function fetchResultByIDAndPassForEdit(raceNumber, season, points, tracks, constructor, driver, status) {
        $.ajax({
            type: "GET",
            url: `/result/${raceNumber}`,
            contentType: "application/json",
            success: function (result) {
                // console.log(result)
                let isResultImportedOrFromScratch = 1;

                result.results.sort((a,b) => a.position - b.position);
                viewJSONData(result, season, points, tracks, constructor, driver, status, isResultImportedOrFromScratch);

                $('.numInp').addClass('disable');
                $('.numInp').addClass('cursor-not-allowed');
                $('.addMoreBtn').addClass('disable');
                $('.addMoreBtn').addClass('cursor-not-allowed');
                $('#addMoreTrack').addClass('disable');
                $('#addMoreTrack').addClass('cursor-not-allowed');

                enableEditOnErrorAfterLoading(result);
            },
            error: function (result, status) {
                $('#incorrectRaceNumber').html(`<p><strong>Race ID ${raceNumber}</strong> is not present in database</p>`);
                $('#importRace').html('Import uploaded race result');
                $('#incorrectRaceNumber').slideDown(500);
            }
        });
    }
</script>
@endsection
