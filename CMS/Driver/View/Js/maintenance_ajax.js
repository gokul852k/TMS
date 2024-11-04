getTranslationsajax();

let tlabels2;

function getTranslationsajax () {
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
                tlabels2 = response.data;
                console.log(tlabels2);
            }else {
                tlabels2 = [
                    {"translation": "Something went wrong while add the Maintenance Report"},  // 0
                    {"translation": "Something went wrong while add the Spare Part"},          // 1
                    {"translation": "Maintenance Added Successfully"},                         // 2
                    {"translation": "Success"},                                                // 3
                    {"translation": "Oops!"},                                                  // 4
                    {"translation": "Something went wrong! Please try again."},                // 5
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
                    
                }
                resolve();
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
                        title: tlabels2[3]['translation'],
                        text: tlabels2[2]['translation'],
                        icon: "success"
                    });
                }
                else if (data.status === 'errorMain') {
                    Swal.fire({
                        title: tlabels2[4]['translation'],
                        text: tlabels2[0]['translation'],
                        icon: "error"
                    });
                }else if (data.status === 'errorSub') {
                    Swal.fire({
                        title: tlabels2[4]['translation'],
                        text: tlabels2[1]['translation'],
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: tlabels2[4]['translation'],
                        text: tlabels2[5]['translation'],
                        icon: "error"
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: tlabels2[4]['translation'],
                    text: tlabels2[5]['translation'],
                    icon: "error"
                });
            }
        });
    });
});