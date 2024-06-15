<?php

require_once '../config.php';
require_once '../Models/PasswordModel.php';
class PasswordService {

    private $model;
    public function __construct() {
        global $conn;
        $this->model = new PasswordModel($conn);
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
        

    }

    public function generateToken($userid)
    {
        $randomBytes = bin2hex(random_bytes(16)); // Generates a 32-character random string
        $timestamp = time(); // Current timestamp
        $token = hash('sha256', $userid . $randomBytes . $timestamp); // Combines all to generate a token
        return $token;
    }

}