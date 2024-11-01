<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// print_r($_SESSION);
require_once './header.php';
require_once './navbar.php';
require_once '../../../Common/Common file/search_select_cdn.php';
require_once '../Services/DailyReportServices.php';
require_once '../Services/MaintenanceReportService.php';
//Get translations labels
$serviceDR = new DailyReportServices();
$serviceMR = new MaintenanceReportService();

$tlabels = $serviceDR->getTranslationsLabels(3);
if (!$tlabels && empty($tlabels)) {
    $tlabels = [
        ["translation" => "Maintenance Report"],            // 0
        ["translation" => "Car No"],                        // 1
        ["translation" => "Select Car"],                    // 2
        ["translation" => "Date"],                          // 3
        ["translation" => "Add Changed Spare Parts"],       // 4
        ["translation" => "Spare Parts"],                   // 5
        ["translation" => "Quantity"],                      // 6
        ["translation" => "Price"],                         // 7
        ["translation" => "Select Spare"],                  // 8
        ["translation" => "Service Charge"],                // 9
        ["translation" => "Total Charges"],                 // 10
        ["translation" => "Upload Bill"],                   // 11
        ["translation" => "Submit"]                         // 12
    ];
}


?>
<link rel="stylesheet" href="./Style/index.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">

<?php
//Select bus
// $buses = $serviceDR->getBuses();
$carsValue = $serviceMR->getCars();
$cars = $carsValue['data'];
?>
<div class="wrapper m-t-40">
    <form id="add-maintenance-report" class="car centered p-10" enctype="multipart/form-data">
        <div class="container box-container w3-animate-bottom">
            <h5 class="heading center"><?= $tlabels[0]['translation'] ?></h5>

            <div class="row">
                <div class="col-sm-4">
                    <label for="car-no" class="input-label"><?= $tlabels[1]['translation'] ?></label>
                    <select class="input-field" name="car-id" id="car-no" required>
                        <option value=""><?= $tlabels[2]['translation'] ?></option>
                        <!-- <option value="1">TN30CC4386</option> -->

                        <?php
                            foreach ($cars as $car) {
                                ?>
                                    <option value="<?php echo $car['id']; ?>"><?php echo $car['car_number']; ?></option>
                                <?php
                            }
                        ?>

                    </select>
                </div>

                <div class="col-sm-4">
                    <label for="date" class="input-label"><?= $tlabels[3]['translation'] ?></label>
                    <input type="date" class="input-field" name="date" id="date" required />
                </div>
            </div>

            <div class="bms-shift-header">
                <p class="bms-shift-title"><?= $tlabels[4]['translation'] ?></p>
                <button type="button" class="add-button" id="add-spare-part" title="Add Spare Part">
                    <i class="fa-solid fa-circle-plus"></i>
                </button>
            </div>

            <!-- <div class="bms-shift-container"> -->
            <div class="row">
                <div class="cms-spares" id="cms-spares">
                    <div class="bms-shift" id="bms-shift">
                        <!-- Dynamically added spare parts will go here -->
                    </div>
                </div>

                <div>
                    <div class="row p-20">
                        <div class="col-sm-4">
                            <label for="service_charge" class="input-label"><?= $tlabels[9]['translation'] ?></label>
                            <input type="number" class="input-field" name="service_charge" placeholder="" required />
                        </div>

                        <div class="col-sm-4">
                            <label for="total_chargers" class="input-label"><?= $tlabels[10]['translation'] ?></label>
                            <input type="number" class="input-field" name="total_chargers" placeholder="" required />
                        </div>

                        <div class="col-sm-4">
                            <label for="upload_bill" class="input-label"><?= $tlabels[11]['translation'] ?></label>
                            <div class="file-input m-t-5">
                                <input type="file" name="upload_bill" id="upload_bill"
                                    class="reupload-file-input__input" onchange="updateFileName()" required />
                                <label class="reupload-file-input__label" for="upload_bill" id="file-label">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="upload"
                                        class="svg-inline--fa fa-upload fa-w-16" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor"
                                            d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z">
                                        </path>
                                    </svg>
                                    <span id="file-name"><b><?= $tlabels[11]['translation'] ?></b></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="admin-modal-footer">
                <button type="submit" class="button-3"><?= $tlabels[12]['translation'] ?></button>
            </div>

        </div>
    </form>
</div>

<!-- Progress loader -->
<div class="tms-pop-up" id="progress-loader">
    <div class="pop-up-bg"></div>
    <div class="progress-loader">
        <div class="loader"></div>
        <p class="progress-text" id="progress-text">Loading, please wait..</p>
    </div>
</div>

<script src="../../../Common/Common file/common_function.js"></script>
<script src="./Js/maintenance.js"></script>
<script src="./Js/maintenance_ajax.js"></script>


<?php
require_once './footer.php';
?>