// Admin Login Ajax
$(document).ready(function () {
    $('#login').on('submit', function (event) {
        event.preventDefault();
        let username_value = $('#username').val();
        let password_value = $('#password').val();
        if (username_value != "") {
            $('#username').removeClass('input-error');
            $('#username-error').html('');
        } else {
            $('#username').addClass('input-error');
            $('#username-error').html('Username is required');
            return false;
        }

        if (password_value != "") {
            $('#password').removeClass('input-error');
            $('#password-error').html('');
        } else {
            $('#password').addClass('input-error');
            $('#password-error').html('Password is required');
            return false;
        }
        //Check captcha value
        if (validateForm() && username_value != "" && password_value != "") {
            $('#scode').removeClass('input-error');
            var formData = {
                action: 'login',
                username: username_value,
                password: password_value
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/LoginController.php',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.status === 'success') {

                        let userId = response.userId;
                        let token = response.token;
                        let postUrl = response.redirect;

                        let form = document.createElement("form");
                        form.setAttribute("method", "post");
                        form.setAttribute("action", postUrl);

                        let userIdInput = document.createElement("input");
                        userIdInput.setAttribute("type", "hidden");
                        userIdInput.setAttribute("name", "userid");
                        userIdInput.setAttribute("value", userId);
                        form.appendChild(userIdInput);

                        let tokenInput = document.createElement("input");
                        tokenInput.setAttribute("type", "hidden");
                        tokenInput.setAttribute("name", "token");
                        tokenInput.setAttribute("value", token);
                        form.appendChild(tokenInput);
                        
                        document.body.appendChild(form);
                        form.submit();

                    } else if (response.status == 'change password') {
                        window.location.href = response.url;
                    } else if (response.status == 'error') {
                        $('#username').addClass('input-error');
                        $('#password').addClass('input-error');
                        Swal.fire({
                            title: "Error",
                            text: response.message,
                            icon: "error"
                        });
                        refreshCaptcha();
                        document.getElementById('captchavalue').value = "";
                    } else if(response.status === 'warning') {
                        Swal.fire({
                            title: "warning",
                            text: response.message,
                            icon: "error"
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: "Error",
                        text: "Something went wrong! Please try again.",
                        icon: "error"
                    });
                }
            })
        } else {
            $('#scode').addClass('input-error');
        }


    })
})


//User login Ajax
$(document).ready(function () {
    $('#login2').on('submit', function (event) {
        event.preventDefault();
        let username_value = $('#username').val();
        let password_value = $('#password').val();
        if(username_value!="") {
            $('#username').removeClass('input-error');
            $('#username-error').html('');
        }else {
            $('#username').addClass('input-error');
            $('#username-error').html('Username is required');
            return false;
        }

        if(password_value!="") {
            $('#password').removeClass('input-error');
            $('#password-error').html('');
        }else {
            $('#password').addClass('input-error');
            $('#password-error').html('Password is required');
            return false;
        }
        //Check captcha value
        if (username_value!="" && password_value!="") {
            var formData = {
                action: 'login2',
                username: username_value,
                password: password_value
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/LoginController.php',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    // let data = JSON.parse(response);
                    if (response.status === 'success') {
                        // window.location.href = response.redirect;

                        let userId = response.userId;
                        let token = response.token;
                        let postUrl = response.redirect;
                        
                        window.location.href = postUrl;

                    } else if (response.status == 'change password') {
                        window.location.href = response.url;
                    } else if (response.status == 'error') {
                        $('#username').addClass('input-error');
                        $('#password').addClass('input-error');
                        Swal.fire({
                            title: "Error",
                            text: response.message,
                            icon: "error"
                        });
                        refreshCaptcha();
                        document.getElementById('captchavalue').value = "";
                    } else if(response.status === 'warning') {
                        Swal.fire({
                            title: "warning",
                            text: response.message,
                            icon: "error"
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: "Error",
                        text: "Something went wrong! Please try again.",
                        icon: "error"
                    });
                }
            })
        }


    })
});

//Forgot password Ajax
$(document).ready(function () {
    $('#forgot-password').on('submit', function (event) {
        event.preventDefault();
        let mail = $('#mail').val();
        if(mail!="") {
            $('#mail').removeClass('input-error');
            $('#mail-error').html('');
        }else {
            $('#mail').addClass('input-error');
            $('#mail-error').html('Mail is required');
            return false;
        }
        //Check captcha value
        if (mail!="") {
            var formData = {
                action: 'forgotPassword',
                mail: mail
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/PasswordController.php',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    // let data = JSON.parse(response);
                    if (response.status === 'success') {
                        Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else if (response.status == 'error') {
                        $('#mail').addClass('input-error');
                        Swal.fire({
                            title: "Error",
                            text: response.message,
                            icon: "error"
                        });
                        refreshCaptcha();
                        document.getElementById('captchavalue').value = "";
                    } else if(response.status === 'warning') {
                        Swal.fire({
                            title: "warning",
                            text: response.message,
                            icon: "error"
                        });
                    } 
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: "Error",
                        text: "Something went wrong! Please try again.",
                        icon: "error"
                    });
                }
            })
        }
    })
});

//Change new Password

$(document).ready(function () {
    $('#change-password').on('submit', function (event) {
        event.preventDefault();
        let createPassword = $('#create-password').val();
        let confirmPassword = $('#confirm-password').val();
        let token = $('#token').val();
        if (createPassword != "") {
            if(createPassword.length < 5) {
                $('#create-password').addClass('input-error');
                $('#create-error').html('Minimum of 5 characters required.');
                return false;
            }
            $('#create-password').removeClass('input-error');
            $('#create-error').html('');
        } else {
            $('#create-password').addClass('input-error');
            $('#create-error').html('Password is required.');
            return false;
        }

        if (createPassword === confirmPassword) {
            $('#confirm-password').removeClass('input-error');
            $('#confirm-error').html('');
        } else {
            $('#confirm-password').addClass('input-error');
            $('#confirm-error').html('Confirm password does not match.');
            return false;
        }
        //Check captcha value
        if (createPassword != "" && confirmPassword != "" && createPassword === confirmPassword) {
            var formData = {
                action: 'changePassword',
                token: token,
                create_password: createPassword,
                confirm_password: confirmPassword
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/PasswordController.php',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.status == 'success') {
                        Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "Login"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = response.redirectUrl;
                            }
                        });
                    } else {
                        $('#create-password').addClass('input-error');
                        $('#confirm-password').addClass('input-error');
                        Swal.fire({
                            title: "Error",
                            text: response.message,
                            icon: "error"
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: "Error",
                        text: "Something went wrong! Please try again.",
                        icon: "error"
                    });
                }
            })
        }


    })
})