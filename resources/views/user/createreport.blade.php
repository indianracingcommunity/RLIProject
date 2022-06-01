@extends('layouts.app')
@section('content')

<style>
input[type="radio"]+label span,
input[type="checkbox"]+label span {
    transition: background .2s,
        transform .2s;
}

input[type="radio"]:checked+label,
input[type="checkbox"]:checked+label {
    color: rgb(147 51 234);
}

input[type="radio"]+label span:hover,
input[type="radio"]+label:hover span {
    transform: scale(1.2);
}

input[type="radio"]:checked+label span {
    background-color: rgb(147 51 234);
    box-shadow: 0px 0px 0px 2px white inset;
}

input[type="checkbox"]:checked+label span {
    background-color: rgb(147 51 234);
}

input[type="checkbox"]:checked+label span::before {
    position: absolute;
    top: -5px;
    content: '✔';
    font-weight: 200;
    color: white;
}

select {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

#photo_upload_label:hover svg,
#photo_upload_label:hover p {
    color: rgb(147 51 234);
}

/* ============================== Driver Select Dropdown ==================================*/
.spacing {
    height: 42px;
}

.dropdown-form {
    height: 42px;
    position: relative;
}

.dropdown-label {
    position: absolute;
}

.dropdown-list {
    position: absolute;
    max-height: 230px;
    top: 42px;
    transform-origin: 50% 0;
    transform: scale(1, 0);
    transition: transform .15s ease-in-out .15s;
    overflow-y: scroll;
    background-color: white;
}

.dropdown-activated {
    transform: scale(1, 1);
}

.dropdown-disabled {
    pointer-events: none;
    opacity: 0.5;
}

@media screen and (min-width: 1920px) {
    .container {
        margin-top: 125px;
    }
}

@media screen and (max-width: 450px) {
    .mobile-text-xxs {
        font-size: 0.5rem;
    }
}
</style>

<!-- <div class="container mx-auto lg:w-3/4">
    <div class="rounded text-green-600 p-4 mb-3 border-2 border-green-600 font-semibold my-4">
        <i class="far fa-check-circle mr-2"></i>Report Submitted Successfully
    </div>
