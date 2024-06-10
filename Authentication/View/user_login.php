<?php
require_once './header.php';
?>

<div class="wrapper">
    <form id="login">
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
                <a href="#">Forgot password?</a>
            </div>
        </div>


        <div class="input-group">
            <button class="button-1">Login</button>
        </div>
    </form>
</div>

<?php
require_once './footer.php';
?>