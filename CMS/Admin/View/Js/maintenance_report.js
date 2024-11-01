//Spare parts as  globle variable
let sparePart;

let sparePartSelect;

//cars as globel variable
let cars;

//driver as globel variable
let drivers;

//driver as globel variable
let company;

let sparePartCounter = 0;
let tripCounters = { 1: 1 };
let driverCounters = { 1: { 1: 1 } };
let conductorCounters = { 1: { 1: 1 } };

function updateFileName() {
    const input = document.getElementById('upload_bill');
    const label = document.getElementById('file-name');

    if (input.files.length > 0) {
        label.innerHTML = `<b>${input.files[0].name}</b>`;
    } else {
        label.innerHTML = '<b>Upload Bill</b>';
    }
}

function editupdateFileName() {
    alert('editupdateFileName');
    const input = document.getElementById('edit_upload_bill');
    const label = document.getElementById('file-name');

    if (input.files.length > 0) {
        label.innerHTML = `<b>${input.files[0].name}</b>`;
    } else {
        label.innerHTML = '<b>Upload Bill</b>';
    }
}

$(document).ready(function () {

    //Add Shift
    $("#add-spare-part").click(async function () {
        //Driver
        //Spare parts
        if (!sparePart) {
            await sparePartAjax();
        }
        // let select2 = $('#spare-part');
        // select2.empty();  // Clear existing options

        // Add default "Select Spare" option
        sparePartSelect = '<option value="" selected>Select Spare</option>';

        sparePart.forEach((spar_part) => {
            sparePartSelect += '<option value="' + spar_part.spare_part_id + '">' + spar_part.spare_part_name + '</option>';
        });


        sparePartCounter++;
        // tripCounters[sparePartCounter] = 1

        $('#cms-spares').append(
            `
        <div class="bms-shift" id="bms-shift-${sparePartCounter}">
            <div class="bms-shift-header">
                <p class="bms-shift-title">Spare Parts</p>
                <button class="remove-button" title="Remove Spare Part" onclick="remove('bms-shift-${sparePartCounter}')"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="bms-shift-body">
                <div class="bms-shift-details">
                    <div class="row">
                        <div class="col-sm-4">
                            
                            <label for="" class="input-label">Spare Part</label>
                            <select class="input-field" name="spare[${sparePartCounter}][sparePartId]" required>
                                ${sparePartSelect}
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="input-label">Quantity</label>
                            <input type="text" class="input-field" name="spare[${sparePartCounter}][spareQuantity]" placeholder="" required />
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="input-label">Price</label>
                            <input type="text" class="input-field" name="spare[${sparePartCounter}][sparePrice]" placeholder="" required />
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        `
        )
    });

});


$(document).ready(function () {

    //Add Shift
    $("#edit-spare-part").click(async function () {
        //Driver
        //Spare parts

        if (!sparePart) {
            await sparePartAjax();
        }
        // let select2 = $('#spare-part-edit');
        // select2.empty();  // Clear existing options

        // Add default "Select Spare" option
        sparePartSelect = '<option value="" selected>Select Spare</option>';

        sparePart.forEach((spar_part) => {
            sparePartSelect += '<option value="' + spar_part.spare_part_id + '">' + spar_part.spare_part_name + '</option>';
        });


        sparePartCounter++;
        // tripCounters[sparePartCounter] = 1

        $('#cms-edit-spares').append(
            `
        <div class="bms-shift" id="bms-shift-${sparePartCounter}">
            <div class="bms-shift-header">
                <p class="bms-shift-title">Spare Parts</p>
                <button class="remove-button" title="Remove Spare Part" onclick="remove('bms-shift-${sparePartCounter}')"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="bms-shift-body">
                <div class="bms-shift-details">
                    <div class="row">
                        <div class="col-sm-4">
                            
                            <label for="" class="input-label">Spare Part</label>
                            <select class="input-field" name="spare[${sparePartCounter}][sparePartId]" required>
                                ${sparePartSelect}
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="input-label">Quantity</label>
                            <input type="text" class="input-field" name="spare[${sparePartCounter}][spareQuantity]" placeholder="" required />
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="input-label">Price</label>
                            <input type="text" class="input-field" name="spare[${sparePartCounter}][sparePrice]" placeholder="" required />
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        `
        )
    });

});
// <label for="" class="input-label">Shift End date</label>
// <input type="date" class="input-field" name="shift[${sparePartCounter}][shiftEndDate]" id="spare-part" placeholder="" required />

