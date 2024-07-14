<?php
require_once './header.php';
require_once './navbar.php';
?>

<link rel="stylesheet" href="../../../Common/Common file/card.css">
<link rel="stylesheet" href="../../../Common/Common file/header.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">
<link rel="stylesheet" href="./Style/driver.css">

<div class="register-driver">
    <div class="container box-container box-head w3-animate-top">
        <div class="row row-head">
            <div class="">
                <h4 class="heading">Routes Details</h4>
            </div>
            <div class="row-head-div-2">
                <button class="button-1 head-button3" onclick="popupOpen('route-add')"><i
                        class="fa-solid fa-location-dot"></i>Add Route</button>
                <button class="button-1 head-button2">Download<i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>
    <div class="container box-container w3-animate-top">
        <div class="row row-head">
            <div class="content">
                <div class="container-fluid">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 card-row-d-r">
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Total Bus</p>
                                                <h4 class="my-1 text-info" id="total_drivers">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                                                <i class="fa-solid fa-bus"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Total Routes</p>
                                                <h4 class="my-1 text-info t-c-2" id="active_drivers">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                                <i class="fa-solid fa-road"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Language Support</p>
                                                <h4 class="my-1 text-info t-c-4" id="expired_licenses">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                                <i class="fa-solid fa-book"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Active Buses</p>
                                                <h4 class="my-1 text-info t-c-3" id="upcoming_expitations">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle  bg-gradient-blooker text-white ms-auto">
                                                <i class="fa-solid fa-shield-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container box-container w3-animate-bottom" onload="getDrivers()">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table
                            summary="This table shows how to create responsive tables using Datatables' extended functionality"
                            class="table table-bordered table-hover dt-responsive" id="drivers-table">

                            <thead>
                                <tr>
                                    <th class="th">S.No</th>
                                    <th class="th">Name</th>
                                    <th class="th">Mobile</th>
                                    <th class="th">Mail ID</th>
                                    <th class="th">District</th>
                                    <th class="th">License No</th>
                                    <th class="th">License Expiry</th>
                                    <th class="th">License Status</th>
                                    <th class="th">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Add Driver Pop ups-->
<div class="tms-pop-up" id="route-add">
    <div class="pop-up-bg" onclick="popupClose('route-add')"></div>
    <div class="pop-up-card-3 scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-location-dot"></i>Add route</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('route-add')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="register-driver">
                <form enctype="multipart/form-data" id="driver-form">
                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Route Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="" class="input-label">Route</label>
                                <input type="text" class="input-field" name="" placeholder="" />
                            </div>
                            <div class="col-sm-12">
                                <label for="" class="input-label">Route</label>
                                <input type="text" class="input-field" name="" placeholder="" />
                            </div>
                            <div class="col-sm-12">
                                <label for="" class="input-label">Route</label>
                                <input type="text" class="input-field" name="" placeholder="" />
                            </div>
                            <div class="col-sm-12">
                                <label for="" class="input-label">Route</label>
                                <input type="text" class="input-field" name="" placeholder="" />
                            </div>
                            <div class="col-sm-12">
                                <label for="" class="input-label">Route</label>
                                <input type="text" class="input-field" name="" placeholder="" />
                            </div>
                        </div>
                    </div>

                    <div class="pop-up-button-div box-container box-head m-b-10">
                        <button type="submit" name="submit" class="button-2 box-shadow">Create Route</button>
                        <button type="reset" name="submit" class="button-3 box-shadow"
                            onclick="popupClose('route-add')">cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--View Driver Pop ups-->
<div class="tms-pop-up" id="driver-view">
    <div class="pop-up-bg" onclick="popupClose('driver-view')"></div>
    <div class="pop-up-card-3 scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-location-dot"></i>Route Details</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('driver-view')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="loader-div" style="display: none">
                <div class="loader"></div>
                <p class="loader-text">Loading</p>
            </div>
            <div class="driver-info" style="display: none">
                <div class="container box-container">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="info-div">
                                <p class="info-title">Salem new bus stand</p>
                                <div class="infos">
                                    <p class="info-heading">English</p>
                                    <p class="info-content" id="d-v-name">Salem new bus stand</p>
                                </div>
                                <div class="infos">
                                    <p class="info-heading">Tamil</p>
                                    <p class="info-content" id="d-v-mail">சேலம் புதிய பேருந்து நிலையம்</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!--Edit Driver Pop ups-->

<div class="tms-pop-up" id="driver-edit">
    <div class="pop-up-bg" onclick="popupClose('driver-edit')"></div>
    <div class="pop-up-card-3 scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-location-dot"></i>Update Route Details</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('driver-edit')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="loader-div" style="display: none">
                <div class="loader"></div>
                <p class="loader-text">Loading</p>
            </div>
            <div class="container driver-info" style="display: none">
                <form enctype="multipart/form-data" id="driver-edit-form">
                    <input type="hidden" name="driver_id" id="d-e-driver-id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="driver-info-right box-container-2 m-b-10">
                                <div class="row">
                                    <p class="info-title">Route information</p>
                                    <div class="col-sm-12">
                                        <div class="infos">
                                            <p class="info-heading">Route</p>
                                            <input type="text" class="input-field m-0" name="licence_no"
                                                id="d-e-licence-no" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="infos">
                                            <p class="info-heading">Route</p>
                                            <input type="date" class="input-field m-0" name="licence_expiry"
                                                id="d-e-licence-ex" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="pop-up-button-div box-container-sm m-b-10">
                                <button type="submit" name="submit" class="button-2 box-shadow"
                                    onclick="popupClose('driver-edit')">Update Route</button>
                                <button type="button" class="button-3 box-shadow"
                                    onclick="popupClose('driver-edit')">cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- Progress loader -->
<div class="tms-pop-up" id="progress-loader">
    <div class="pop-up-bg"></div>
    <div class="progress-loader">
        <div class="loader"></div>
        <p class="progress-text" id="progress-text">Loading, please wait..</p>
    </div>
</div>

<script src="../../../Common/Common file/pop_up.js"></script>
<script src="../../../Common/Common file/data_table.js"></script>
<script src="../../../Common/Common file/main.js"></script>
<script src="./js/driver.js"></script>
<script src="./js/drivers_ajax.js"></script>
<?php
require_once './footer.php';
?>