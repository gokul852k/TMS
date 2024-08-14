<?php
require_once './header.php';
require_once './navbar.php';

$companies = ["Apple", "Google", "Microsoft", "Amazon"];
?>

<link rel="stylesheet" href="../../../Common/Common file/card.css">
<link rel="stylesheet" href="../../../Common/Common file/header.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">
<link rel="stylesheet" href="./Style/bus.css">
<style>
    h2 {
        text-align: center;
        padding: 20px 0;
    }
</style>

<div class="register-driver">
    <div class="container box-container box-head w3-animate-top">
        <div class="row row-head">
            <div class="">
                <h4 class="heading">Company Details</h4>
            </div>
            <div class="row-head-div-2">
                <button class="button-1 head-button3" onclick="popupOpen('company-add')"><i
                        class="fa-solid fa-building"></i>Add Company</button>
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
                                                <p class="mb-0 text-secondary">Total Companies</p>
                                                <h4 class="my-1 text-info" id="total_drivers">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                                                <i class="fa-solid fa-user-pilot"></i>
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
                                                <p class="mb-0 text-secondary">Active Companies</p>
                                                <h4 class="my-1 text-info t-c-2" id="active_drivers">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                                <i class="fa-solid fa-user-check"></i>
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
                                                <p class="mb-0 text-secondary">About</p>
                                                <h4 class="my-1 text-info t-c-4" id="expired_licenses">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                                <i class="fa-solid fa-file-xmark"></i>
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
                                                <p class="mb-0 text-secondary">Target</p>
                                                <h4 class="my-1 text-info t-c-3" id="upcoming_expitations">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle  bg-gradient-blooker text-white ms-auto">
                                                <i class="fa-solid fa-memo-circle-info"></i>
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

    <div class="container box-container w3-animate-bottom" onload="getCompany()">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <table
                            summary="This table shows how to create responsive tables using Datatables' extended functionality"
                            class="table table-bordered table-hover dt-responsive" id="company-table">

                            <thead>

                                <tr>
                                    <th class="th">S.No</th>
                                    <th class="th">Company Name</th>
                                    <th class="th">District</th>
                                    <th class="th">State</th>
                                    <th class="th">Office Mail</th>
                                    <th class="th">GST Number</th>
                                    <th class="th">Contact No.</th>
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

<!--Add Company Pop ups-->
<div class="tms-pop-up" id="company-add">
    <div class="pop-up-bg" onclick="popupClose('company-add')"></div>
    <div class="pop-up-card-2 scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-building"></i>Add New Company</h4>
                    </div>

                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('company-add')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="register-driver">
                <form enctype="multipart/form-data" id="company-form">
                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Company Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" class="input-field" name="company" placeholder="Company Name"
                                            required />
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="input-field" name="gstnum" placeholder="GST Number"
                                            required />
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" class="input-field" name="email" placeholder="Mail ID"
                                            required />
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" class="input-field" name="mobile" placeholder="Contact Number"
                                            required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Company Location</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" class="input-field" name="address" placeholder="Address" />
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="input-field" name="state" placeholder="State" />
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="input-field" name="district" placeholder="District" />
                            </div>
                            <div class="col-sm-6">
                                <input type="number" class="input-field" name="pincode" placeholder="Pin Code" />
                            </div>
                        </div>
                    </div>

                    <div class="pop-up-button-div box-container box-head m-b-10">
                        <button type="submit" name="submit" class="button-2 box-shadow">Register Company</button>
                        <button type="reset" name="submit" class="button-3 box-shadow"
                            onclick="popupClose('company-add')">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--View Company Pop ups-->
<div class="tms-pop-up" id="company-view">
    <div class="pop-up-bg" onclick="popupClose('company-view')"></div>
    <div class="pop-up-card-2 height scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-building"></i>Company Details</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('company-view')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="loader-div" style="display: none">
                <div class="loader"></div>
                <p class="loader-text">Loading</p>
            </div>
            <div class="container driver-info" style="display: none">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row">
                                <p class="info-title">Company Information</p>
                                <div class="col-sm-6">
                                    <p class="info-heading">Company Name</p>
                                    <p class="info-content" id="d-v-name"></p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="info-heading">GST Number</p>
                                    <p class="info-content" id="d-v-gstno"></p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="info-heading">Email</p>
                                    <p class="info-content" id="d-v-mail"></p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="info-heading">Contact Number</p>
                                    <p class="info-content" id="d-v-mobile"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="driver-info-bottom box-container-2 m-b-10">
                                    <div class="row">
                                        <p class="info-title">Company Location Information</p>
                                        <div class="col-sm-6">
                                            <div class="infos">
                                                <p class="info-heading">Address</p>
                                                <p class="info-content" id="d-v-address"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="infos">
                                                <p class="info-heading">District</p>
                                                <p class="info-content" id="d-v-district"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="infos">
                                                <p class="info-heading">State</p>
                                                <p class="info-content" id="d-v-state"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="infos">
                                                <p class="info-heading">Pincode</p>
                                                <p class="info-content" id="d-v-pincode"></p>
                                            </div>
                                        </div>
                                    </div>
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

<div class="tms-pop-up" id="company-edit">
    <div class="pop-up-bg" onclick="popupClose('company-edit')"></div>
    <div class="pop-up-card-2 scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-building"></i>Update Company Details</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('company-edit')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="loader-div" style="display: none">
                <div class="loader"></div>
                <p class="loader-text">Loading</p>
            </div>
            <div class="container driver-info" style="display: none">
                <form enctype="multipart/form-data" id="company-edit-form">
                    <input type="hidden" name="driver_id" id="d-e-driver-id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="driver-info-right box-container-2 m-b-10">
                                    <div class="row">
                                        <p class="info-title">Company Information</p>
                                        <div class="col-sm-6">
                                            <div class="infos">
                                                <p class="info-heading">Company Name</p>
                                                <input type="text" class="input-field m-0" name="address"
                                                    id="d-e-name" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="infos">
                                                <p class="info-heading">GST Number</p>
                                                <input type="text" class="input-field m-0" name="district"
                                                    id="d-e-gstno" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="infos">
                                                <p class="info-heading">Email</p>
                                                <input type="text" class="input-field m-0" name="state"
                                                    id="d-e-mail" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="infos">
                                                <p class="info-heading">Contact Number</p>
                                                <input type="text" class="input-field m-0" name="pincode"
                                                    id="d-e-mobile" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="driver-info-right box-container-2 m-b-10">
                                    <div class="row">
                                        <p class="info-title">Location information</p>
                                        <div class="col-sm-6">
                                            <div class="infos">
                                                <p class="info-heading">Address</p>
                                                <input type="text" class="input-field m-0" name="address"
                                                    id="d-e-address" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="infos">
                                                <p class="info-heading">District</p>
                                                <input type="text" class="input-field m-0" name="district"
                                                    id="d-e-district" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="infos">
                                                <p class="info-heading">State</p>
                                                <input type="text" class="input-field m-0" name="state"
                                                    id="d-e-state" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="infos">
                                                <p class="info-heading">Pincode</p>
                                                <input type="text" class="input-field m-0" name="pincode"
                                                    id="d-e-pincode" />
                                            </div>
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
                                    onclick="popupClose('company-edit')">Update Company</button>
                                <button type="button" class="button-3 box-shadow"
                                    onclick="popupClose('company-edit')">Cancel</button>
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
<script src="./js/company_ajax.js"></script>
<?php
require_once './footer.php';
?>