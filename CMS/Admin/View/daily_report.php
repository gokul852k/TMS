<?php
require_once './header.php';
require_once './navbar.php';
?>

<link rel="stylesheet" href="../../../Common/Common file/card.css">
<link rel="stylesheet" href="../../../Common/Common file/header.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">
<link rel="stylesheet" href="./Style/driver.css">

<div class="register-driver">
    <div class="box-container box-head w3-animate-top">
        <div class="row row-head">
            <div class="row-head-div-1">
                <h4 class="heading">Daily Report Details</h4>
            </div>
            <div class="row-head-div-2">
                <button class="button-1 head-button3" onclick="popupOpen('add'); getDetails()"><i
                        class="fa-solid fa-user-pilot"></i>Add</button>
                <button class="button-1 head-button2">Download<i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>
    <div class="box-container w3-animate-top">
        <div class="row row-head c-5">
            <div class="content">
                <div class="container-fluid">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 card-row-d-r">
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Total Drivers</p>
                                                <h4 class="my-1 text-info t-c-4" id="total-driver">-</h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle bg-g-4 text-white ms-auto">
                                                <i class="fa-solid fa-car"></i>
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
                                                <p class="mb-0 text-secondary">Driver On Duty</p>
                                                <h4 class="my-1 text-info t-c-5" id="total-duty">-</h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle bg-g-5 text-white ms-auto">
                                                <i class="fa-solid fa-gauge-max"></i>
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
                                                <p class="mb-0 text-secondary">Avg Mileage</p>
                                                <h4 class="my-1 text-info t-c-6" id="avg-mileage">-</h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle bg-g-6 text-white ms-auto">
                                                <i class="fa-solid fa-gas-pump"></i>
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
                                                <p class="mb-0 text-secondary">Cost per KM</p>
                                                <h4 class="my-1 text-info t-c-7" id="cost-per-km">-</h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle  bg-g-7 text-white ms-auto">
                                                <i class="fa-solid fa-receipt"></i>
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
                                                <p class="mb-0 text-secondary">Expired</p>
                                                <h4 class="my-1 text-info t-c-3" id="expitations">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle  bg-gradient-blooker text-white ms-auto">
                                                <i class="fa-solid fa-file-xmark"></i>
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

    <div class="box-container w3-animate-bottom" onload="getDrivers()">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table
                            summary="This table shows how to create responsive tables using Datatables' extended functionality"
                            class="table table-bordered table-hover dt-responsive" id="daily-report-table">

                            <thead>
                                <tr>
                                    <th class="th">S.No</th>
                                    <th class="th">Driver Name</th>
                                    <th class="th">Checkin Date</th>
                                    <th class="th">Checkin Time</th>
                                    <th class="th">Checkin KM</th>
                                    <th class="th">Checkout Date</th>
                                    <th class="th">Checkout Time</th>
                                    <th class="th">Checkout KM</th>
                                    <th class="th">Total KM</th>
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

<!--Add Maintenance Report Pop ups-->
<div class="admin-modal model-m" id="add">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('add')"></div>
        <div class="admin-modal-content">
            <form id="add-daily-report">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Add Daily Report</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('add')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body">
                    <div>
                        <div class="row p-20">

                            <div class="col-sm-3">
                                <label for="" class="input-label">Car No</label>
                                <select class="input-field" name="car-id" id="car-no" required>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="" class="input-label">Driver Name</label>
                                <select class="input-field" name="driver-name" id="driver-name" required>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="" class="input-label">Company Name</label>
                                <select class="input-field" name="cabcompany" id="cabcompany" required>
                                    <option value="">Select Company</option>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="" class="input-label">Date</label>
                                <input type="date" class="input-field" name="date" id="date" placeholder="" required />
                            </div>
                        </div>
                    </div>

                    <div class="bms-shift-container">
                        <div>
                            <div class="row p-20">
                                <div class="col-sm-3">
                                    <label for="" class="input-label">Enter Starting KM</label>
                                    <input type="number" class="input-field" name="st-km" id="st-km" placeholder=""
                                        required />
                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="input-label">Enter Starting Date</label>
                                    <input type="date" class="input-field" name="st-date" id="st-date" placeholder=""
                                        required />
                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="input-label">Enter Starting Time</label>
                                    <input type="time" class="input-field" name="st-time" id="st-time" placeholder=""
                                        required />
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="row p-20">
                                <div class="col-sm-3">
                                    <label for="" class="input-label">Enter Ending KM</label>
                                    <input type="number" class="input-field" name="ed-km" id="ed-km" placeholder=""
                                        required />
                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="input-label">Enter Ending Date</label>
                                    <input type="date" class="input-field" name="ed-date" id="ed-date" placeholder=""
                                        required />
                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="input-label">Enter Ending Time</label>
                                    <input type="time" class="input-field" name="ed-time" id="ed-time" placeholder=""
                                        required />
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="admin-modal-footer">
                    <button type="submit" class="button-3">Submit</button>
                    <button type="reset" class="button-2" onclick="popupClose('add')">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--Edit Driver Pop ups-->
