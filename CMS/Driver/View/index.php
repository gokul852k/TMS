<?php

session_start();
require_once './header.php';
require_once './navbar.php';
require_once '../Services/DailyReportServices.php';
//Get translations labels
$serviceDR = new DailyReportServices();

$tlabels = $serviceDR->getTranslationsLabels(1);
if (!$tlabels && empty($tlabels)) {
    $tlabels = [
        ["translation" => "Hello"],
        ["translation" => "please provide Ododmeter reading"],
        ["translation" => "KM in Car"],
        ["translation" => "Start Duty"],
        ["translation" => "Note"].
        ["translation" => "You have Started at"],
        ["translation" => "End Duty"],
        ["translation" => "KM"]
    ];
}

?>
<link rel="stylesheet" href="./Style/index.css">

<?php

// This code will decide whether to display "SELECT BUS" or "SELECT TRIP"
$display = $serviceDR->getDisplay();
$data = $display['data'];
// print_r($display);
if($display['display'] == "check_in"){
?>
<div class="duty-container" id="check_in">
    <div class="wrapper center-div">
        <form id="check-in" class="car centered">
            <div class="container box-container w3-animate-bottom">
                <!-- <div class="row img-div">
                    <img src="../../Assets/Developer/image/gas.png" alt="Odometer" class="odometer">
                </div> -->
                <div class="row">
                    <div class="text">
                        <p class="para"><?= $tlabels[0]['translation'] ?><span>
                                <?= $_SESSION['fullName'] ?>
                            </span>, <?= $tlabels[1]['translation'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <input type="text" id="checkin-km" name="checkin_km" class="input-field" placeholder="<?= $tlabels[2]['translation'] ?>"
                        oninput="validateCharInput(this)" required>
                        <span class="error-message" id="username-error"></span>
                    </div>
                    <div class="col-sm-12">
                        <div class="input-group">
                            <button class="button-1" id="submit" name="btn"><?= $tlabels[3]['translation'] ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
}else if($display['display'] == "check_out"){
?>
<div class="duty-out-container" id="check_out">
    <div class="wrapper center-div">
        <form id="check-out" class="car centered-div">
            <div class="container box-container w3-animate-bottom">
                <!-- <div class="row img-div">
                    <img src="../../Assets/Developer/image/speedometer.png" alt="Odometer" class="odometer">
                </div> -->
                <div class="row">
                    <div class="text">
                        <p class="para"><?= $tlabels[0]['translation'] ?> <span>
                                <?= $_SESSION['fullName'] ?>
                            </span>, <?= $tlabels[1]['translation'] ?></p>
                            <p class="para"><?= $tlabels[4]['translation'] ?>: <?= $data['check_in_km'] ?> <?= $tlabels[5]['translation'] ?></p>
                    </div>
                </div>
                <input type="hidden" id="hidden_checkin_km" name="hidden_checkin_km" value="<?= $data['check_in_km'] ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <input type="number" id="checkout-km" name="checkout_km" class="input-field" placeholder="<?= $tlabels[2]['translation'] ?>"
                        oninput="validateCharInput(this)" required>
                        <span class="error-message" id="username-error"></span>
                    </div>
                    <div class="col-sm-12">
                        <div class="input-group">
                            <button class="button-1" id="submit" name="btn"><?= $tlabels[6]['translation'] ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
}else{
?>
<div class="row">
    <div class="text">
        <p class="para">Hello, <span>
                <?= $_SESSION['fullName'] ?>
            </span>, please provide the odometer reading.</p>
    </div>
</div>
<?php
echo $display['display'];
}
?>

<script src="../../../Common/Common file/common_function.js"></script>
<script src="./Js/daily_report.js"></script>
<script src="./Js/daily_report_ajax.js"></script>


<?php
require_once './footer.php';
?>