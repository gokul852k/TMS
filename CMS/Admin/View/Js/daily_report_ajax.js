//Globle variable

let cars;
let drivers;
let company;
let driver_opt;
let companies;
//Get driver Table data 
getDailyReport();



function getDailyReport() {
    let formData1 = {
        action: 'getDailyReportCard'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData1,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let cardDetails = response.data;
                document.getElementById("total-driver").innerHTML = cardDetails.total_driver;
                document.getElementById("total-duty").innerHTML = cardDetails.active_driver;
                document.getElementById("avg-mileage").innerHTML = cardDetails.total_km;
                document.getElementById("cost-per-km").innerHTML = cardDetails.total_cab_company;
                document.getElementById("expitations").innerHTML = cardDetails.total_car;
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            // Swal.fire({
            //     title: "Error",
            //     text: "Something went wrong! Please try again.",
            //     icon: "error"
            // });
        }
    });
    
    let formData2 = {
        action: 'getDailyReports'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData2,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let dailyReportDetails = response.data;
                console.log(dailyReportDetails);

                let tableBody = $('#daily-report-table tbody');
                tableBody.empty();

                $.each(dailyReportDetails, function (index, item) {
                    let row = '<tr>' +
                                    '<td class="text-center">' + (index + 1) + '</td>' +
                                    '<td class="text-center">' + item.fullname + '</td>' +
                                    '<td class="text-center">' + item.check_in_date + '</td>' +
                                    '<td class="text-center">' + item.check_in_time + '</td>' +
                                    '<td class="text-center">' + item.check_in_km + '</td>' +
                                    '<td class="text-center">' + item.check_out_date + '</td>' +
                                    '<td class="text-center">' + item.check_out_time + '</td>' +
                                    '<td class="text-center">' + item.check_out_km + '</td>' +
                                    '<td class="text-center">' + item.total_km + '</td>' +
                                    `<td class="text-center">
                                        <div class="th-btn">
                                            <button class="table-btn view" onclick="popupOpen('view'); getCarDetails(`+ item.daily_report_id + `);"><i class="fa-duotone fa-eye"></i></button>
                                            <button class="table-btn edit" onclick="popupOpen('edit'); getCarDetailsForEdit(`+ item.daily_report_id + `);"><i class="fa-duotone fa-pen-to-square"></i></button>
                                            <button class="table-btn delete" onclick="deleteBus(`+ item.daily_report_id + `, '` + item.fullname + `')"><i class="fa-duotone fa-trash"></i></button>
                                        </div>
                                    </td>`
                                '</tr>';
                    tableBody.append(row);
                })
                DataTable();
            }
        },
        error: function (xhr, status, error) {
            popupClose('driver-view');
            console.error(xhr.responseText);
            // Swal.fire({
            //     title: "Error",
            //     text: "Something went wrong! Please try again.",
            //     icon: "error"
            // });
        }
    });
}

// Create new car