</div> -->
<div class="container w-screen">
    <!-- Report Title -->
    <div class="font-semibold text-left shadow-lg bg-purple-200 rounded-md lg:w-3/4 px-6 py-4 mx-auto">
        <div class="text-xl lg:text-3xl text-purple-800">Create Report<br></div>
        <p class="text-sm lg:text-base text-purple-600"><i class="fa fa-exclamation-circle"
                aria-hidden="true"></i><strong>
                Disclaimer</strong>: Stewards can take <strong>action</strong> against parties involved,
            <strong>including</strong> the reporting driver.
        </p>
    </div>

    <!-- Report Form -->
    <div class="mx-auto my-4 py-4 px-8 lg:px-20 shadow-lg rounded-lg lg:w-3/4">
        <form action="{{route('report.submit')}}" method="POST" class="my-4" onsubmit="return validateReport()"
            enctype="multipart/form-data">
            @csrf
            <!-- Form Elements -->
            <div class='grid row-gap-2 md:row-gap-8 md:grid-cols-2'>
                <!-- ======= Race ======= -->
                <label class="text-gray-700 text-base font-bold">Race</label>
                <div class="relative mb-6 md:mb-0">
                    <div
                        class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                    <select
                        class="appearance-none bg-gray-200 shadow-lg border border-gray-500 cursor-pointer rounded py-2 px-3 w-full hover:border-purple-600 hover:bg-purple-100 focus:bg-white focus:border-purple-600"
                        id="race" name="race">
                        @for ($i =0 ; $i <count($data) ; $i++) <option value="{{$data[$i]['id']}}">
                            {{$data[$i]['circuit']['name'] ." - ".$data[$i]['season']['name']}} </option>
                            @endfor
                    </select>
                </div>

                <!-- ======= Reporting Against ======= -->
                <label class="text-gray-700 text-base font-bold">Reporting Against?</label>
                <div class="mb-6 md:mb-0">
                    <div class="inline-flex items-center mr-4">
                        <input id="radio_driver" name="reporting_against" type="radio" class="hidden" value="DRIVER"
                            checked />
                        <label id="label_driver" for="radio_driver" class="flex items-center cursor-pointer">
                            <span class="w-3 h-3 inline-block mr-1 rounded-full border border-grey"></span>
                            Driver</label>
                    </div>
                    <div class="inline-flex items-center mr-4">
                        <input id="radio_game" name="reporting_against" type="radio" class="hidden" value="GAME" />
                        <label id="label_game" for="radio_game" class="flex items-center cursor-pointer">
                            <span class="w-3 h-3 inline-block mr-1 rounded-full border border-grey"></span>
                            Game</label>
                    </div>
                </div>

                <!-- ======= Driver Select ======= -->
                <div class="md:col-span-2" id="driver_select_container">
                    <div class="grid row-gap-2 md:grid-cols-2 mb-8 md:mb-2">
                        <label class="text-gray-700 text-base font-bold">Select Driver(s)
                        </label>
                        <div class="w-96 dropdown-form">
                            <label
                                class="dropdown-label overflow-auto bg-gray-200 shadow-lg border border-gray-500 cursor-pointer rounded py-2 px-3 w-full hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-600">
                                No Drivers Selected
                            </label>
                            <div
                                class="inline-block pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 15 15">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                            <div class="spacing w-full"></div>
                            <div class="block w-auto text-red-600 text-sm italic" id="errorDriver"></div>
                            <!-- Driver Dropdown List -->
                            <div class="dropdown-list border rounded hover:bg-white hover:border-purple-600 w-full">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======= Incident Occurance ======= -->
                <label class="text-gray-700 text-base font-bold">Incident Occurred In?</label>
                <div class="mb-6 md:mb-0">
                    <div class="inline-flex items-center mr-6">
                        <input id="radio_quali" name="incident_occurred" type="radio" class="hidden" value="QUALI" />
                        <label id="label_quali" for="radio_quali" class="flex items-center cursor-pointer">
                            <span class="w-3 h-3 inline-block mr-1 rounded-full border border-grey"></span>
                            Quali</label>
                    </div>
                    <div class="inline-flex items-center mr-6">
                        <input id="radio_formation" name="incident_occurred" type="radio" class="hidden"
                            value="FORMATION" />
                        <label id="label_formation" for="radio_formation" class="flex items-center cursor-pointer">
                            <span class="w-3 h-3 inline-block mr-1 rounded-full border border-grey"></span>
                            Formation</label>
                    </div>
                    <div class="inline-flex items-center mr-4">
                        <input id="radio_race" name="incident_occurred" type="radio" class="hidden" value="RACE"
                            checked />
                        <label id="label_race" for="radio_race" class="flex items-center cursor-pointer">
                            <span class="w-3 h-3 inline-block mr-1 rounded-full border border-grey"></span>
                            Race</label>
                    </div>
                </div>

                <!-- ======= Lap ======= -->
                <div class="md:col-span-2" id="lap_num_container">
                    <div class="grid row-gap-2 md:grid-cols-2 mb-6 md:mb-2">
                        <label class="text-gray-700 text-base font-bold">Lap Number</label>
                        <div>
                            <input id="lap" name="lap" type="number"
                                class="bg-gray-200 shadow-lg border border-gray-500 rounded py-2 px-3 w-full hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-600"
                                placeholder="Lap Number" min=-1>
                            <div class="block w-auto text-red-600 text-sm italic" id="errorLap"></div>
                        </div>
                    </div>
                </div>

                <!-- ======= Explanation ======= -->
                <label class="text-gray-700 text-base font-bold">Elaborate the Issue</label>
                <div class="mb-6 md:mb-0">
                    <textarea id="explanation" name="explanation"
                        class="bg-gray-200 shadow-lg border border-gray-500 rounded py-2 px-3 w-full hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-600"
                        rows="3" maxlength="140"></textarea>
                    <div class="mobile-text-xxs text-xs font-semibold text-gray-600">
                        Limit 140 characters
                    </div>
                    <div class="block w-auto text-red-600 text-sm italic" id="errorExplanation"></div>
                </div>

                <!-- ======= Proof ======= -->
                <label class="text-gray-700 text-base font-bold">Evidence</label>
                <div class="relative" id="proof_container">
                    <!-- Links -->
                    <input type="text" id="proof" name="proof"
                        class="bg-gray-200 shadow-lg border border-gray-500 rounded py-2 px-3 w-full hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-600">
                    <div class="mobile-text-xxs text-xs font-semibold text-gray-600">
                        For multiple videos seperate it by comma
                    </div>

                    <!-- Photos  -->
                    <div class="my-4 py-6 px-8 shadow-lg bg-gray-100 rounded-lg w-full">
                        <input type="file" id="photo_upload" name="photo_upload" onchange="javascript:uploadFiles()"
                            hidden multiple>
                        <label id="photo_upload_label" for="photo_upload"
                            class="flex flex-col justify-center relative text-xs font-semibold text-gray-600 w-full h-32 border-2 rounded border-dashed border-gray-500 bg-gray-200 hover:border-purple-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="block my-4 mx-auto h-8 w-8 opacity-50"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            <p class="mx-auto">Upload Photos</p>
                        </label>
                        <div id="uploaded_files" class="text-xs font-semibold text-gray-600"></div>
                    </div>

                    <div class="block w-auto text-red-600 text-sm italic" id="errorProof"></div>
                </div>
            </div>
            <!-- Form Submit -->
            <div class="flex w-full mt-10 content-center items-center justify-center">
                <button
                    class="bg-purple-500 hover:bg-purple-600 text-white font-bold shadow-lg py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit" id="submitid">
                    Submit
                </button>
            </div>
        </form>

    </div>
