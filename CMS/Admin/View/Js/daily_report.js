

// let cars;
// let drivers;
// let company;fv

async function getDetails() {

    if (!cars) {
        await carsAjax();
    }

    let select = $('#car-no');
    select.empty();  // Clear existing options

    // Add default "Select Car" option
    select.append('<option value="" selected>Select Car</option>');
    
    if (cars != undefined) {
        
        cars.forEach((car) => {
            select.append('<option value="' + car.id + '">' + car.car_number + '</option>');
        });
    }else{
        select.append('<option value="">No car found.</option>');
    }

    //Spare parts
    if (!drivers) {
        await driverAjax();
    }
    let select3 = $('#driver-name');
    select3.empty();  // Clear existing options

    // Add default "Select Spare" option
    select3.append('<option value="" selected>Select Driver</option>');

    if (driver_opt != undefined) {
        driver_opt.forEach((driver_options) => {
            select3.append('<option value="' + driver_options.id + '">' + driver_options.fullName + '</option>');
        });
    }else{
        select3.append('<option value="">No driver found.</option>');
    }


    // Company
    if (!company) {
        await companyAjax();
    }
    let select4 = $('#cabcompany');
    select4.empty();
    select4.append('<option value="" disabled selected>Select Company</option>');
    if (companies != undefined) {
        companies.forEach(companys => {
            select4.append('<option value="' + companys.id + '">' + companys.company_name + '</option>');
        });
    }else{
        select4.append('<option value="">No company found.</option>');
    }
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
                    companies = response.data;                  // 
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