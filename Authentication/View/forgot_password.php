<?php
require_once './header.php';
?>

<div class="wrapper wrapper-2">
    <form id="forgot-password">
        <div class="heading">
            <h2>Forgot Password</h2>
            <p>Enter your email address. We will send you the password change link.</p>
        </div>

        <div class="input-group">
            <div class="password-div">
                <input type="mail" id="mail" class="input-field" placeholder="Mail id">
            </div>
            <span class="error-message" id="mail-error"></span>
        </div>

        <div class="input-group">
            <input type="text" class="input-field" name='scode' maxlength="5" id="scode" placeholder="Security Code">
            <span class="error-message" id="code-error"></span>
        </div>

        <div class="input-group captcha-div m-b-15">
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


        <div class="input-group">
            <button class="button-1">Send</button>
        </div>
    </form>
</div>

<script src="./Js/captcha.js"></script>
<script src="./Js/main.js"></script>
<script src="./Js/ajax.js"></script>
<?php
require_once './footer.php';
?>