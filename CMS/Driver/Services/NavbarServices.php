<?php
require_once '../Services/SessionServices.php';
require_once '../Models/NavbarModel.php';
require_once '../../config.php';

class NavbarServices {

    private $model;

    private $sesion;

    public function __construct() {
        $this->sesion = new SessionServices();

        if (!$this->sesion->isLoggedIn()) {
            // Handle the case where the user is not logged in
            header('Location: login.php');
            exit();
        }
        global $cmsDB;
        $this->model = new NavbarModel($cmsDB);
    }

    public function adminNavbar() {

        $roleId = $_SESSION['userRoleId'];
        $languageCode = $_SESSION['languageCode'];
        $response = $this->model->getAdminNavbar($roleId, $languageCode);

        if ($response) {
            return $response;
        } else {
            return null;
        }
    }
}