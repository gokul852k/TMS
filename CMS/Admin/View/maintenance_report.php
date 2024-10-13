<?php
require_once './header.php';
require_once './navbar.php';
// require_once '../../../Common/Common file/search_select_cdn.php';
require_once '../Services/MaintenanceReportService.php';

?>

<link rel="stylesheet" href="../../../Common/Common file/card.css">
<link rel="stylesheet" href="../../../Common/Common file/header.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">
<link rel="stylesheet" href="../../../Common/Common file/search_select.css">
<link rel="stylesheet" href="./Style/driver.css">
<link rel="stylesheet" href="./Style/daily_report.css">
<link rel="stylesheet" href="./Style/chart.css">


<div class="register-driver">
    <div class="container box-container box-head w3-animate-top">
        <div class="row row-head">
            <div class="col-sm-2 row-head-div-1">
                <h4 class="heading">Maintenance Report</h4>
            </div>
            <div class="col-sm-10 row-head-div-2">
                <button class="button-1 head-button2" onclick="popupOpen('filter'), getFilterField()"><i
                        class="fa-solid fa-filter"></i>Filter</button>
                <button class="button-1 head-button3" onclick="popupOpen('add'), getDetails()"><i
                        class="fa-solid fa-bus"></i>Add</button>
                <button class="button-1 head-button2">Download<i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>

    <div class="container d-chart">
        <div class="row">
            <div class="col-12 w3-animate-left d-chart-left">
                <div class="box-container tms-card">
                    <div class="tms-card-head">
                        <div><i class="fa-duotone fa-gas-pump"></i></div>
                        <div>Maintenance</div>
                    </div>
                    <div class="container tms-card-body" style="margin:0;height: 100%;width: 100%;">
                        <div class="row row-head">
                            <div class="content num-card">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-3 card-col-d-r">
                                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                                <a href="#" class="no-underline">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <p class="mb-0 text-secondary">Total Amount</p>
                                                                <h4 class="my-1 text-info t-c-4" id="total-amount">-
                                                                </h4>
                                                            </div>
                                                            <div
                                                                class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                                                <i class="fa-solid fa-indian-rupee-sign"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-3 card-col-d-r">
                                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                                <a href="./social_media_leads.php" class="no-underline">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <p class="mb-0 text-secondary">Total Services</p>
                                                                <h4 class="my-1 text-info t-c-3" id="total-services">-
                                                                </h4>
                                                            </div>
                                                            <div
                                                                class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
                                                                <i class="fa-solid fa-chart-simple"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-3 card-col-d-r">
                                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                                <a href="#" class="no-underline">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <p class="mb-0 text-secondary">Avg Service charge</p>
                                                                <h4 class="my-1 text-info t-c-2"
                                                                    id="avg-service-charge">-</h4>
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
                                        <div class="col-3 card-col-d-r">
                                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                                <a href="#" class="no-underline">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <p class="mb-0 text-secondary">New Metric</p>
                                                                <h4 class="my-1 text-info t-c-1" id="new-metric">-</h4>
                                                            </div>
                                                            <div
                                                                class="widgets-icons-2 rounded-circle bg-gradient-new text-white ms-auto">
                                                                <i class="fa-solid fa-new-icon"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Add more cards here if needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container box-container w3-animate-bottom">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table
                            summary="This table shows how to create responsive tables using Datatables' extended functionality"
                            class="table table-bordered table-hover dt-responsive" id="maintenance-report-table">

                            <thead>
                                <tr>
                                    <th class="th">S.No</th>
                                    <th class="th">Car Number</th>
                                    <th class="th">Driver Name</th>
                                    <th class="th">Maintenance Date</th>
                                    <th class="th">Total Charge</th>
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
            <form id="add-maintenance-report" enctype="multipart/form-data">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Add Maintenance Report</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('add')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body">
                    <div>
                        <div class="row p-20">



                            <div class="col-sm-4">
                                <label for="" class="input-label">Car No</label>
                                <select class="input-field" name="car-id" id="car-no" required>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="" class="input-label">Driver Name</label>
                                <select class="input-field" name="driver-name" id="driver-name" required>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="" class="input-label">Company Name</label>
                                <select class="input-field" name="cabcompany" id="cabcompany" required>
                                    <option value="">Select Company</option>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="" class="input-label">Date</label>
                                <input type="date" class="input-field" name="date" placeholder="" required />
                            </div>

                            <div class="bms-shift-header">
                                    <p class="bms-shift-title">Add Changed Spare Parts</p>
                                    <button type="button" class="add-button" id="add-spare-part"
                                        title="Add Spare Part"><i class="fa-solid fa-circle-plus"></i></button>
                                </div>
                        </div>
                    </div>



                    <div class="bms-shift-container">
                        <div class="cms-spares" id="cms-spares">
                            <div class="bms-shift" id="bms-shift">
                                
                            </div>
                        </div>

                        <div>
                            <div class="row p-20">
                                <div class="col-sm-4">
                                    <label for="" class="input-label">Service Charge</label>
                                    <input type="number" class="input-field" name="service_charge" placeholder=""
                                        required />
                                </div>

                                <div class="col-sm-4">
                                    <label for="" class="input-label">Total Charges</label>
                                    <input type="number" class="input-field" name="total_chargers" placeholder=""
                                        required />
                                </div>

                                <div class="col-sm-4">
                                    <label for="upload_bill" class="input-label">Upload Bill</label>
                                    <div class="file-input m-t-5">
                                        <input type="file" name="upload_bill" id="upload_bill"
                                            class="reupload-file-input__input" onchange="updateFileName()" />
                                        <label class="reupload-file-input__label" for="upload_bill" id="file-label">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path fill="currentColor"
                                                    d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z">
                                                </path>
                                            </svg>
                                            <span id="file-name"><b>Upload Bill</b></span>
                                        </label>
                                    </div>
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