</div>

<script type='text/javascript'>
// ----------------------- HTML References --------------------------------//
var selectedRace = $("#race");

var reportingAgainstDriver = $('#radio_driver');
var reportingAgainstGame = $('#radio_game');

var driverDropdown = $('.dropdown-form');
var driverDropdownLabel = $('.dropdown-label');
var driverDropdownList = $('.dropdown-list');
var driverSelectCheckboxes = null;
var driverSelectError = $("#errorDriver");

var incidentOccuredQuali = $('#radio_quali');
var incidentOccuredRace = $('#radio_race');

var lap_number = $("#lap");
var lapNumberError = $("#errorLap");

var explanation = $("#explanation");
var explanationError = $("#errorExplanation");

var proof = $("#proof");
var proofError = $("#errorProof");


$(document).ready(function() {

    resetForm();
    updateDriverDropdownList(selectedRace.val());

    //Race changed
    selectedRace.change(function() {
        var race_id = $(this).val();
        updateDriverDropdownList(race_id);
    });

    //------------------- Custom behaviour Radio Input Groups ----------------------//
    $("#label_driver").click(() => {
        $("#radio_game").prop("checked", false);
        $("#driver_select_container").show('400');
    })

    $("#label_game").click(() => {
        $("#radio_driver").prop("checked", false);
        $("#driver_select_container").hide('400', () => {
            resetDriverSelectDropdown();
        });
    })

    $("#label_quali").click(() => {
        $("#radio_race").prop("checked", false);
        $("#radio_formation").prop("checked", false);
        $("#lap_num_container").hide('400', () => {
            lap_number.val(-1);
        });
    })

    $("#label_formation").click(() => {
        $("#radio_race").prop("checked", false);
        $("#radio_quali").prop("checked", false);
        $("#lap_num_container").hide('400', () => {
            lap_number.val(0);
        });
    })

    $("#label_race").click(() => {
        $("#radio_quali").prop("checked", false);
        $("#radio_formation").prop("checked", false);
        lap_number.val('');
        $("#lap_num_container").show('400');
    })

    //-------------------- Driver Select Drop Down ------------------------------//
    function updateDriverDropdownList(race_id) {

        resetDriverSelectDropdown();
        driverDropdown.addClass('dropdown-disabled');
        driverDropdownList.empty();

        $.ajax({
            url: '/fetch/drivers/' + race_id,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var len = 0;
                if (response != null) {
                    len = response.length;
                }
                if (len > 0) {
                    for (var i = 0; i < len; i++) {

                        var id = response[i].id;
                        var name = response[i].name;

                        var driverDropdownEntry =
                            "<div class='py-1 hover:bg-purple-200'><input id='checkbox-" + id +
                            "'class='hidden' type='checkbox' name='drivers[]' value='" + id +
                            "'/>" +
                            "<label class='block ml-3' for='checkbox-" + id + "'>" +
                            "<span class='relative w-4 h-4 inline-block mr-2 border border-purple-600' style='top: 1.5px;'></span>" +
                            name + "</label></div>";

                        driverDropdownList.append(driverDropdownEntry);
                    }
                    driverSelectCheckboxes = driverDropdownList.find('[type="checkbox"]');
                    driverSelectCheckboxes.on('click', (e) => {
                        updateSelectedDrivers(e.target);
                    });
                    driverDropdown.removeClass('dropdown-disabled');
                }
            }
        });
    }

    var dropdownOpen = false;
    var driverNames = [];
    const MAX_DRIVERS_DISPLAY = 2;
    driverDropdownLabel.on('click', () => {
        toggleDropdown();
    });

    function toggleDropdown() {
        if (!dropdownOpen) {
            dropdownOpen = true;
            $(document).on('click', (e) => {
                if ($(e.target).closest('.dropdown-form').length === 0) {
                    toggleDropdown();
                }
            });
            driverDropdownList.addClass('dropdown-activated');
        } else {
            dropdownOpen = false;
            $(document).off('click');
            driverDropdownList.removeClass('dropdown-activated');
        }
    }

    function updateSelectedDrivers(driverCheckbox) {
        //Update drivers
        if ($(driverCheckbox).prop("checked") === true) {
            driverNames.push($(driverCheckbox).parent().text());
        } else {
            driverNames.splice(driverNames.indexOf($(driverCheckbox).parent().text()), 1);
        }

        //Display selected drivers
        if (driverNames.length <= MAX_DRIVERS_DISPLAY) {
            driverDropdownLabel.text(driverNames.length == 0 ? "No Drivers Selected" : driverNames.toString()
                .replace(',', ', '));
        } else {
            driverDropdownLabel.text(`${driverNames[0].toString()} , +${driverNames.length - 1} more..`);
        }
    }

    // -------------------------- Reset --------------------------------------//
    function resetForm() {
        selectedRace.prop('selectedIndex', 0);

        reportingAgainstDriver.prop('checked', true);
        reportingAgainstGame.prop('checked', false);

        resetDriverSelectDropdown();

        incidentOccuredQuali.prop('checked', false);
        incidentOccuredRace.prop('checked', true);

        lap_number.val('');
        explanation.val('');
        proof.val('');
    }

    function resetDriverSelectDropdown() {
        if (driverSelectCheckboxes !== null) {
            driverSelectCheckboxes.prop('checked', false);
        }
        driverDropdownLabel.text("No Drivers Selected");
        driverSelectError.hide();
        driverNames = [];
    }
});

