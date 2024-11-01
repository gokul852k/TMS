//Get Daily Report Table data 
//Data table and Cards
//Chart as globle variable

let chartInstance = null;

//Get driver Table data 
getMaintenanceReports();

function getMaintenanceReports() {
    let formData1 = {
        action: 'getMaintenanceCardDetails'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/MaintenanceReportController.php',
        data: formData1,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let cardDetails = response.data;
                document.getElementById("total-amount").innerHTML = cardDetails.total_charge;
                document.getElementById("total-services").innerHTML = cardDetails.total_services;
                document.getElementById("avg-service-charge").innerHTML = cardDetails.avg_service_charge;
            }
        },
        error: function (xhr, status, error) {
            // popupClose('driver-view');
            console.error(xhr.responseText);
            // Swal.fire({
            //     title: "Error",
            //     text: "Something went wrong! Please try again.",
            //     icon: "error"
            // });
        }
    });
    let formData2 = {
        action: 'getMaintenanceDetails'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/MaintenanceReportController.php',
        data: formData2,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let driverDetails = response.data;
                console.log(driverDetails);

                let tableBody = $('#maintenance-report-table tbody');
                tableBody.empty();

                $.each(driverDetails, function (index, item) {
                    let row = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + item.car_number + '</td>' +
                        '<td>' + item.fullname + '</td>' +
                        '<td>' + convertDateFormat(item.maintenance_date) + '</td>' +
                        '<td>' + item.total_charge + '</td>' +
                        `<td>
                            <div class="th-btn">
                            <button class="table-btn view" onclick="popupOpen('view'); getMaintenanceReportDetails(${item.maintenance_report_id});" title="View">
                                <i class="fa-duotone fa-eye"></i>
                            </button>
                                <button class="table-btn edit" onclick="popupOpen('edit'); getMaintenanceReportEdit(`+ item.maintenance_report_id + `);"><i
                                                    class="fa-duotone fa-pen-to-square"></i></button>
                                <button class="table-btn delete" onclick="deleteMaintenance(`+ item.maintenance_report_id + `)"><i class="fa-duotone fa-trash"></i></button>
                            </div>
                        </td>`
                    '</tr>';
                    // `, '` + item.carId + `', '` + item.maintenanceDate + 
                    tableBody.append(row);
                })
                DataTable();
            }
        },
        error: function (xhr, status, error) {
            // popupClose('driver-view');
            console.error(xhr.responseText);
            // Swal.fire({
            //     title: "Error",
            //     text: "Something went wrong! Please try again.",
            //     icon: "error"
            // });
        }
    });
}

function getMaintenanceReportDetails(maintenance_report_id) {
    let formData = {
        maintenance_report_id: maintenance_report_id,
        action: 'getMaintenanceReportDetails'
    }
    // document.getElementsByClassName("loader-div")[0].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/MaintenanceReportController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                displayView(response.data);
            }
            else if (response.status === 'error') {
                popupClose('view');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('edit');
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            popupClose('bus-view');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}


async function getDetails() {
    // alert("getEditDetails");
    if (!cars) {
        await carsAjax();
    }

    let select = $('#edit-car-no');
    select.empty();  // Clear existing options

    // Add default "Select Car" option
    select.append('<option value="" selected>Select Car</option>');

    cars.forEach((car) => {
        select.append('<option value="' + car.id + '">' + car.car_number + '</option>');
    });

    //Spare parts
    if (!drivers) {
        await driverAjax();
    }
    let select3 = $('#driver-name');
    select3.empty();  // Clear existing options

    // Add default "Select Spare" option
    select3.append('<option value="" selected>Select Driver</option>');

    driver_opt.forEach((driver_options) => {
        select3.append('<option value="' + driver_options.id + '">' + driver_options.fullName + '</option>');
    });

    // Company
    if (!company) {
        await companyAjax();
    }
    let select4 = $('#cabcompany');
    select4.empty();
    select4.append('<option value="" disabled selected>Select Company</option>');

    companyss.forEach(companys => {
        select4.append('<option value="' + companys.id + '">' + companys.company_name + '</option>');
    });

}


