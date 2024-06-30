<?php

require_once '../Services/SessionServices.php';
class SessionController {

    private $service;

    public function __construct() {

        $this->service = new SessionServices();

        // Check if the request is an POST request
        // if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     die('Invalid request');
        // }

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            // Get the action from the AJAX request
            $action = isset($_POST['action']) ? $_POST['action'] : '';

            // Call the appropriate method based on the action
            if (method_exists($this, $action)) {
                $this->$action();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request!']);
            }
        } else {
            if ($this->tokenValidation()) {
                $this->storeSessionValue();
            } else {
                die("Invalid request");
            }
        }
    }

    private function tokenValidation() {
        return $this->service->tokenValidation($_POST['userid'], $_POST['token']);
    }

    private function storeSessionValue() {
        $response = $this->service->storeSessionValue($_POST['userid']);
        echo $response['message'];
    }

    private function logout() {
        echo json_encode($this->service->logout());
    }
    
}

new SessionController();