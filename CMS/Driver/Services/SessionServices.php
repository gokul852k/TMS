<?php
require_once '../../config.php';
require_once '../Models/SessionModel.php';

class SessionServices {

    private $modelMA;
    private $modelA;
    private $modelCMS;
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        global $masterAdminDB;
        global $authenticationDB;
        global $cmsDB;
        $this->modelMA = new SessionModel($masterAdminDB);
        $this->modelA = new SessionModel($authenticationDB);
        $this->modelCMS = new SessionModel($cmsDB);
    }

    public function storeSessionValue($token) {
        $response1 = $this->modelA->getUser($token);
        $userId = $response1['company_id'];
        // $response2 = $this->modelMA->getUserDetails($userId);

        //Get user role from Authentication Database
        $response3 = $this->modelA->getUserRoleFromAuthentication($response1['id']);

        //Get User role ID from CMS Database

        $response4 = $this->modelCMS->getUserIdFromCMS($response3['role_name']);

        //Storing value in session
        if($response1) {
            $_SESSION['userId'] = $userId;
            // $_SESSION['companyId'] = $response2['id'];
            // $_SESSION['companyName'] = $response2['company_name'];
            // $_SESSION['companyLogo'] = $response2['company_logo'];
            $_SESSION['languageCode'] = 'en';
            $_SESSION['userRoleId'] = $response4['id'];

            //Yokesh you need to store session as per your need.

            $redirectUrl = '../View/index.php';
            header('Location: ' . $redirectUrl);
            exit;
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['userId']);
    }
}