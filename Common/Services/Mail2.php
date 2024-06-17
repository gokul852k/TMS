<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require '../External/PHPMailer2/src/Exception.php';
// require '../External/PHPMailer2/src/PHPMailer.php';
// require '../External/PHPMailer2/src/SMTP.php';
require_once 'PHPMailer2/src/Exception.php';
require_once 'PHPMailer2/src/PHPMailer.php';
require_once 'PHPMailer2/src/SMTP.php';

class Mail2
{
    public function sendMail($to, $subject, $body)
    {
        $mail = new PHPMailer(true);
        $response = [
            'status' => '',
            'message' => ''
        ];
        try {
            // $mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'solutionscolte@gmail.com';
            $mail->Password = 'bikgjjsfjqiuczpj';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS encryption
            $mail->Port = 587;

            $mail->setFrom('solutionscolte@gmail.com', 'AstronuX');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();

            $response['status'] = 'success';
            $response['message'] = 'Message has been sent';
        } catch (Exception $e) {
            $response['status'] = 'error';
            $response['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }

        return $response;
    }
}