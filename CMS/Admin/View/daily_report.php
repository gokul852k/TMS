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
                <h4 class="heading">Daily Report Details</h4>
            </div>
            <div class="row-head-div-2">
                <!-- <button class="button-1 head-button3" onclick="popupOpen('car-add'); getFuelType()"><i
                        class="fa-solid fa-car"></i>Add Car</button> -->
                <button class="button-1 head-button2">Download<i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>
    <div class="container box-container w3-animate-top">
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
                                                <h4 class="my-1 text-info t-c-4" id="total-car">-</h4>
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
                                                <h4 class="my-1 text-info t-c-5" id="total-km">-</h4>
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

    <div class="container box-container w3-animate-bottom" onload="getDrivers()">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
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

<!--Add Car Pop ups-->
<div class="tms-pop-up" id="car-add">
    <div class="pop-up-bg" onclick="popupClose('car-add')"></div>
    <div class="pop-up-card-2 scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Add Car</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('car-add')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="register-driver">
                <form enctype="multipart/form-data" id="car-form">
                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Car Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" class="input-field" name="car-number" placeholder="Car Number"
                                    required />
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="input-field" name="car-model" placeholder="Car Model" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="number" class="input-field" name="seating-capacity"
                                    placeholder="Seating Capacity" />
                            </div>
                            <div class="col-sm-6">
                                <select class="input-field" id="fuel-type" name="fuel-type" required>
                                    <option value="">--Select Fuel Type--</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <select class="input-field" name="car-status" required>
                                    <option value="" disabled selected>--Select Car Status--</option>
                                    <option value="1">Running</option>
                                    <option value="0">Not Running</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Documents</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="exampleFormControlFile1" class="drop-container" id="dropcontainer">
                                    <span class="drop-title">RC Book</span>
                                    <br>
                                    <input type="file" class="form-control-file" name="rc-book" accept="image/*,.pdf" />
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <label for="exampleFormControlFile1" class="drop-container" id="dropcontainer">
                                    <span class="drop-title">Upload Car Insurance</span>
                                    <br>
                                    <input type="file" class="form-control-file" name="insurance"
                                        accept="image/*,.pdf" />
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="" class="input-label">RC Book Number</label>
                                <input type="text" class="input-field" name="rc-book-number" />
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="input-label">Insurance Number</label>
                                <input type="text" class="input-field" name="insurance-number" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="" class="input-label">RC Book Expiry Date</label>
                                <input type="date" class="input-field" name="rc-book-expiry" />
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="input-label">Insurance Expiry Date</label>
                                <input type="date" class="input-field" name="insurance-expiry" />
                            </div>
                        </div>
                    </div>

                    <div class="pop-up-button-div box-container box-head m-b-10">
                        <button type="submit" name="submit" class="button-2 box-shadow">Add Car</button>
                        <button type="reset" name="submit" class="button-3 box-shadow"
                            onclick="popupClose('car-add')">cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--View Driver Pop ups-->
<div class="tms-pop-up" id="car-view">
    <div class="pop-up-bg" onclick="popupClose('car-view')"></div>
    <div class="pop-up-card scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Car Details</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('car-view')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="loader-div" style="display: none">
                <div class="loader"></div>
                <p class="loader-text">Loading</p>
            </div>
            <div class="container car-info" style="display: none">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="driver-info-right box-container-2 m-b-10">
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
                                                                    <p class="mb-0 text-secondary">Profit</p>
                                                                    <h4 class="my-1 text-info t-c-4" id="c-v-profit">
                                                                        -</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-g-4 text-white ms-auto">
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
                                                                    <p class="mb-0 text-secondary">Cost</p>
                                                                    <h4 class="my-1 text-info t-c-3" id="c-v-cost">-
                                                                    </h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle  bg-gradient-blooker text-white ms-auto">
                                                                    <i class="fa-solid fa-money-check-pen"></i>
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
                                                                    <p class="mb-0 text-secondary">Total KM</p>
                                                                    <h4 class="my-1 text-info t-c-5" id="c-v-total-km">-
                                                                    </h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-g-5 text-white ms-auto">
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
                                                                    <h4 class="my-1 text-info t-c-6"
                                                                        id="c-v-avg-mileage">-</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-g-6 text-white ms-auto">
                                                                    <i class="fa-sharp fa-solid fa-gas-pump"></i>
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
                                                                    <h4 class="my-1 text-info t-c-7"
                                                                        id="c-v-cost-per-km">-</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle  bg-g-7 text-white ms-auto">
                                                                    <i class="fa-solid fa-receipt"></i>
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

                        <div class="row">

                            <div class="col-sm-7 p-r-0 m-b-10">
                                <div class="driver-info-left box-container-2 h-100">
                                    <div class="chart-1" id="chart-1">

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="driver-info-right box-container-2 m-b-10">
                                    <div class="chart-2" id="chart-2">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row">
                                <p class="info-title">Car information</p>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Car Number</p>
                                        <p class="info-content" id="c-v-car-no">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Car Model</p>
                                        <p class="info-content" id="c-v-car-model">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Seating Capacity</p>
                                        <p class="info-content" id="c-v-seating-capacity">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Fuel Type</p>
                                        <p class="info-content" id="c-v-fuel-type">-</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Car Status</p>
                                        <p class="info-content" id="c-v-car-status">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">RC Book Number</p>
                                        <p class="info-content" id="c-v-rc-no">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">RC Book Expiry Date</p>
                                        <p class="info-content" id="c-v-rcbook-expiry">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Insurance Number</p>
                                        <p class="info-content" id="c-v-insurance-no">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Insurance Expiry Date</p>
                                        <p class="info-content" id="c-v-insurance-expiry">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row">
                                <p class="info-title">Documents</p>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">RC Book</p>
                                        <a href="" id="c-v-rcbook-path" class="document-view d-v-2" target="_blank">
                                            <i class="fa-duotone fa-file-invoice"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Insurance</p>
                                        <a href="" id="c-v-insurance-path" class="document-view  d-v-3" target="_blank">
                                            <i class="fa-duotone fa-file-invoice"></i>
                                        </a>
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

