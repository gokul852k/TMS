<?php
require_once '../../config.php';
require_once '../Models/SessionModel.php';

class SessionServices
{

    private $modelMA;
    private $modelA;

    private $modelCMS;
    public function __construct()
    {
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

    public function tokenValidation($userId, $token)
    {
        $response = $this->modelA->getToken($userId);
        if ($response['token'] == $token) {
            return true;
        } else {
            return false;
        }
    }

    public function storeSessionValue($userId)
    {

        //Get company ID
        $response1 = $this->modelA->getToken($userId);
        $companyId = $response1['company_id'];

        //Get
        $response2 = $this->modelMA->getCompanyDetails($companyId);

        //Get user role from Authentication Database
        $response3 = $this->modelA->getUserRoleFromAuthentication($userId);

        //Get User role ID from CMS Database

        $response4 = $this->modelCMS->getUserIdFromCMS($response3['role_name']);

        //Storing value in session
        if ($response1 && $response2 && $response3 && $response4) {
            $_SESSION['userId'] = $userId;
            $_SESSION['companyId'] = $response2['id'];
            $_SESSION['companyName'] = $response2['company_name'];
            $_SESSION['companyLogo'] = $response2['company_logo'];
            $_SESSION['languageCode'] = $response2['language_code'];
            $_SESSION['userRoleId'] = $response4['id'];

            $redirectUrl = '../View/index.php';
            header('Location: ' . $redirectUrl);
            exit;
        } else {
            return [
                "status" => "error",
                "message" => "There was an error in the session. Please contact the AstronuX support team."
            ];
        }
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['userId']);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        return [
            "status" => "success"
        ];
    }
}