// Admin Logout Ajax
$(document).ready(function () {
    $('.logout').on('click', function (event) {
        event.preventDefault();
        var formData = {
            action: 'logout'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/SessionController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if(response.status === 'success') {
                    let redirectUrl = '../../../Authentication/View/admin_login.php';
                    window.location.href = redirectUrl;
                }
                else if (response.status === 'error') {
                    Swal.fire({
                        title: "Error",
                        text: response.message,
                        icon: "error"
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: "Error",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        })

    })
})

// Create new driver

$(document).ready(function () {
    $('#driver-form').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('action', 'createDriver');
        
        $.ajax({
            type: 'POST',
            url: '../Controllers/DriverController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                let data = JSON.parse(response);
                if(data.status === 'success') {
                    popupClose('driver-add');
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
                    });
                }
                else if (data.status === 'error') {
                    popupClose('driver-add');
                    Swal.fire({
                        title: "Error",
                        text: data.message,
                        icon: "error"
                    });
                } else {
                    popupClose('driver-add');
                    Swal.fire({
                        title: "Error",
                        text: data.message,
                        icon: "error"
                    });
                }
            },
            error: function (response) {
                popupClose('driver-add');
                console.error(xhr.responseText);
                Swal.fire({
                    title: "Error",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        });
    });
});

//Get Driver details

function getDriverDetails(driverId) {
    let formData = {
        driverId: driverId,
        action: 'getDriver'
    }
    document.getElementsByClassName("loader-div")[0].style.display="block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/DriverController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if(response.status === 'success') {
                let driverDetails = response.data;
                document.getElementsByClassName("loader-div")[0].style.display="none";
                document.getElementsByClassName("driver-info")[0].style.display="block";
                driverDetails.driver_image_path != "" ? document.getElementById("d-v-profile-img").src = "../../Assets/User/"+driverDetails.driver_image_path : document.getElementById("d-v-profile-img").src = "../../Assets/Developer/image/manager.png";               
                driverDetails.fullname != "" ? document.getElementById("d-v-name").innerHTML = driverDetails.fullname : document.getElementById("d-v-name").innerHTML = "";
                driverDetails.mail != "" ? document.getElementById("d-v-mail").innerHTML = driverDetails.mail : document.getElementById("d-v-mail").innerHTML = "";
                driverDetails.mobile != "" ? document.getElementById("d-v-mobile").innerHTML = driverDetails.mobile : document.getElementById("d-v-mobile").innerHTML = "";
                driverDetails.licence_no != "" ? document.getElementById("d-v-licence-no").innerHTML = driverDetails.licence_no : document.getElementById("d-v-licence-no").innerHTML = "";
                driverDetails.licence_expiry != "" ? document.getElementById("d-v-licence-ex").innerHTML = driverDetails.licence_expiry : document.getElementById("d-v-licence-ex").innerHTML = "";
                driverDetails.aadhar_no != "" ? document.getElementById("d-v-aadhar-no").innerHTML = driverDetails.aadhar_no : document.getElementById("d-v-aadhar-no").innerHTML = "";
                driverDetails.pan_no != "" ? document.getElementById("d-v-pan-no").innerHTML = driverDetails.pan_no : document.getElementById("d-v-pan-no").innerHTML = "";
                driverDetails.licence_path != "" ? document.getElementById("d-v-licence-path").href = "../../Assets/User/"+driverDetails.licence_path : document.getElementById("d-v-licence-path").href = "";
                driverDetails.aadhar_path != "" ? document.getElementById("d-v-aadhar-path").href = "../../Assets/User/"+driverDetails.aadhar_path : document.getElementById("d-v-aadhar-path").href = "";
                driverDetails.pan_path != "" ? document.getElementById("d-v-pan-path").href = "../../Assets/User/"+driverDetails.pan_path : document.getElementById("d-v-pan-path").href = "";
                driverDetails.licence_path != "" ? document.getElementById("d-v-licence-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("d-v-licence-path").innerHTML = "";
                driverDetails.aadhar_path != "" ? document.getElementById("d-v-aadhar-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("d-v-aadhar-path").innerHTML = "";
                driverDetails.pan_path != "" ? document.getElementById("d-v-pan-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("d-v-pan-path").innerHTML = "";
            }
            else if (response.status === 'error') {
                popupClose('driver-view');
                Swal.fire({
                    title: "Error",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('driver-view');
                Swal.fire({
                    title: "Error",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        },
        error: function (response) {
            popupClose('driver-view');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Error",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}

