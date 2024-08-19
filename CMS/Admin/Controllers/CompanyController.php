<?php

require_once '../Services/CompanyService.php';

class CompanyController {
    private $service;
    public function __construct() {
        $this->service = new CompanyService();

        // Check if the request is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            die('Invalid request');
        }

        // Get the action from the AJAX request
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        // Call the appropriate method based on the action
        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request!', 'error' => $action . "this method is not exit". $_POST['driverId']]);
        }
    }

    private function createCompany() {
        $company = $_POST['company'];
        $gstnum = $_POST['gstnum'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];

        echo json_encode($this->service->createCompany($company, $gstnum, $mobile, $email, $address, $state, $district, $pincode));
    }

    private function getCompany() {
        echo json_encode($this->service->getCompany($_POST['companyId']));
    }

    private function getDriversCardDetails() {
        echo json_encode($this->service->getDriversCardDetails());
    }

    private function getCompanys() {
        echo json_encode($this->service->getCompanys());
    }

    private function updateCompany() {
        $company_id = $_POST['company_id'];
        $company = $_POST['company'];
        $gstnum = $_POST['gstnum'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];
        echo json_encode($this->service->updateCompany($company_id, $company, $gstnum, $mobile, $email, $address, $state, $district, $pincode));
    
    }

    private function deleteDriver() {
        echo json_encode($this->service->deleteDriver($_POST['driverId']));
    }
}

new CompanyController();