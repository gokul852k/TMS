<?php

require_once '../config.php';
require_once '../Models/PasswordModel.php';
require_once '../../Common/Services/Mail2.php';

class PasswordService {

    private $model;
    private $mail;
    public function __construct() {
        global $conn;
        $this->model = new PasswordModel($conn);
        $this->mail = new Mail2();
    }

    public function forgotPassword($mailId) {
        //Check if the mail ID is excit.
        $response1 = $this->model->getMailId($mailId);

        if(!$response1) {
            return [
                'status' => 'error',
                'message' => 'Mail does not exist'
            ];
        }

        $userId = $response1['id'];

        $token = $this->generateToken($mailId);

        //Insert the token in password_change table

        $response2 = $this->model->setChangePassword($userId, 1, $token);

        if($response2['status'] != 'success') {
            return $response2;
        }

        //Send mail to the user
        $subject = "Reset Your Password on AstronuX";
        $body = $this->mailBody($token);
        $response3 = $this->mail->sendMail($mailId, $subject, $body);

        if($response3['status'] == 'error') {
            return $response3;
        }

        return [
            "status" => "success",
            "message" => "A password reset link has been sent to your email address"
        ];
    }

    public function forcePasswordChange($userId) {
        $token = $this->generateToken($userId);

        //Insert the token in password_change table

        $response2 = $this->model->setChangePassword($userId, 3, $token);

        if($response2['status'] != 'success') {
            return null;
        }

        //Redirect the user to password change page with token
        $redirectUrl = './change_password.php?token='.$token;
        
        return [
            'status' => 'success',
            'url' => $redirectUrl
        ];

    }

    public function checkPasswordChange($token) {
        $response = $this->model->getPasswordChange($token);

        if(!$response) {
            return [
                'status' => 'error',
                'message' => 'Time limit reached. To change your password, please begin the process again'
            ];
        }
        return [
            'status' => 'success',
            'message' => 'Now you can change the password'
        ];
    }

    public function changePassword($token, $createPassword, $confirmPassword) {

        //Check create password and confirm password are equal
        if($createPassword != $confirmPassword) {
            return [
                'status' => 'error',
                'message' => 'Confirm password does not match'
            ];
        }

        //Check password change time limit is exit or not.
        $response1 = $this->model->getPasswordChange($_POST['token']);

        if (!$response1) {
            return $response1;
        }

        //Store new password
        $hashPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);

        $response2 = $this->model->updatePassword($response1['user_id'], $hashPassword);