<div class="admin-modal model-m" id="edit">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('edit')"></div>
        <div class="admin-modal-content">
            <form id="edit-daily-report">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Add Daily Report</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('edit')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body">
                    <div>
                        <div class="row p-20">
                        <input type="text" name="daily_id" id="edit-daily-id">
                            <div class="col-sm-3">
                                <label for="" class="input-label">Car No</label>
                                <select class="input-field" name="car-id" id="e-car-no" required>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="" class="input-label">Driver Name</label>
                                <select class="input-field" name="driver-name" id="e-driver-name" required>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="" class="input-label">Company Name</label>
                                <select class="input-field" name="cabcompany" id="e-cabcompany" required>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="" class="input-label">Date</label>
                                <input type="date" class="input-field" name="date" id="e-date" placeholder="" required />
                            </div>
                        </div>
                    </div>

                    <div class="bms-shift-container">
                        <div>
                            <div class="row p-20">
                                <div class="col-sm-3">
                                    <label for="" class="input-label">Enter Starting KM</label>
                                    <input type="number" class="input-field" name="st-km" id="e-st-km" placeholder=""
                                        required />
                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="input-label">Enter Starting Date</label>
                                    <input type="date" class="input-field" name="st-date" id="e-st-date" placeholder=""
                                        required />
                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="input-label">Enter Starting Time</label>
                                    <input type="time" class="input-field" name="st-time" id="e-st-time" placeholder=""
                                        required />
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="row p-20">
                                <div class="col-sm-3">
                                    <label for="" class="input-label">Enter Ending KM</label>
                                    <input type="number" class="input-field" name="ed-km" id="e-ed-km" placeholder=""
                                        required />
                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="input-label">Enter Ending Date</label>
                                    <input type="date" class="input-field" name="ed-date" id="e-ed-date" placeholder=""
                                        required />
                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="input-label">Enter Ending Time</label>
                                    <input type="time" class="input-field" name="ed-time" id="e-ed-time" placeholder=""
                                        required />
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="admin-modal-footer">
                    <button type="submit" class="button-3">Update</button>
                    <button type="reset" class="button-2" onclick="popupClose('edit')">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--View Driver Pop ups-->
