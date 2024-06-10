<?php
require_once './header.php';
?>

<div class="wrapper">
    <form id="login">
        <div class="logo-card">
            <img src="../Assets/Developer/Svg/logo-3.svg" alt="logo" class="logo-left">
            <span class="logo-right">stronu<span>X</span></span>
        </div>
        <div class="login-card">
            <div class="login-left">
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
                <div class="input-group">
                    <input type="text" class="input-field" name='scode' maxlength="5" id="scode"
                        placeholder="Security Code">
                    <span class="error-message" id="code-error"></span>
                </div>
                <div class="input-group captcha-div">
                    <div>
                        <div id="captcha" style="width:150px"></div>
                        <input type="hidden" name="captchavalue" class="input-field" id="captchavalue">
                    </div>
                    <div>
                        <a onclick="refreshCaptcha()" class="captcha-refersh">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                    </div>
                </div>

                <div class="input-group row">

                    <div class="row">
                        <a href="#">Forgot password?</a>
                    </div>
                </div>


                <div class="input-group">
                    <button class="button-1">Login</button>
                </div>
            </div>
            <div class="login-right">
                <img src="../Assets/Developer/Svg/system.svg" alt="TMS" class="system">
            </div>
        </div>
    </form>
</div>


<script src="./Js/captcha.js"></script>
<script src="./Js/main.js"></script>
<script src="./Js/ajax.js"></script>
<?php
require_once './footer.php';
?>