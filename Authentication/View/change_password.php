<?php
require_once './header.php';
require_once '../Services/PasswordService.php';

if(!isset($_GET['token'])) {
    ?>
    <p>Invalid request!</p>
    <?php
    exit;
}
?>

<?php
$password = new PasswordService();
$response1 = $password->checkPasswordChange($_GET['token']);

if ($response1['status'] == 'success') {
    ?>

    <div class="wrapper wrapper-2">
        <form id="change-password">
            <div class="heading">
                <h2>New Password</h2>
                <p>Enter your new password.</p>
            </div>

            <input type="hidden" name="token" id="token" value="<?=$_GET['token']?>">

            <div class="input-group">
                <div class="password-div">
                    <input type="password" id="create-password" class="input-field" placeholder="Create New Password">
                    <i class="fa-regular fa-eye" id="password-eye-1"></i>
                </div>
                <span class="error-message" id="create-error"></span>
            </div>

            <div class="input-group">
                <div class="password-div">
                    <input type="password" id="confirm-password" class="input-field" placeholder="Confirm Your Password">
                    <i class="fa-regular fa-eye" id="password-eye-2"></i>
                </div>
                <span class="error-message" id="confirm-error"></span>
            </div>


            <div class="input-group">
                <button class="button-1">Change</button>
            </div>
        </form>
    </div>
    <?php
} else {
    ?>
    <div class=".time-limit-exit-div">
        <img class="time-limit-exit-img" src="../Assets/Developer/Svg/time-limit-exit.svg" alt="Time Limit Exit">
        <p class="time-limit-exit-text">Time limit exceeded. Please request a password change.</p>
    </div>
    <?php
}
?>

<script src="./Js/captcha.js"></script>
<script src="./Js/main.js"></script>
<script src="./Js/ajax.js"></script>
<?php
require_once './footer.php';
?>