        if (!$response2) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong! Please try again.',
                'error' => 'Error while update password'
            ]; 
        }

        $this->model->updateChangePasswordStatus($token);

        if ($response1['change_type_id'] == 3) {
            $this->model->updateForcePasswordChange($response1['user_id']);
        }

        $response3 = $this->model->getUserRole($response1['user_id']);

        $redirectUrl = '../View/user_login.php';
        if($response3) {
            if($response3['role_id'] == 2) {
                $redirectUrl = '../View/admin_login.php';
            }
        }

        return [
            'status' => 'success',
            'message' => 'Password changed successfully. Please log in again.',
            'redirectUrl' => $redirectUrl
        ];
    }

    public function generateToken($userid)
    {
        $randomBytes = bin2hex(random_bytes(16)); // Generates a 32-character random string
        $timestamp = time(); // Current timestamp
        $token = hash('sha256', $userid . $randomBytes . $timestamp); // Combines all to generate a token
        return $token;
    }

    public function mailBody($token) {
        return '
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">

            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <meta name="x-apple-disable-message-reformatting" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <meta name="color-scheme" content="light dark" />
                <meta name="supported-color-schemes" content="light dark" />
                <title></title>
                <style>
                    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");
                </style>
                <!--[if mso]>
                <style type="text/css">
                .f-fallback  {
                    font-family: Arial, sans-serif;
                }
                </style>
            <![endif]-->
            </head>

            <body style="width: 100% !important; height: 100%; margin: 0; -webkit-text-size-adjust: none; background-color: #f9f3ea; color: #51545E; font-family: Poppins, sans-serif;">
                <span class="preheader" style="display: none !important; visibility: hidden; mso-hide: all; font-size: 1px; line-height: 1px; max-height: 0; max-width: 0; opacity: 0; overflow: hidden;">Use this link to reset your password. The link is only valid for 24 hours.</span>
                <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; margin: 0; padding: 0; background-color: #f9f3ea;">
                    <tr>
                        <td align="center">
                            <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; margin: 0; padding: 0;">
                                <tr>
                                    <td class="email-masthead" style="padding: 25px 0; text-align: center;">
                                        <a href="https://example.com" class="f-fallback email-masthead_name" style="font-size: 16px; font-weight: bold; color: #A8AAAF; text-decoration: none; text-shadow: 0 1px 0 white;">
                                            <div class="logo-card" style="display: flex; align-items: flex-start; justify-content: center; font-family: Poppins, sans-serif;">
                                                <img src="https://colte.mylsc.in/images/logo-3.svg" alt="logo" class="logo-left" style="width: 60px;">
                                                <span class="logo-right" style="color: black; font-size: 50px; font-weight: bold; position: relative; top: 3px;">stronu<span style="color: #ff9900;">X</span></span>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="email-body" width="570" cellpadding="0" cellspacing="0" style="width: 100%; margin: 0; padding: 0;">
                                        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="width: 700px; margin: 0 auto; padding: 0; background-color: #FFFFFF;">
                                            <tr>
                                                <td class="content-cell">
                                                    <div class="fp-svg" style="text-align: center;">
                                                        <img src="https://colte.mylsc.in/images/forgot-password.svg" alt="" style="width: 100%;">
                                                    </div>
                                                    <div class="f-fallback p-div" style="padding: 10px 60px 60px 60px;">
                                                        <h1 style="color: #ff9900 !important; text-align: center; margin-top: 0; font-size: 22px; font-weight: bold;">Forgot your password?</h1>
                                                        <p style="margin: .4em 0 1.1875em; font-size: 16px; line-height: 1.625; color: #c38426;">You recently requested to reset your password for your [Product Name] account. Use the button below to reset it. <strong>This password reset is only valid for the next 10 Minutes.</strong></p>
                                                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; margin: 30px auto; padding: 0; text-align: center;">
                                                            <tr>
                                                                <td align="center">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                                        <tr>
                                                                            <td align="center">
                                                                                <a href="http://localhost/TMS/Authentication/View/change_password.php?token='.$token.'" class="f-fallback button button--green" target="_blank" style="background-color: #ff9900; border-top: 10px solid #ff9900; border-right: 18px solid #ff9900; border-bottom: 10px solid #ff9900; border-left: 18px solid #ff9900; display: inline-block; color: #FFF; text-decoration: none; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); box-sizing: border-box;">Reset your password</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <p style="margin: .4em 0 1.1875em; font-size: 16px; line-height: 1.625; color: #c38426;">If you did not request a password reset, please ignore this email or <a href="{{support_url}}" style="color: #3869D4;">contact support</a> if you have questions.</p>
                                                        <p style="margin: .4em 0 1.1875em; font-size: 16px; line-height: 1.625; color: #c38426;">Thanks,<br>The AstronuX team</p>
                                                        <table class="body-sub" role="presentation" style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #EAEAEC;">
                                                            <tr>
                                                                <td>
                                                                    <p class="f-fallback sub" style="margin: .4em 0 1.1875em; font-size: 13px; line-height: 1.625; color: #c38426;">If you’re having trouble with the button above, copy and paste the URL below into your web browser.</p>
                                                                    <p class="f-fallback sub" style="margin: .4em 0 1.1875em; font-size: 13px; line-height: 1.625; color: #c38426;">http://localhost/TMS/Authentication/View/change_password.php?token='.$token.'</p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="width: 570px; margin: 0 auto; padding: 0; text-align: center;">
                                            <tr>
                                                <td class="content-cell" align="center" style="padding: 45px;">
                                                    <p class="f-fallback sub align-center" style="margin: .4em 0 1.1875em; font-size: 13px; line-height: 1.625; color: #A8AAAF;">[AstronuX]<br>6, 22nd St, Ashok Nagar<br>Chennai</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>

            </html>

        ';
    }

}