//Add Daily Report
$(document).ready(function () {
    $('#add-maintenance-report').on('submit', function (e) {
        // alert("yes");
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('add');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Adding Maintenance report. Please waite..", 4000], ["Uploading maintenance bill..", 4000], ["wait a moment...", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'createMaintenanceReport');

        $.ajax({
            type: 'POST',
            url: '../Controllers/MaintenanceReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getMaintenanceReports();
                    // alert('Success');
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
                    });
                }
                else if (data.status === 'error') {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        });
    });
});

//Edit Daily Report

function getDailyReportForEdit(reportId) {
    let formData = {
        reportId: reportId,
        action: 'getDailyReportForEdit'
    }
    // document.getElementsByClassName("loader-div")[0].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/MaintenanceReportController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {

            }
            else if (response.status === 'error') {
                popupClose('bus-view');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('bus-view');
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            popupClose('bus-view');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}

function getSixMonthsAgoDate() {
    return new Promise((resolve, reject) => {
        // Get the current date
        const currentDate = new Date();

        // Create a new date object for 6 months ago
        const sixMonthsAgo = new Date(currentDate);
        sixMonthsAgo.setMonth(currentDate.getMonth() - 6);

        // Get the start of the month for the date 6 months ago
        const startOfSixMonthsAgo = getStartOfMonth(sixMonthsAgo);

        // Add 1 day to the start of the month
        const adjustedDate = addDays(startOfSixMonthsAgo, 1);

        // Resolve the promise with the adjusted date
        resolve(adjustedDate.toISOString().split('T')[0]);
    });
}

// Function to get the start of the month for a given date
function getStartOfMonth(date) {
    return new Date(date.getFullYear(), date.getMonth(), 1);
}

// Function to add days to a given date
function addDays(date, days) {
    const newDate = new Date(date);
    newDate.setDate(newDate.getDate() + days);
    return newDate;
}

//Edit Daily Report

function getMaintenanceReportEdit(maintenance_report_id) {
    // alert("maintenance_report_id "+maintenance_report_id);
    let formData = {
        maintenance_report_id: maintenance_report_id,
        action: 'getMaintenanceReportEdit'
    }

    $.ajax({
        type: 'POST',
        url: '../Controllers/MaintenanceReportController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                console.log(response);
                displayEdit(response.data);
            }

            else if (response.status === 'error') {
                popupClose('edit');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('edit');
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        },
       error: function (xhr, status, error) {
            popupClose('bus-view');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
    // alert("maintenance_report_id "+maintenance_report_id);
}

$(document).ready(function () {
    $('#edit-maintenance-report').on('submit', function (e) {
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('edit');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Adding Daily report. Please waite..", 4000], ["Calculating Daily report..", 4000], ["wait a moment...", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('deletedItems', JSON.stringify(deletedItems));
        formData.append('action', 'updateDailyReport');

        $.ajax({
            type: 'POST',
            url: '../Controllers/MaintenanceReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getMaintenanceReports()();
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
                    });
                }
                else if (data.status === 'error') {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        });
    });
});

//Delete Maintenance

function deleteMaintenance(maintenance_report_id, carId, maintenanceDate) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            //Calling progress bar
            popupOpen("progress-loader");
            let array = [["Deleting car. Please wait..", 4000], ["Deleting car documents..", 4000], ["Please wait a moment..", 4000]];
            progressLoader(array);
            let formData = {
                maintenanceReportId: maintenance_report_id,
                action: 'deleteMaintenance'
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/MaintenanceReportController.php',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    popupClose("progress-loader");
                    let data = response;
                    if (data.status === 'success') {
                        getMaintenanceReports();
                        Swal.fire({
                            title: "Success",
                            text: data.message,
                            icon: "success"
                        });
                    }
                    else if (data.status === 'error') {
                        Swal.fire({
                            title: "Oops!",
                            text: data.message,
                            icon: "error"
                        });
                    } else {
                        Swal.fire({
                            title: "Oops!",
                            text: data.message,
                            icon: "error"
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: "Oops!",
                        text: "Something went wrong! Please try again.",
                        icon: "error"
                    });
                }
            });
        }
    });
}

