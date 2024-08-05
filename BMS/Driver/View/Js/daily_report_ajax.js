// Create Daily Report

$(document).ready(function () {
    $('#select-bus').on('submit', function (e) {
        e.preventDefault();
        // Check if form is valid
        if ($("#bus-id").val() == "") {
            Swal.fire({
                title: "Oops!",
                text: "Please select bus",
                icon: "warning"
            });
            return;
        }

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
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
                    }).then((result) => {
                        window.location.reload();
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

// Create Trip

$(document).ready(function () {
    $('#select-trip').on('submit', function (e) {
        e.preventDefault();
        
        if ($("#start-route").val() == "") {
            $('#start-route').addClass('input-error');
            $('#start-route-error').html('Start route is required');
        }

        if ($("#end-route").val() == "") {
            $('#end-route').addClass('input-error');
            $('#end-route-error').html('End route is required');
        }

        if ($("#start-km").val() == "") {
            $('#start-km').addClass('input-error');
            $('#start-km-error').html('Start KM is required');
        }

        var formData = new FormData(this);
        formData.append('action', 'createTrip');

        $.ajax({
            type: 'POST',
            url: '../Controllers/DailyReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
                    }).then((result) => {
                        window.location.reload();
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