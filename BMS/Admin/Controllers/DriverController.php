<?php

require_once '../Services//DriverService.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class DriverController {
    private $service;
    public function __construct() {
        $this->service = new DriverService();

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
            echo json_encode(['status' => 'error', 'message' => 'Invalid request!']);
        }
    }

    private function createDriver() {
        $driverImage = $_FILES['imageUpload'];
        $name = $_POST['fullname'];
        $mobile = $_POST['mobile'];
        $mail = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];
        $drivingLicence = $_FILES['driving-licence'];
        $licenceNo = $_POST['driving-licence-no'];
        $licenceExpiry = $_POST['licence-expiry'];
        $aadharCard = $_FILES['aadhar-card'];
        $aadharNo = $_POST['aadhar-no'];
        $panCard = $_FILES['pan-card'];
        $panNo = $_POST['pan-no'];

        // echo json_encode([
        //     'status' => 'error',
        //     'message' => 'Sorry, only PDF, JPG, JPEG, PNG & GIF files are allowed.'
        // ]);

        echo json_encode($this->service->createDriver($driverImage, $name, $mobile, $mail, $password, $address, $state, $district, $pincode, $drivingLicence, $licenceNo, $licenceExpiry, $aadharCard, $aadharNo, $panCard, $panNo));
    }
}

new DriverController();