//Get driver Table data 
$(document).ready(function () {
    $(window).on('load', function (event) {
        getDrivers();
    });
});

function getDrivers() {
    let formData = {
        action: 'getDrivers'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/DriverController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if(response.status === 'success') {
                let driverDetails = response.data;
                console.log(driverDetails);

                let tableBody = $('#drivers-table tbody');
                tableBody.empty();

                $.each(driverDetails, function(index, item) {
                    let row = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + item.fullname + '</td>' +
                        '<td>' + item.mobile + '</td>' +
                        '<td>' + item.mail + '</td>' +
                        '<td>' + item.district + '</td>' +
                        '<td>' + item.licence_no + '</td>' +
                        '<td>' + convertDateFormat(item.licence_expiry) + '</td>' +
                        `<td class="th-btn">
                                        <button class="table-btn view" onclick="popupOpen('driver-view'); getDriverDetails(`+ item.id +`);"><i
                                                class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>`
                        '</tr>';
                    tableBody.append(row);
                })
                
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