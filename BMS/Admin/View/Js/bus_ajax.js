function getFuelType() {
    let formData = {
        action: 'getFuelType'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/BusController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let fuelTypes = response.data;
                let select = $('#fuel-type');
                select.empty();
                select.append('<option value="" disabled selected>Select Fuel Type</option>');

                fuelTypes.forEach(fuelType => {
                    select.append('<option value="' + fuelType.id + '">' + fuelType.fuel + '</option>');
                });
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

// Create new bus

$(document).ready(function () {
    $('#bus-form').on('submit', function (e) {
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('bus-add');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Creating bus. Please waite..", 4000], ["Uploading bus documents..", 4000], ["wait a moment...", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'createBus');

        $.ajax({
            type: 'POST',
            url: '../Controllers/BusController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getDrivers();
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
                    });
                }
                else if (data.status === 'error') {
                    Swal.fire({
                        title: "Error",
                        text: data.message,
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: data.message,
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
        });
    });
});