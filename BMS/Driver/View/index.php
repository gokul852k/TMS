<?php
session_start();
// print_r($_SESSION);
require_once './header.php';
require_once './navbar.php';
require_once '../../../Common/Common file/search_select_cdn.php';
require_once '../Services/DailyReportService.php';
//Get translations labels
$serviceDR = new DailyReportService();

$tlabels = $serviceDR->getTranslationsLabels(1);
if (!$tlabels && empty($tlabels)) {
    $tlabels = [
        ["translation" => "Bus Duty"],
        ["translation" => "Hello"],
        ["translation" => "Please select bus"],
        ["translation" => "Start Work"],
        ["translation" => "Select bus"]
    ];
}

?>
    <link rel="stylesheet" href="./Style/driver.css">
    <div class="duty-container">
        <div class="duty-row">
        <div class="duty-button active-duty-button" onclick="endDuty()">
            <div>
                <span>END DUTY</span>
            </div>
            <div>
                <div class="radius-btn active-radius-btn">
                    <span class="rount-btn active-rount-btn"></span>
                </div>
            </div>
        </div>
        </div>
    </div>
<?php

// This code will decide whether to display "SELECT BUS" or "SELECT TRIP"
$display = $serviceDR->getDisplay();
if ($display['display'] == "SELECT BUS") {
    //Display the SELECT BUS
    //Select bus
    $buses = $serviceDR->getBuses();
    ?>
    <script>
        document.getElementsByClassName("duty-container")[0].style.display = "none";
    </script>
    <div class="duty-container-2">
        <div class="duty-row">
        <div class="duty-button" onclick="startDuty()">
            <div>
                <span class="duty-text">START DUTY</span>
            </div>
            <div>
                <div class="radius-btn">
                    <span class="rount-btn"></span>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="wrapper center-div select-bus-container w3-animate-bottom">
        <form id="select-bus" class="car centered p-10">
            <div class="container box-container">
                <h5 class="heading center"><?= $tlabels[0]['translation'] ?></h5>

                <p class="para"><?= $tlabels[1]['translation'] ?>, <span>
                        <?= $_SESSION['userName'] ?>
                    </span>, <?= $tlabels[2]['translation'] ?>.</p>

                <div class="row selectpicker-row">
                    <div class="col-sm-12">
                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                            name="bus-id" id="bus-id">
                            <option value=""><?= $tlabels[4]['translation'] ?></option>
                            <?php
                            foreach ($buses as $bus) {
                                ?>
                                <option value="<?= $bus['id'] ?>"><?= $bus['bus_number'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-12">
                        <div class="input-group button-center">
                            <button class="button-2" id="submit" name="btn"><?= $tlabels[3]['translation'] ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
} else if ($display['display'] == "SELECT TRIP") {
    //Display the SELECT TRIP
    $displayTrip = $serviceDR->getDisplayTrip();
    if ($displayTrip['display'] == 'TRIP START') {
        //select route
        $routes = $serviceDR->getRoutes();
        ?>
            <div class="wrapper center-div">
                <form id="start-trip" class="car centered p-10">
                    <div class="container box-container w3-animate-bottom">
                        <h5 class="heading center"><?= $tlabels[5]['translation'] ?></h5>

                        <div class="row selectpicker-row">
                            <div class="col-sm-12">
                                <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                                    name="start-route" id="start-route">
                                    <option value=""><?= $tlabels[6]['translation'] ?></option>
                                    <?php
                                    foreach ($routes as $route) {
                                        ?>
                                        <option value="<?= $route['routeId'] ?>"><?= $route['routeName'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="error-message p-r-l-15" id="start-route-error"></span>
                            </div>
                        </div>

                        <div class="row selectpicker-row">
                            <div class="col-sm-12">
                                <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                                    name="end-route" id="end-route">
                                    <option value=""><?= $tlabels[7]['translation'] ?></option>
                                    <?php
                                    foreach ($routes as $route) {
                                        ?>
                                        <option value="<?= $route['routeId'] ?>"><?= $route['routeName'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="error-message p-r-l-15" id="end-route-error"></span>
                            </div>
                        </div>

                        <div class="row selectpicker-row">
                            <div class="col-sm-12">
                                <input type="number" class="input-field" name="start-km" id="start-km"
                                    placeholder="<?= $tlabels[8]['translation'] ?>">
                                <span class="error-message p-r-l-15" id="start-km-error"></span>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-sm-12">
                                <div class="input-group button-center">
                                    <button class="button-2" id="submit" name="btn"><?= $tlabels[9]['translation'] ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <?php
    } else if ($displayTrip['display'] == 'TRIP END') {

        $displayStartTrip = $serviceDR->getDisplayStartTrip($displayTrip['tripId']);

        if ($displayStartTrip['status'] == 'success') {
            $tripDetails = $serviceDR->getTripDetails($displayTrip['tripId']);
            ?>
                    <div class="wrapper center-div">
                        <form id="start-trip-2" class="car centered p-10">
                            <div class="container box-container w3-animate-bottom">
                                <h5 class="heading center"><?= $tlabels[5]['translation'] ?></h5>
                                <input type="hidden" name="trip-id-2" value="<?= $displayTrip['tripId'] ?>" />
                                <div class="row selectpicker-row">
                                    <div class="col-sm-12">
                                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                                            name="start-route" id="start-route" disabled>
                                            <option value="<?= $tripDetails['data']['startRouteId'] ?>">
                                        <?= $tripDetails['data']['startRouteName'] ?>
                                            </option>
                                        </select>
                                        <span class="error-message p-r-l-15" id="start-route-error"></span>
                                    </div>
                                </div>

                                <div class="row selectpicker-row">
                                    <div class="col-sm-12">
                                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                                            name="end-route" id="end-route" disabled>
                                            <option value="<?= $tripDetails['data']['endRouteId'] ?>">
                                        <?= $tripDetails['data']['endRouteName'] ?>
                                            </option>
                                        </select>
                                        <span class="error-message p-r-l-15" id="end-route-error"></span>
                                    </div>
                                </div>

                                <div class="row selectpicker-row">
                                    <div class="col-sm-12">
                                        <input type="number" class="input-field" name="start-km" id="start-km-2"
                                            placeholder="<?= $tlabels[8]['translation'] ?>">
                                        <span class="error-message p-r-l-15" id="start-km-2-error"></span>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="input-group button-center">
                                            <button class="button-2" id="submit" name="btn"><?= $tlabels[9]['translation'] ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
            <?php
        } else {

            $tripDetails = $serviceDR->getTripDetails($displayTrip['tripId']);
            ?>
                    <div class="wrapper center-div">
                        <form id="end-trip" class="car centered p-10">
                            <div class="container box-container w3-animate-bottom">
                                <h5 class="heading center"><?= $tlabels[10]['translation'] ?></h5>
                                <input type="hidden" name="trip-id" value="<?= $displayTrip['tripId'] ?>" />
                                <input type="hidden" name="trip-driver-id" value="<?= $displayTrip['tripDriverId'] ?>" />
                                <div class="row selectpicker-row">
                                    <div class="col-sm-12">
                                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                                            name="start-route" disabled>
                                            <option value="<?= $tripDetails['data']['startRouteId'] ?>">
                                        <?= $tripDetails['data']['startRouteName'] ?>
                                            </option>
                                        </select>
                                        <span class="error-message p-r-l-15" id="start-route-error"></span>
                                    </div>
                                </div>

                                <div class="row selectpicker-row">
                                    <div class="col-sm-12">
                                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                                            name="end-route" disabled>
                                            <option value="<?= $tripDetails['data']['endRouteId'] ?>">
                                        <?= $tripDetails['data']['endRouteName'] ?>
                                            </option>
                                        </select>
                                        <span class="error-message p-r-l-15" id="end-route-error"></span>
                                    </div>
                                </div>

                                <div class="row selectpicker-row">
                                    <div class="col-sm-12">
                                        <input type="number" class="input-field" name="end-km" id="end-km"
                                            placeholder="<?= $tlabels[12]['translation'] ?>">
                                        <span class="error-message p-r-l-15" id="end-km-error"></span>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="input-group button-center">
                                            <button class="button-2" id="submit" name="btn"><?= $tlabels[11]['translation'] ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
            <?php
        }
    }
} else {

}
?>
<script src="./js/daily_report_ajax.js"></script>
<?php
require_once './footer.php';
?>