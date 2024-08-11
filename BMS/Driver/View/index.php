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
                ["translation"=>"Bus Duty"],
                ["translation"=>"Hello"],
                ["translation"=>"Please select bus"],
                ["translation"=>"Start Work"],
                ["translation"=>"Select bus"]
               ];
}

// This code will decide whether to display "SELECT BUS" or "SELECT TRIP"
$display = $serviceDR->getDisplay();
if ($display['display'] == "SELECT BUS") {
    //Display the SELECT BUS
    //Select bus
    $buses = $serviceDR->getBuses();
    ?>
    <div class="wrapper center-div">
        <form id="select-bus" class="car centered p-10">
            <div class="container box-container w3-animate-bottom">
                    <h5 class="heading center"><?=$tlabels[0]['translation']?></h5>
    
                    <p class="para"><?=$tlabels[1]['translation']?>, <span>
                            <?= $_SESSION['userName'] ?>
                        </span>, <?=$tlabels[2]['translation']?>.</p>

                <div class="row selectpicker-row">
                    <div class="col-sm-12">
                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true" name="bus-id" id="bus-id">
                            <option value=""><?=$tlabels[4]['translation']?></option>
                            <?php
                            foreach ($buses as $bus) {
                                ?>
                                <option value="<?=$bus['id']?>"><?=$bus['bus_number']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-12">
                        <div class="input-group button-center">
                            <button class="button-2" id="submit" name="btn"><?=$tlabels[3]['translation']?></button>
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
    //select route
    $routes = $serviceDR->getRoutes();
    if (false) {
    ?>
    <div class="wrapper center-div">
        <form id="select-trip" class="car centered p-10">
            <div class="container box-container w3-animate-bottom">
                    <h5 class="heading center"><?=$tlabels[5]['translation']?></h5>

                <div class="row selectpicker-row">
                    <div class="col-sm-12">
                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true" name="start-route" id="start-route">
                            <option value=""><?=$tlabels[6]['translation']?></option>
                            <?php
                            foreach ($routes as $route) {
                                ?>
                                <option value="<?=$route['routeId']?>"><?=$route['routeName']?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="error-message p-r-l-15" id="start-route-error"></span>
                    </div>
                </div>

                <div class="row selectpicker-row">
                    <div class="col-sm-12">
                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true" name="end-route" id="end-route">
                            <option value=""><?=$tlabels[7]['translation']?></option>
                            <?php
                            foreach ($routes as $route) {
                                ?>
                                <option value="<?=$route['routeId']?>"><?=$route['routeName']?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="error-message p-r-l-15" id="end-route-error"></span>
                    </div>
                </div>

                <div class="row selectpicker-row">
                    <div class="col-sm-12">
                        <input type="number" class="input-field" name="start-km" id="start-km" placeholder="<?=$tlabels[8]['translation']?>">
                        <span class="error-message p-r-l-15" id="start-km-error"></span>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-12">
                        <div class="input-group button-center">
                            <button class="button-2" id="submit" name="btn"><?=$tlabels[9]['translation']?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
    }

    if (true) {
    ?>
    <div class="wrapper center-div">
        <form id="select-trip" class="car centered p-10">
            <div class="container box-container w3-animate-bottom">
                    <h5 class="heading center"><?=$tlabels[5]['translation']?></h5>

                <div class="row selectpicker-row">
                    <div class="col-sm-12">
                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true" name="start-route" id="start-route">
                            <option value=""><?=$tlabels[6]['translation']?></option>
                            <?php
                            foreach ($routes as $route) {
                                ?>
                                <option value="<?=$route['routeId']?>"><?=$route['routeName']?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="error-message p-r-l-15" id="start-route-error"></span>
                    </div>
                </div>

                <div class="row selectpicker-row">
                    <div class="col-sm-12">
                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true" name="end-route" id="end-route">
                            <option value=""><?=$tlabels[7]['translation']?></option>
                            <?php
                            foreach ($routes as $route) {
                                ?>
                                <option value="<?=$route['routeId']?>"><?=$route['routeName']?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="error-message p-r-l-15" id="end-route-error"></span>
                    </div>
                </div>

                <div class="row selectpicker-row">
                    <div class="col-sm-12">
                        <input type="number" class="input-field" name="start-km" id="start-km" placeholder="<?=$tlabels[8]['translation']?>">
                        <span class="error-message p-r-l-15" id="start-km-error"></span>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-12">
                        <div class="input-group button-center">
                            <button class="button-2" id="submit" name="btn"><?=$tlabels[9]['translation']?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
    }
} else {

}
?>
<script src="./js/daily_report_ajax.js"></script>
<?php
require_once './footer.php';
?>