<!--Edit Fuel Report Pop ups-->
<div class="admin-modal model-m" id="edit">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('edit')"></div>
        <div class="admin-modal-content">
            <form id="edit-maintenance-report" enctype="multipart/form-data">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Edit Maintenance Report</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('edit')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body">
                    <div>
                        <div class="row p-20">
                        <input type="hidden" name="maintenance_report_id" id="edit-maintenance-report-id" value="23">
                            <div class="col-sm-4">
                                <label for="" class="input-label">Car No</label>
                                <select class="input-field" name="edit-car-id" id="edit-car-no" required>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="" class="input-label">Driver Name</label>
                                <select class="input-field" name="driver-name" id="edit-driver-name" required>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="" class="input-label">Company Name</label>
                                <select class="input-field" name="cabcompany" id="edit-cabcompany" required>
                                    
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="" class="input-label">Date</label>
                                <input type="date" class="input-field" name="date" id="maintenance-date" placeholder="" required />
                            </div>
                            <div class="bms-shift-header">
                                    <p class="bms-shift-title">Add Changed Spare Parts</p>
                                    <button type="button" class="add-button" id="edit-spare-part"
                                        title="Add Spare Part"><i class="fa-solid fa-circle-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="bms-shift-container">
                        <div class="cms-edit-spares" id="cms-edit-spares">
                            <div class="bms-shift" id="bms-shift">
                                
                            </div>
                        </div>
                        <div>
                            <div class="row p-20">
                                <div class="col-sm-4">
                                    <label for="" class="input-label">Service Charge</label>
                                    <input type="number" class="input-field" name="service_charge" id="edit-service-charge" placeholder=""
                                        required />
                                </div>

                                <div class="col-sm-4">
                                    <label for="" class="input-label">Total Charges</label>
                                    <input type="number" class="input-field" name="total_chargers" id="edit-total-charge" placeholder=""
                                        required />
                                </div>

                                <div class="col-sm-4">
                                    <label for="upload_bill" class="input-label" id="icon_upload">Upload Bill&nbsp;&nbsp;</label>
                                    <div class="file-input m-t-5">
                                        <input type="hidden" id="hidden-file-url" name="file-url">
                                        <input type="file" name="edit_upload_bill" id="edit_upload_bill"
                                            class="reupload-file-input__input" onchange="editupdateFileName()" />
                                        <label class="reupload-file-input__label" for="upload_bill" id="file-label">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path fill="currentColor"
                                                    d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z">
                                                </path>
                                            </svg>
                                            <span id="file-name"><b>Upload Bill</b></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="admin-modal-footer">
                    <button type="submit" class="button-3" onclick="popupClose('edit')">Update</button>
                    <button type="reset" class="button-2" onclick="popupClose('edit')">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--View Daily Report Pop ups-->
<div class="admin-modal model-m" id="view">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('view')"></div>
        <div class="admin-modal-content daily-report-view">
            <form id="view-daily-report">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title" id="View-title">Maintenance Report</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('view')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body admin-view-body" id="daily-report-view-content">
                    
                </div>
            </form>
        </div>
    </div>
</div>

<!--Filter Pop ups-->
<div class="admin-modal model-sm" id="filter">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('filter')"></div>
        <div class="admin-modal-content">
            <form id="filter-form">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Add Filter</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('filter')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body">
                    <div class="row p-20">
                        <div class="col-sm-12">
                            <label for="" class="input-label">Date</label>
                            <div class="form-group filter-date">
                                <span>From</span>
                                <input type="date" name="filter-from-date" class="form-field">
                            </div>
                            <div class="form-group filter-date">
                                <input type="date" name="filter-to-date" class="form-field">
                                <span>To</span>
                            </div>
                        </div>
                        <div class="selectpicker-row p-0">
                            <div class="col-sm-12 search-select-1">
                                <label for="" class="input-label">Car No</label>
                                <select class="selectpicker input-field" data-show-subtext="true"
                                    data-live-search="true" name="filter-car" id="filter-car">

                                </select>
                            </div>
                        </div>
                        <div class="selectpicker-row p-0">
                            <div class="col-sm-12 search-select-1">
                                <label for="" class="input-label">Spare Part</label>
                                <select class="selectpicker input-field" data-show-subtext="true"
                                    data-live-search="true" name="spare-part-filter" id="spare-part-filter">

                                </select>
                            </div>
                        </div>

                        <div class="selectpicker-row p-0">
                            <div class="col-sm-12 search-select-1">
                                <label for="" class="input-label">Driver</label>
                                <select class="selectpicker input-field" data-show-subtext="true"
                                    data-live-search="true" name="driver-filter" id="driver-filter">

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="" class="input-label">Fuel Cost Range</label>
                            <div class="form-group filter-date">
                                <span>From</span>
                                <input type="number" name="filter-fuel-cost-from" class="form-field">
                            </div>
                            <div class="form-group filter-date">
                                <input type="number" name="filter-fuel-cost-to" class="form-field">
                                <span>To</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="admin-modal-footer">
                    <button type="submit" class="button-3" onclick="popupClose('filter')">Apply Filter</button>
                    <button type="reset" class="button-2">Clear</button>
                </div>
            </form>
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
<script src="./Js/maintenance_report_ajax.js"></script>
<script src="./Js/maintenance_report.js"></script>
<?php
require_once './footer.php';
?>