//Add Trips
async function addTrip(shiftNumber) {
    //Driver
    if (!drivers) {
        await driverAjax();
    }

    if (!driversSelect) {

        // Add default "Select Bus" option
        driversSelect += '<option value="" selected>Select Driver</option>';

        drivers.forEach((driver) => {
            driversSelect += '<option value="' + driver.id + '">' + driver.fullname + '</option>';
        });
    }

    //Conductor
    if (!conductors) {
        await conductorAjax();
    }

    if (!conductorsSelect) {

        // Add default "Select Bus" option
        conductorsSelect += '<option value="" selected>Select Conductor</option>';

        conductors.forEach((conductor) => {
            conductorsSelect += '<option value="' + conductor.id + '">' + conductor.fullname + '</option>';
        });
    }

    //Routes
    if (!routes) {
        await routeAjax();
    }

    if (!routesSelect) {

        // Add default "Select Bus" option
        routesSelect += '<option value="" selected>Select Route</option>';

        routes.forEach((route) => {
            routesSelect += '<option value="' + route.routeId + '">' + route.routeName + '</option>';
        });
    }

    tripCounters[shiftNumber]++

    if (!driverCounters[shiftNumber]) {
        driverCounters[shiftNumber] = {};
    }

    if (!driverCounters[shiftNumber][tripCounters[shiftNumber]]) {
        driverCounters[shiftNumber][tripCounters[shiftNumber]] = 1;
    }

    if (!conductorCounters[shiftNumber]) {
        conductorCounters[shiftNumber] = {};
    }

    if (!conductorCounters[shiftNumber][tripCounters[shiftNumber]]) {
        conductorCounters[shiftNumber][tripCounters[shiftNumber]] = 1;
    }
    $('#bms-trips-' + shiftNumber).append(
        `
         <div class="bms-trip" id="bms-trips-${shiftNumber}-${tripCounters[shiftNumber]}">
            <div class="bms-trip-header">
                <p class="bms-trip-title">Trip</p>
                <button type="button" class="remove-button" title="Remove Trip" onclick="remove('bms-trips-${shiftNumber}-${tripCounters[shiftNumber]}')"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="bms-trip-body">
                <div class="bms-trip-route">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="" class="input-label">Start Route</label>
                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][startRoute]">
                                ${routesSelect}
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="input-label">End Route</label>
                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][endRoute]">
                                ${routesSelect}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bms-trip-driver-container">
                    <div class="bms-trip-drivers" id="bms-trip-drivers-${shiftNumber}-${tripCounters[shiftNumber]}">
                        <div class="bms-trip-driver" id="bms-trip-driver-${shiftNumber}-${tripCounters[shiftNumber]}-1">
                            <div class="bms-trip-driver-header">
                                <p class="bms-trip-driver-title">Driver</p>
                                <button type="button" class="add-button" onclick="addDriver(${shiftNumber},${tripCounters[shiftNumber]})"><i class="fa-solid fa-circle-plus"></i></button>
                            </div>
                            <div class="bms-trip-driver-body">
                                <div class="bms-trip-driver-content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="" class="input-label">Driver</label>
                                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][driver][1][driver_id]" required>
                                                ${driversSelect}
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">Start Time</label>
                                            <input type="time" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][driver][1][start_time]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">End Time</label>
                                            <input type="time" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][driver][1][end_time]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">Start KM</label>
                                            <input type="text" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][driver][1][start_km]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">End KM</label>
                                            <input type="text" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][driver][1][end_km]" placeholder="" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bms-trip-conductor-container">
                    <div class="bms-trip-conductors" id="bms-trip-conductors-${shiftNumber}-${tripCounters[shiftNumber]}">
                        <div class="bms-trip-conductor" id="bms-trip-conductor-${shiftNumber}-${tripCounters[shiftNumber]}-1">
                            <div class="bms-trip-conductor-header">
                                <p class="bms-trip-conductor-title">Conductor</p>
                                <button type="button" class="add-button" onclick="addConductor(${shiftNumber},${tripCounters[shiftNumber]})"><i class="fa-solid fa-circle-plus"></i></button>
                            </div>
                            <div class="bms-trip-conductor-body">
                                <div class="bms-trip-conductor-content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="" class="input-label">Conductor</label>
                                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][conductor][1][conductor_id]" required>
                                                ${conductorsSelect}
                                            </select>
                                        </div>
                                        <!-- <div class="col-sm-2">
                                            <label for="" class="input-label">Start Time</label>
                                            <input type="time" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][conductor][1][start_time]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">End Time</label>
                                            <input type="time" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][conductor][1][conductor_id]" placeholder="" required />
                                        </div> -->
                                        <div class="col-sm-3">
                                            <label for="" class="input-label">Passangers</label>
                                            <input type="text" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][conductor][1][passangers]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="" class="input-label">Collection</label>
                                            <input type="text" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][conductor][1][collection]" placeholder="" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    );
}

//Add Driver

async function addDriver(shiftNumber, tripNumber) {

    //Driver
    if (!drivers) {
        await driverAjax();
    }

    if (!driversSelect) {

        // Add default "Select Bus" option
        driversSelect += '<option value="" selected>Select Driver</option>';

        drivers.forEach((driver) => {
            driversSelect += '<option value="' + driver.id + '">' + driver.fullname + '</option>';
        });
    }

    if (!driverCounters[shiftNumber]) {
        driverCounters[shiftNumber] = {};
    }

    if (!driverCounters[shiftNumber][tripNumber]) {
        driverCounters[shiftNumber][tripNumber] = 1;
    } else {
        driverCounters[shiftNumber][tripNumber]++;
    }

    let driverNumber = driverCounters[shiftNumber][tripNumber];

    $('#bms-trip-drivers-' + shiftNumber + '-' + tripNumber).append(
        `
        <div class="bms-trip-driver" id="bms-trip-driver-${shiftNumber}-${tripNumber}-${driverNumber}">
            <div class="bms-trip-driver-header">
                <p class="bms-trip-driver-title">Driver</p>
                <button type="button" class="remove-button" title="Remove Driver" onclick="remove('bms-trip-driver-${shiftNumber}-${tripNumber}-${driverNumber}')"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="bms-trip-driver-body">
                <div class="bms-trip-driver-content">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="" class="input-label">Driver</label>
                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripNumber}][driver][${driverNumber}][driver_id]" required>
                                ${driversSelect}
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="" class="input-label">Start Time</label>
                            <input type="time" class="input-field"
                                name="shift[${shiftNumber}][trip][${tripNumber}][driver][${driverNumber}][start_time]" placeholder="" required />
                        </div>
                        <div class="col-sm-2">
                            <label for="" class="input-label">End Time</label>
                            <input type="time" class="input-field"
                                name="shift[${shiftNumber}][trip][${tripNumber}][driver][${driverNumber}][end_time]" placeholder="" required />
                        </div>
                        <div class="col-sm-2">
                            <label for="" class="input-label">Start KM</label>
                            <input type="text" class="input-field"
                                name="shift[${shiftNumber}][trip][${tripNumber}][driver][${driverNumber}][start_km]" placeholder="" required />
                        </div>
                        <div class="col-sm-2">
                            <label for="" class="input-label">End KM</label>
                            <input type="text" class="input-field"
                                name="shift[${shiftNumber}][trip][${tripNumber}][driver][${driverNumber}][end_km]" placeholder="" required />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    )

    // Initialize or refresh selectpicker for newly added selects
    $('.selectpicker').selectpicker('refresh');
}

