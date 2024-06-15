//Password Show & Hide functionality
$(document).ready(function () {
    $('#password-eye').on('click', function() {
        console.log("clicking");
        // fa-sharp fa-eye-slash
        // fa-eye
        if(document.getElementById('password').type == 'password') {
            $('#password-eye').removeClass('fa-eye');
            $('#password-eye').addClass('fa-sharp fa-eye-slash');
            document.getElementById('password').type = "text";
            console.log("if");
        } else {
            $('#password-eye').removeClass('fa-sharp fa-eye-slash');
            $('#password-eye').addClass('fa-eye');
            document.getElementById('password').type = "Password";
        }
    })
});

//Password Show & Hide functionality
$(document).ready(function () {
    $('#password-eye-1').on('click', function () {
        // fa-sharp fa-eye-slash
        // fa-eye
        if (document.getElementById('create-password').type == 'password') {
            $('#password-eye-1').removeClass('fa-eye');
            $('#password-eye-1').addClass('fa-sharp fa-eye-slash');
            document.getElementById('create-password').type = "text";
        } else {
            $('#password-eye-1').removeClass('fa-sharp fa-eye-slash');
            $('#password-eye-1').addClass('fa-eye');
            document.getElementById('create-password').type = "Password";
        }
    })
    $('#password-eye-2').on('click', function () {
        // fa-sharp fa-eye-slash
        // fa-eye
        if (document.getElementById('confirm-password').type == 'password') {
            $('#password-eye-2').removeClass('fa-eye');
            $('#password-eye-2').addClass('fa-sharp fa-eye-slash');
            document.getElementById('confirm-password').type = "text";
        } else {
            $('#password-eye-2').removeClass('fa-sharp fa-eye-slash');
            $('#password-eye-2').addClass('fa-eye');
            document.getElementById('confirm-password').type = "Password";
        }
    })
});