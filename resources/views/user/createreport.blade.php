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

.ellipsis {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

#evidence_primary_container:hover svg,
#evidence_primary_container:hover p {
    color: rgb(147 51 234);
}

.delete_container:hover svg,
.delete_container:hover svg {
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

@media screen and (max-width: 450px) {
    .mobile-text-xxs {
        font-size: 0.6rem;
    }
}
</style>

@if (session()->has('report_success'))
<div class="container mx-auto lg:w-3/4">
    <div class="rounded text-green-600 p-4 mb-3 border-2 bg-green-200 shadow-lg font-semibold my-4">
        <i class="far fa-check-circle mr-2"></i>{{session()->get('report_success')}}
    </div>
</div>
@endif
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
        <form action="{{route('report.submit')}}" method="POST" class="my-4" onsubmit="return submitForm()"
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
                        class="ellipsis appearance-none bg-gray-200 shadow-lg border border-gray-500 cursor-pointer rounded py-2 px-3 w-full hover:border-purple-600 hover:bg-purple-100 focus:bg-white focus:border-purple-600"
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
                            <div class="block w-auto text-red-600 text-sm italic pointer-events-none" id="errorDriver">
                            </div>
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
                            <div class="block w-auto text-red-600 text-sm italic pointer-events-none" id="errorLap">
                            </div>
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
                    <div class="block w-auto text-red-600 text-sm italic pointer-events-none" id="errorExplanation">
                    </div>
                </div>

                <!-- ======= Evidence ======= -->
                <div class="md:col-span-2">
                    <div class="shadow-inner rounded bg-gray-100 px-4 py-4 border hover:border-purple-600">
                        <label class="text-gray-700 text-base font-bold">Evidence</label>

                        <div class="relative grid md:grid-cols-2 md:gap-4">
                            <!-- Links -->
                            <div class="my-2">
                                <div class="py-6 px-8 shadow-lg bg-white rounded-lg w-full">
                                    <div onclick="addLink()" id="evidence_primary_container"
                                        class="flex flex-col justify-center relative text-xs font-semibold text-gray-600 w-full h-32 border-2 rounded border-dashed border-gray-500 bg-gray-200 hover:border-purple-600 hover:bg-purple-100">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="block my-4 mx-auto h-8 w-8 opacity-50" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <p class="mx-auto">Add Video Link</p>
                                    </div>
                                    <div id="links_container" class="text-xs font-semibold text-gray-600"></div>
                                </div>
                                <div class="block w-auto text-red-600 text-sm italic pointer-events-none"
                                    id="errorLink"></div>
                            </div>

                            <!-- Images  -->
                            <div class="my-2 relative">
                                <div class="flex justify-start text-gray-600 font-semibold pointer-events-none md:absolute md:w-full"
                                    style="top: -20px;">
                                    <p class="ml-2" style="font-size: 0.6rem;">Size / Image : 2 MB</p>
                                    <p class="ml-auto mr-2" style="font-size: 0.6rem;">Max Limit : 8 MB</p>
                                </div>
                                <div class="py-6 px-8 shadow-lg bg-white rounded-lg w-full">
                                    <input type="file" id="images_input" name="images[]" accept=".png, .jpg, .jpeg"
                                        onchange="addImages()" hidden multiple>
                                    <label for="images_input" id="evidence_primary_container"
                                        class="flex flex-col justify-center relative text-xs font-semibold text-gray-600 w-full h-32 border-2 rounded border-dashed border-gray-500 bg-gray-200 hover:border-purple-600 hover:bg-purple-100">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="block my-4 mx-auto h-8 w-8 opacity-50" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <p class="mx-auto">Add Images</p>
                                    </label>
                                    <div id="images_container" class="text-xs font-semibold text-gray-600"></div>
                                </div>
                                <div class="block w-auto text-red-600 text-sm italic pointer-events-none"
                                    id="errorImage"></div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-2 block w-auto text-red-600 text-sm italic pointer-events-none"
                        id="errorEvidence"></div>
                </div>
            </div>

            <!-- =========== Form Submit =========== -->
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
var incidentOccuredFormation = $("#radio_formation");
var incidentOccuredRace = $('#radio_race');

var lap_number = $("#lap");
var lapNumberError = $("#errorLap");

var explanation = $("#explanation");
var explanationError = $("#errorExplanation");

var imagesInput = $("#images_input");

var linkError = $("#errorLink");
var imageError = $("#errorImage");
var evidenceError = $("#errorEvidence");

$(document).ready(function() {

    resetFormData();
    updateDriverDropdownList(selectedRace.val());

    //Race changed
    selectedRace.change(function() {
        var race_id = $(this).val();
        updateDriverDropdownList(race_id);
    });

    //------------------- Custom behaviour Radio Input Groups ----------------------//
    $("#label_driver").click(() => {
        $("#radio_game").prop("checked", false);
        $("#driver_select_container").slideDown('fast');
    })

    $("#label_game").click(() => {
        $("#radio_driver").prop("checked", false);
        $("#driver_select_container").slideUp('fast', () => {
            resetDriverSelectDropdown();
        });
    })

    $("#label_quali").click(() => {
        $("#radio_race").prop("checked", false);
        $("#radio_formation").prop("checked", false);
        $("#lap_num_container").slideUp('fast', () => {
            lap_number.val(-1);
        });
    })

    $("#label_formation").click(() => {
        $("#radio_race").prop("checked", false);
        $("#radio_quali").prop("checked", false);
        $("#lap_num_container").slideUp('fast', () => {
            lap_number.val(0);
        });
    })

    $("#label_race").click(() => {
        $("#radio_quali").prop("checked", false);
        $("#radio_formation").prop("checked", false);
        lap_number.val('');
        $("#lap_num_container").slideDown('fast');
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

                        var driverDropdownEntry = `<div class='py-1 hover:bg-purple-200'>
                                                        <input id="checkbox-${id}" type="checkbox" name="drivers[]" value="${id}" hidden/>
                                                        <label class="block ml-3" for="checkbox-${id}">
                                                            <span class="relative w-4 h-4 inline-block mr-2 border border-purple-600" style="top: 1.5px;"></span>
                                                            ${name}
                                                        </label>
                                                    </div>`;

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
    function resetFormData() {
        selectedRace.prop('selectedIndex', 0);

        reportingAgainstDriver.prop('checked', true);
        reportingAgainstGame.prop('checked', false);

        incidentOccuredQuali.prop('checked', false);
        incidentOccuredFormation.prop('checked', false);
        incidentOccuredRace.prop('checked', true);

        lap_number.val('');
        explanation.val('');

        var dt = new DataTransfer();
        imagesInput.prop('files', dt.files);
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

// -------------------------- Evidence --------------------------------//

//Link
function addLink() {
    var linksContainer = $("#links_container");

    var link = `<div id="evidence_secondary_container"
                    class="flex justify-start my-2 w-full">
                    <input type="url" name="video_links[]"
                            class="relative bg-gray-200 shadow-lg border border-gray-500 rounded py-2 px-3 w-10/12 md:w-11/12 h-10 hover:border-purple-600 hover:bg-purple-100 focus:outline-none focus:bg-white focus:border-purple-600">
                    <div class="delete_container w-2/12 md:w-1/12 flex justify-center md:justify-end" onclick="deleteLink(event)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="my-auto h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                </div>`

    linksContainer.append(link);
}

function deleteLink(e) {
    $(e.currentTarget).parents("#evidence_secondary_container").remove();
}

//Images
var imagesArray = []

function addImages() {
    var imagesContainer = $("#images_container");
    var images = imagesInput.prop("files"); //New files
    imagesArray = [...imagesArray]; //Get existing files 

    var imageName;
    var imageType;
    var imageSize;

    for (var i = 0; i < images.length; i++) {

        //Ignore image if it has already been added
        if (imagesArray.some((element) => {
                return element.name === images[i].name;
            })) {
            continue;
        }

        imagesArray.push(images[i]);
        imageName = images[i].name.slice(0, images[i].name.lastIndexOf('.'));
        imageType = images[i].name.slice(images[i].name.lastIndexOf('.'));
        imageSize = `${(images[i].size / (1024 * 1024)).toFixed(1)} MB`;

        // var imageEntry = `<div id="evidence_secondary_container" class="flex justify-start my-2 w-full">

        //                     <div class="relative flex justify-start pointer-events-none bg-gray-200 shadow-lg border border-gray-500 rounded py-1 px-3 w-10/12 md:w-11/12">                    
        //                         <svg xmlns="http://www.w3.org/2000/svg" class="text-purple-500 my-auto h-8 w-8"
        //                             viewBox="0 0 20 20" fill="currentColor">
        //                             <path fill-rule="evenodd"
        //                                 d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
        //                                 clip-rule="evenodd" />
        //                         </svg>
        //                         <p class="ellipsis ml-4 my-auto w-24 md:w-8/12">${imageName}</p>
        //                         <div class="flex justify-end w-4/12">
        //                             <p class="my-auto">${imageType}</p>
        //                         </div>
        //                     </div>

        //                     <div id="${images[i].name}" class="delete_container w-2/12 md:w-1/12 flex justify-center md:justify-end" onclick="deleteImage(event)">
        //                         <svg xmlns="http://www.w3.org/2000/svg" class="my-auto h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        //                             <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        //                         </svg>
        //                     </div>

        //                 </div>`

        var imageEntry = `<div id="evidence_secondary_container" class="flex justify-start my-2 w-full">

                            <div class="relative flex justify-start pointer-events-none bg-gray-200 shadow-lg border border-gray-500 rounded py-1 px-3 w-10/12 h-10 md:w-11/12">                    
                                <p class="my-auto w-12" style="font-size: 0.6rem;">${imageSize}</p>
                                <p class="ellipsis ml-1 md:ml-2 my-auto w-24 md:w-8/12">${imageName}</p>
                                <div class="flex justify-end w-2/12">
                                    <p class="my-auto" style="font-size: 0.6rem;">${imageType}</p>
                                </div>
                            </div>

                            <div id="${images[i].name}" class="delete_container w-2/12 md:w-1/12 flex justify-center md:justify-end" onclick="deleteImage(event)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="my-auto h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                            
                        </div>`
        imagesContainer.append(imageEntry);
    }
    updateImagesInput();
}

//Update files property of input[type="file"] after new files are added or existing ones are removed
function updateImagesInput() {
    var dt = new DataTransfer();
    for (const image of imagesArray) {
        dt.items.add(image);
    }
    imagesInput.prop('files', dt.files);
}

function deleteImage(e) {
    imagesArray.splice(imagesArray.findIndex((image) => {
        return image.name === e.currentTarget.id;
    }), 1);

    updateImagesInput();
    $(e.currentTarget).parents("#evidence_secondary_container").remove();
}

//------------------------------ Submit Form ------------------------------------//
function submitForm() {
    if (validateReport()) {
        return true;
    }

    return false;
}

function validateReport() {

    var sendForm = true;
    driverSelectError.hide();
    lapNumberError.hide();
    explanationError.hide();
    linkError.hide();
    imageError.hide();
    evidenceError.hide();

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

    //Condition 4: No Evidence provided
    var links = $('input[type="url"]');
    var images = imagesInput.prop('files');
    if (links.length === 0 && images.length === 0) {
        evidenceError.show();
        evidenceError.html("No Evidence provided. Please include either links or images or both!");
        sendForm = false;
    }

    //Condition 5: Empty links
    links.each((i, link) => {
        if (link.value === '') {
            linkError.show();
            linkError.html("Links cannot be empty!");
            sendForm = false;
        }
    });

    //Condition 6: Total images size > 8MB
    var totalSize = 0;
    for (var i = 0; i < images.length; i++) {

        //Condition 7: File Type 
        if (images[i].type != 'image/png' && images[i].type != 'image/jpg' && images[i].type != 'image/jpeg') {
            imageError.show();
            imageError.html("Some files are not of image type. Please make sure files are of type jpg/png/jpeg!");
            sendForm = false;
            break;
        }
        //Condition 8: Image size > 2MB
        if (images[i].size > 2097152) {
            imageError.show();
            imageError.html("Image size cannot exceed 2MB!");
            sendForm = false;
            break;
        }
        totalSize += images[i].size;

    }
    if (totalSize > 8388608) {
        imageError.show();
        imageError.html("Max upload limit cannot exceed 8MB!");
        sendForm = false;
    }

    return sendForm;
}
</script>
@endsection