$(document).ready(function () {
    $('#add-daily-report').on('submit', function (e) {
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('add');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Creating Daily Report. Please wait..", 4000], ["wait a moment...", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'createDailyReport');

        $.ajax({
            type: 'POST',
            url: '../Controllers/DailyReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getDailyReport();
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

//Get Bus details

function getCarDetails(carId) {
    let formData = {
        carId: carId,
        action: 'getCarView'
    }
    // document.getElementsByClassName("loader-div")[0].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let dailyReportDetails = response.data;
                console.log(dailyReportDetails);
                document.getElementsByClassName("loader-div")[0].style.display = "none";
                document.getElementsByClassName("daily-info")[0].style.display = "block";

                // console.log(typeof dailyReportDetails.fuel_cost);
                //Card details
                // document.getElementById("c-v-profit").innerHTML = 0;
                // document.getElementById("c-v-cost").innerHTML = parseFloat(dailyReportDetails.fuel_cost) + parseFloat(dailyReportDetails.maintenance_cost);
                // document.getElementById("c-v-total-km").innerHTML = dailyReportDetails.total_km;
                // document.getElementById("c-v-avg-mileage").innerHTML = dailyReportDetails.avg_mileage;
                // document.getElementById("c-v-cost-per-km").innerHTML = dailyReportDetails.cost_per_km;

                dailyReportDetails.car_id != "" ? document.getElementById("v-car-no").innerHTML = dailyReportDetails.car_id : document.getElementById("v-car-no").innerHTML = "";
                dailyReportDetails.driver_id != "" ? document.getElementById("v-driver").innerHTML = dailyReportDetails.driver_id : document.getElementById("v-driver").innerHTML = "";
                dailyReportDetails.cab_company_id != "" ? document.getElementById("v-company").innerHTML = dailyReportDetails.cab_company_id : document.getElementById("v-company").innerHTML = "";
                dailyReportDetails.admin_entry_date != "" ? document.getElementById("v-date").innerHTML = dailyReportDetails.admin_entry_date : document.getElementById("v-date").innerHTML = "";
                dailyReportDetails.check_in_km != "" ? document.getElementById("v-st-km").innerHTML = dailyReportDetails.check_in_km : document.getElementById("v-st-km").innerHTML = "";
                dailyReportDetails.check_in_date != "" ? document.getElementById("v-st-date").innerHTML = dailyReportDetails.check_in_date : document.getElementById("v-st-date").innerHTML = "";
                dailyReportDetails.check_in_time != "" ? document.getElementById("v-st-time").innerHTML = dailyReportDetails.check_in_time : document.getElementById("v-st-time").innerHTML = "";
                dailyReportDetails.check_out_km != "" ? document.getElementById("v-ed-km").innerHTML = dailyReportDetails.check_out_km : document.getElementById("v-ed-km").innerHTML = "";
                dailyReportDetails.check_out_date != "" ? document.getElementById("v-ed-date").innerHTML = dailyReportDetails.check_out_date : document.getElementById("v-ed-date").innerHTML = "";
                dailyReportDetails.check_out_time != "" ? document.getElementById("v-ed-time").innerHTML = dailyReportDetails.check_out_time : document.getElementById("v-ed-time").innerHTML = "";
                dailyReportDetails.total_km != "" ? document.getElementById("v-total-km").innerHTML = dailyReportDetails.total_km : document.getElementById("v-total-km").innerHTML = "";

                // dailyReportDetails.car_number != "" ? document.getElementById("c-v-car-no").innerHTML = dailyReportDetails.car_number : document.getElementById("c-v-car-no").innerHTML = "-";
                // dailyReportDetails.car_model != "" ? document.getElementById("c-v-car-model").innerHTML = dailyReportDetails.car_model : document.getElementById("c-v-car-model").innerHTML = "-";
                // dailyReportDetails.seating_capacity != "" ? document.getElementById("c-v-seating-capacity").innerHTML = dailyReportDetails.seating_capacity : document.getElementById("c-v-seating-capacity").innerHTML = "-";
                // dailyReportDetails.fuel_type != "" ? document.getElementById("c-v-fuel-type").innerHTML = dailyReportDetails.fuel_type : document.getElementById("c-v-fuel-type").innerHTML = "-";
                // dailyReportDetails.car_status != "" ? document.getElementById("c-v-car-status").innerHTML = (dailyReportDetails.car_status == 1) ? "Running" : "Not Running" : document.getElementById("c-v-car-status").innerHTML = "-";
                
                // dailyReportDetails.rcbook_no != "" ? document.getElementById("c-v-rc-no").innerHTML = dailyReportDetails.rcbook_no : document.getElementById("c-v-rc-no").innerHTML = "-";
                // dailyReportDetails.insurance_no != "" ? document.getElementById("c-v-insurance-no").innerHTML = dailyReportDetails.insurance_no : document.getElementById("c-v-insurance-no").value = "-";
                // dailyReportDetails.rcbook_expiry != "" ? document.getElementById("c-v-rcbook-expiry").innerHTML = convertDateFormat(dailyReportDetails.rcbook_expiry) : document.getElementById("c-v-rcbook-expiry").innerHTML = "-";
                // dailyReportDetails.insurance_expiry != "" ? document.getElementById("c-v-insurance-expiry").innerHTML = convertDateFormat(dailyReportDetails.insurance_expiry) : document.getElementById("c-v-insurance-expiry").innerHTML = "-";
                
                // dailyReportDetails.rcbook_path != "" ? document.getElementById("c-v-rcbook-path").href = "../../Assets/User/" + dailyReportDetails.rcbook_path : document.getElementById("c-v-rcbook-path").href = "";
                // dailyReportDetails.insurance_path != "" ? document.getElementById("c-v-insurance-path").href = "../../Assets/User/" + dailyReportDetails.insurance_path : document.getElementById("c-v-insurance-path").href = "";

                // dailyReportDetails.rcbook_path != "" ? document.getElementById("c-v-rcbook-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("c-v-rcbook-path").innerHTML = "-";
                // dailyReportDetails.insurance_path != "" ? document.getElementById("c-v-insurance-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("c-v-insurance-path").innerHTML = "-";

                // //Bar chart
                // var options = {
                //     series: [{
                //     data: [40000, 30000, 8000, 5000]
                //   }],
                //     chart: {
                //     type: 'bar',
                //     height: 350
                //   },
                //   plotOptions: {
                //     bar: {
                //       borderRadius: 4,
                //       borderRadiusApplication: 'end',
                //       horizontal: true,
                //     }
                //   },
                //   dataLabels: {
                //     enabled: false
                //   },
                //   xaxis: {
                //     categories: ['Collection', 'Profit', 'Fuel Cost', 'Maintenance Cost'
                //     ],
                //   }
                //   };
          
                //   var chart = new ApexCharts(document.querySelector("#chart-1"), options);
                //   chart.render();

                // //Pie chart
                // var options = {
                //     series: [30000, 13000],
                //     chart: {
                //     type: 'donut',
                //   },
                //   responsive: [{
                //     breakpoint: 480,
                //     options: {
                //       chart: {
                //         width: 200
                //       },
                //       legend: {
                //         position: 'bottom'
                //       }
                //     }
                //   }]
                //   };
          
                //   var chart = new ApexCharts(document.querySelector("#chart-2"), options);
                //   chart.render();
            }
            else if (response.status === 'error') {
                popupClose('view');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('view');
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            popupClose('view');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}




async function getCarDetailsForEdit(CarId) {
    if (!cars) {
        await carsAjax();
    }

    //Spare parts
    if (!drivers) {
        await driverAjax();
    }

    // Company
    if (!company) {
        await companyAjax();
    }

    let formData = {
        carId: CarId,
        action: 'getCarEdit'
    }
    // document.getElementsByClassName("loader-div")[1].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let dailyReportDetails = response.data;
                console.log(dailyReportDetails);
                // document.getElementsByClassName("loader-div")[1].style.display = "none";
                // document.getElementsByClassName("car-info")[1].style.display = "block";
                // document.getElementById("e-date").value = dailyReportDetails.admin_entry_date;
                dailyReportDetails.id != "" ? document.getElementById("edit-daily-id").value = dailyReportDetails.id : document.getElementById("edit-daily-id").value = "";
                dailyReportDetails.admin_entry_date != "" ? document.getElementById("e-date").value = dailyReportDetails.admin_entry_date : document.getElementById("e-date").value = "";
                dailyReportDetails.check_in_km != "" ? document.getElementById("e-st-km").value = dailyReportDetails.check_in_km : document.getElementById("e-st-km").value = "";
                dailyReportDetails.check_in_date != "" ? document.getElementById("e-st-date").value = dailyReportDetails.check_in_date : document.getElementById("e-st-date").value = "";
                dailyReportDetails.check_in_time != "" ? document.getElementById("e-st-time").value = dailyReportDetails.check_in_time : document.getElementById("e-st-time").value = "";
                dailyReportDetails.check_out_km != "" ? document.getElementById("e-ed-km").value = dailyReportDetails.check_out_km : document.getElementById("e-ed-km").value = "";
                // alert(dailyReportDetails.check_out_km);
                dailyReportDetails.check_out_date != "" ? document.getElementById("e-ed-date").value = dailyReportDetails.check_out_date : document.getElementById("e-ed-date").value = "";
                // alert(dailyReportDetails.check_out_date);
                dailyReportDetails.check_out_time != "" ? document.getElementById("e-ed-time").value = dailyReportDetails.check_out_time : document.getElementById("e-ed-time").value = "";
                // alert(dailyReportDetails.check_out_time);
                
                //FuelType
                let select = $('#e-car-no');
                select.empty();
                select.append('<option value="" disabled>Select Car</option>');

                cars.forEach(car => {
                    if (car.id == dailyReportDetails.car_id) {
                        select.append('<option value="' + car.id + '" selected>' + car.car_number + '</option>');
                    } else {
                        select.append('<option value="' + car.id + '">' + car.car_number + '</option>');
                    }
                });

                let select2 = $('#e-driver-name');
                select2.empty();
                select2.append('<option value="" disabled>Select Driver</option>');

                driver_opt.forEach(driver_options => {
                    if (driver_options.id == dailyReportDetails.driver_id) {
                        select2.append('<option value="' + driver_options.id + '" selected>' + driver_options.fullName + '</option>');
                    } else {
                        select2.append('<option value="' + driver_options.id + '">' + driver_options.fullName + '</option>');
                    }
                });

                let select3 = $('#e-cabcompany');
                select3.empty();
                select3.append('<option value="" disabled>Select Company</option>');

                companies.forEach(companys => {
                    if (companys.id == dailyReportDetails.cab_company_id) {
                        select3.append('<option value="' + companys.id + '" selected>' + companys.company_name + '</option>');
                    } else {
                        select3.append('<option value="' + companys.id + '">' + companys.company_name + '</option>');
                    }
                });

            }
            else if (response.status === 'error') {
                document.getElementsByClassName("loader-div")[1].style.display = "none";
                document.getElementsByClassName("car-info")[1].style.display = "block";
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
            document.getElementsByClassName("loader-div")[1].style.display = "none";
                document.getElementsByClassName("car-info")[1].style.display = "block";
            popupClose('edit');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}

//Update driver details

$(document).ready(function () {
    $('#edit-daily-report').on('submit', function (e) {
        e.preventDefault();
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Updating Daily Report. Please wait..", 4000], ["please wait a moment..", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'updateCar');

        $.ajax({
            type: 'POST',
            url: '../Controllers/DailyReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                popupClose('edit');
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getDailyReport();
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

//Delete Driver

function deleteBus(busId, busName) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete " + busName,
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
                busId: busId,
                action: 'deleteBus'
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/BusController.php',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    popupClose("progress-loader");
                    // let data = JSON.parse(response);
                    if (data.status === 'success') {
                        getDailyReport();
                        Swal.fire({
                            title: "Deleted!",
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
    }else{
        select.append('<option value="" >No car found</option>');
    }

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
    }else{
        select3.append('<option value="" >No driver found</option>');
    }

    if (!company) {
        await companyAjax();
    }
    let select4 = $('#filter-company');
    select4.empty();
    select4.append('<option value="" disabled selected>Select Company</option>');

    if(companies != undefined){
        companies.forEach(companys => {
        select4.append('<option value="' + companys.id + '">' + companys.company_name + '</option>');
        });
    }else{
        select4.append('<option value="">No company found</option>');
    }

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
            url: '../Controllers/DailyReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {

                    //Card
                    let dailyreportcarddetails = data.cardCount;
                    document.getElementById("total-driver").innerHTML = dailyreportcarddetails.total_driver;
                    document.getElementById("total-duty").innerHTML = dailyreportcarddetails.active_driver;
                    document.getElementById("avg-mileage").innerHTML = dailyreportcarddetails.total_km;
                    document.getElementById("cost-per-km").innerHTML = dailyreportcarddetails.total_cab_company;
                    document.getElementById("expitations").innerHTML = dailyreportcarddetails.total_car;

                    // Assuming DataTables is already initialized on '#daily-report-table'
                    let table = $('#daily-report-table').DataTable(); // Initialize the DataTable

                    // Clear the DataTable
                    table.clear();

                    // Daily Report Data
                    let reports = data.dailyReport;

                    // Iterate over reports and add rows to the DataTable
                    $.each(reports, function (index, report) {

                        let row = [
                            index + 1, // Add index
                            report.fullname,
                            report.check_in_date,
                            report.check_in_time,
                            report.check_in_km,
                            report.check_out_date,
                            report.check_out_time,
                            report.check_out_km,
                            report.total_km,

                            `<div class="th-btn">
                                <button class="table-btn view" onclick="popupOpen('view'); getCarDetails(`+ report.daily_report_id + `);"><i class="fa-duotone fa-eye"></i></button>
                                <button class="table-btn edit" onclick="popupOpen('edit'); getCarDetailsForEdit(`+ report.daily_report_id + `);"><i class="fa-duotone fa-pen-to-square"></i></button>
                                <button class="table-btn delete" onclick="deleteBus(`+ report.daily_report_id + `, '` + report.fullname + `')"><i class="fa-duotone fa-trash"></i></button>
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


// -------------------------------------------------

//Get Daily Report Table data 
getDailyReports();

function getDailyReports() {
    
    let formData1 = {
        days: 30,
        fromDate: '',
        toDate: '',
        bus: '',
        collectionFrom: '',
        collectionTo: '',
        profitFrom: '',
        profitTo: '',
        kmFrom: '',
        kmTo: '',
        orderBy: 'DESC',
        action: 'applyFilter'
    }
    //We want to get the filer data to Excel download & store in localhost
    localStorage.setItem("filter", JSON.stringify(formData1));
    
    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData1,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            // let data = JSON.parse(response);
            if (data.status === 'success') {
                //Card
                let cardDetails = data.cardCount;
                document.getElementById("c-total-km").innerHTML = cardDetails.totalKm ? cardDetails.totalKm : '-';
                document.getElementById("c-fuel-usage").innerHTML = cardDetails.fuelUsage ? cardDetails.fuelUsage : '-';
                document.getElementById("c-passangers").innerHTML = cardDetails.passengers ? cardDetails.passengers : '-';
                document.getElementById("c-collection").innerHTML = cardDetails.collection ? '₹'+cardDetails.collection : '-';
                document.getElementById("c-expense").innerHTML = cardDetails.expenses ? '₹'+cardDetails.expenses : '-';
                document.getElementById("c-fuel-amount").innerHTML = cardDetails.fuelAmount ? '₹'+cardDetails.fuelAmount : '-';
                document.getElementById("c-salary").innerHTML = cardDetails.salary ? '₹'+cardDetails.salary : '-';
                document.getElementById("c-commission").innerHTML = cardDetails.commission ? '₹'+cardDetails.commission : '-';
                document.getElementById("c-loss").innerHTML = cardDetails.loss ? '₹'+cardDetails.loss : '-';
                document.getElementById("c-profit").innerHTML = cardDetails.profit ? '₹'+cardDetails.profit : '-';


                // Assuming DataTables is already initialized on '#daily-report-table'
                let table = $('#daily-report-table').DataTable(); // Initialize the DataTable

                // Clear the DataTable
                table.clear(); 

                // Daily Report Data
                let reports = data.dailyReport;

                // Iterate over reports and add rows to the DataTable
                $.each(reports, function (index, report) {
                    let row = [
                        index + 1, // Add index
                        report.date,
                        report.busNumber,
                        report.km,
                        report.fuelUsage,
                        report.avgMilage,
                        report.passenger,
                        report.collection,
                        report.expenses,
                        report.fuelAmount,
                        report.salary,
                        report.commission,
                        report.profit,
                        `<div class="th-btn">
                            <button class="table-btn view" onclick="popupOpen('view'); getDailyReportDetails(${report.reportId});" title="View">
                                <i class="fa-duotone fa-eye"></i>
                            </button>
                            <button class="table-btn edit" onclick="popupOpen('edit'); getDailyReportForEdit(${report.reportId});" title="Edit">
                                <i class="fa-duotone fa-pen-to-square"></i>
                            </button>
                            <button class="table-btn delete" onclick="deleteDailyReport(${report.reportId}, '${report.busNumber}', '${report.date}')" title="Delete">
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
}