// -------------------------- File Upload --------------------------------//
function uploadFiles() {
    var uploadedFilesContainer = $("#uploaded_files");
    var files = $("#photo_upload").prop("files");

    for (var i = 0; i < files.length; i++) {

        var fileEntry = `<div id="file_container"
                            class="flex justify-start bg-gray-200 shadow-lg border border-gray-500 rounded my-2 py-2 px-3 w-full h-16">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-purple-500 my-auto h-8 w-8"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="relative ml-4 my-auto flex w-full h-full">
                                <span class="w-2/3 my-auto">${files[i].name}</span>
                                <div id="delete_file${i + 1}" class="w-1/3 flex justify-end">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="my-auto h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </div>
                            </div>
                        </div>`
        uploadedFilesContainer.append(fileEntry);
        $("#delete_file" + (i + 1)).on("click", (e) => {
            $(e.target).parents("#file_container").remove();
        });
    }
}

//------------------------------ Validate ------------------------------------//
function validateReport() {

    var sendForm = true;
    driverSelectError.hide();
    lapNumberError.hide();
    explanationError.hide();
    proofError.hide();

    //Condition 1: Reporting against driver but no driver selected
    if (reportingAgainstDriver.prop("checked") && $('input[type="checkbox"]:checked').length === 0) {
        driverSelectError.html("Please select driver(s)!");
        driverSelectError.show();
        sendForm = false;
    }

    //Condition 2: No Lap number provided
    if (incidentOccuredRace.prop("checked") &&
        (lap_number.val() === '' || lap_number.val() <= '0')) {
        lapNumberError.show();
        lapNumberError.html("Please enter a valid lap number!");
        sendForm = false;
    }

    //Condition 3: No explanation provided
    if (explanation.val() === "") {
        explanationError.show();
        explanationError.html("Please explain the incident!");
        sendForm = false;
    }

    //Condition 4: Invalid or No URL provided
    if (!validateYouTubeUrl()) {
        proofError.show();
        proofError.html("Please enter a valid link!");
        sendForm = false;
    }

    return sendForm;
}

function validateYouTubeUrl() {
    var url = $('#proof').val();
    if (url != undefined || url != '') {
        var regExp =
            /^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/gm;
        var match = url.match(regExp);
        if (match) {
            return true;
        }
    } else {
        return false;
    }

    return false;
}
</script>
@endsection