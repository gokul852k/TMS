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
        $userId = $response1['id'];
        $response2 = $this->modelCMS->getUserDetails($userId);

        //Get user role from Authentication Database
        $response3 = $this->modelA->getUserRoleFromAuthentication($response1['id']);

        //Get User role ID from CMS Database

        $response4 = $this->modelCMS->getUserIdFromCMS($response3['role_name']);

        //Storing value in session
        if($response1) {
            $_SESSION['userId'] = $userId;
            $_SESSION['driverId'] = $response2['id'];
            $_SESSION['cabCompanyId'] = $response2['cab_company_id'];
            $_SESSION['fullName'] = $response2['fullname'];
            $_SESSION['email'] = $response2['mail'];
            $_SESSION['mobile'] = $response2['mobile'];
            $_SESSION['companyId'] = $response2['company_id'];
            $_SESSION['languageCode'] = $response2['language'];
            $_SESSION['carId'] = $response2['car_id'];
            $_SESSION['userRoleId'] = $response4['id'];

            //Yokesh you need to store session as per your need.

            return [
                "status" => "success",
                "message" => "Session value is stored."
            ];
        }

        return [
            "status" => "error",
            "message" => "Session value not stored."
        ];
    }

    
    public function changeLanguage($code) {
        $language = $this->modelCMS->getLanguage($code, $_SESSION['companyId']);
        if ($language) {
            $this->modelCMS->updateLanguage($_SESSION['driverId'], $language['code']);
            $_SESSION['languageCode'] = $language['code'];
            return [
                "status" => "success",
                "message" => "Language changed."
            ];
        } else {
            return [
                "status" => "error",
                "message" => "error"
            ];
        }
    }

    public function isLoggedIn() {
        //check if session value is avilable.
        if (isset($_SESSION['userId'])) {
            return true;
        }

        //check if cookie value is avilable.
        if (isset($_COOKIE['remember_me_tms_user'])) {
            $reponse = $this->storeSessionValue($_COOKIE['remember_me_tms_user']);
            return ($reponse['status'] === 'success') ? true : false;
        }

        return false;
    }

    public function logout() {

        session_unset();

        session_destroy();

        // Delete the remember me cookie
        setcookie('remember_me_tms_user', '', time() - 3600, '/', 'localhost', false, true);

        //For Server
        // setcookie('remember_me_tms_user', '', time() - 3600, '/', false, true);

        return [
            "status" => "success"
        ];
    }
}