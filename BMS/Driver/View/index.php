<?php
session_start();
// print_r($_SESSION);
require_once './header.php';
require_once './navbar.php';
require_once '../Services/DailyReportService.php';
//Get translations labels
$serviceDR = new DailyReportService();

$tlabels = $serviceDR->getTranslationsLabels(1);
if (!$tlabels && empty($tlabels)) {
    $tlabels = [
                ["translation"=>"Bus Duty"],
                ["translation"=>"Hello"],
                ["translation"=>"Please select bus"],
                ["translation"=>"Start Work"]
               ];
}

//select bus
$buses = $serviceDR->getBuses();
?>
<div class="wrapper center-div">
    <form id="select-bus" class="car centered p-10">
        <div class="container box-container w3-animate-bottom">
                <h5 class="heading center"><?=$tlabels[0]['translation']?></h5>
 
                <p class="para"><?=$tlabels[1]['translation']?>, <span>
                        <?= $_SESSION['userName'] ?>
                    </span>, <?=$tlabels[2]['translation']?>.</p>
            <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet"
                href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />

            <div class="row selectpicker-row">
                <div class="col-sm-12">
                    <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true" name="bus-id">
                        <option value="af">TN50H49504</option>
                        <?php
                        foreach ($buses as $bus) {
                            ?>
                            <option value="<?=$bus['id']?>"><?=$bus['bus_number']?></option>
                            <?php
                        }
                        ?>
                        <!-- <option data-subtext="Rep California">Tom Foolery</option>
                        <option data-subtext="Sen California">Bill Gordon</option>
                        <option data-subtext="Sen Massacusetts">Elizabeth Warren</option>
                        <option data-subtext="Rep Alabama">Mario Flores</option>
                        <option data-subtext="Rep Alaska">Don Young</option>
                        <option data-subtext="Rep California" disabled="disabled">Marvin Martinez</option>
                        <option data-subtext="Rep California">Tom Foolery</option>
                        <option data-subtext="Sen California">Bill Gordon</option>
                        <option data-subtext="Sen Massacusetts">Elizabeth Warren</option>
                        <option data-subtext="Rep Alabama">Mario Flores</option>
                        <option data-subtext="Rep Alaska">Don Young</option>
                        <option data-subtext="Rep California" disabled="disabled">Marvin Martinez</option>
                        <option data-subtext="Rep California">Tom Foolery</option>
                        <option data-subtext="Sen California">Bill Gordon</option>
                        <option data-subtext="Sen Massacusetts">Elizabeth Warren</option>
                        <option data-subtext="Rep Alabama">Mario Flores</option>
                        <option data-subtext="Rep Alaska">Don Young</option>
                        <option data-subtext="Rep California" disabled="disabled">Marvin Martinez</option> -->
                    </select>
                </div>
            </div>

            <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
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
require_once './footer.php';
?>