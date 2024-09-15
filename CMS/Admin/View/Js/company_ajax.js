getCompany();

function getCompany() {
    let formData1 = {
        action: 'getDriversCardDetails'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/CompanyController.php',
        data: formData1,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let cardDetails = response.data;
                document.getElementById("total_drivers").innerHTML = cardDetails.total_drivers;
                document.getElementById("active_drivers").innerHTML = cardDetails.active_drivers;
                document.getElementById("expired_licenses").innerHTML = cardDetails.expired_licenses;
                document.getElementById("upcoming_expitations").innerHTML = cardDetails.upcoming_expirations;
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
        action: 'getCompanys'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/CompanyController.php',
        data: formData2,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let driverDetails = response.data;
                console.log(driverDetails);

                let tableBody = $('#company-table tbody');
                tableBody.empty();

                $.each(driverDetails, function (index, item) {
                    let row = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + item.company_name + '</td>' +
                        '<td>' + item.district + '</td>' +
                        '<td>' + item.state + '</td>' +
                        '<td>' + item.company_email + '</td>' +
                        '<td>' + item.gstnumber + '</td>' +
                        '<td>' + item.company_phone + '</td>' +
                        // '<td><div class="btn-td"><span class="' + item.license_status + '">' + item.license_status + '</span></div></td>' +
                        `<td>
                            <div class="th-btn">
                                <button class="table-btn view" onclick="popupOpen('company-view'); getCompanyDetails(`+ item.id + `);"><i
                                                class="fa-duotone fa-eye"></i></button>
                                <button class="table-btn edit" onclick="popupOpen('company-edit'); getDriverDetailsForEdit(`+ item.id + `);"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                <button class="table-btn delete" onclick="deleteDriver(`+ item.id + `, '` + item.company_name + `')"><i class="fa-duotone fa-trash"></i></button>
                            </div>
                        </td>`      
                    '</tr>';
                    tableBody.append(row);
                })
                DataTable();
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

// Create new company

$(document).ready(function () {
    $('#company-form').on('submit', function (e) {
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('company-add');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Creating Company. Please wait..", 3000], ["Uploading company detail..", 3000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'createCompany');

        $.ajax({
            type: 'POST',
            url: '../Controllers/CompanyController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getCompany();
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

//Get Driver details

function getCompanyDetails(companyId) {
    let formData = {
        companyId: companyId,
        action: 'getCompany'
    }
    document.getElementsByClassName("loader-div")[0].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/CompanyController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let CompanyDetails = response.data;
                document.getElementsByClassName("loader-div")[0].style.display = "none";
                document.getElementsByClassName("driver-info")[0].style.display = "block";

                // id, company_name, district, state, company_email, gstnumber, company_phone

                CompanyDetails.company_name != "" ? document.getElementById("d-v-name").innerHTML = CompanyDetails.company_name : document.getElementById("d-v-name").innerHTML = "-";
                CompanyDetails.district != "" ? document.getElementById("d-v-district").innerHTML = CompanyDetails.district : document.getElementById("d-v-district").innerHTML = "-";
                CompanyDetails.state != "" ? document.getElementById("d-v-state").innerHTML = CompanyDetails.state : document.getElementById("d-v-state").innerHTML = "-";
                CompanyDetails.company_email != "" ? document.getElementById("d-v-mail").innerHTML = CompanyDetails.company_email : document.getElementById("d-v-mail").innerHTML = "-";
                CompanyDetails.gstnumber != "" ? document.getElementById("d-v-gstno").innerHTML = CompanyDetails.gstnumber : document.getElementById("d-v-gstno").innerHTML = "-";
                CompanyDetails.company_phone != "" ? document.getElementById("d-v-mobile").innerHTML = CompanyDetails.company_phone : document.getElementById("d-v-mobile").innerHTML = "-";
                CompanyDetails.company_address != "" ? document.getElementById("d-v-address").innerHTML = CompanyDetails.company_address : document.getElementById("d-v-address").innerHTML = "-";
                CompanyDetails.pincode != "" ? document.getElementById("d-v-pincode").innerHTML = CompanyDetails.pincode : document.getElementById("d-v-pincode").innerHTML = "-";
                
            }
            else if (response.status === 'error') {
                popupClose('company-view');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('company-view');
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            popupClose('company-view');
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

function getDriverDetailsForEdit(companyId) {
    let formData = {
        companyId: companyId,
        action: 'getCompany'
    }
    document.getElementsByClassName("loader-div")[1].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/CompanyController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let CompanyDetails = response.data;
                console.log(response);
                document.getElementsByClassName("loader-div")[1].style.display = "none";
                document.getElementsByClassName("driver-info")[1].style.display = "block";
                document.getElementById("d-e-driver-id").value = CompanyDetails.id;


                CompanyDetails.company_name != "" ? document.getElementById("d-e-name").value = CompanyDetails.company_name : document.getElementById("d-e-name").value = "-";
                CompanyDetails.district != "" ? document.getElementById("d-e-district").value = CompanyDetails.district : document.getElementById("d-e-district").value = "-";
                CompanyDetails.state != "" ? document.getElementById("d-e-state").value = CompanyDetails.state : document.getElementById("d-e-state").value = "-";
                CompanyDetails.company_email != "" ? document.getElementById("d-e-mail").value = CompanyDetails.company_email : document.getElementById("d-e-mail").value = "-";
                CompanyDetails.gstnumber != "" ? document.getElementById("d-e-gstno").value = CompanyDetails.gstnumber : document.getElementById("d-e-gstno").value = "-";
                CompanyDetails.company_phone != "" ? document.getElementById("d-e-mobile").value = CompanyDetails.company_phone : document.getElementById("d-e-mobile").value = "-";
                CompanyDetails.company_address != "" ? document.getElementById("d-e-address").value = CompanyDetails.company_address : document.getElementById("d-e-address").value = "-";
                CompanyDetails.pincode != "" ? document.getElementById("d-e-pincode").value = CompanyDetails.pincode : document.getElementById("d-e-pincode").value = "-";

            }
            else if (response.status === 'error') {
                popupClose('company-edit');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('company-edit');
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            popupClose('company-edit');
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
    $('#company-edit-form').on('submit', function (e) {
        e.preventDefault();
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Updating company. Please wait..", 4000], ["please wait a moment..", 4000], ["Uploading company details..", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'updateCompany');

        $.ajax({
            type: 'POST',
            url: '../Controllers/CompanyController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getCompany();
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

function deleteDriver(driverId, driverName) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete " + driverName,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            //Calling progress bar
            popupOpen("progress-loader");
            let array = [["Deleting driver. Please wait..", 4000], ["Deleting driver documents..", 4000], ["Please wait a moment..", 4000]];
            progressLoader(array);
            let formData = {
                driverId: driverId,
                action: 'deleteDriver'
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/CompanyController.php',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    popupClose("progress-loader");
                    // let data = JSON.parse(response);
                    if (data.status === 'success') {
                        getCompany();
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