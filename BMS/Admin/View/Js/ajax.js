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
                if(response.status === 'success') {
                    Swal.fire({
                        title: "Success",
                        text: response.message,
                        icon: "success"
                    });
                }
                else if (response.status === 'error') {
                    Swal.fire({
                        title: "Error",
                        text: response.message,
                        icon: "error"
                    });
                }
            },
            error: function (response) {
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