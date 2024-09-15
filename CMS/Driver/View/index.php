<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();
// print_r($_SESSION);
require_once './header.php';
require_once './navbar.php';
// require_once '../../../Common/Common file/search_select_cdn.php';
require_once '../Services/DailyReportServices.php';
//Get translations labels
$serviceDR = new DailyReportServices();

// $tlabels = $serviceDR->getTranslationsLabels(1);
// if (!$tlabels && empty($tlabels)) {
//     $tlabels = [
//         ["translation" => "Bus Duty"],
//         ["translation" => "Hello"],
//         ["translation" => "Please select bus"],
//         ["translation" => "Start Work"],
//         ["translation" => "Select bus"]
//     ];
// }

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
                <div class="row img-div">
                    <img src="../../Assets/Developer/image/gas.png" alt="Odometer" class="odometer">
                </div>
                <div class="row">
                    <div class="text">
                        <p class="para">Hello <span>
                                <?= $_SESSION['fullName'] ?>
                            </span>, please provide the Odometer reading.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <input type="text" id="checkin-km" name="checkin_km" class="input-field" placeholder="KM in Car"
                        oninput="validateCharInput(this)" required>
                        <span class="error-message" id="username-error"></span>
                    </div>
                    <div class="col-sm-12">
                        <div class="input-group">
                            <button class="button-1" id="submit" name="btn">Start Duty</button>
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
                <div class="row img-div">
                    <img src="../../Assets/Developer/image/speedometer.png" alt="Odometer" class="odometer">
                </div>
                <div class="row">
                    <div class="text">
                        <p class="para">Hello, <span>
                                <?= $_SESSION['fullName'] ?>
                            </span>, please provide the odometer reading.</p>
                            <p class="para">Note: You have Started with <?= $data['check_in_km'] ?> KM </p>
                    </div>
                </div>Kf
                <input type="hidden" id="hidden_checkin_km" name="hidden_checkin_km" value="<?= $data['check_in_km'] ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <input type="number" id="checkout-km" name="checkout_km" class="input-field" placeholder="KM in Car"
                        oninput="validateCharInput(this)" required>
                        <span class="error-message" id="username-error"></span>
                    </div>
                    <div class="col-sm-12">
                        <div class="input-group">
                            <button class="button-1" id="submit" name="btn">End Duty</button>
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
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla quod officiis culpa saepe velit animi vero molestias voluptates minima, quaerat fuga laboriosam, fugit iure eum. Minima vel nisi odio, nulla a omnis iusto fugit magni et nihil quod pariatur sed inventore tempore quae illo impedit consequuntur dicta sit! Aliquid quisquam at vel sit cum consequatur minus alias tempora dolorum excepturi pariatur blanditiis reprehenderit ipsa unde dolor repellat, voluptatum inventore amet aliquam quae. Tempora delectus nihil voluptatum autem minus quos quasi veritatis placeat minima, ex numquam quae a amet cumque eum pariatur perferendis ea atque maiores doloribus recusandae, voluptates impedit fugiat.</p>

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