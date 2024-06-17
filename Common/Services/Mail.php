<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../External/PHPMailer/autoload.php';
class Mail
{
    function sendMail($to, $subject, $body)
    {
        $response = [
            'status' => '',
            'message' => ''
        ];
        $mail = new PHPMailer(true);
        $mail->From = "rgokul784@gmail.com";
        $mail->FromName = "AxtronuX";
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        try {
            $mail->send();
            $response['status'] = 'success';
            $response['message'] = 'Message has been sent';

        } catch (Exception $e) {
            $response['status'] = 'error';
            $response['message'] = 'Message could not be sent';
            $response['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }

        return $response;
    }
}