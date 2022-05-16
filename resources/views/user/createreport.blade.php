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
    color: #38a169;
}

input[type="radio"]+label span:hover,
input[type="radio"]+label:hover span,
    {
    transform: scale(1.2);
}

input[type="radio"]:checked+label span {
    background-color: #38a169;
    box-shadow: 0px 0px 0px 2px white inset;
}

input[type="checkbox"]:checked+label span {
    background-color: rgb(22 163 74);
}

input[type="checkbox"]:checked+label span::before {
    position: absolute;
    top: -5px;
    content: '✔';
    font-weight: 200;
    color: white;
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

.dropdown-disabled{
    pointer-events: none;
    opacity: 0.5;
}

@media screen and (min-width: 1920px) {
    .container {
        margin-top: 125px;
    }
}
</style>

<div class="container w-screen">
    <!-- Report Title -->
    <div class="font-semibold text-left shadow-lg bg-green-200 rounded-md md:w-2/3 px-6 py-4 mx-auto">
        <div class="text-3xl text-green-800">Create Report<br></div>
        <p class="text-green-600"><i class="fa fa-exclamation-circle" aria-hidden="true"></i><strong>
                Disclaimer</strong>: Stewards can take <strong>action</strong> against parties involved,
            <strong>including</strong> the reporting driver.
        </p>
    </div>

    <!-- Report Form -->
    <div class="mx-auto my-4 py-4 px-20 shadow-lg rounded-lg md:w-2/3">
        <form action="{{route('report.submit')}}" method="POST" class="my-4" onsubmit="return validateReport()">
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
                        class="appearance-none bg-gray-200 shadow-lg border border-gray-500 cursor-pointer rounded py-2 px-3 w-full hover:border-green-600 hover:bg-green-100 focus:bg-white focus:border-green-600"
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
                        <input id="radio_driver" name="reporting_against" type="radio" class="hidden" value="DRIVER" checked />
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
                                class="dropdown-label overflow-auto bg-gray-200 shadow-lg border border-gray-500 cursor-pointer rounded py-2 px-3 w-full hover:border-green-600 hover:bg-green-100 focus:outline-none focus:bg-white focus:border-green-600">
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
                            <div class="dropdown-list border rounded hover:bg-white hover:border-green-600 w-full">
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
                    <div class="inline-flex items-center mr-4">
                        <input id="radio_race" name="incident_occurred" type="radio" class="hidden" value="RACE" checked />
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
                            <input id="lap_num" name="lap_num" type="number"
                                class="bg-gray-200 shadow-lg border border-gray-500 rounded py-2 px-3 w-full hover:border-green-600 hover:bg-green-100 focus:outline-none focus:bg-white focus:border-green-600"
                                placeholder="Lap Number" min=-1>
                            <div class="block w-auto text-red-600 text-sm italic" id="errorLap"></div>
                        </div>
                    </div>
                </div>

                <!-- ======= Explanation ======= -->
                <label class="text-gray-700 text-base font-bold">Elaborate the Issue</label>
                <div class="mb-6 md:mb-0">
                    <textarea id="explanation" name="explanation"
                        class="bg-gray-200 shadow-lg border border-gray-500 rounded py-2 px-3 w-full hover:border-green-600 hover:bg-green-100 focus:outline-none focus:bg-white focus:border-green-600"
                        rows="3" name="explained"></textarea>
                    <div class="block w-auto text-red-600 text-sm italic" id="errorExplanation"></div>
                </div>

                <!-- ======= Video Proof ======= -->
                <label class="text-gray-700 text-base font-bold">Video Proof</label>
                <div>
                    <input type="text" id="proof" name="proof"
                        class="bg-gray-200 shadow-lg border border-gray-500 rounded py-2 px-3 w-full hover:border-green-600 hover:bg-green-100 focus:outline-none focus:bg-white focus:border-green-600"
                        placeholder="Youtube link">
                    <div class="text-xs font-semibold text-gray-600">
                        For multiple videos seperate it by comma
                    </div>
                    <div class="block w-auto text-red-600 text-sm italic" id="errorProof"></div>
                </div>
            </div>
            <!-- Form Submit -->
            <div class="flex w-full mt-10 content-center items-center justify-center">
                <button
                    class="bg-green-500 hover:bg-green-600 text-white font-bold shadow-lg py-2 px-4 rounded focus:outline-none focus:shadow-outline"
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

var lap_number = $("#lap_num");
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
        $("#lap_num_container").hide('400', () => {
            lap_number.val(-1);
        });
    })

    $("#label_race").click(() => {
        $("#radio_quali").prop("checked", false);
        lap_number.val('');
        $("#lap_num_container").show('400');
    })

    //-------------------- Driver Select Drop Down ------------------------------//
    function updateDriverDropdownList(race_id) {

        resetDriverSelectDropdown();
        driverDropdown.addClass('dropdown-disabled');
        driverDropdownList.empty();

        $.ajax({
            url: '/api/fetch/drivers/' + race_id,
            type: 'get',
            dataType: 'json',
            beforeSend: function(request) {
                request.setRequestHeader("Authorization", 'Bearer MyAPITOken');
            },
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
                            "<div class='py-1 hover:bg-green-200'><input id='checkbox-" + id +
                            "'class='hidden' type='checkbox' name='drivers[]' value='" + id +
                            "'/>" +
                            "<label class='block ml-3' for='checkbox-" + id + "'>" +
                            "<span class='relative w-4 h-4 inline-block mr-2 border border-green-600' style='top: 1.5px;'></span>" +
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
        console.log(match);
        if (match) {
            console.log(url);
            return true;
        }
    } else {
        return false;
    }

    return false;
}
</script>
@endsection