function unSelect() {
    document.querySelectorAll('[name="days"]').forEach(function (radio) {
        radio.checked = false;
    });
}

function uncheck() {
    document.querySelector('input[name="filter-from-date"]').value = '';
    document.querySelector('input[name="filter-to-date"]').value = '';
}

$(document).ready(function () {
    $('#filter-form').on('submit', function (e) {
        e.preventDefault();
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Applying filter..", 4000], ["please wait a moment..", 4000], ["Uploading fuel bill..", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('orderBy', 'ASC');
        formData.append('action', 'applyFilter');

        $.ajax({
            type: 'POST',
            url: '../Controllers/MaintenanceReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {

                    //Card
                    let maintenanceDetails = data.cardCount;
                    document.getElementById("total-amount").innerHTML = maintenanceDetails.total_charge;
                    document.getElementById("total-services").innerHTML = maintenanceDetails.total_services;
                    document.getElementById("avg-service-charge").innerHTML = maintenanceDetails.avg_service_charge;
                    // document.getElementById("c-collection").innerHTML = cardDetails.collection;
                    // document.getElementById("c-expense").innerHTML = cardDetails.expenses;
                    // document.getElementById("c-fuel-amount").innerHTML = cardDetails.fuelAmount;
                    // document.getElementById("c-salary").innerHTML = cardDetails.salary;
                    // document.getElementById("c-commission").innerHTML = cardDetails.commission;
                    // document.getElementById("c-loss").innerHTML = cardDetails.loss;
                    // document.getElementById("c-profit").innerHTML = cardDetails.profit;


                    // Assuming DataTables is already initialized on '#daily-report-table'
                    let table = $('#maintenance-report-table').DataTable(); // Initialize the DataTable

                    // Clear the DataTable
                    table.clear();

                    // Daily Report Data
                    let reports = data.dailyReport;

                    // Iterate over reports and add rows to the DataTable
                    $.each(reports, function (index, report) {
                        let row = [
                            index + 1, // Add index
                            report.car_number,
                            report.fullname,
                            report.maintenance_date,
                            report.total_charge,
                            // report.avgMilage,
                            // report.passenger,
                            // report.collection,
                            // report.expenses,
                            // report.fuelAmount,
                            // report.salary,
                            // report.commission,
                            // report.profit,
                            // `<div class="th-btn">
                            //     <button class="table-btn view" onclick="popupOpen('view'); getMaintenanceReportDetails(${item.maintenance_report_id});" title="View">
                            //         <i class="fa-duotone fa-eye"></i>
                            //     </button>
                            //     <button class="table-btn edit" onclick="popupOpen('edit'); getMaintenanceReportEdit(`+ item.maintenance_report_id + `); title="Edit">
                            //         <i class="fa-duotone fa-pen-to-square"></i>
                            //     </button>
                            //     <button class="table-btn delete" onclick="deleteMaintenance(`+ item.maintenance_report_id + `)" title="Delete">
                            //         <i class="fa-duotone fa-trash"></i>
                            //     </button>
                            // </div>`

                            `<div class="th-btn">
                                <button class="table-btn view" onclick="popupOpen('view'); getDailyReportDetails(${report.reportId});" title="View">
                                    <i class="fa-duotone fa-eye"></i>
                                </button>
                                <button class="table-btn edit" onclick="popupOpen('edit'); getDailyReportForEdit(${report.reportId});" title="Edit">
                                    <i class="fa-duotone fa-pen-to-square"></i>
                                </button>
                                <button class="table-btn delete" onclick="deleteBus(${report.reportId}, '${report.busNumber}')" title="Delete">
                                    <i class="fa-duotone fa-trash"></i>
                                </button>
                            </div>`
                        ];

                        

                        // Add the new row to the DataTable
                        table.row.add(row);
                    });

                    // Redraw the DataTable to show the new data
                    table.draw();

                }
                else if (data.status === 'error') {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                }
            },
            error: function (response) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        });
    });
});