<?php

require_once '../Services/CommissionService.php';

class CommissionController {
    private $commissionService;
    public function __construct() {
        $this->commissionService = new CommissionService();

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
            echo json_encode(['status' => 'error', 'message' => 'Invalid request!', 'error' => $action . "this method is not exit"]);
        }
    }

    // private function getFuelType() {
    //     echo json_encode($this->commissionService->getFuelType());
    // }

    private function createCommission() {
        $rangeFrom = $_POST['range-from'];
        $rangeTo = $_POST['range-to'];
        $amountPerCommission = $_POST['amount-per-commission'];
        $commissionAmount = $_POST['commission-amount'];

        echo json_encode($this->commissionService->createCommission($rangeFrom, $rangeTo, $amountPerCommission, $commissionAmount));
    }

    // private function getBusCardDetails() {
    //     echo json_encode($this->commissionService->getBusCardDetails());
    // }

    private function getCommission() {
        echo json_encode($this->commissionService->getCommission());
    }

    // private function getBusEdit() {
    //     echo json_encode($this->commissionService->getBusEdit($_POST['busId']));
    // }

    // private function updateBus() {
    //     $busId = $_POST['bus_id'];
    //     $busNumber = $_POST['bus_number'];
    //     $busModel = $_POST['bus_model'];
    //     $seatingCapacity = $_POST['seating_capacity'];
    //     $fuelTypeId = $_POST['fuel_type_id'];
    //     $driverSalary = $_POST['driver_salary'];
    //     $conductorSalary = $_POST['conductor_salary'];
    //     $busStatus = $_POST['bus_status'];
    //     $rcbookNo = $_POST['rcbook_no'];
    //     $insuranceNo = $_POST['insurance_no'];
    //     $rcbookExpiry = $_POST['rcbook_expiry'];
    //     $insuranceExpiry = $_POST['insurance_expiry'];

    //     $rcBook = $_FILES['rcbook_path'];
    //     $insurance = $_FILES['insurance_path'];

    //     echo json_encode($this->commissionService->updateBus($busId, $busNumber, $busModel, $seatingCapacity, $fuelTypeId, $driverSalary, $conductorSalary, $busStatus, $rcbookNo, $insuranceNo, $rcbookExpiry, $insuranceExpiry, $rcBook, $insurance));
    
    // }

    // private function getBusView() {
    //     echo json_encode($this->commissionService->getBusView($_POST['busId']));
    // }

    // private function deleteBus() {
    //     echo json_encode($this->commissionService->deleteBus($_POST['busId']));
    // }
}

new CommissionController();