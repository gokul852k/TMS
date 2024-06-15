<?php

require_once '../Services/SessionServices.php';
class SessionController {

    private $service;

    public function __construct() {

        if (!isset($_COOKIE['remember_me_tms_user'])) {
            $redirctUrl = '../../../Authentication/View/user_login.php';
            header('Location: ' . $redirctUrl);
            exit;
        }

        // echo $_COOKIE['remember_me_tms_user'];

        $this->service = new SessionServices();

        $this->storeSessionValue($_COOKIE['remember_me_tms_user']);

    }

    private function storeSessionValue($token) {
        $this->service->storeSessionValue($token);
    }
    
}

new SessionController();