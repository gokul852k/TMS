<?php
session_start();

require_once '../config.php';
require_once '../Models/SessionModel.php';

class SessionServices {

    private $modelMA;

    private $modelA;
    public function __construct() {
        global $masterAdminDB;
        global $authenticationDB;
        $this->modelMA = new SessionModel($masterAdminDB);
        $this->modelA = new SessionModel($authenticationDB);
    }

    public function tokenValidation($userId, $token) {
        $response = $this->modelA->getToken($userId);
        if($response['token'] == $token) {
            return true; 
        } else {
            return false;
        }
    }

    public function storeSessionValue($userId) {
        $response1 = $this->modelA->getToken($userId);
        $companyId = $response1['company_id'];
        $response2 = $this->modelMA->getCompanyDetails($companyId);

        //Storing value in session
        if($response2) {
            $_SESSION['companyId'] = $response2['id'];
            $_SESSION['companyName'] = $response2['company_name'];
            $_SESSION['companyLogo'] = $response2['company_logo'];

            $redirectUrl = '../View/index.php';
            header('Location: ' . $redirectUrl);
            exit;
        }
    }
}