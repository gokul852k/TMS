// Get translations labels
let tlabels;
getTranslations();
function getTranslations () {
    var formData2 = {
        action: 'getTranslations',
        pageId: 2
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData2,
        dataType: 'json',
        success: function (response) {
            if (response.status == "success") {
                tlabels = response.data;
                console.log(tlabels);
            }else {
                tlabels = [
                    {"translation": "Something went wrong while Starting Duty"},    // 0
                    {"translation": "Duty Started Successfully"},                   // 1
                    {"translation": "Something went wrong while Ending Duty"},      // 2
                    {"translation": "Duty Ended Successfully"},                     // 3
                    {"translation": "Please enter the correct Reading"},            // 4
                    {"translation": "Oops!"},                                       // 5
                    {"translation": "Success"},                                     // 6
                    {"translation": "Something went wrong! Please try again."},     // 7
                    {"translation": "Alert"}                                        // 8
                ]
            }
            
        }
    });
}

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
                        title: tlabels[6]['translation'],
                        text: tlabels[1]['translation'],
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
                        title: tlabels[5]['translation'],
                        text: tlabels[0]['translation'],
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: tlabels[5]['translation'],
                        text: tlabels[0]['translation'],
                        icon: "error"
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: tlabels[5]['translation'],
                    text: tlabels[7]['translation'],
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
                            title: tlabels[6]['translation'],
                            text: tlabels[3]['translation'],
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
                            title: tlabels[5]['translation'],
                            text: tlabels[2]['translation'],
                            icon: "error"
                        });
                    } else {
                        Swal.fire({
                            title: tlabels[5]['translation'],
                            text: tlabels[2]['translation'],
                            icon: "error"
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: tlabels[5]['translation'],
                        text: tlabels[7]['translation'],
                        icon: "error"
                    });
                }
            });
        } else {
            Swal.fire({
                title: tlabels[8]['translation'],
                text: tlabels[4]['translation'],
                icon: "warning",
                timer: 6000,
                timerProgressBar: true
            });
        }
    });
});