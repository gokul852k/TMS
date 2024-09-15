<?php

require_once '../Services/DailyReportServices.php';

class DailyReportController {
    private $service;
    public function __construct() {
        $this->service = new DailyReportServices();

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

    private function startTrip() {

        $currentDate = date('Y-m-d');

        date_default_timezone_set('Asia/Kolkata');
        $currentTime = date('H:i:s');
        
        $checkin_km = $_POST['checkin_km'];

        echo json_encode($this->service->startTrip($currentDate, $currentTime, $checkin_km));
    }

    private function endTrip() {

        $checkin = $_POST['hidden_checkin_km'];
        $checkout_km = $_POST['checkout_km'];

        $total_km = $checkout_km - $checkin;

        $currentDate = date('Y-m-d');

        date_default_timezone_set('Asia/Kolkata');
        $currentTime = date('H:i:s');
        // echo $currentDate;
        echo json_encode($this->service->endTrip($currentDate, $currentTime, $checkout_km, $total_km));
    }

    private function getDriver() {
        echo json_encode($this->service->getDriver($_POST['driverId']));
    }

    private function getDriversCardDetails() {
        echo json_encode($this->service->getDriversCardDetails());
    }

    private function getDrivers() {
        echo json_encode($this->service->getDrivers());
    }

    private function updateDriver() {

        $companyId = $_SESSION['companyId'];
        $cabCompanyId = $_SESSION['cabCompanyId'];
        $driverId = $_SESSION['dirverId'];

        $driverId = $_POST['driver_id'];
        $name = $_POST['fullname'];
        $mobile = $_POST['mobile'];
        $subcompany = $_POST['subcompany'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];
        $licenceNo = $_POST['licence_no'];
        $licenceExpiry = $_POST['licence_expiry'];
        $aadharNo = $_POST['aadhar_no'];
        $panNo = $_POST['pan_no'];

        $driverImage = $_FILES['driver_image_path'];
        $drivingLicence = $_FILES['licence_path'];
        $aadharCard = $_FILES['aadhar_path'];
        $panCard = $_FILES['pan_path'];

        echo json_encode($this->service->updateDriver($driverId, $driverImage, $name, $mobile, $subcompany, $password, $address, $state, $district, $pincode, $drivingLicence, $licenceNo, $licenceExpiry, $aadharCard, $aadharNo, $panCard, $panNo));
    
    }

    private function deleteDriver() {
        echo json_encode($this->service->deleteDriver($_POST['driverId']));
    }

    private function getCompany() {
        echo json_encode($this->service->getCompany());
    }

}

new DailyReportController();