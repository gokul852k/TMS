<?php

require_once '../Services/PasswordService.php';

class PasswordController {

    private $service;
    public function __construct() {
        // Check if the request is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            die('Invalid request');
        }

        $this->service = new PasswordService();

        // Get the action from the AJAX request
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        // Call the appropriate method based on the action
        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request!']);
        }
    }

    private function forgotPassword() {
        echo json_encode($this->service->forgotPassword($_POST['mail']));
    }

    private function changePassword() {
        echo json_encode($this->service->changePassword($_POST['token'], $_POST['create_password'], $_POST['confirm_password']));
    }

}

new PasswordController();