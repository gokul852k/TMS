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

// Trip Collection

$(document).ready(function () {
    $('#trip-collection').on('submit', function (e) {
        e.preventDefault();
        
        if ($("#start-route").val() == "") {
            $('#start-route').addClass('input-error');
            $('#start-route-error').html('Start route is required');
            return;
        }

        if ($("#end-route").val() == "") {
            $('#end-route').addClass('input-error');
            $('#end-route-error').html('End route is required');
            return;
        }

        if ($("#passengers").val() == "") {
            $('#passengers').addClass('input-error');
            $('#passengers-error').html('Passengers is required');
            return;
        }

        if ($("#collection").val() == "") {
            $('#collection').addClass('input-error');
            $('#collection-error').html('Collection is required');
            return;
        }

        var formData = new FormData(this);
        formData.append('action', 'tripCollection');

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

// Trip Collection 2

$(document).ready(function () {
    $('#trip-collection-2').on('submit', function (e) {
        e.preventDefault();

        if ($("#passengers-2").val() == "") {
            $('#passengers-2').addClass('input-error');
            $('#passengers-2-error').html('Passengers is required');
            return;
        }

        if ($("#collection-2").val() == "") {
            $('#collection-2').addClass('input-error');
            $('#collection-2-error').html('Collection is required');
            return;
        }

        var formData = new FormData(this);
        formData.append('action', 'tripCollection2');

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

// End Trip

$(document).ready(function () {
    $('#end-trip').on('submit', function (e) {
        e.preventDefault();
        
        if ($("#end-km").val() == "") {
            $('#end-km').addClass('input-error');
            $('#end-km-error').html('End KM is required');
            return;
        }

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
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Continue Work",
                        cancelButtonText: "Stop Work"
                      }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        } else if (result.isDismissed) {
                            var formData1 = {
                                action: 'endDuty',
                                tripId: data.tripId
                            }
                            $.ajax({
                                type: 'POST',
                                url: '../Controllers/DailyReportController.php',
                                data: formData1,
                                dataType: 'json',
                                success: function (response) {
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            title: "Success",
                                            text: response.message,
                                            icon: "success"
                                        }).then((result) => {
                                            window.location.reload();
                                        });
                                    }
                                    else if (response.status === 'error') {
                                        Swal.fire({
                                            title: "Oops!",
                                            text: response.message,
                                            icon: "error"
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Oops!",
                                            text: response.message,
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

function startDuty() {
    document.getElementsByClassName("duty-container-2")[0].style.display = 'none';
    document.getElementsByClassName("select-bus-container")[0].style.display = 'flex';
}

function endDuty() {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to End Duty ",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, End Duty"
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = {
                action: 'endDuty2'
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/DailyReportController.php',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: "success"
                        }).then((result) => {
                            window.location.reload();
                        });
                    }
                    else if (response.status === 'error') {
                        Swal.fire({
                            title: "Oops!",
                            text: response.message,
                            icon: "error"
                        });
                    } else {
                        Swal.fire({
                            title: "Oops!",
                            text: response.message,
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