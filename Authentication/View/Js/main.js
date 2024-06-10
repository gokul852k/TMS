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