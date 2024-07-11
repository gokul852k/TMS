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
        $rcBookNumber = $_POST['rc-book-number'];
        $insuranceNumber = $_POST['insurance-number'];
        $rcBookExpiry = $_POST['rc-book-expiry'];
        $insuranceExpiry = $_POST['insurance-expiry'];
        $rcBook = $_FILES['rc-book'];
        $insurance = $_FILES['insurance'];

        echo json_encode($this->busService->createBus($busNumber, $busModel, $seatingCapacity, $fuelType, $busStatus, $rcBookNumber, $insuranceNumber, $rcBookExpiry, $insuranceExpiry, $rcBook, $insurance));
    }
}

new BusController();