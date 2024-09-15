// Start Trip

$(document).ready(function () {
    $('#check-in').on('submit', function (e) {
        e.preventDefault();

        // if ($("#start-route").val() == "") {
        //     $('#start-route').addClass('input-error');
        //     $('#start-route-error').html('Start route is required');
        //     return;
        // }

        // if ($("#end-route").val() == "") {
        //     $('#end-route').addClass('input-error');
        //     $('#end-route-error').html('End route is required');
        //     return;
        // }

        // if ($("#start-km").val() == "") {
        //     $('#start-km').addClass('input-error');
        //     $('#start-km-error').html('Start KM is required');
        //     return;
        // }

        var formData = new FormData(this);
        formData.append('action', 'startTrip');

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
                        icon: "success",
                        timer: 6000,
                        timerProgressBar: true
                    }).then((result) => {
                        window.location.reload();
                        // Hide all status divs
                        // document.getElementById('check_in').style.display = 'none';
                        // document.getElementById('check_out').style.display = 'block';
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

// End Trip

$(document).ready(function () {
    $('#check-out').on('submit', function (e) {
        e.preventDefault();
        // alert(document.getElementById('hidden_checkin_km').value);

        // if ($("#start-route").val() == "") {
        //     $('#start-route').addClass('input-error');
        //     $('#start-route-error').html('Start route is required');
        //     return;
        // }

        // if ($("#end-route").val() == "") {
        //     $('#end-route').addClass('input-error');
        //     $('#end-route-error').html('End route is required');
        //     return;
        // }

        // if ($("#start-km").val() == "") {
        //     $('#start-km').addClass('input-error');
        //     $('#start-km-error').html('Start KM is required');
        //     return;
        // }
        let checkOutKm = $('#checkout-km').val();
        let checkInKm = $('#hidden_checkin_km').val();
        if (checkOutKm > checkInKm) {
            var formData = new FormData(this);
            formData.append('action', 'endTrip');
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
                            icon: "success",
                            timer: 6000,
                            timerProgressBar: true
                        }).then((result) => {
                            window.location.reload();
                            // Hide all status divs
                            // document.getElementById('check_in').style.display = 'block';
                            // document.getElementById('check_out').style.display = 'none';
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
        } else {
            Swal.fire({
                title: "Alert",
                text: "Please enter the correct Reading",
                icon: "warning",
                timer: 6000,
                timerProgressBar: true
            });
        }
    });
});