//Fuel type as  globle variable
let fuelTypes;

//Get driver Table data 
getCares();



function getCares() {
    let formData1 = {
        action: 'getCarCardDetails'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/CarController.php',
        data: formData1,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let cardDetails = response.data;
                document.getElementById("total-car").innerHTML = cardDetails.total_car;
                document.getElementById("total-km").innerHTML = cardDetails.total_km;
                document.getElementById("avg-mileage").innerHTML = cardDetails.avg_mileage;
                document.getElementById("cost-per-km").innerHTML = cardDetails.cost_per_km;
                document.getElementById("expitations").innerHTML = cardDetails.expired_licenses;
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
        action: 'getCares'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/CarController.php',
        data: formData2,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let carDetails = response.data;
                console.log(carDetails);

                let tableBody = $('#car-table tbody');
                tableBody.empty();

                $.each(carDetails, function (index, item) {
                    let row = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + item.car_number + '</td>' +
                        '<td>' + item.fuel_type + '</td>' +
                        '<td>' + item.total_km + '</td>' +
                        '<td>' + item.avg_mileage + '</td>' +
                        '<td>' + item.cost_per_km + '</td>' +
                        '<td><div class="btn-td"><span class="' + item.rc_book_status + '">' + item.rc_book_status + '</span></div></td>' +
                        '<td><div class="btn-td"><span class="' + item.insurance_status + '">' + item.insurance_status + '</span></div></td>' +
                        `<td>
                            <div class="th-btn">
                                <button class="table-btn view" onclick="popupOpen('car-view'); getCarDetails(`+ item.car_id + `);"><i
                                                class="fa-duotone fa-eye"></i></button>
                                <button class="table-btn edit" onclick="popupOpen('car-edit'); getCarDetailsForEdit(`+ item.car_id + `);"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                <button class="table-btn delete" onclick="deleteCar(`+ item.car_id + `, '` + item.car_number + `')"><i class="fa-duotone fa-trash"></i></button>
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

async function getFuelType() {
    if (!fuelTypes) {
        await fuelTypeAjax();
    }
    let select = $('#fuel-type');
    select.empty();
    select.append('<option value="" disabled selected>Select Fuel Type</option>');

    fuelTypes.forEach(fuelType => {
        select.append('<option value="' + fuelType.id + '">' + fuelType.fuel + '</option>');
    });

}

//Fuel type ajax
function fuelTypeAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getFuelType'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/CarController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    fuelTypes = response.data;
                    resolve();
                } else {
                    reject();
                }
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

// Create new car

$(document).ready(function () {
    $('#car-form').on('submit', function (e) {
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('car-add');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Creating car. Please waite..", 4000], ["Uploading car documents..", 4000], ["wait a moment...", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'createCar');

        $.ajax({
            type: 'POST',
            url: '../Controllers/CarController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getCares();
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
    document.getElementsByClassName("loader-div")[0].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/CarController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let carDetails = response.data;
                console.log(carDetails);
                document.getElementsByClassName("loader-div")[0].style.display = "none";
                document.getElementsByClassName("car-info")[0].style.display = "block";

                console.log(typeof carDetails.fuel_cost);
                //Card details
                document.getElementById("c-v-profit").innerHTML = 0;
                document.getElementById("c-v-cost").innerHTML = parseFloat(carDetails.fuel_cost) + parseFloat(carDetails.maintenance_cost);
                document.getElementById("c-v-total-km").innerHTML = carDetails.total_km;
                document.getElementById("c-v-avg-mileage").innerHTML = carDetails.avg_mileage;
                document.getElementById("c-v-cost-per-km").innerHTML = carDetails.cost_per_km;

                carDetails.car_number != "" ? document.getElementById("c-v-car-no").innerHTML = carDetails.car_number : document.getElementById("c-v-car-no").innerHTML = "-";
                carDetails.car_model != "" ? document.getElementById("c-v-car-model").innerHTML = carDetails.car_model : document.getElementById("c-v-car-model").innerHTML = "-";
                carDetails.seating_capacity != "" ? document.getElementById("c-v-seating-capacity").innerHTML = carDetails.seating_capacity : document.getElementById("c-v-seating-capacity").innerHTML = "-";
                carDetails.fuel_type != "" ? document.getElementById("c-v-fuel-type").innerHTML = carDetails.fuel_type : document.getElementById("c-v-fuel-type").innerHTML = "-";
                carDetails.car_status != "" ? document.getElementById("c-v-car-status").innerHTML = (carDetails.car_status == 1) ? "Running" : "Not Running" : document.getElementById("c-v-car-status").innerHTML = "-";
                
                carDetails.rcbook_no != "" ? document.getElementById("c-v-rc-no").innerHTML = carDetails.rcbook_no : document.getElementById("c-v-rc-no").innerHTML = "-";
                carDetails.insurance_no != "" ? document.getElementById("c-v-insurance-no").innerHTML = carDetails.insurance_no : document.getElementById("c-v-insurance-no").value = "-";
                carDetails.rcbook_expiry != "" ? document.getElementById("c-v-rcbook-expiry").innerHTML = convertDateFormat(carDetails.rcbook_expiry) : document.getElementById("c-v-rcbook-expiry").innerHTML = "-";
                carDetails.insurance_expiry != "" ? document.getElementById("c-v-insurance-expiry").innerHTML = convertDateFormat(carDetails.insurance_expiry) : document.getElementById("c-v-insurance-expiry").innerHTML = "-";
                
                carDetails.rcbook_path != "" ? document.getElementById("c-v-rcbook-path").href = "../../Assets/User/" + carDetails.rcbook_path : document.getElementById("c-v-rcbook-path").href = "";
                carDetails.insurance_path != "" ? document.getElementById("c-v-insurance-path").href = "../../Assets/User/" + carDetails.insurance_path : document.getElementById("c-v-insurance-path").href = "";

                carDetails.rcbook_path != "" ? document.getElementById("c-v-rcbook-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("c-v-rcbook-path").innerHTML = "-";
                carDetails.insurance_path != "" ? document.getElementById("c-v-insurance-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("c-v-insurance-path").innerHTML = "-";

                //Bar chart
                var options = {
                    series: [{
                    data: [40000, 30000, 8000, 5000]
                  }],
                    chart: {
                    type: 'bar',
                    height: 350
                  },
                  plotOptions: {
                    bar: {
                      borderRadius: 4,
                      borderRadiusApplication: 'end',
                      horizontal: true,
                    }
                  },
                  dataLabels: {
                    enabled: false
                  },
                  xaxis: {
                    categories: ['Collection', 'Profit', 'Fuel Cost', 'Maintenance Cost'
                    ],
                  }
                  };
          
                  var chart = new ApexCharts(document.querySelector("#chart-1"), options);
                  chart.render();

                //Pie chart
                var options = {
                    series: [30000, 13000],
                    chart: {
                    type: 'donut',
                  },
                  responsive: [{
                    breakpoint: 480,
                    options: {
                      chart: {
                        width: 200
                      },
                      legend: {
                        position: 'bottom'
                      }
                    }
                  }]
                  };
          
                  var chart = new ApexCharts(document.querySelector("#chart-2"), options);
                  chart.render();
            }
            else if (response.status === 'error') {
                popupClose('car-view');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('car-view');
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            popupClose('car-view');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}

//Get Driver details for edit

async function getCarDetailsForEdit(CarId) {
    if(!fuelTypes) {
        await fuelTypeAjax();
    }
    let formData = {
        carId: CarId,
        action: 'getCarEdit'
    }
    document.getElementsByClassName("loader-div")[1].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/CarController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let carDetails = response.data;
                console.log(carDetails);
                document.getElementsByClassName("loader-div")[1].style.display = "none";
                document.getElementsByClassName("car-info")[1].style.display = "block";
                document.getElementById("c-e-car-id").value = carDetails.id;
                carDetails.car_number != "" ? document.getElementById("c-e-car-no").value = carDetails.car_number : document.getElementById("c-e-car-no").value = "";
                carDetails.car_model != "" ? document.getElementById("c-e-car-model").value = carDetails.car_model : document.getElementById("c-e-car-model").value = "";
                carDetails.seating_capacity != "" ? document.getElementById("c-e-seating-capacity").value = carDetails.seating_capacity : document.getElementById("c-e-seating-capacity").value = "";
                //FuelType
                let select = $('#c-e-fuel-type');
                select.empty();
                select.append('<option value="" disabled>--Select Fuel Type--</option>');

                fuelTypes.forEach(fuelType => {
                    if (fuelType.id == carDetails.fuel_type_id) {
                        select.append('<option value="' + fuelType.id + '" selected>' + fuelType.fuel + '</option>');
                    } else {
                        select.append('<option value="' + fuelType.id + '">' + fuelType.fuel + '</option>');
                    }
                });
                
                //car satatus
                let select2 = $('#c-e-car-status');
                select2.empty();
                select2.append('<option value="" disabled>--Select Car Status--</option>');
                if (carDetails.car_status) {
                    select2.append('<option value="1" selected>Running</option>');
                    select2.append('<option value="0">Not Running</option>');
                } else {
                    select2.append('<option value="1">Running</option>');
                    select2.append('<option value="0" selected>Not Running</option>');
                }
                
                carDetails.rcbook_no != "" ? document.getElementById("c-e-rc-no").value = carDetails.rcbook_no : document.getElementById("c-e-rc-no").value = "";
                carDetails.insurance_no != "" ? document.getElementById("c-e-insurance-no").value = carDetails.insurance_no : document.getElementById("c-e-insurance-no").value = "";
                carDetails.rcbook_expiry != "" ? document.getElementById("c-e-rcbook-expiry").value = carDetails.rcbook_expiry : document.getElementById("c-e-rcbook-expiry").value = "";
                carDetails.insurance_expiry != "" ? document.getElementById("c-e-insurance-expiry").value = carDetails.insurance_expiry : document.getElementById("c-e-insurance-expiry").value = "";
                
                carDetails.rcbook_path != "" ? document.getElementById("c-e-rcbook-path").href = "../../Assets/User/" + carDetails.rcbook_path : document.getElementById("c-e-rcbook-path").href = "";
                carDetails.insurance_path != "" ? document.getElementById("c-e-insurance-path").href = "../../Assets/User/" + carDetails.insurance_path : document.getElementById("c-e-insurance-path").href = "";

                carDetails.rcbook_path != "" ? document.getElementById("c-e-rcbook-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("c-e-rcbook-path").innerHTML = "-";
                carDetails.insurance_path != "" ? document.getElementById("c-e-insurance-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("c-e-insurance-path").innerHTML = "-";

            }
            else if (response.status === 'error') {
                document.getElementsByClassName("loader-div")[1].style.display = "none";
                document.getElementsByClassName("car-info")[1].style.display = "block";
                popupClose('car-edit');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('car-edit');
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
            popupClose('car-edit');
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
    $('#car-edit-form').on('submit', function (e) {
        e.preventDefault();
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Updating car. Please wait..", 4000], ["please wait a moment..", 4000], ["Uploading car documents..", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'updateCar');

        $.ajax({
            type: 'POST',
            url: '../Controllers/CarController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getCares();
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

function deleteCar(carId, carName) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete " + carName,
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
                carId: carId,
                action: 'deleteCar'
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/CarController.php',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    popupClose("progress-loader");
                    // let data = JSON.parse(response);
                    if (data.status === 'success') {
                        getCares();
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