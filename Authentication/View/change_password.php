<?php
require_once './header.php';
?>

<div class="wrapper wrapper-2">
    <form id="login">
        <div class="heading">
            <h2>New Password</h2>
            <p>Enter your new password.</p>
        </div>

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

<script src="./Js/captcha.js"></script>
<script src="./Js/main.js"></script>
<script src="./Js/ajax.js"></script>
<?php
require_once './footer.php';
?>