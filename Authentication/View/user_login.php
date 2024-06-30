<?php
require_once './header.php';
require_once '../Services/LoginService.php';

$LoginServices = new LoginService();
$response1 = $LoginServices->checkLoginUser2();
if ($response1['status'] === 'logged in') {
    $redirectUrl = $response1['url'];
    header('Location: ' . $redirectUrl);
    exit;
}
?>

<div class="wrapper wrapper-2">
    <div class="logo-card">
        <img src="../Assets/Developer/Svg/logo.svg" alt="logo" class="logo-left user-logo-left">
        <span class="logo-right user-logo-right">stronu<span>X</span></span>
    </div>
    <form id="login2">
        <div class="heading">
            <h2>Welcome!</h2>
            <p>Sign In to your account</p>
        </div>

        <div class="input-group">
            <input type="text" id="username" class="input-field" placeholder="Username">
            <span class="error-message" id="username-error"></span>
        </div>

        <div class="input-group">
            <div class="password-div">
                <input type="password" id="password" class="input-field" placeholder="Password">
                <i class="fa-regular fa-eye" id="password-eye"></i>
            </div>
            <span class="error-message" id="password-error"></span>
        </div>


        <div class="input-group row">

            <div class="row">
                <a href="./forgot_password.php">Forgot password?</a>
            </div>
        </div>


        <div class="input-group">
            <button class="button-1">Login</button>
        </div>
    </form>
</div>

<script src="./Js/main.js"></script>
<script src="./Js/ajax.js"></script>

<?php
require_once './footer.php';
?>