<div class="admin-modal model-m w3-animate-top" id="view">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('view')"></div>
        <div class="admin-modal-content">
            <div class="admin-modal-header">
                <h5 class="admin-modal-title">Driver Details</h5>
                <button type="button" class="admin-modal-close" onclick="popupClose('view')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="admin-modal-body admin-view-body">
                <div class="loader-div" style="display: none">
                    <div class="loader"></div>
                    <p class="loader-text">Loading</p>
                </div>
                <div class="container daily-info" style="display: none">
                    <div class="row">
                        <!-- <div class="col-sm-3 p-r-0 m-b-10">
                            <div class="driver-info-left box-container-2 h-100">
                                <div class="row">
                                    <div class="col-sm-12 info-profile-image-div">
                                        <img id="d-v-profile-img" src="../../Assets/Developer/image/manager.png"
                                            alt="profile image" class="info-profile-image">
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="info-div">
                                            <p class="info-title">Personal information</p>
                                            <div class="infos">
                                                <p class="info-heading">Name</p>
                                                <p class="info-content" id="d-v-name"></p>
                                            </div>
                                            <div class="infos">
                                                <p class="info-heading">Email</p>
                                                <p class="info-content" id="d-v-mail"></p>
                                            </div>
                                            <div class="infos">
                                                <p class="info-heading">Mobile Number</p>
                                                <p class="info-content" id="d-v-mobile"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-sm-12">
                            <!-- <div class="driver-info-right box-container-2 m-b-10">
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
                                                                        <p class="mb-0 text-secondary">Total Kilometers</p>
                                                                        <h4 class="my-1 text-info">20</h4>
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
                                                                        <p class="mb-0 text-secondary">Fuel Efficiency
                                                                        </p>
                                                                        <h4 class="my-1 text-info t-c-2">15</h4>
                                                                    </div>
                                                                    <div
                                                                        class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                                                        <i class="fa-solid fa-gas-pump"></i>
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
                                                                        <p class="mb-0 text-secondary">Safety Score
                                                                        </p>
                                                                        <h4 class="my-1 text-info t-c-5">-</h4>
                                                                    </div>
                                                                    <div
                                                                        class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
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
                            </div> -->
                            <div class="driver-info-right box-container-2 m-b-10">
                                <div class="row">
                                    <p class="info-title">Driver information</p>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Car Number</p>
                                            <p class="info-content" id="v-car-no"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Driver Name</p>
                                            <p class="info-content" id="v-driver"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Company Name</p>
                                            <p class="info-content" id="v-company"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Admin Entry Date</p>
                                            <p class="info-content" id="v-date"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Total KM</p>
                                            <p class="info-content" id="v-total-km"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="driver-info-right box-container-2 m-b-10">
                                <div class="row">
                                    <p class="info-title">Trip Start Details</p>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Start KM</p>
                                            <p class="info-content" id="v-st-km"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Start Date</p>
                                            <p class="info-content" id="v-st-date"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Start Time</p>
                                            <p class="info-content" id="v-st-time"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="driver-info-right box-container-2 m-b-10">
                                <div class="row">
                                    <p class="info-title">Trip End Details</p>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">End KM</p>
                                            <p class="info-content" id="v-ed-km"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">End Date</p>
                                            <p class="info-content" id="v-ed-date"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">End Time</p>
                                            <p class="info-content" id="v-ed-time"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="driver-info-right box-container-2 m-b-10">
                                <div class="row">
                                    <p class="info-title">Documents</p>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Licence</p>
                                            <a href="" id="d-v-licence-path" class="document-view d-v-1" target="_blank">
                                                <i class="fa-duotone fa-file-invoice"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Aadhar card</p>
                                            <a href="" id="d-v-aadhar-path" class="document-view d-v-2" target="_blank">
                                                <i class="fa-duotone fa-file-invoice"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">PAN card</p>
                                            <a href="" id="d-v-pan-path" class="document-view  d-v-3" target="_blank">
                                                <i class="fa-duotone fa-file-invoice"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-sm-12">
                            <div class="driver-info-bottom box-container-2 m-b-10">
                                <div class="row">
                                    <p class="info-title">Location information</p>
                                    <div class="col-sm-6">
                                        <div class="infos">
                                            <p class="info-heading">Address</p>
                                            <p class="info-content" id="d-v-address"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="infos">
                                            <p class="info-heading">District</p>
                                            <p class="info-content" id="d-v-district"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="infos">
                                            <p class="info-heading">State</p>
                                            <p class="info-content" id="d-v-state"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="infos">
                                            <p class="info-heading">Pincode</p>
                                            <p class="info-content" id="d-v-pincode"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
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
<script src="./Js/daily_report_ajax.js"></script>
<script src="./Js/daily_report.js"></script>
<?php
require_once './footer.php';
?>