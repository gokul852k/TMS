//Get driver Table data 
$(document).ready(function () {
    $(window).on('load', function (event) {
        getRoutes();
    });
});



function getRoutes() {
    let formData1 = {
        action: 'getRouteCardDetails'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/RouteController.php',
        data: formData1,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let cardDetails = response.data;
                document.getElementById("total_bus").innerHTML = cardDetails.total_bus;
                document.getElementById("total_routes").innerHTML = cardDetails.total_routes;
                document.getElementById("language_support").innerHTML = cardDetails.language_support;
                document.getElementById("active_bus").innerHTML = cardDetails.active_bus;
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            // Swal.fire({
            //     title: "Error",
            //     text: "Something went wrong! Please try again.",
            //     icon: "error"
            // });
        }
    });
    let formData2 = {
        action: 'getRoutes'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/RouteController.php',
        data: formData2,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let routesDetails = response.data;
                console.log(routesDetails);

                let tableBody = $('#route-table tbody');
                tableBody.empty();

                $.each(routesDetails, function (index, item) {
                    let row = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + item.routeName + '</td>' +
                        `<td>
                            <div class="th-btn">
                                <button class="table-btn view" onclick="popupOpen('route-view'); getRouteDetails(`+ item.routeId + `);"><i
                                                class="fa-duotone fa-eye"></i></button>
                                <button class="table-btn edit" onclick="popupOpen('route-edit'); getRouteDetailsForEdit(`+ item.routeId + `);"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                <button class="table-btn delete" onclick="deleteRoute(`+ item.routeId + `, '` + item.routeName + `')"><i class="fa-duotone fa-trash"></i></button>
                            </div>
                        </td>`      
                    '</tr>';
                    tableBody.append(row);
                })
                DataTable();
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

function getLaguage() {
    let formData = {
        action: 'getLanguage'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/RouteController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let language_array = response.data;
                console.log(language_array);
                let html = "";
                for(let i=0; i<language_array.length; i++) {
                    html+=`
                        <div class="col-sm-12">
                            <label for="" class="input-label">Route name in ${language_array[i].language_name}</label>
                            <input type="text" class="input-field" name="${language_array[i].language_code}" placeholder="" required/>
                        </div>
                    `;
                }

                document.getElementById("route-input").innerHTML = html;
                
            }
            else if (response.status === 'error') {
                popupClose('route-add');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('route-add');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            popupClose('route-add');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}

// Create new route

$(document).ready(function () {
    $('#route-form').on('submit', function (e) {
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('route-add');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Creating route. Please waite..", 4000], ["Please wait a moment..", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'createRoute');

        $.ajax({
            type: 'POST',
            url: '../Controllers/RouteController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getRoutes();
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
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
            error: function (response) {
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


function getRouteDetailsForEdit(routeId) {
    let formData = {
        routeId: routeId,
        action: 'getRoute'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/RouteController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let language_array = response.data;
                console.log(language_array);
                document.getElementById("r-e-route-id").value = language_array[1].routeId;
                let html = "";
                for(let i=0; i<language_array.length; i++) {
                    html+=`
                        <div class="col-sm-12">
                            <label for="" class="input-label">Route name in ${language_array[i].language}</label>
                            <input type="text" class="input-field" name="route${language_array[i].translationId}" value="${language_array[i].routeName}" required/>
                        </div>
                    `;
                }
                document.getElementsByClassName("loader-div")[1].style.display = "none";
                document.getElementsByClassName("route-info")[1].style.display = "block";
                document.getElementById("route-edit-input").innerHTML = html;
                
            }
            else if (response.status === 'error') {
                popupClose('route-add');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('route-add');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            popupClose('route-add');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}

//Update route details

$(document).ready(function () {
    $('#route-edit-form').on('submit', function (e) {
        e.preventDefault();
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Updating bus. Please wait..", 4000], ["please wait a moment..", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'updateRoute');

        $.ajax({
            type: 'POST',
            url: '../Controllers/RouteController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getRoutes();
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
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
            error: function (response) {
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

//Route View

function getRouteDetails(routeId) {
    let formData = {
        routeId: routeId,
        action: 'getRoute'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/RouteController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let language_array = response.data;
                console.log(language_array);
                let html = "";
                for(let i=0; i<language_array.length; i++) {
                    html+=`
                        <div class="infos">
                            <p class="info-heading">${language_array[i].language}</p>
                            <p class="info-content">${language_array[i].routeName}</p>
                        </div>
                    `;
                }
                document.getElementsByClassName("loader-div")[0].style.display = "none";
                document.getElementsByClassName("route-info")[0].style.display = "block";
                document.getElementById("route-view-value").innerHTML = html;
                
            }
            else if (response.status === 'error') {
                popupClose('route-add');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('route-add');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            popupClose('route-add');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}

//Delete Route

function deleteRoute(routeId, routeName) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete " + routeName,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            //Calling progress bar
            popupOpen("progress-loader");
            let array = [["Deleting route. Please wait..", 4000], ["Please wait a moment..", 4000]];
            progressLoader(array);
            let formData = {
                routeId: routeId,
                action: 'deleteRoute'
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/RouteController.php',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    popupClose("progress-loader");
                    // let data = JSON.parse(response);
                    if (data.status === 'success') {
                        getRoutes();
                        Swal.fire({
                            title: "Deleted!",
                            text: data.message,
                            icon: "success"
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
        }
    });
}