//Add Conductor

async function addConductor(shiftNumber, tripNumber) {

    //Conductor
    if (!conductors) {
        await conductorAjax();
    }

    if (!conductorsSelect) {

        // Add default "Select Bus" option
        conductorsSelect += '<option value="" selected>Select Conductor</option>';

        conductors.forEach((conductor) => {
            conductorsSelect += '<option value="' + conductor.id + '">' + conductor.fullname + '</option>';
        });
    }

    if (!conductorCounters[shiftNumber]) {
        conductorCounters[shiftNumber] = {};
    }

    if (!conductorCounters[shiftNumber][tripNumber]) {
        conductorCounters[shiftNumber][tripNumber] = 1;
    } else {
        conductorCounters[shiftNumber][tripNumber]++;
    }

    let conductorNumber = conductorCounters[shiftNumber][tripNumber];

    $('#bms-trip-conductors-' + shiftNumber + '-' + tripNumber).append(
        `
        <div class="bms-trip-conductor" id="bms-trip-conductor-${shiftNumber}-${tripNumber}-${conductorNumber}">
            <div class="bms-trip-conductor-header">
                <p class="bms-trip-conductor-title">Conductor</p>
                <button type="button" class="remove-button" title="Remove Conductor" onclick="remove('bms-trip-conductor-${shiftNumber}-${tripNumber}-${conductorNumber}')"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="bms-trip-conductor-body">
                <div class="bms-trip-conductor-content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="row selectpicker-row p-0">
                                <div class="col-sm-12 search-select-1">
                                    <label for="" class="input-label">Conductor</label>
                                    <select class="input-field" name="shift[${shiftNumber}][trip][${tripNumber}][conductor][${conductorNumber}][conductor_id]" required>
                                        ${conductorsSelect}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="" class="input-label">Passangers</label>
                            <input type="text" class="input-field"
                                name="shift[${shiftNumber}][trip][${tripNumber}][conductor][${conductorNumber}][passangers]" placeholder="" required />
                        </div>
                        <div class="col-sm-3">
                            <label for="" class="input-label">Collection</label>
                            <input type="text" class="input-field"
                                name="shift[${shiftNumber}][trip][${tripNumber}][conductor][${conductorNumber}][collection]" placeholder="" required />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    )
}

function remove(id) {
    $('#' + id).remove();
}

async function getDetails() {
    if (!cars) {
        await carsAjax();
    }

    let select = $('#car-no');
    select.empty();  // Clear existing options

    // Add default "Select Car" option
    select.append('<option value="" selected>Select Car</option>');

    if(cars != undefined){
        cars.forEach((car) => {
            select.append('<option value="' + car.id + '">' + car.car_number + '</option>');
        });
    }

    //Spare parts
    if (!sparePart) {
        await sparePartAjax();
    }
    let select2 = $('#spare-part');
    select2.empty();  // Clear existing options

    // Add default "Select Spare" option
    sparePartSelect = '<option value="" selected>Select Spare</option>';

    if(sparePart != undefined){
        sparePart.forEach((spar_part) => {
            sparePartSelect += '<option value="' + spar_part.spare_part_id + '">' + spar_part.spare_part_name + '</option>';
        });
    }

    select2.append(sparePartSelect);

    //Spare parts
    if (!drivers) {
        await driverAjax();
    }
    let select3 = $('#driver-name');
    select3.empty();  // Clear existing options

    // Add default "Select Spare" option
    select3.append('<option value="" selected>Select Driver</option>');

    if(driver_opt != undefined){
        driver_opt.forEach((driver_options) => {
            select3.append('<option value="' + driver_options.id + '">' + driver_options.fullName + '</option>');
        });
    }

    // Company
    if (!company) {
        await companyAjax();
    }
    let select4 = $('#cabcompany');
    select4.empty();
    select4.append('<option value="" disabled selected>Select Company</option>');

    if(companyss != undefined){
        companyss.forEach(companys => {
            select4.append('<option value="' + companys.id + '">' + companys.company_name + '</option>');
        });
    }

}

//Driver ajax
function sparePartAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getSpareParts'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/MaintenanceReportController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    sparePart = response.data;
                    
                }
                resolve();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                reject();
                // Swal.fire({
                //     title: "Error",
                //     text: "Something went wrong! Please try again.",
                //     icon: "error"
                // });
            }
        });
    })
}


//Driver ajax
function driverAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getDriverName'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/MaintenanceReportController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    driver_opt = response.data;
                   
                } 
                resolve();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                reject();
                // Swal.fire({
                //     title: "Error",
                //     text: "Something went wrong! Please try again.",
                //     icon: "error"
                // });
            }
        });
    })

}

//Driver ajax
function conductorAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getConductorField'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/ConductorController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    conductors = response.data;
                    
                }
                resolve();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                reject();
                // Swal.fire({
                //     title: "Error",
                //     text: "Something went wrong! Please try again.",
                //     icon: "error"
                // });
            }
        });
    })

}

//Bus ajax
function carsAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getCars'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/MaintenanceReportController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    cars = response.data;
                    
                }
                resolve();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                reject();
                // Swal.fire({
                //     title: "Error",
                //     text: "Something went wrong! Please try again.",
                //     icon: "error"
                // });
            }
        });
    })
}

//Route ajax
function routeAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getRouteField'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/RouteController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    routes = response.data;
                    
                }
                resolve();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                reject();
                // Swal.fire({
                //     title: "Error",
                //     text: "Something went wrong! Please try again.",
                //     icon: "error"
                // });
            }
        });
    })
}


//Fuel type ajax
function companyAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getCompany'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/MaintenanceReportController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    companyss = response.data;
                    
                }
                resolve();
            },
            error: function (xhr, status, error) {
                popupClose('driver-view');
                console.error(xhr.responseText);
                reject();
                // Swal.fire({
                //     title: "Error",
                //     text: "Something went wrong! Please try again.",
                //     icon: "error"
                // });
            }
        });
    })

}

let sparePartFilter;
let driverFilter;
let carFilter;

//Get Field for Filter
async function getFilterField() {

    if (!cars) {
        await carsAjax();
    }

    let select = $('#filter-car');
    select.empty();  // Clear existing options

    // Add default "Select Car" option
    select.append('<option value="" selected>Select Car</option>');
    if(cars != undefined){    
        cars.forEach((car) => {
            select.append('<option value="' + car.id + '">' + car.car_number + '</option>');
        });
    }

    //Spare parts
    if (!sparePart) {
        await sparePartAjax();
    }
    let select2 = $('#filter-spare');
    select2.empty();  // Clear existing options

    // Add default "Select Spare" option
    sparePartSelect = '<option value="" selected>Select Spare</option>';

    if(sparePart != undefined){
        sparePart.forEach((spar_part) => {
            sparePartSelect += '<option value="' + spar_part.spare_part_id + '">' + spar_part.spare_part_name + '</option>';
        });
    }

    select2.append(sparePartSelect);

    //Spare parts
    if (!drivers) {
        await driverAjax();
    }
    let select3 = $('#filter-driver');
    select3.empty();  // Clear existing options

    // Add default "Select Spare" option
    select3.append('<option value="" selected>Select Driver</option>');

    if(driver_opt != undefined){
        driver_opt.forEach((driver_options) => {
            select3.append('<option value="' + driver_options.id + '">' + driver_options.fullName + '</option>');
        });
    }

    // Company
    // if (!company) {
    //     await companyAjax();
    // }
    // let select4 = $('#cabcompany');
    // select4.empty();
    // select4.append('<option value="" disabled selected>Select Company</option>');

    // companyss.forEach(companys => {
    //     select4.append('<option value="' + companys.id + '">' + companys.company_name + '</option>');
    // });

}

let editsparePartCounter = 1;

var carSelect;
var driverSelect;
var companySelect;
let sparePartEditSelect;

async function displayEdit(data) {
    editsparePartCounter = 1;
    console.log(data);

    $("#edit-maintenance-report-id").val(data.maintenanceReportId);

    if (!cars) {
        await carsAjax();
    }

    if (!carSelect) {

        // Add default "Select Bus" option
        carSelect += '<option value="" selected>Select car</option>';

        cars.forEach((car) => {
            carSelect += '<option value="' + car.id + '">' + car.car_number + '</option>';
        });
    }

    let carField = $("#edit-car-no");

    carField.append(carSelect);

    carField.val(data.carId);

    if (!drivers) {
        await driverAjax();
    }

    if (!driverSelect) {

        // Add default "Select Bus" option
        driverSelect += '<option value="" selected>Select driver</option>';

        driver_opt.forEach((driver) => {
            driverSelect += '<option value="' + driver.id + '">' + driver.fullName + '</option>';
        });
    }

    let driverField = $("#edit-driver-name");

    driverField.append(driverSelect);

    driverField.val(data.driverId);

    if (!company) {
        await companyAjax();
    }

    if (!companySelect) {

        // Add default "Select Bus" option
        companySelect += '<option value="" selected>Select driver</option>';

        companyss.forEach((company) => {
            companySelect += '<option value="' + company.id + '">' + company.company_name + '</option>';
        });
    }

    let companyField = $("#edit-cabcompany");

    companyField.append(companySelect);

    companyField.val(data.cabcompanyId);

    if (!sparePart) {
        await sparePartAjax();
    }


    $("#maintenance-date").val(data.maintenanceDate);
    $("#edit-service-charge").val(data.serviceCharge);
    $("#edit-total-charge").val(data.totalCharge);
    // $("#edit-upload_bill").val(data.maintenanceBillUrl);

    // Assuming you have the URL stored in `data.maintenanceBillUrl`
    const fileName = data.maintenanceBillUrl.split('/').pop(); // Extract the file name from the URL

    // Update the label to show the file name
    $("#edit-upload_bill").html(`<b>${fileName}</b>`);

    var variableValue = data.maintenanceBillUrl; // Change this to "" to test the condition

    // Select the label element by ID
    var label = document.getElementById('icon_upload');

    var existingIconLink = label.querySelector('.icon-link');
    if (existingIconLink) {
        label.removeChild(existingIconLink);
    }

    // Check if the variable has a value
    if (variableValue) {
        // Create an <a> tag with the icon
        var iconLink = document.createElement('a');
        iconLink.href = `../../Assets/User/${data.maintenanceBillUrl}`; // Dynamically set the href
        iconLink.target = "_blank"; // Open the link in a new tab
        iconLink.className = "icon-link"; // Add any desired classes

        // Create the <i> icon
        var icon = document.createElement('i');
        icon.className = "fas fa-info-circle"; // Use Font Awesome classes for the icon
        iconLink.appendChild(icon); // Append the icon to the <a> tag

        // Append the <a> tag next to the label
        label.appendChild(iconLink);
    }

    // Optionally, you might want to store the file URL in a hidden input if needed for form submission
    $("#hidden-file-url").val(data.maintenanceBillUrl); // Make sure to create this input in your HTML


    $('#bms-edit-shifts').html('');

    let spares = data.spare;

    console.log(Object.keys(data.spare).length);
    $('#cms-edit-spares').html("");

    // console.log(Object.keys(data.spare));
    for (let s = 1; s <= Object.keys(spares).length; s++) {
        console.log(spares[s]['spareId']);
        console.log(spares[s]['sparePartId']);

        let spareId = spares[s]['sparePartId']

        sparePartEditSelect = "";

        // Add default "Select Bus" option
        sparePartEditSelect += '<option value="">Select spare</option>';

        sparePart.forEach((spares) => {
            if (spares.spare_part_id == spareId) {
                sparePartEditSelect += '<option value="' + spares.spare_part_id + '" selected>' + spares.spare_part_name + '</option>';
            } else {
                sparePartEditSelect += '<option value="' + spares.spare_part_id + '">' + spares.spare_part_name + '</option>';
            }

        });

        //  onclick="remove('bms-shift-${editsparePartCounter}')" 

        $('#cms-edit-spares').append(
            `
                <div class="bms-shift" id="bms-shift-edit-${editsparePartCounter}">
                    <div class="bms-shift-header">
                        <p class="bms-shift-title">Spare Parts</p>
                        <button class="remove-button" title="Remove Spare Part" onclick="deleteItem('bms-shift-edit-${editsparePartCounter}', '${spares[s]['spareId']}')"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="bms-shift-body">
                        <div class="bms-shift-details">
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="hidden" name="spare[${editsparePartCounter}][spareId]" value="${spares[s]['spareId']}">
                                    <label for="" class="input-label">Spare Part</label>
                                    <select class="input-field" name="spare[${editsparePartCounter}][sparePartId]" value="${spares[s]['sparePartId']}" required>
                                        ${sparePartEditSelect}
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="input-label">Quantity</label>
                                    <input type="text" class="input-field" name="spare[${editsparePartCounter}][spareQuantity]" value="${spares[s]['spareQuantity']}" placeholder="" required />
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="input-label">Price</label>
                                    <input type="text" class="input-field" name="spare[${editsparePartCounter}][sparePrice]" value="${spares[s]['sparePrice']}" placeholder="" required />
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            `
        )

        editsparePartCounter++;

    }

}

let deletedItems = [];

function deleteItem(id, itemId) {
    deletedItems.push({
        id: itemId,
    });
    console.log(deletedItems);
    $('#' + id).remove();
}

function displayView(data) {
    // let view = data.car_number + ' - ' + data.maintenanceDate;
    // $('#View-title').html(view);
    // $reportDetails = data['reportDetails'];
    $('#daily-report-view-content').html('');

    

    $('#daily-report-view-content').append(
        `
        <div class="driver-info-right box-container-2">
            <div class="row">
                
                <div class="col-sm-3">
                    <div class="infos">
                        <p class="info-heading">Car Number</p>
                        <p class="info-content">${data['car_number']}</p>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="infos">
                        <p class="info-heading">Driver Name</p>
                        <p class="info-content">${data['fullname']}</p>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="infos">
                        <p class="info-heading">Company Name</p>
                        <p class="info-content">${data['company_name']}</p>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="infos">
                        <p class="info-heading">Fuel Type</p>
                        <p class="info-content">${data['maintenanceDate']}</p>
                    </div>
                </div>
            </div>
        </div>        


        <div class="container box-container-2 mt-2" id="sparePartsTable" style="display: ${data.spare && Object.keys(data.spare).length > 0 ? 'block' : 'none'};">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Spare Part Name</th>
                        <th scope="col">Spare Part Quantity</th>
                        <th scope="col">Spare Part Price</th>
                    </tr>
                </thead>
                <tbody>
                    ${data.spare ? (() => {
                        // console.log(Object.keys(data.spare).length);
                        let rows = '';
                        for (let i = 1; i <= Object.keys(data.spare).length; i++) {
                            const part = data.spare[i];
                            // console.log("==============================================");
                            console.log(data.spare);
                            rows += `
                                <tr>
                                    <td>${i}</td>
                                    <td>${part['spare_name']}</td>
                                    <td>${part['spareQuantity']}</td>
                                    <td>${part['sparePrice']}</td>
                                </tr>
                            `;
                        }
                        return rows;
                    })() : ''}
                </tbody>
            </table>
        </div>


        <div class="driver-info-right box-container-2 mt-2">
            <div class="row mt-2">
                <div class="col-sm-3">
                    <div class="infos">
                        <p class="info-heading">Service Charge</p>
                        <p class="info-content">${data.serviceCharge}</p>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="infos">
                        <p class="info-heading">Total Charges</p>
                        <p class="info-content">${data.totalCharge}</p>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="infos">
                        <p class="info-heading">Insurance</p>
                        <a href="../../Assets/User/${data.maintenanceBillUrl}" class="document-view  d-v-2" target="_blank">
                            <i class="fa-duotone fa-file-invoice"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        `
    );
}