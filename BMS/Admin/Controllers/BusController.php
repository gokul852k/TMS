<?php

require_once '../Services/BusService.php';

class BusController {
    private $busService;
    public function __construct() {
        $this->busService = new BusService();

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

    private function getFuelType() {
        echo json_encode($this->busService->getFuelType());
    }

    private function createBus() {
        $busNumber = $_POST['bus-number'];
        $busModel = $_POST['bus-model'];
        $seatingCapacity = $_POST['seating-capacity'];
        $fuelType = $_POST['fuel-type'];
        $busStatus = $_POST['bus-status'];
        $driverSalary = $_POST['driver-salary'];
        $conductorSalary = $_POST['conductor-salary'];
        $rcBookNumber = $_POST['rc-book-number'];
        $insuranceNumber = $_POST['insurance-number'];
        $rcBookExpiry = $_POST['rc-book-expiry'];
        $insuranceExpiry = $_POST['insurance-expiry'];
        $rcBook = $_FILES['rc-book'];
        $insurance = $_FILES['insurance'];

        echo json_encode($this->busService->createBus($busNumber, $busModel, $seatingCapacity, $fuelType, $busStatus, $driverSalary, $conductorSalary, $rcBookNumber, $insuranceNumber, $rcBookExpiry, $insuranceExpiry, $rcBook, $insurance));
    }

    private function getBusCardDetails() {
        echo json_encode($this->busService->getBusCardDetails());
    }

    private function getBuses() {
        echo json_encode($this->busService->getBuses());
    }

    private function getBusEdit() {
        echo json_encode($this->busService->getBusEdit($_POST['busId']));
    }

    private function updateBus() {
        $busId = $_POST['bus_id'];
        $busNumber = $_POST['bus_number'];
        $busModel = $_POST['bus_model'];
        $seatingCapacity = $_POST['seating_capacity'];
        $fuelTypeId = $_POST['fuel_type_id'];
        $driverSalary = $_POST['driver_salary'];
        $conductorSalary = $_POST['conductor_salary'];
        $busStatus = $_POST['bus_status'];
        $rcbookNo = $_POST['rcbook_no'];
        $insuranceNo = $_POST['insurance_no'];
        $rcbookExpiry = $_POST['rcbook_expiry'];
        $insuranceExpiry = $_POST['insurance_expiry'];

        $rcBook = $_FILES['rcbook_path'];
        $insurance = $_FILES['insurance_path'];

        echo json_encode($this->busService->updateBus($busId, $busNumber, $busModel, $seatingCapacity, $fuelTypeId, $driverSalary, $conductorSalary, $busStatus, $rcbookNo, $insuranceNo, $rcbookExpiry, $insuranceExpiry, $rcBook, $insurance));
    
    }

    private function getBusView() {
        echo json_encode($this->busService->getBusView($_POST['busId']));
    }

    private function deleteBus() {
        echo json_encode($this->busService->deleteBus($_POST['busId']));
    }
}

new BusController();