<div class="tms-pop-up" id="car-edit">
    <div class="pop-up-bg" onclick="popupClose('car-edit')"></div>
    <div class="pop-up-card-2 scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Update Car Details</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('car-edit')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="loader-div" style="display: none">
                <div class="loader"></div>
                <p class="loader-text">Loading</p>
            </div>
            <div class="container car-info p-0" style="display: none">
                <form enctype="multipart/form-data" id="car-edit-form">
                    <input type="hidden" name="car_id" id="c-e-car-id">
                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Car Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <label for="" class="input-label">Car Number</label>
                                <input type="text" class="input-field" name="car_number" id="c-e-car-no"
                                    placeholder="Car Number" required />
                            </div>
                            <div class="col-sm-6">
                            <label for="" class="input-label">Car Model</label>
                                <input type="text" class="input-field" name="car_model" id="c-e-car-model"
                                    placeholder="Car Model" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <label for="" class="input-label">Seating Capacity</label>
                                <input type="number" class="input-field" name="seating_capacity"
                                    id="c-e-seating-capacity" placeholder="Seating Capacity" required />
                            </div>
                            <div class="col-sm-6">
                            <label for="" class="input-label">Fuel Type</label>
                                <select class="input-field" name="fuel_type_id" id="c-e-fuel-type">
                                    <option value="">--Select Fuel Type--</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                            <label for="" class="input-label">Car Status</label>
                                <select class="input-field" name="car_status" id="c-e-car-status">
                                    <option value="">--Select Car Status--</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <label for="" class="input-label">Rc Book Number</label>
                                <input type="text" class="input-field" name="rcbook_no" id="c-e-rc-no"
                                    placeholder="Rc Book Number" required />
                            </div>
                            <div class="col-sm-6">
                            <label for="" class="input-label">Insurance Number</label>
                                <input type="text" class="input-field" name="insurance_no" id="c-e-insurance-no"
                                    placeholder="Insurance Number" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="" class="input-label">RC Book Expiry Date</label>
                                <input type="date" class="input-field" name="rcbook_expiry" id="c-e-rcbook-expiry"
                                    required />
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="input-label">Insurance Expiry Date</label>
                                <input type="date" class="input-field" name="insurance_expiry" id="c-e-insurance-expiry"
                                    required />
                            </div>
                        </div>
                        <div class="row h-center-div">
                            <div class="col-sm-6">
                                <div class="infos">
                                    <p class="info-heading">RC Book</p>
                                    <a href="" id="c-e-rcbook-path" class="document-view d-v-2 m-t-10" target="_blank">
                                        <i class="fa-duotone fa-file-invoice"></i>
                                    </a>
                                    <div class="file-input m-t-20">
                                        <input type="file" name="rcbook_path" id="rcbook_path"
                                            class="reupload-file-input__input" />
                                        <label class="reupload-file-input__label" for="rcbook_path">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path fill="currentColor"
                                                    d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z">
                                                </path>
                                            </svg>
                                            <span>Re-upload RC Book</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="infos">
                                    <p class="info-heading">Insurance</p>
                                    <a href="" id="c-e-insurance-path" class="document-view d-v-3 m-t-10"
                                        target="_blank">
                                        <i class="fa-duotone fa-file-invoice"></i>
                                    </a>
                                    <div class="file-input m-t-20">
                                        <input type="file" name="insurance_path" id="insurance_path"
                                            class="reupload-file-input__input" />
                                        <label class="reupload-file-input__label" for="insurance_path">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path fill="currentColor"
                                                    d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z">
                                                </path>
                                            </svg>
                                            <span>Re-upload Insurance</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="pop-up-button-div box-container box-head  m-b-10 m-t-0">
                                <button type="submit" name="submit" class="button-2 box-shadow"
                                    onclick="popupClose('car-edit')">Update Car</button>
                                <button type="button" class="button-3 box-shadow"
                                    onclick="popupClose('car-edit')">cancel</button>
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
<script src="./Js/daily_report_ajax.js"></script>
<?php
require_once './footer.php';
?>