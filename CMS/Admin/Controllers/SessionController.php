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
        
        if ($this->tokenValidation()) {
            echo 'token success';
            $this->storeSessionValue();
        } else {
            die("Invalid request");
        }

    }

    private function tokenValidation() {
        return $this->service->tokenValidation($_POST['userid'], $_POST['token']);
    }

    private function storeSessionValue() {
        $this->service->storeSessionValue($_POST['userid']);
    }
    
}

new SessionController();