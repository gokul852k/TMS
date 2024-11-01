// Get translations labels
let tlabels;
getTranslations();
function getTranslations () {
    var formData2 = {
        action: 'getTranslations',
        pageId: 4
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
                    {"translation": "Spare Parts"},                                 // 5
                    {"translation": "Quantity"},                                    // 6
                    {"translation": "Price"},                                       // 7
                    {"translation": "Select Spare"},                                // 8
                ]
            }
            
        }
    });
}

function sparePartAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getSpareParts'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/MaintenanceReportController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    sparePart = response.data;
                    resolve();
                } else {
                    reject();
                }
            },
            error: function (xhr, status, error) {
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


//Add Daily Report
$(document).ready(function () {
    $('#add-maintenance-report').on('submit', function (e) {
        // alert("yes");
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        //Calling progress bar
        // let array = [["Adding Maintenance report. Please waite..", 4000], ["Uploading maintenance bill..", 4000], ["wait a moment...", 4000]];
        // progressLoader(array);
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
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    // alert('Success');
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
                    });
                }
                else if (data.status === 'errorMain') {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                }else if (data.status === 'errorSub') {
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